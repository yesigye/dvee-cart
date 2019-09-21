<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();

		// Load CI libraries and helpers.
		$this->load->database();
		$this->load->helper('text');

 		// Example of defining a specific language to return flexi carts status and error messages.
 		// The defined language file must be added to the CI application directory as 'application/language/[language_name]/flexi_cart_lang.php'.
 		// Alternatively, CI's default language can be set via the CI config. file.
 		// Note: This must be defined before $this->load->library('flexi_cart').
 		# $this->lang->load('flexi_cart', 'spanish');

 		// IMPORTANT! This global must be defined BEFORE the flexi cart library is loaded! 
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi cart will not work.
		$this->flexi = new stdClass;
		
		$this->load->library(array('ion_auth','flexi_cart_admin', 'session'));

    	// Check if admin user is logged in.
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$this->load->model('users_model');
			$this->data['user'] = $this->users_model->current();
			$this->data['base_url'] = base_url();
			$this->load->config('app');
			$this->data['app'] = $this->config->item('app');
		}
		else
		{
			// redirect if user is not requesting login page.
			if ($this->uri->segment(2) !== 'login')
			{
				$this->session->set_userdata('login_redirect', current_url());
				redirect('admin/login');
			}
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER AUTHENTICATION
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

		/**
		 * login
		 * login a user
		 */
		function login()
		{
			$this->load->library(array('form_validation'));

			//validate form input
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == true)
			{
				// check for "remember me"
				$remember = (bool) $this->input->post('remember');

				if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember, 'username'))
				{
					//The login is successful

					// Check if the user is not an admin!
					if (!$this->ion_auth->is_admin())
					{
						// Log the admin out
						$this->ion_auth->logout();

						// Let admin know what happened
						$this->flexi_cart->set_error_message('You are not an administrator', 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));

						// Reload login page.
						redirect('admin/login');
					}

					$this->load->model('users_model');
					$user = $this->users_model->current();

					// Welcome user by first name.
					$this->flexi_cart_admin->set_status_message('Hi, '.$user->first_name.'. welcome back!', 'public', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('public'));

					if ($this->session->userdata('login_redirect'))
					{
						redirect($this->session->userdata('login_redirect'));
					}
					redirect('admin');
				}
				else
				{
					// Login was un-successful, set appropriate message
					$this->flexi_cart_admin->set_error_message($this->ion_auth->errors(), 'public', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('public'));

					// use redirects instead of loading views for compatibility with MY_Controller libraries
					redirect('admin/login', 'refresh');
				}
			}

			$this->load->model('users_model');

			$this->data['owner'] = $this->users_model->owner();

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('admin/login_view', $this->data);
		}

		/**
		 * logout
		 * logout the user
		 */
		function logout()
		{
			// log the user out
			$logout = $this->ion_auth->logout();
			redirect('admin/login');
		}
	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ADMIN DASHBOARD
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * index
	 * View and manage all the available admin functions within flexi cart.
	 */ 
	function index()
	{
		$this->load->helper('text');

		// Get latest users.
		$this->load->library('store');
		$users = $this->store->users(array(
			'ignore_status' => FALSE, // Both active and inactive users
			'order' => 'desc',
			'limit' => 3,
			'select' => array('created_on'),
		));
		$latestUsers = $users['rows'];
		foreach ($latestUsers as $key => $user) {
			$user->created = $this->time_elapsed_string($user->created_on);
		}
		$this->data['latest_users'] = $latestUsers;
		
		// Get latest products.
		$this->load->model('product_model');
		$this->data['latest_products'] = $this->product_model->get_latest_in_category(3);

		// Get monthly orders revenue
		$this->load->model('dashboard_model');
		$order_data = $this->dashboard_model->get_monthly_revenue(date('Y'), 12);
		$this->data['order_data'] = json_encode($order_data);

		// Get total orders revenue
		$this->data['order_total'] = $this->dashboard_model->get_orders_total();

		// Get total products number
		$this->data['products_total'] = $this->db->count_all('products');

		// Get total users number
		$this->data['users_total'] = $this->db->count_all('users');

		$this->load->view('admin/dashboard_view', $this->data);
	}

	function profile()
	{
		$this->load->model('users_model');
		$this->load->library(array('ion_auth', 'form_validation'));

		// if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		// {
		// 	redirect('auth', 'refresh');
		// }

		$this->data['user'] = $this->users_model->owner();

		// validate form input
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('company_name', 'company name', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('company_phone', 'Phone Number', 'required');
		$this->form_validation->set_rules('old_password', 'Old password', 'required|callback_password_check');

		if ($this->input->post('edit_user'))
		{
			// Additional rules.
			// Rules for the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}


			if ($this->form_validation->run() === TRUE)
			{
				$user_data = array(
					'username' => $this->input->post('username'),
					'first_name' => $this->input->post('company_name'),
					'email'	=> $this->input->post('email'),
					'phone' => $this->input->post('company_phone'),
					'postal' => $this->input->post('company_p_o_box'),
					'address' => $this->input->post('company_address'),
				);

				if ($_FILES['userfile']['size'] > 0)
				{
					// Get the image name.
					$filename = $this->data['user']->logo;
					$avatar = $this->upload_image($filename);

					if ( ! $avatar['error'])
					{
						$user_data['avatar'] = $avatar['path'];
					}
				}

				// update the password if it was posted
				if ($this->input->post('password'))
					$user_data['password'] = $this->input->post('password');

				// check to see if we are updating the user
			   if($this->ion_auth->update($this->data['user']->id, $user_data))
			    {
					// Set a success message.
					$this->flexi_cart_admin->set_status_message($this->ion_auth->messages(), 'admin', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			    }
			    else
			    {
					// Set an error message.
					$this->flexi_cart_admin->set_error_message($this->ion_auth->errors(), 'admin', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			    }
				redirect('admin/profile', 'refresh');
			}
		}

		$this->load->view('admin/user_profile', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER MANAGEMENT
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * View and manage store items and categories
	*/
	function users()
	{
		if ($this->input->post('activate_user'))
		{
			if ($this->input->is_ajax_request())
			{
				if ($this->ion_auth->activate($this->input->post('id')))
				{
					echo json_encode(array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
					return TRUE;
				}
				else
				{
					echo json_encode(array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Something went wrong'
					));
					return FALSE;
				}
			}
			else
			{
				if ($this->ion_auth->activate($this->input->post('id')))
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors()
					));
				}
				redirect(current_url());
			}
		}

		if ($this->input->post('deactivate_user'))
		{
			if ($this->input->is_ajax_request())
			{
				if ($this->ion_auth->deactivate($this->input->post('id')))
				{
					echo json_encode(array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
					return TRUE;
				}
				else
				{
					echo json_encode(array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Something went wrong'
					));
					return FALSE;
				}
			}
			else
			{
				if ($this->ion_auth->deactivate($this->input->post('id')))
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors()
					));
				}
				redirect(current_url());
			}
		}

		// Delete multiple selected users
		if ($this->input->post('delete_selected'))
		{
			if ($selected = $this->input->post('selected'))
			{
				foreach ($selected as $key => $id)
				{
					$this->ion_auth->delete_user($id);
				}

				if ($this->ion_auth->messages())
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Something went wrong'
					));
				}
				redirect(current_url());
			}
			else
			{
				$this->session->set_flashdata('alert', array(
					'type' => 'danger',
					'message' => 'Nothing was selected'
				));
			}
		}

		if ($this->input->post('insert_user'))
		{
			$response = $this->healthcare_model->add_company_doctor();
			
			if ($this->input->is_ajax_request())
			{
				echo json_encode($response['alert']);
				return TRUE;
			}
			else
			{
				$this->session->set_flashdata('alert', $response['alert']);
				redirect(current_url());
			}
		}

		if ($this->input->post('remove_user'))
		{
			$response = $this->healthcare_model->remove_company_doctor();
			
			if ($this->input->is_ajax_request())
			{
				echo json_encode($response['alert']);
				return TRUE;
			}
			else
			{
				$this->session->set_flashdata('alert', $response['alert']);
				redirect(current_url());
			}
		}

		if ($this->input->post('delete_user'))
		{
			if ($this->input->is_ajax_request())
			{
				if ($this->ion_auth->delete_user($this->input->post('id')))
				{
					echo json_encode(array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
					return TRUE;
				}
				else
				{
					echo json_encode(array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Something went wrong'
					));
					return FALSE;
				}
			}
			else
			{
				if ($this->ion_auth->delete_user($this->input->post('id')))
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => $this->ion_auth->messages()
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Something went wrong'
					));
				}
				redirect(current_url());
			}
		}

		// Get users.
		$this->load->library('store');

		$users = $this->store->users(array(
			'ignore_status' => TRUE // Both active and inactive users
		));

		$this->data['users'] = $users['rows'];	
		$this->data['users_total'] = $users['total'];	
		$this->data['pagination'] = $users['pagination'];
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('admin/users/users_view', $this->data);
	}
	
	/**
	 * Update user specific data
	 */
	function update_user($user_id)
	{
		$this->load->model('users_model');
		// Variable "person" is used because "user" is already being used for currently signed in user.
		$this->data['person'] = $this->users_model->get_details($user_id);

		$this->load->library('form_validation');

		if ($this->input->post('edit_user'))
		{
			$tables = $this->config->item('tables','ion_auth');
			$identity_column = $this->config->item('identity','ion_auth');
			$this->data['identity_column'] = $identity_column;

			// validate form input
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			// validate form input
			$this->form_validation->set_rules('username', 'above', 'required');
			$this->form_validation->set_rules('email', 'above', 'required|valid_email');
			$this->form_validation->set_rules('address', 'above', 'required');
			$this->form_validation->set_rules('phone', 'above', 'required|trim');

			// Add data for different user groups.
			$this->form_validation->set_rules('first_name', 'above', 'required');
			$this->form_validation->set_rules('last_name', 'above', 'required');

			if ($this->form_validation->run() == true)
			{
				$email    = strtolower($this->input->post('email'));
				$identity = $this->input->post('username');
				$password = $this->input->post('password');

				$profile = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'address' => $this->input->post('address'),
					'phone' => $this->input->post('phone'),
					'postal' => $this->input->post('postal'),
				);
				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$profile['password'] = $this->input->post('password');
				}

				$group = array('2'); // Sets user to public.

				if ($_FILES['userfile']['size'] > 0)
				{
					$filename = $this->data['person']->avatar;
					$avatar = $this->upload_image($filename);
					if ( ! $avatar['error'])
						$profile['avatar'] = $avatar['path'];
				}

				if ($this->ion_auth->update($user_id, $profile))
				{
					$this->flexi_cart_admin->set_status_message($this->ion_auth->messages() ? $this->ion_auth->messages() : 'User Data was updated.', 'admin', TRUE);
				}
				else
				{
					$this->flexi_cart_admin->set_error_message($this->ion_auth->errors() ? $this->ion_auth->errors() : 'User Data was could not be updated.', 'admin', TRUE);
				}

				// Set messages and redirect back to user update page.
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect(current_url());
			}
		}

		$this->load->model('demo_cart_admin_model');

		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('convert_reward_points'))
		{
			$this->demo_cart_admin_model->demo_convert_reward_points($user_id);
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages());
			redirect(current_url());
		}

		// Get an array of all the reward vouchers filtered by the id in the url.
		// Using flexi cart SQL functions, join the demo user table with the discount table.
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'user') => $user_id);
		// $this->flexi_cart_admin->sql_join('demo_users', 'user_id = '.$this->flexi_cart_admin->db_column('discounts', 'user'));
		$this->data['voucher_data_array'] = $this->flexi_cart_admin->get_db_voucher_query(FALSE, $sql_where)->result_array();

		// Get user remaining reward points.
		$summary_data = $this->flexi_cart_admin->get_db_reward_point_summary($user_id);
		$this->data['points_data'] = array(
			'total_points' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points')],
			'total_points_pending' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_pending')],
			'total_points_active' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')],
			'total_points_active' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')],
			'total_points_expired' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_expired')],
			'total_points_converted' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_converted')],
			'total_points_cancelled' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_cancelled')]
		);
		
		// Get an array of a demo user and their related reward points from a custom demo model function, filtered by the id in the url.
		$reward_data = $this->demo_cart_admin_model->demo_reward_point_summary($user_id);
		
		// Note: The custom function returns a multi-dimensional array, of which we only need the first array, so get the first row '$user_data[0]'.
		$this->data['reward_data'] = $reward_data[0];
		$this->data['max_conversion_points'] = $this->flexi_cart_admin->calculate_conversion_reward_points($reward_data[0][$this->flexi_cart_admin->db_column('reward_points','total_points_active')]);

		// Get the conversion tier values for converting reward points to vouchers.
		$conversion_tiers = $this->data['reward_data'][$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')];
		$this->data['conversion_tiers'] = $this->flexi_cart_admin->get_reward_point_conversion_tiers($conversion_tiers);

		// Get an array of all reward points for a user.
		$sql_select = array(
			$this->flexi_cart_admin->db_column('reward_points', 'order_number'),
			$this->flexi_cart_admin->db_column('reward_points', 'description'),
			$this->flexi_cart_admin->db_column('reward_points', 'order_date')
		);	
		$sql_where = array($this->flexi_cart_admin->db_column('reward_points', 'user') => $user_id);
		$this->data['points_awarded_data'] = $this->flexi_cart_admin->get_db_reward_points_query($sql_select, $sql_where)->result_array();
		
		// Call a custom function that returns a nested array of reward voucher codes and the reward point data used to create the voucher.
		$this->data['points_converted_data'] = $this->demo_cart_admin_model->demo_converted_reward_point_history($user_id);

		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('admin/users/user_update_view', $this->data);
	}

	/**
	 * insert_user
	 * Register a new user
	 */
	function insert_user()
	{
		if ($this->input->post('create_user'))
		{
			$tables = $this->config->item('tables','ion_auth');
			$identity_column = $this->config->item('identity','ion_auth');
			$this->data['identity_column'] = $identity_column;

			$this->load->library('form_validation');

			// validate form input
			$this->form_validation->set_rules('username', 'above', 'required|is_unique['.$tables['users'].'.'.$identity_column.']');
			$this->form_validation->set_rules('password_confirm', 'above', 'required');
			$this->form_validation->set_rules('password', 'above', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('email', 'above', 'required|valid_email');
			$this->form_validation->set_rules('address', 'above', 'required');
			$this->form_validation->set_rules('phone', 'above', 'required|trim');

			// Add data for different user groups.
			$this->form_validation->set_rules('first_name', 'above', 'required');
			$this->form_validation->set_rules('last_name', 'above', 'required');

			if ($this->form_validation->run() == true)
			{
				$email    = strtolower($this->input->post('email'));
				$identity = $this->input->post('username');
				$password = $this->input->post('password');

				$profile = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'address' => $this->input->post('address'),
					'phone' => $this->input->post('phone'),
				);

				$group = array('2'); // Sets user to public.

				if ($_FILES['userfile']['size'] > 0) {
					$avatar = $this->upload_image();
					if (!$avatar['error']) $profile['avatar'] = $avatar['path'];
				}

				$user_id = $this->ion_auth->register($identity, $password, $email, $profile, $group);

				if ($user_id) {
					// Define profile information.
					// $this->users_model->add($profile);

					$this->flexi_cart_admin->set_status_message('User has been added', 'admin', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));

					// redirect them back to the login page
					redirect("admin/users", 'refresh');
				} else {
					$this->flexi_cart_admin->set_error_message(($this->ion_auth->errors() ? $this->ion_auth->errors() : 'User could not be added'), 'admin', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));

					// redirect them back to the login page
					redirect("admin/insert_user", 'refresh');
				}
			}
		}

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		// display the create user form
		$this->load->view('admin/users/user_insert', $this->data);
	}




	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// PRODUCT MANAGEMENT
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * View and manage store items and categories
	 */
	function items()
	{
		$this->load->model('product_model');

		// Get products.
		$this->load->library('store');
		$products = $this->store->products($options = array(
			'order' => 'alpha'
		));
		$this->data['products'] = $products['rows'];	
		$this->data['products_total'] = $products['total'];	
		$this->data['pagination'] = $products['pagination'];
		
		// Deleting product(s).
		if ($this->input->post('delete_selected'))
		{
			$this->load->library('form_validation');
			// Set validation rules.
			$this->form_validation->set_rules('selected[]', 'above', 'required');
			$this->form_validation->set_message('required', 'Select some items first.');

			if ($this->form_validation->run())
			{
				foreach ($this->input->post('selected') as $key => $id)
				{
					// Deleting each of the selected products.
					$this->product_model->delete_product($id);
					// Reload the page.
					redirect(current_url(), 'refresh');
				}
			}
		}
		
		// Update product(s).
		if ($this->input->post('update_items'))
		{
			// Deleting each of the selected products.
			$this->product_model->update_products();
			// Reload the page.
			redirect(current_url(), 'refresh');
		}

		$this->data['categories'] = $this->category_model->get_categories_list();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/items_view', $this->data);
	}

	/**
	 * Insert a new item
	 */
	function insert_item()
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model', 'category_model', 'tree_model'));

		// $this->data['category'] = $this->category_model->get_category($category_id);
		
		if ($this->input->post('add_item'))
		{
			$this->load->library('form_validation');

			// Set validation rules.
			$this->form_validation->set_rules('name', 'above', 'required|is_unique[products.name]', array('is_unique' => 'An item with this name already exists'));
			$this->form_validation->set_rules('price', 'above', 'required');
			$this->form_validation->set_rules('stock', 'above', 'required');
			$this->form_validation->set_rules('weight', 'above', 'required');
			$this->form_validation->set_rules('description', 'above', 'required');
			$this->form_validation->set_rules('userfile', 'above', 'callback_userfile_check');

			$this->form_validation->set_error_delimiters('', '');

			if ($this->form_validation->run())
			{
				// Form passed validation. Add the product.
				if ($id = $this->product_model->add_product())
				{
					redirect('admin/update_item/'.$id);
				}
				else
				{
					redirect('admin/add_item');
				}
			}
		}
		$this->data['categories'] = $this->category_model->get_categories_list();
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_add_view', $this->data);
	}

	/**
	 * Delete an item
	 */
	function delete_item($id)
	{
		$this->load->model(array('product_model'));
		
		// Form passed validation. Add the product.
		if ($this->product_model->delete_product($id))
		{
			redirect('admin/items');
		}
		else
		{
			redirect(current_url());
		}
	}

	/**
	 * Update an item
	 */
	function update_item($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model', 'category_model'));

		$this->data['product'] = $this->product_model->get_details($id);
		$this->data['categories'] = $this->category_model->get_categories_list();

		if ($this->input->post('update_item'))
		{
			if (count($_FILES['files']['name']) > $this->data['upload_limit'])
			{
				$this->flexi_cart_admin->set_error_message('You can only upload '.$this->data['upload_limit'].' images', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				$this->session->set_flashdata('alert', array('location' => 'images'));
				redirect(current_url());
			}

			$this->load->library('form_validation');

			// Set validation rules.
			$this->form_validation->set_rules('name', 'above', 'required');
			$this->form_validation->set_rules('price', 'above', 'required');
			$this->form_validation->set_rules('stock', 'above', 'required');
			$this->form_validation->set_rules('weight', 'above', 'required');
			$this->form_validation->set_rules('description', 'above', 'required');

			$this->form_validation->set_error_delimiters('', '');

			if ($this->form_validation->run())
			{
				// Form passed validation. Update the product.
				$response = $this->product_model->update_product($this->input->post('id'));
				
				// Update tax rates
				$this->load->model('demo_cart_admin_model');
				$this->demo_cart_admin_model->demo_update_item_tax();
				
				redirect(current_url());
			}
		}

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_details', $this->data);		
	}

	/**
	 * Update an item attributes
	 */
	function update_item_attributes($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model', 'category_model'));

		$this->data['product'] = $this->product_model->get_details($id);

		if ($this->input->post('update_attributes'))
		{
			$this->product_model->update_product_attributes($this->input->post('id'), $this->input->post('attributes'));
			redirect(current_url());
		}

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_attributes', $this->data);		
	}

	/**
	 * Update an item options
	 */
	function update_item_options($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model('product_model');

		if ($this->input->post('add_option'))
		{
			$this->product_model->add_product_option($this->input->post('id'));
			redirect(current_url());
		}

		if ($this->input->post('update_options'))
		{
			$this->product_model->update_product($this->input->post('id'));
			redirect(current_url());
		}

		if ($this->input->post('update_defaults'))
		{
			$this->product_model->update_product_defaults($id, $this->input->post('default_option'));
			redirect(current_url());
		}

		$this->data['product'] = $this->product_model->get_details($id);
		$this->data['product_options']  = $this->product_model->get_product_options($id);
		$this->data['product_variants'] = $this->product_model->get_product_variants($id);
		$this->data['product_defaults'] = $this->product_model->get_product_defaults($id);

		$this->load->library('store');
		$this->data['upload_limit'] = $this->store->settings('upload_limit') - count($this->data['product']->images);

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_options', $this->data);		
	}

	/**
	 * Update an item option
	 */
	function update_item_option($product_id, $option_id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model('product_model');

		if ($this->input->post('update_option'))
		{
			$this->load->library('form_validation');

			// Set validation rules.
			$this->form_validation->set_rules('values[]', 'Select Attributes', 'required');
			$this->form_validation->set_error_delimiters('', '');

			if ($this->form_validation->run())
			{
				$this->product_model->update_product_option($option_id);
				redirect(current_url());
			}
		}

		if ($this->input->post('delete_item_image'))
		{
			$this->product_model->delete_product_option_image($this->input->post('id'));
			exit();
		}

		$this->data['product'] = $this->product_model->get_details($product_id);
		$this->data['product_option']  = $this->product_model->get_product_option($option_id);
		$this->data['product_options']  = $this->product_model->get_product_options($product_id);

		$this->load->library('store');
		$this->data['upload_limit'] = $this->store->settings('upload_limit') - count($this->data['product_option']->images);

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_option', $this->data);		
	}

	/**
	 * Update an item options
	 */
	function delete_item_options($product_id, $option_id)
	{
		$this->load->model('product_model');

		$this->product_model->delete_product_option($option_id);
		redirect('admin/update_item_options/'.$product_id);
	}

	/**
	 * Update an item images
	 */
	function update_item_images($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model'));

		if ($this->input->post('delete_item_image'))
		{
			$this->product_model->delete_product_image($this->input->post('id'));
			exit();
		}

		$this->data['product'] = $this->product_model->get_details($id);

		$this->load->library('store');
		$this->data['upload_limit'] = $this->store->settings('upload_limit') - count($this->data['product']->images);

		if ($this->input->post('update_images'))
		{
			if (count($_FILES['files']['name']) > $this->data['upload_limit'])
			{
				$this->flexi_cart_admin->set_error_message('You can only upload '.$this->data['upload_limit'].' images', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				$this->session->set_flashdata('alert', array('location' => 'images'));
				redirect(current_url());
			}

			$this->product_model->update_product_images($this->input->post('id'));
			redirect(current_url());
		}

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_images', $this->data);		
	}

	/**
	 * Update an item tax
	 */
	function update_item_tax($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model'));

		$this->data['product'] = $this->product_model->get_details($id);

		if ($this->input->post('insert_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_item_tax($id);
			redirect(current_url());
		}

		if ($this->input->post('update_tax'))
		{
			// Update tax rates
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_item_tax();
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get an array of all the item tax rates filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('item_tax', 'item') => $id);
		$this->data['item_tax_data'] = $this->flexi_cart_admin->get_db_item_tax_query(FALSE, $sql_where)->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_tax', $this->data);		
	}

	/**
	 * Insert an item shipping rules
	 */
	function insert_item_shipping($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model'));

		$this->data['product'] = $this->product_model->get_details($id);

		if ($this->input->post('insert_shipping'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_item_shipping($id);
			redirect('admin/update_item_shipping/'.$id);
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('id' => $id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_query('products', FALSE, $sql_where)->result_array();
		if(!empty($this->data['item_data'])) $this->data['item_data'] = $this->data['item_data'][0];

		// Get an array of all item shipping rules filtered by the id in the url.		
		$sql_where = array($this->flexi_cart_admin->db_column('item_shipping', 'item') => $id);
		$this->data['item_shipping_data'] = $this->flexi_cart_admin->get_db_item_shipping_query(FALSE, $sql_where)->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_insert_shipping', $this->data);		
	}

	/**
	 * Update an item shipping
	 */
	function update_item_shipping($id)
	{
		$this->load->config('app');
		$this->data['app'] = $this->config->item('app');

		$this->load->model(array('product_model'));

		$this->data['product'] = $this->product_model->get_details($id);

		if ($this->input->post('update_shipping'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_item_shipping();
			redirect(current_url());
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('id' => $id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_query('products', FALSE, $sql_where)->result_array();
		if (!empty($this->data['item_data'])) $this->data['item_data'] = $this->data['item_data'][0];

		// Get an array of all item shipping rules filtered by the id in the url.		
		$sql_where = array($this->flexi_cart_admin->db_column('item_shipping', 'item') => $id);
		$this->data['item_shipping_data'] = $this->flexi_cart_admin->get_db_item_shipping_query(FALSE, $sql_where)->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/items/item_update_shipping', $this->data);		
	}

	/**
	 * View and edit item categories
	*/
	function categories($category_id = NULL)
	{
		$this->load->model(array('category_model'));

		if ($this->input->post('delete'))
		{
			$response = $this->category_model->delete_category();
			redirect('admin/categories/'.$category_id);
		}

		if ($this->input->post('update_categories'))
		{
			$response = $this->category_model->update_categories();
			redirect('admin/categories/'.$category_id);
			
		}

		// Load the categories page.
		$this->data['categories'] = $this->category_model->get_all_categories();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/categories/categories_view', $this->data);	
	}

	/**
	 * Add a new item category
	*/
	public function insert_category($category_id = NULL)
	{
		$this->load->model(array('product_model', 'category_model'));

		if ($this->input->post('add_category'))
		{
			$this->load->library('form_validation');

			// Set validation rules.
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('name', 'Category Name', 'required|is_unique[product_categories.name]');

			if ($this->form_validation->run() == true)
			{
				$response = $this->category_model->add_category();
				$this->session->set_flashdata('alert', $response['alert']);
				
				if ( ! $response['error'])
				{
					redirect('admin/categories/'.$category_id);
				}
			}
		}

		// Load the categories page.
		$this->data['category'] = $this->category_model->get_categories($category_id);
		$this->data['categories'] = $this->category_model->get_all_categories();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/categories/category_insert_view', $this->data);
	}

	public function update_attribute($category_id = NULL)
	{
		$this->load->model(array('product_model', 'category_model'));

		if ($this->input->post('delete_attribute'))
		{
			foreach ($this->input->post('delete_attribute') as $key => $attr)
			{
				$this->category_model->delete_attribute($key);
				redirect(current_url());
			}
		}

		if ($this->input->post('update_category'))
		{
			$this->category_model->update_attributes();
			redirect(current_url());
		}

		if ($this->input->post('add_attributes'))
		{
			$this->category_model->add_attributes($category_id);
			redirect(current_url());
		}

		// Load the categories page.
		$this->data['category'] = $this->category_model->get_categories($category_id);
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('admin/categories/attribute_update_view', $this->data);
	}

	public function get_attributes($id = NULL)
	{
		$attributes = $this->Category_model->get_attributes($id, FALSE, TRUE);
		
		// For ajax calls, return a template.
		if ($this->input->is_ajax_request())
		{
			if ($attributes)
			{
				// Load category tiles template.
				$this->load->view(
					'admin/categories/attribute_tiles',
					array(
						'template' => 'form',
						'attributes' => $attributes
					)
				);
			}
		}
		else
		{
			show_404();
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CUSTOM ITEM TABLE
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * items
	 * Whilst flexi cart takes care of online ordering, shipping rates, tax rates, discounts and currencies, it leaves the database structure for item and category 
	 * tables completely up to the design of the developer.
	 * For the purposes of demonstrating some of flexi carts features, a demo item, and category table have been included that are then linked to some of the cart functions.
	 */ 
	// function items()
	// {
	// 	$this->load->model('demo_cart_admin_model');
		
	// 	// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
	// 	if ($this->input->post('update_items'))
	// 	{
	// 		$this->demo_cart_admin_model->demo_update_item_stock();
	// 	}

	// 	// Get an array of all demo items from a custom demo model function.
	// 	$this->data['item_data'] = $this->demo_cart_admin_model->demo_get_item_data();
		
	// 	// Get any status message that may have been set.
	// 	$this->data['message'] = $this->session->flashdata('message');	

	// 	$this->load->view('admin/items/items_view', $this->data);
	// }	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ORDER MANAGEMENT
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * orders
	 * View and manage customer orders that have been saved by flexi cart
	 */ 
	function orders() 
	{
		// Get an array of all saved orders. 
		// Using a flexi cart SQL function, set the order the order data so that dates are listed newest to oldest.
		// $this->db->group_by($this->flexi_cart_admin->db_column('order_summary', 'ord_det_id'));
		// $this->db->group_by($this->flexi_cart_admin->db_column('order_summary', 'date'));
		// $this->db->group_by($this->flexi_cart_admin->db_column('order_summary', 'total'));
		// $this->db->group_by($this->flexi_cart_admin->db_column('order_summary', 'total_items'));
		// $this->flexi_cart_admin->sql_order_by($this->flexi_cart_admin->db_column('order_summary', 'date'), 'desc');
		// $this->data['order_data'] = $this->flexi_cart_admin->get_db_order_query()->result_array();
		
		$this->db->from('order_summary');
		$this->db->join('order_status', 'order_status.ord_status_id = order_summary.ord_status');
		$this->db->join('order_details', 'order_details.ord_det_order_number_fk = order_summary.ord_order_number');
		$this->db->order_by('order_summary.ord_date');
		$this->db->order_by('order_summary.ord_order_number');
		$this->data['order_data'] = $this->db->get()->result_array();

		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('admin/orders/orders_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * order_details
	 * Displays all data related to a saved order, including the users billing and shipping details, the cart contents and the cart summary.
	 * This demo includes an example of indicating to flexi cart which items have been shipped or cancelled since the order was receieved, flexi cart can then use this data 
	 * to manage item stock and user reward points.
	 */ 
	function order_details($order_number) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_order'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_order_details($order_number);
		}
		
		// Get the row array of the order filtered by the order number in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_summary_query(FALSE, $sql_where)->result_array();
		$this->data['summary_data'] = $this->data['summary_data'][0];

		// Get an array of all order details related to the above order, filtered by the order number in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $order_number);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_order_detail_query(FALSE, $sql_where)->result_array();
		
		// Get an array of all order statuses that can be set for an order.
		// The data is then to be displayed via a html select input to allow the user to update the orders status.
		$this->data['status_data'] = $this->flexi_cart_admin->get_db_order_status_query()->result_array();

		// Get the row array of any refund data that may be available for the order, filtered by the order number in the url.
		$this->data['refund_data'] = $this->flexi_cart_admin->get_refund_summary_query($order_number)->result_array();
		$this->data['refund_data'] = $this->data['refund_data'][0];
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('admin/orders/order_details_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * update_order_details
	 * Reloads the saved cart data from a saved order into the users current cart session.
	 * Once the saved cart data is reloaded, the user can browse the store adding and updating items to the cart as normal.
	 * When the cart is resaved, the new cart data will update and overwrite the original saved order.
	 * The page includes an example of listing items that can be further added to the cart, and examples of how to apply discounts and surcharges all from within the same page.
	 *
	 * This page is accessed from the 'Order Details' page via the 'Edit Order' link.
	 */ 
	function update_order_details($order_number)
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_order'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_resave_order($order_number);
		}
		
		// Get the row array of the original order details, filtered by the order number in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$this->data['current_order_data'] = $this->flexi_cart_admin->get_db_order_summary_query(FALSE, $sql_where)->result_array();
		$this->data['current_order_data'] = $this->data['current_order_data'][0];

		// Get the id of the loaded cart data.
		$cart_data_id = $this->data['current_order_data'][$this->flexi_cart_admin->db_column('order_summary', 'cart_data')];

		// To prevent re-reloading the saved cart data (And losing any changes) every time the page is refreshed, check if the current CI session contains 
		// the cart data array matching the saved order data that is to be updated.		
		if ($this->flexi_cart_admin->cart_data_id() != $cart_data_id)
		{
			// Load saved cart data array from the confirmed order.
			// This data is loaded into the browser session as if you were shopping with the cart as a customer.
			$this->flexi_cart_admin->load_cart_data($cart_data_id, TRUE);
		}
		
		// This demo includes a list of items from the demo item table that can be added to the reloaded cart.
		// For simplicity, rather than including all example items that can be found in the demo, only items from the 'demo_items' table are used.
		// $this->load->model('demo_cart_model');
		// $this->data['item_data'] = $this->demo_cart_model->demo_get_item_data();

		// Get required data on cart items, summary discounts and cart surcharges for use on the cart.
		// Note: This demo requires the 'get_shipping_options()' function being loaded from the standard flexi cart library.

		$this->load->model('flexi_cart_model');
		$shipping_options = $this->flexi_cart_model->shipping_options($this->flexi->cart_contents['settings']['shipping']['location']);
		$shipping_options = $this->flexi_cart_model->rename_shipping_columns($shipping_options);
		
		$this->data['update_shipping_options'] = $shipping_options; 
		$this->data['update_cart_items'] = $this->flexi_cart_admin->cart_items(FALSE, TRUE, TRUE);
		$this->data['update_reward_vouchers'] = $this->flexi_cart_admin->reward_voucher_data(TRUE, TRUE);
		$this->data['update_discounts'] = $this->flexi_cart_admin->summary_discount_data(FALSE, TRUE, TRUE);
		$this->data['update_surcharges'] = $this->flexi_cart_admin->surcharge_data(FALSE, TRUE, TRUE);
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('admin/orders/order_details_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * unset_discount
	 * Removes a specific active item or summary discount from the cart. 
	 * This function is accessed from the 'Update Order Details' page via a 'Remove' link located in the description of an active discount.
	 */ 
	function unset_discount($discount_id = FALSE, $order_number = FALSE)
	{
		$this->load->library('flexi_cart');
		
		// If a discount id is submitted, then only that specific discount will be unset, if submitted as FALSE, all discounts are unset.
		$this->flexi_cart->unset_discount($discount_id);
		
		redirect('admin/update_order_details/'.$order_number);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * unset_surcharge
	 * Removes a specific surcharge from the cart.
	 * This function is accessed from the 'Update Order Details' page via a 'Remove' link located in the description of a surcharge.
	 */ 
	function unset_surcharge($surcharge_id = FALSE, $order_number = FALSE)
	{
		$this->load->library('flexi_cart');

		// If a surcharge id is submitted, then only that specific surcharge will be unset, if submitted as FALSE, all surcharges will be unset.
		$this->flexi_cart->unset_surcharge($surcharge_id);
		
		redirect('admin/update_order_details/'.$order_number);
	}	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// LOCATIONS AND ZONES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * LOCATIONS AND ZONES
	 * Location Types act as a parent grouping for locations, for example a location type of 'Country' would act as the parent to locations like 'United States', 'United Kingdom'.
	 * Locations can be setup to identify a users specific location. Shipping and tax rates can then be applied to each location.
	 * Zones can be setup so the shipping and tax rates can be applied to a range of locations, rather than each specific location. For example, EU and non EU European countries.
	 */
	
	/**
	 * location_types
	 * Displays a manageable list of all 'Locations Types'. Each row can be updated or deleted. 
	 */ 
	function location_types() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_location_types'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_location_types();
		}
	
		// Get an array of all location types.		
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_query()->result_array();
		
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->load->view('admin/locations/location_type_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_location_type
	 * Inserts new location types to the database. 
	 * This page is accessed via the 'Location' page via a link titled 'Insert New Location Type'.
	 */ 
	function insert_location_type() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_location_type'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_location_type();
		}
		
		// Get an array of all location types.		
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_query()->result_array();

		$this->load->view('admin/locations/location_type_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * locations
	 * Displays a manageable list of all 'Locations'. Each row can be updated or deleted.
	 * This page is accessed via the 'Location Type' page via a link on the row of the locations 'parent' (Location type).
	 */ 
	function locations($location_type_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_locations'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_locations();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get arrays of all shipping and tax zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');
	
		// Get the row array of the location type filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('location_type', 'id') => $location_type_id);
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_query(FALSE, $sql_where)->result_array();
		$this->data['location_type_data'] = $this->data['location_type_data'][0];

		// Get an array of all locations filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('locations', 'type') => $location_type_id);
		$this->data['location_data'] = $this->flexi_cart_admin->get_db_location_query(FALSE, $sql_where)->result_array();
	
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('admin/locations/location_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_location
	 * Inserts new locations to the database. 
	 * This page is accessed via the 'Location Type' page via a link on the row of the locations 'parent' (Location type), followed by a link similar to 'Insert New Location'.
	 */ 
	function insert_location($location_type_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_location'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_location($location_type_id);
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get arrays of all shipping and tax zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');
	
		// Get the row array of the location type filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('location_type', 'id') => $location_type_id);
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_query(FALSE, $sql_where)->result_array();
		$this->data['location_type_data'] = $this->data['location_type_data'][0];
		
		$this->load->view('admin/locations/location_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * zones
	 * Displays a manageable list of all 'Zones'. Each row can be updated or deleted.
	 */ 
	function zones() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_zones'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_zones();
		}
		
		// Get an array of all zones.
		$this->data['location_zone_data'] = $this->flexi_cart_admin->get_db_location_zone_query()->result_array();
	
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('admin/locations/zone_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_zone
	 * Inserts new location based zones to the database. 
	 * This page is accessed via the 'Zones' page via a link titled 'Insert New Zone'.
	 */ 
	function insert_zone() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_zone'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_zones();
		}

		$this->load->view('admin/locations/zone_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// SHIPPING OPTIONS AND RATES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * SHIPPING OPTIONS AND RATES
	 * Shipping can be setup to return a selection of different shipping options and rates related to a customers location and the weight and value of the cart.
	 */
	
	/**
	 * shipping
	 * Displays a manageable list of all shipping options. Each row can be updated or deleted.
	 */ 
	function shipping() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_shipping'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_shipping();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
	
		// Get an array of all shipping option data.
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_query()->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('admin/shipping/shipping_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_shipping
	 * Inserts new shipping options to the database. 
	 * This page is accessed via the 'Shipping Options' page via a link titled 'Insert New Shipping Option'.
	 */ 
	function insert_shipping() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_option') && $this->input->post('insert_rate'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_shipping();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
	
		$this->load->view('admin/shipping/shipping_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * shipping_rates
	 * Displays a manageable list of all shipping rates for a specific shipping option. Each row can be updated or deleted.
	 * This page is accessed via the 'Shipping Options' page via a link titled 'Manage'.
	 */ 
	function shipping_rates($shipping_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_shipping_rates'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_shipping_rate();
		}
		
		// Get the row array of the shipping option filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('shipping_options', 'id') => $shipping_id);
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_query(FALSE, $sql_where)->result_array();
		$this->data['shipping_data'] = $this->data['shipping_data'][0];
		
		// Get an array of all shipping rates filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('shipping_rates', 'parent') => $shipping_id);
		$this->data['shipping_rate_data'] = $this->flexi_cart_admin->get_db_shipping_rate_query(FALSE, $sql_where)->result_array();
		
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('admin/shipping/shipping_rate_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_shipping_rate
	 * Inserts new shipping rates to a specific shipping option in the database. 
	 * This page is accessed via the 'Shipping Options' page via a link titled 'Insert New Rates'.
	 */ 
	function insert_shipping_rate($shipping_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_shipping_rate'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_shipping_rate($shipping_id);
		}
		
		// Get the row array of the shipping option filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('shipping_options', 'id') => $shipping_id);
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_query(FALSE, $sql_where)->result_array();
		$this->data['shipping_data'] = $this->data['shipping_data'][0];
	
		$this->load->view('admin/shipping/shipping_rate_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * item_shipping
	 * Displays a manageable list of all shipping rates for a specific item. Each row can be updated or deleted.
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Shipping Rules' table column.	 
	 */ 
	function item_shipping($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_item_shipping'))
		{		
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_item_shipping();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_query('demo_items', FALSE, $sql_where)->result_array();
		$this->data['item_data'] = $this->data['item_data'][0];

		// Get an array of all item shipping rules filtered by the id in the url.		
		$sql_where = array($this->flexi_cart_admin->db_column('item_shipping', 'item') => $item_id);
		$this->data['item_shipping_data'] = $this->flexi_cart_admin->get_db_item_shipping_query(FALSE, $sql_where)->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('admin/items/item_shipping_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// TAXES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * TAXES
	 * Taxes can be setup to return a tax rate related to a customers location.
	 */
	
	/**
	 * tax
	 * Displays a manageable list of all tax rates. Each row can be updated or deleted.
	 */ 
	function tax() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_tax();
		}
	
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get an array of all tax rates.
		$this->data['tax_data'] = $this->flexi_cart_admin->get_db_tax_query()->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('admin/tax/tax_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_tax
	 * Inserts new tax rate to the database. 
	 * This page is accessed via the 'Taxes' page via a link titled 'Insert New Tax'.
	 */ 
	function insert_tax() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_tax();
		}
	
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		$this->load->view('admin/tax/tax_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * item_tax
	 * Displays a manageable list of all tax rates for a specific item. Each row can be updated or deleted.
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Taxes' table column.
	 */ 
	function item_tax($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_item_tax'))
		{		
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_item_tax();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_query('demo_items', FALSE, $sql_where)->result_array();
		$this->data['item_data'] = $this->data['item_data'][0];

		// Get an array of all the item tax rates filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('item_tax', 'item') => $item_id);
		$this->data['item_tax_data'] = $this->flexi_cart_admin->get_db_item_tax_query(FALSE, $sql_where)->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('admin/items/item_tax_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_item_tax
	 * Inserts new item tax rates for a specific item in the database. 
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Taxes' table column, followed by a link titled 'Insert New Item Tax Rates'.
	 */ 
	function insert_item_tax($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_item_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_item_tax($item_id);
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_query('demo_items', FALSE, $sql_where)->result_array();
		$this->data['item_data'] = $this->data['item_data'][0];
	
		$this->load->view('admin/items/item_tax_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// DISCOUNTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * DISCOUNTS
	 * Discounts can be setup with a wide range of rule conditions.
	 * The discounts can then be applied to specific items, groups of items or can be applied across the entire cart.
	 */ 
	
	/**
	 * item_discounts
	 * Displays a manageable list of all item discounts. Each row can be updated or deleted.
	 */ 
	function item_discounts() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discounts'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discounts();
		}
		
		// Get an array of all discounts filtered by a 'type' of 1 ('item discounts') and for purposes of this demo, have an id of 32+.
		$sql_where = array(
			$this->flexi_cart_admin->db_column('discounts', 'id').' >=' => 32,
			$this->flexi_cart_admin->db_column('discounts', 'type') => 1
		);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_query(FALSE, $sql_where)->result_array();
		
		// Set a variable to indicate on the html page that the discount is an 'item' discount.
		$this->data['discount_type'] = 'item';
	
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('admin/discounts/discounts_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * summary_discounts
	 * Displays a manageable list of all summary discounts. Each row can be updated or deleted.
	 */ 
	function summary_discounts() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discounts'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discounts();
		}

		// Get an array of all discounts filtered by a 'type' of 2 ('summary discounts').
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'type') => 2);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_query(FALSE, $sql_where)->result_array();
		
		// Set a variable to indicate on the html page that the discount is an 'summary' discount.
		$this->data['discount_type'] = 'summary';
	
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('admin/discounts/discounts_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * update_discount
	 * Updates data for an existing discount in the database. 
	 * This page is accessed via either the 'Item Discounts' or 'Summary Discounts' page via a link titled 'Edit'.
	 */ 
	function update_discount($discount_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discount'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount($discount_id);
		}

		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all zones.
		$this->data['zones'] = $this->flexi_cart_admin->location_zones();
		
		// Get an array of all discount types.		
		$this->data['discount_types'] = $this->flexi_cart_admin->get_db_discount_type_query()->result_array();
		
		// Get an array of all discount methods.	
		$this->data['discount_methods'] = $this->flexi_cart_admin->get_db_discount_method_query()->result_array();
		
		// Get an array of all discount tax methods.		
		$this->data['discount_tax_methods'] = $this->flexi_cart_admin->get_db_discount_tax_method_query()->result_array();
		
		// Get an array of all discount groups.		
		$this->data['discount_groups'] = $this->flexi_cart_admin->get_db_discount_group_query()->result_array();
		
		// Get an array of all demo items.		
		$this->data['items'] = $this->flexi_cart_admin->get_db_table_data_query('products')->result_array();

		// Get the row array of the discount filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'id') => $discount_id);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_query(FALSE, $sql_where)->result_array();
		$this->data['discount_data'] = $this->data['discount_data'][0];

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('admin/discounts/discount_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_discount
	 * Inserts a new item or summary discount to the database. 
	 * This page is accessed via either the 'Item Discounts' or 'Summary Discounts' page via a link titled 'Insert New Discount'.
	 */ 
	function insert_discount() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_discount'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount();
		}

		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all zones.
		$this->data['zones'] = $this->flexi_cart_admin->location_zones();
		
		// Get an array of all discount types.		
		$this->data['discount_types'] = $this->flexi_cart_admin->get_db_discount_type_query()->result_array();
		
		// Get an array of all discount methods.	
		$this->data['discount_methods'] = $this->flexi_cart_admin->get_db_discount_method_query()->result_array();
		
		// Get an array of all discount tax methods.		
		$this->data['discount_tax_methods'] = $this->flexi_cart_admin->get_db_discount_tax_method_query()->result_array();
		
		// Get an array of all discount groups.		
		$this->data['discount_groups'] = $this->flexi_cart_admin->get_db_discount_group_query()->result_array();
		
		// Get an array of all demo items.		
		$this->data['items'] = $this->flexi_cart_admin->get_db_table_data_query('products')->result_array();
	
		$this->load->view('admin/discounts/discount_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * discount_groups
	 * Displays a manageable list of all discount groups. Each row can be updated or deleted.
	 */ 
	function discount_groups() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discount_groups'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount_groups();
		}
	
		// Get an array of all discount groups.		
		$this->data['discount_group_data'] = $this->flexi_cart_admin->get_db_discount_group_query()->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('admin/discounts/discount_groups_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * update_discount_group
	 * Updates data for an existing discount group and its related discount group items in the database. 
	 * This page is accessed via the 'Discount Groups' page via a link titled 'Manage Items in Group'.
	 */ 
	function update_discount_group($group_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discount_group_items'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount_group($group_id);
		}
		
		// Get the row array of the discount group filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('discount_groups', 'id') => $group_id);
		$this->data['group_data'] = $this->flexi_cart_admin->get_db_discount_group_query(FALSE, $sql_where)->result_array();
		$this->data['group_data'] = $this->data['group_data'][0];
		
		// Get an array of all the discount group items filtered by the id in the url.
		// Using flexi cart SQL functions, join the demo item table with the discount group items and then order the data by item id.
		$this->flexi_cart_admin->sql_join('products', 'products.id = '.$this->flexi_cart_admin->db_column('discount_group_items', 'item')); 
		$this->flexi_cart_admin->sql_order_by('id');
		$sql_where = array($this->flexi_cart_admin->db_column('discount_group_items', 'group') => $group_id);		
		$this->data['group_item_data'] = $this->flexi_cart_admin->get_db_discount_group_item_query(FALSE, $sql_where)->result_array();
		
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('admin/discounts/discount_group_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_discount_group
	 * Inserts a new discount group and its related discount group items to the database. 
	 * This page is accessed via the 'Discount Groups' page via a link titled 'Insert New Group'.
	 */ 
	function insert_discount_group() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_discount_group'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount_group();
		}
	
		$this->load->view('admin/discounts/discount_group_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_discount_group_items
	 * Inserts new discount group items to the database. 
	 * This page is accessed via the 'Discount Groups' page via a link titled 'Insert New Items to Group'.
	 */ 
	function insert_discount_group_items($group_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.

		if ($this->input->post('insert_selected'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount_group_items($group_id);
			redirect('admin/update_discount_group/'.$group_id);
		}
		
		// Get the row array of the discount group filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('discount_groups', 'id') => $group_id);
		$this->data['group_data'] = $this->flexi_cart_admin->get_db_discount_group_query(FALSE, $sql_where)->result_array();
		$this->data['group_data'] = $this->data['group_data'][0];

		// Get product items to choose from.
		// Get products.
		$this->load->library('store');
		$products = $this->store->products($options = array(
			'order' => 'alpha'
		));
		$this->data['products'] = $products['rows'];	
		$this->data['products_total'] = $products['total'];	
		$this->data['pagination'] = $products['pagination'];

		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('admin/discounts/discount_group_items_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// REWARD POINTS AND VOUCHERS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * REWARD POINTS AND VOUCHERS
	 * Customers can earn reward points when purchasing cart items. The reward points can then be converted to vouchers that can be used to buy other items.
	 */ 
	
	/**
	 * user_reward_points
	 * Displays a summary list of all users and their reward points.
	 */ 
	function user_reward_points() 
	{
		$this->load->model('demo_cart_admin_model');
		
		// Get an array of all demo users and their related reward points from a custom demo model function.
		$this->data['user_data'] = $this->demo_cart_admin_model->demo_reward_point_summary();
		
		$this->load->view('admin/reward_points/user_reward_points_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * user_reward_point_history
	 * Displays an itemised list of all earnt and converted user reward points.
	 * This page is accessed via the 'Reward Points' page via a link titled 'View' in the 'History' table column.
	 */ 
	function user_reward_point_history($user_id)
	{
		$this->load->model('demo_cart_admin_model');
		
		// Get the row array of the demo users filtered by the id in the url.
		$sql_where = array('id' => $user_id);
		$this->data['user_data'] = $this->flexi_cart_admin->get_db_table_data_query('users', FALSE, $sql_where)->result_array();
		if (!empty($this->data['user_data'])) $this->data['user_data'] = $this->data['user_data'][0];
	
		// Get an array of all reward points for a user filtered by the id in the url.
		// The 'get_user_reward_points()' function only returns the minimum required fields, therefore define the other required table fields via an SQL SELECT statement.
		$sql_select = array(
			$this->flexi_cart_admin->db_column('reward_points', 'order_number'),
			$this->flexi_cart_admin->db_column('reward_points', 'description'),
			$this->flexi_cart_admin->db_column('reward_points', 'order_date')
		);	
		$sql_where = array($this->flexi_cart_admin->db_column('reward_points', 'user') => $user_id);
		$this->data['points_awarded_data'] = $this->flexi_cart_admin->get_db_reward_points_query($sql_select, $sql_where)->result_array();
		
		// Call a custom function that returns a nested array of reward voucher codes and the reward point data used to create the voucher.
		$this->data['points_converted_data'] = $this->demo_cart_admin_model->demo_converted_reward_point_history($user_id);
		
		$this->load->view('admin/reward_points/user_reward_point_history_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * user_vouchers
	 * Displays a list of all reward vouchers for a specific user. Each row can be updated.
	 * This page is accessed via the 'Reward Points' page via a link titled 'View' in the 'Vouchers' table column.
	 */ 
	function user_vouchers($user_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_vouchers'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_voucher();
		}
	
		// Get the row array of the demo user filtered by the id in the url.
		$sql_where = array('user_id' => $user_id);
		$this->data['user_data'] = $this->flexi_cart_admin->get_db_table_data_query('demo_users', FALSE, $sql_where)->result_array();
		if(!empty($this->data['user_data'])) $this->data['user_data'] = $this->data['user_data'][0];

		// Get an array of all the reward vouchers filtered by the id in the url.
		// Using flexi cart SQL functions, join the demo user table with the discount table.
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'user') => $user_id);
		$this->flexi_cart_admin->sql_join('demo_users', 'user_id = '.$this->flexi_cart_admin->db_column('discounts', 'user'));
		$this->data['voucher_data'] = $this->flexi_cart_admin->get_db_voucher_query(FALSE, $sql_where)->result_array();
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/reward_points/user_vouchers_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * vouchers
	 * Displays a list of all reward vouchers. Each row can be updated.
	 */ 
	function vouchers() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_vouchers'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_voucher();
		}
	
		// Get an array of all reward vouchers.
		// Using flexi cart SQL functions, join the demo users table with the discount table.
		$this->flexi_cart_admin->sql_join('users', 'id = '.$this->flexi_cart_admin->db_column('discounts', 'user'));
		$this->data['voucher_data'] = $this->flexi_cart_admin->get_db_voucher_query()->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/reward_points/vouchers_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * convert_reward_points
	 * Converts a submitted number of reward points into a reward voucher.
	 * This page is accessed via the 'Reward Points' page via a link titled 'Convert' in the 'Vouchers' table column.
	 */ 
	function convert_reward_points($user_id) 
	{
		$this->load->model('demo_cart_admin_model');
		
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('convert_reward_points'))
		{
			$this->demo_cart_admin_model->demo_convert_reward_points($user_id);
			redirect('admin/user_vouchers/'.$user_id);
		}

		// Get an array of a demo user and their related reward points from a custom demo model function, filtered by the id in the url.
		$user_data = $this->demo_cart_admin_model->demo_reward_point_summary($user_id);
		
		// Note: The custom function returns a multi-dimensional array, of which we only need the first array, so get the first row '$user_data[0]'.
		$this->data['user_data'] = $user_data[0];
		
		// Get the conversion tier values for converting reward points to vouchers.
		$conversion_tiers = $this->data['user_data'][$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')];
		$this->data['conversion_tiers'] = $this->flexi_cart_admin->get_reward_point_conversion_tiers($conversion_tiers);
		
		$this->load->view('admin/reward_points/user_reward_point_convert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CURRENCY
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * currency
	 * Displays a manageable list of all currencies. Each row can be updated or deleted.
	 */ 
	function currency() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_currency'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_currency();
		}

		// Get an array of all currencies.
		$this->data['currency_data'] = $this->flexi_cart_admin->get_db_currency_query()->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('admin/currency/currency_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_currency
	 * Inserts new currencies to the database. 
	 * This page is accessed via the 'Currency' page via a link titled 'Insert New Currency'.
	 */ 
	function insert_currency() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_currency'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_currency();
		}

		$this->load->view('admin/currency/currency_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ORDER STATUS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * order_status
	 * Displays a manageable list of all order statuses. Each row can be updated or deleted.
	 */ 
	function order_status() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_order_status'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_order_status();
		}

		// Get an array of all order statuses.
		$this->data['order_status_data'] = $this->flexi_cart_admin->get_db_order_status_query()->result_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('admin/orders/order_status_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_order_status
	 * Inserts new order statuses to the database. 
	 * This page is accessed via the 'Order Status' page via a link titled 'Insert New Order Status'.
	 */ 
	function insert_order_status()
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_order_status'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_order_status();
		}

		$this->load->view('admin/orders/order_status_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CART CONFIGURATION AND DEFAULTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * config
	 * Updates the carts configuration data in the database. 
	 */ 
	function config() 
	{
		// Check function config(if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_config'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_config();
		}
		
		// Get the row array of the config table.
		$this->data['config'] = $this->flexi_cart_admin->get_db_config_query()->result_array();
		if(!empty($this->data['config'])) $this->data['config'] = $this->data['config'][0];

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/config/config_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * defaults
	 * Sets the default cart values for the currency, shipping and tax tables. 
	 */ 
	function defaults() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_defaults'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_defaults();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all currencies.
		$this->data['currency_data'] = $this->flexi_cart_admin->get_db_currency_query()->result_array();

		// Get an array of all shipping options.
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_query()->result_array();

		// Get an array of all tax rate.
		$this->data['tax_data'] = $this->flexi_cart_admin->get_db_tax_query()->result_array();

		// Get current cart defaults.
		$this->data['default_currency'] = $this->flexi_cart_admin->get_db_currency_query(FALSE, array('curr_default' => 1))->result_array();
		if(!empty($this->data['default_currency'])) $this->data['default_currency'] = $this->data['default_currency'][0];
		$this->data['default_ship_location'] = $this->flexi_cart_admin->get_db_location_query(FALSE, array('loc_ship_default' => 1))->result_array();
		if (!empty($this->data['default_ship_location'])) $this->data['default_ship_location'] = $this->data['default_ship_location'][0];
		$this->data['default_tax_location'] = $this->flexi_cart_admin->get_db_location_query(FALSE, array('loc_tax_default' => 1))->result_array();
		if (!empty($this->data['default_tax_location'])) $this->data['default_tax_location'] = $this->data['default_tax_location'][0];
		$this->data['default_ship_option'] = $this->flexi_cart_admin->get_db_shipping_query(FALSE, array('ship_default' => 1))->result_array();
		$this->data['default_tax_rate'] = $this->flexi_cart_admin->get_db_tax_query(FALSE, array('tax_default' => 1))->result_array();
		if (!empty($this->data['default_tax_rate'])) $this->data['default_tax_rate'] = $this->data['default_tax_rate'][0];

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/config/defaults_update_view', $this->data);
	}
	
	function payments()
	{
		$this->load->helper('file');

        $config_file = APPPATH.'config'.DIRECTORY_SEPARATOR.'payments.php';
        $config_perm = octal_permissions(fileperms($config_file));
        
        if ($config_perm === '666' || $config_perm === '777' || $config_perm === '744' || $config_perm === '644') {
			// 644 applies to files that are writable
            $config_data = file_get_contents($config_file);
        } else {
            // User does not have file read permission.
            $this->dashman->set_message('An error occured while accessing settings', 'error');
        }

        include $config_file;
        
        if ($this->input->post('save')) {
			$formatted = $config;
			
			if($paypal_data = $this->input->post('paypal')) {
				
				foreach ($paypal_data as $key => $value) {
					if ($key == 'sandbox') {
						$formatted['paypal'][$key] = ($value == '0') ? false : true;
					} else {
						$formatted['paypal'][$key] = filter_var($value, FILTER_SANITIZE_STRING);
					}
				}
			}
			
			switch ($this->input->post('isactive')) {
				case 'paypalExpress':
					$formatted['active'] = 'paypalExpress';
					break;
				case 'paypalPro':
					$formatted['active'] = 'paypalPro';
					break;
				case 'stripe':
					$formatted['active'] = 'stripe';
					break;
				default:
					$formatted['active'] = 'paypalExpress';
					break;
			}

            if ($config === $formatted && empty($formatted)) {
                // Submitted, without any changes
				$this->flexi_cart_admin->set_error_message('You did not make any changes', 'admin', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
                redirect(current_url());
			}

            // Write data to config file with CI security standard at top.
            $field_data = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); \n";
			$field_data .= ('$config = '.var_export($formatted, true)).';';
			$is_written = write_file($config_file, $field_data); 
			
			if($this->input->is_ajax_request()) {
				header_remove();
				header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
				header('Content-Type: application/json');
				echo ($is_written) ? true : false;
			} else {
				if ($is_written) {
					$this->flexi_cart_admin->set_status_message('Your settings were saved successfully', 'admin', TRUE);
				} else {
					// Unable to write the file
					$this->flexi_cart_admin->set_error_message('Your settings could not be saved', 'admin', TRUE);
				}
				
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect(current_url());
			}

        }

		if(!$this->input->is_ajax_request()) {
			$this->data['settings'] = $config;
			$this->data['message'] = $this->session->flashdata('message');
			
			$this->load->view('admin/config/payments_view', $this->data);
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// LOCATION MENU EXAMPLE
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * demo_location_menus
	 * A demo example of how location data can be displayed via html select menus with a JavaScript and non Javascript example.
	 */ 
	function demo_location_menus()
	{
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		$this->load->view('admin/locations/location_menu_demo_view', $this->data);		
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER CREATED PAGES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * pages
	 * View and edit user pages.
	 */ 
	public function pages()
	{
		$this->load->model('pages_model');

		$this->load->library('form_validation');

		if ($this->input->post('delete_selected'))
		{
			$this->form_validation->set_rules('selected[]', 'above', 'required');

			if ($this->form_validation->run())
			{
				$response = $this->pages_model->delete_multiple($this->input->post('selected[]'));
				redirect(current_url());
			}
		}

		$this->data['pages'] = $this->pages_model->get_pages();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/pages/pages_view', $this->data);
	}	
	
	/**
	 * update_page
	 * View and edit user page.
	 */ 
	public function update_page($id)
	{
		$this->load->model('pages_model');

		$this->load->library('form_validation');

		if ($this->input->post('update_page'))
		{
			$this->form_validation->set_rules('name', 'above', 'required');
			$this->form_validation->set_rules('body', 'above', 'required');

			if ($this->form_validation->run())
			{
				$response = $this->pages_model->update_page($id);
				redirect(current_url());
			}
		}

		$this->data['page_data'] = $this->pages_model->get_pages($id);

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/pages/pages_update_view', $this->data);
	}

	/**
	 * insert_page
	 * Insert a new page.
	 */ 
	public function insert_page()
	{
		$this->load->model('pages_model');

		$this->load->library('form_validation');

		if ($this->input->post('insert_page'))
		{
			$this->form_validation->set_rules('name', 'above', 'required|is_unique[pages.name]', array('is_unique' => 'A Page with this name already exists'));
			$this->form_validation->set_rules('body', 'above', 'required');

			if ($this->form_validation->run())
			{
				if ($this->pages_model->add_page())
				{
					redirect('admin/pages');
				}
				else
				{
					redirect(current_url());
				}
			}
		}

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/pages/pages_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER BANNERS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * banners
	 * View and edit user banners.
	 */ 
	public function banners($id = NULL)
	{
		$this->load->model('banners_model');

		$this->load->library('form_validation');

		if ($this->input->post('delete_selected'))
		{
			$this->form_validation->set_rules('selected[]', 'above', 'required');

			if ($this->form_validation->run())
			{
				$response = $this->banners_model->delete_multiple($this->input->post('selected[]'));
				redirect(current_url());
			}
		}

		if ($this->input->post('update_page'))
		{
			$this->form_validation->set_rules('name', 'above', 'required');
			$this->form_validation->set_rules('body', 'above', 'required');

			if ($this->form_validation->run())
			{
				$response = $this->pages_model->update_page($id);
				redirect(current_url());
			}
		}

		$this->data['banners'] = $this->banners_model->get_banners();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/banners/banners_view', $this->data);
	}

	/**
	 * insert_banner
	 * Insert a new page.
	 */ 
	public function insert_banner()
	{
		$this->load->model('banners_model');

		$this->load->library('form_validation');

		if ($this->input->post('insert_banner'))
		{
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_is_date_valid');
			$this->form_validation->set_rules('end_date', 'End Date', 'required|callback_is_date_valid');

			if ($this->form_validation->run())
			{
				$is_banner_inserted = $this->banners_model->insert_banner();

				if ($this->input->post('add_another') OR !$is_banner_inserted)
				{
					// Display insert banner page if user indicated so
					// or if the banner was not added successfully
					redirect(current_url());
				}
				else
				{
					redirect('admin/banners');
				}
			}
		}

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/banners/banner_insert_view', $this->data);
	}

	/**
	 * update_banner
	 * Update a banner.
	 */ 
	public function update_banner($id)
	{
		$this->load->model('banners_model');

		$this->load->library('form_validation');

		if ($this->input->post('update_banner'))
		{
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_is_date_valid');
			$this->form_validation->set_rules('end_date', 'End Date', 'required|callback_is_date_valid');

			if ($this->form_validation->run())
			{
				$this->banners_model->update_banner();
				redirect(current_url());
			}
		}

		$this->data['banner']  = $this->banners_model->get_banner_details($id);
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('admin/banners/banner_update_view', $this->data);
	}

	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// MINI CART DATA
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * mini_cart_data
	 * This function is called by the '__construct()' to set item data to be displayed on the 'Mini Cart' menu.
	 */ 
	private function mini_cart_data()
	{
		$this->data['mini_cart_items'] = $this->flexi_cart_admin->cart_items();
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CUSTOM VALIDATION CALLBACKS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * userfile_check
	 * Custom validation for user uploaded files
	 */
	function userfile_check()
	{
		if ($_FILES['userfile']['size'] > 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('userfile_check', 'The {field} file is required');
			return FALSE;
		}
	}

	/**
	 * is_date_valid
	 * Custom Validation for date not to be in past
	 */
	function is_date_valid($str)
	{
		$this->load->helper('date');

		if (mysql_to_unix(date('Y-m-d')) <= mysql_to_unix($str))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('is_date_valid', 'The {field} must not be in the past');
			return FALSE;
		}
	}


	/**
	 * password_check
	 * Custom validation for user password match
	 */
	function password_check($old_password)
	{
		if ($this->ion_auth->hash_password_db($this->data['user']->id, $old_password))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('password_check', 'Sorry, the password did not match');
			return FALSE;
		}
	}

	/**
	 * upload_image
	 * Upload image to the server
	 */
	private function upload_image($filename = NULL)
	{
		// Path that the logo image will be uploaded to
		$uploadPath = $this->data['app']['file_path'];

		// Ensure that the upload directory exists
		if ( ! file_exists($uploadPath) )
		{
			if ( ! mkdir($uploadPath, 0777, true) )
			{
				// Return an error if it should occur
				return array(
					"error" => 'create directory "assets/images/store" and retry'
				);
			}
		}
		// Load the CI upload library
		$config['upload_path'] 		= $uploadPath;
        $config['allowed_types']	= 'gif|jpg|png';
        $config['max_width'] 		= 0;
        $config['max_height'] 		= 0;
        $config['max_size'] 		= 0;
		$config['remove_spaces'] 	= FALSE;
        $config['encrypt_name'] 	= TRUE;
        $config['overwrite'] 		= FALSE;
        $this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			// Return an error if it should occur
			return array(
				'error' => $this->upload->display_errors()
			);
		}
		else
		{
			// Remove the old logo.
			if ($filename AND is_file($filename))
			{
				unlink($filename);
			}

			// Get file properties data.
			$imageData = $this->upload->data();

			if ($this->input->post('crop_width') AND $this->input->post('crop_height'))
			{
				// Crop Banner image.
				$this->load->library('image_lib');
				$config['source_image']	  = $uploadPath.$imageData['file_name'];
				$config['maintain_ratio'] = FALSE;
				$config['width'] 	= $this->input->post('crop_width');
				$config['height'] 	= $this->input->post('crop_height');
				$config['x_axis'] 	= $this->input->post('crop_x');
				$config['y_axis'] 	= $this->input->post('crop_y');

				$this->image_lib->initialize($config); 

				if ( ! $this->image_lib->crop())
				{
					echo $this->image_lib->display_errors();
				}
			}


			// Resize the logo.
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= $uploadPath.$imageData['file_name'];
			$config['file_name']		= $uploadPath.$imageData['file_name'];
			$config['create_thumb'] 	= FALSE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']	 		= 150;
			$config['height']			= 150;

			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			$this->image_lib->resize($config);

			return array(
				'error' => FALSE,
				'path' => $uploadPath.$imageData['file_name']
			);
		}
	}

	private function time_elapsed_string($datetime, $full = false) {
		$this->load->helper('date');
		$datetime = unix_to_human($datetime);
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
			);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */