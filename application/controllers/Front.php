<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends CI_Controller {

	function __construct() 
	{
		parent::__construct();

		// IMPORTANT! This global must be defined BEFORE the flexi cart library is loaded! 
 		// It is used as a global by the library, without it, flexi cart will not work.
		$this->flexi = new stdClass;

		// Load required libraries.
		$this->load->library(array(
			'flexi_cart', 'session', 'form_validation', 'ion_auth', 'store'
		));
		// Load required models.
		$this->load->model(array(
			'users_model','category_model','product_model'
		));
		// Load required config files.
		$this->load->config('app');

		// Initialize data used by view pages.
		$this->data = array(
			'app' 	=> $this->config->item('app'),
			'owner' => $this->users_model->owner(),
			'user' 	=> NULL,
		);

    	// Check if a non admin user is logged in.
		if ($this->ion_auth->logged_in() && !$this->ion_auth->is_admin())
		{
			$this->data['user'] = $this->users_model->current();
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
			// Redirect logged in users and admins to the home page.
			if ($this->ion_auth->logged_in() OR $this->ion_auth->is_admin()) redirect();

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

					// Check if the user is an admin!
					if ($this->ion_auth->is_admin())
					{
						// Log the admin out
						$this->ion_auth->logout();

						// Let admin know what happened
						$this->flexi_cart->set_error_message('You cannot log in here', 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));

						// Reload login page.
						redirect('login');
					}

					$this->load->model('users_model');
					$user = $this->users_model->current();

					// Welcome user by first name.
					$this->flexi_cart->set_status_message('Hi, '.$user->first_name.'. welcome back!', 'public', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));

					redirect();
				}
				else
				{
					// Login was un-successful, set appropriate message
					$this->flexi_cart->set_error_message($this->ion_auth->errors(), 'public', TRUE);
					$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));

					// use redirects instead of loading views for compatibility with MY_Controller libraries
					redirect('login', 'refresh');
				}
			}

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/auth/login_view', $this->data);
		}

		/**
		 * logout
		 * logout the user
		 */
		function logout()
		{
			// log the user out
			$logout = $this->ion_auth->logout();
			redirect('login');
		}

		/**
		 * forgot_password
		 * reset forgotten password
		 */
		function forgot_password()
		{
			// setting validation rules by checking whether identity is email
		   $this->form_validation->set_rules('identity', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == false)
			{
				$this->data['type'] = $this->config->item('identity','ion_auth');
			}
			else
			{
				$identity = $this->ion_auth->where('email', $this->input->post('identity'))->users()->row();

				if(empty($identity)) {

	        		if($this->config->item('identity', 'ion_auth') != 'email')
	            	{
						$this->flexi_cart->set_error_message('No record of that username', 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
	            	}
	            	else
	            	{
						$this->flexi_cart->set_error_message('No record of that email address', 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
	            	}
	    		}
	    		else
	    		{
					// run the forgotten password method to email an activation code to the user
					$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

					if ($forgotten)
					{
						// if there were no errors
						$this->flexi_cart->set_status_message($this->ion_auth->messages(), 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
						
						// we should display a confirmation page here instead of the login page
						redirect("login", 'refresh');
					}
					else
					{
						$this->flexi_cart->set_error_message($this->ion_auth->errors(), 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
						redirect(current_url(), 'refresh');
					}
	    		}
			}
			

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');
			$this->load->view('public/auth/forgot_password', $this->data);
		}

		/**
		 * reset_password
		 * final step for forgotten password
		 */
		function reset_password($code = NULL)
		{
			if (!$code)
			{
				show_404();
			}

			$user = $this->ion_auth->forgotten_password_check($code);

			if ($user)
			{
				// if the code is valid then display the password reset form

				$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
				$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

				if ($this->form_validation->run() == false)
				{
					// display the form

					// set the flash data error message if there is one
					$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

					$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
					$this->data['new_password'] = array(
						'name' => 'new',
						'id'   => 'new',
						'type' => 'password',
						'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
					);
					$this->data['new_password_confirm'] = array(
						'name'    => 'new_confirm',
						'id'      => 'new_confirm',
						'type'    => 'password',
						'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
					);
					$this->data['user_id'] = array(
						'name'  => 'user_id',
						'id'    => 'user_id',
						'type'  => 'hidden',
						'value' => $user->id,
					);
					$this->data['csrf'] = $this->_get_csrf_nonce();
					$this->data['code'] = $code;

					// render
					$this->load->view('auth/reset_password', $this->data);
				}
				else
				{
					// do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
					{
						// something fishy might be up
						$this->ion_auth->clear_forgotten_password_code($code);
						show_error($this->lang->line('error_csrf'));
					}
					else
					{
						// finally change the password
						$identity = $user->{$this->config->item('identity', 'ion_auth')};

						$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

						if ($change)
						{
							// if the password was successfully changed
							$this->flexi_cart->set_status_message($this->ion_auth->messages(), 'public', TRUE);
							$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
							redirect("auth/login", 'refresh');
						}
						else
						{
							$this->flexi_cart->set_error_message($this->ion_auth->errors(), 'public', TRUE);
							$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
							redirect('auth/reset_password/' . $code, 'refresh');
						}
					}
				}
			}
			else
			{
				// if the code is invalid then send them back to the forgot password page
				$this->flexi_cart->set_error_message($this->ion_auth->errors(), 'public', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
				redirect("auth/forgot_password", 'refresh');
			}
		}

		/**
		 * register
		 * Register a new user
		 */
		function register()
		{
			if ($this->input->post('create_user'))
			{
				if ($this->data['user'])
				{
					if ($this->ion_auth->in_group('public'))
					{
						$this->session->set_flashdata('alert', array(
							'type' => 'danger',
							'message' => 'You are already registered.'
						));

						// redirect them back to this page.
						redirect(current_url(), 'refresh');
					}
				}

				$tables = $this->config->item('tables','ion_auth');
				$identity_column = $this->config->item('identity','ion_auth');
				$this->data['identity_column'] = $identity_column;

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

					if ($_FILES['userfile']['size'] > 0)
					{
						$avatar = $this->upload_image();
						if ( ! $avatar['error'])
							$profile['avatar'] = $avatar['path'];
					}

					$user_id = $this->ion_auth->register($identity, $password, $email, $profile, $group);

					$this->load->library('flexi_cart_admin');

					if ($user_id)
					{
						// Define profile information.
						// $this->users_model->add($profile);

						$this->flexi_cart_admin->set_status_message('Account was successfully created', 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('public'));

						// redirect them back to the login page
						redirect("login", 'refresh');
					}
					else
					{
						$this->flexi_cart_admin->set_error_message(($this->ion_auth->errors() ? $this->ion_auth->errors() : 'Account could not be created'), 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('public'));

						// redirect them back to the login page
						redirect("register", 'refresh');
					}
				}
			}

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			// display the create user form
			$this->load->view('public/auth/register_user', $this->data);
		}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER DASHBOARD
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
		/**
		 * User Dashboard.
		 * Overview of user functions
		 */ 
		function user_dashboard()
		{
			if ( ! $this->data['user'])
			{
				$this->flexi_cart->set_error_message('You must login first.', 'public', TRUE);
				redirect('login');
			}

			$this->load->library('flexi_cart_admin');

			$reward_data = $this->flexi_cart_admin->get_db_reward_point_summary($this->data['user']->id);
			
			$this->data['reward_points'] = $reward_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')];
			$this->data['max_points_value'] = $this->flexi_cart_admin->calculate_conversion_reward_points($this->data['reward_points']);

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/dashboard/dashboard_view', $this->data);
		}

		/**
		 * Profile.
		 * Manage user's saved carts
		 */ 
		function profile()
		{
			if ( ! $this->data['user'])
			{
				$this->flexi_cart->set_error_message('You must login first.', 'public', TRUE);
				redirect('login');
			}

			$this->load->model('users_model');
			$this->load->library(array('ion_auth', 'form_validation'));

			$this->data['user'] = $this->users_model->get_details($this->data['user']->id);

			// validate form input
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('first_name', 'first name', 'required');
			$this->form_validation->set_rules('last_name', 'last name', 'required');
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			$this->form_validation->set_rules('phone', 'Phone Number', 'required');
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
					// Set the user profile data.
					$user_data = array(
						'username' => $this->input->post('username'),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'email'	=> $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'postal' => $this->input->post('postal'),
						'address' => $this->input->post('address'),
					);

					// Handle uploaded image(avatar).
					if ($_FILES['userfile']['size'] > 0)
					{
						// Get the image name.
						$filename = $this->data['user']->avatar;
						$avatar = $this->upload_image($filename);

						if ( ! $avatar['error'])
						{
							$user_data['avatar'] = $avatar['path'];
						}
					}

					// Set appropriate messages following user update
				   if($this->ion_auth->update($this->data['user']->id, $user_data))
				    {
						$this->flexi_cart->set_status_message($this->ion_auth->messages(), 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
				    }
				    else
				    {
						$this->flexi_cart->set_error_message($this->ion_auth->errors(), 'public', TRUE);
						$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));

					}
					
					$this->data['message'] = $this->session->flashdata('message');
					redirect('profile', 'refresh');
				}
			}

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/dashboard/user_profile_view', $this->data);
		}

		/**
		 * change_password
		 * Change a user's password
		 */
		function change_password()
		{
			if ($this->input->post('change_password'))
			{
				$this->form_validation->set_rules('old_password', 'above', 'required');
				$this->form_validation->set_rules('password', 'above', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'above', 'required');


				if ($this->form_validation->run())
				{
					$identity = $this->session->userdata('identity');
					$old_pass = $this->input->post('old_password');
					$new_pass = $this->input->post('password');

					if ($this->ion_auth->change_password($identity, $old_pass, $new_pass))
					{
						$this->flexi_cart->set_status_message($this->ion_auth->messages(), 'public', TRUE);
						// Logout so the user can re-login.
						$this->logout();
					}
					else
					{
						$this->flexi_cart->set_error_message($this->ion_auth->errors(), 'public', TRUE);
						redirect(current_url());
					}
				}
			}

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->load->view('public/dashboard/change_password', $this->data);
		}

		/**
		 * User Orders.
		 * View user's orders
		 */ 
		function orders()
		{
			if ( ! $this->data['user'])
			{
				$this->flexi_cart->set_error_message('You must login to view orders.', 'public', TRUE);
				redirect('login');
			}

			// The load/save/delete cart data functions require the flexi cart ADMIN library.
			$this->load->library('flexi_cart_admin');

			// Get an array of all saved orders. 
			// Using a flexi cart SQL function, set the order the order data so that dates are listed newest to oldest.
			// $this->flexi_cart_admin->sql_where($this->flexi_cart_admin->db_column('order_summary', 'user'), $this->data['user']->id);
			// $this->flexi_cart_admin->sql_order_by($this->flexi_cart_admin->db_column('order_summary', 'date'), 'desc');
			// $this->data['order_data'] = $this->flexi_cart_admin->get_db_order_query()->result_array();
			
			$this->db->from('order_summary');
			$this->db->join('order_status', 'order_status.ord_status_id = order_summary.ord_status');
			$this->db->join('order_details', 'order_details.ord_det_order_number_fk = order_summary.ord_order_number');
			$this->db->order_by('order_summary.ord_date');
			$this->db->order_by('order_summary.ord_order_number');
			$this->db->where('ord_user_fk', $this->data['user']->id);
			$this->data['order_data'] = $this->db->get()->result_array();

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/dashboard/orders_view', $this->data);
		}

		/**
		 * User Order.
		 * View user's order details
		 */ 
		function order($order_number)
		{
			if ( ! $this->data['user'])
			{
				$this->flexi_cart->set_error_message('You must login to view orders.', 'public', TRUE);
				redirect('login');
			}

			// The load/save/delete cart data functions require the flexi cart ADMIN library.
			$this->load->library('flexi_cart_admin');

			// Get the row array of the order filtered by the order number in the url.
			$sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
			$summary_data = $this->flexi_cart_admin->get_db_order_summary_query(FALSE, $sql_where)->result_array();

			$summary_data[0]['has_savings'] = ($summary_data[0]['ord_savings_total'] > 0) ? true : false;
			$summary_data[0]['has_surcharge'] = ($summary_data[0]['ord_surcharge_total'] > 0) ? true : false;
			$summary_data[0]['has_voucher'] = ($summary_data[0]['ord_reward_voucher_total'] > 0) ? true : false;
			
			$summary_data[0]['ord_item_summary_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_item_summary_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_item_summary_savings_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_item_summary_savings_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_shipping_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_shipping_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_item_shipping_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_item_shipping_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_summary_savings_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_summary_savings_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_savings_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_savings_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_surcharge_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_surcharge_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_reward_voucher_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_reward_voucher_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_tax_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_tax_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_sub_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_sub_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_total'] = $this->flexi_cart->get_currency_value($summary_data[0]['ord_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
			$summary_data[0]['ord_total_weight'] = number_format($summary_data[0]['ord_total_weight']);
			$summary_data[0]['ord_date'] = date('jS, M Y', strtotime($summary_data[0]['ord_date']));
			
			// foreach ($summary_data[0] as $key => $value) {
			// 	var_dump($key.'-----------------'.$value);
			// 	echo '<hr>';

			// }
			// exit();

			$this->data['summary_data'] = $summary_data[0];

			// Get an array of all order details related to the above order, filtered by the order number in the url.
			$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $order_number);
			$item_data = $this->flexi_cart_admin->get_db_order_detail_query(FALSE, $sql_where)->result_array();
			
			foreach ($item_data as $key => $value) {
				$item_data[$key]['price'] = $this->flexi_cart->get_currency_value($value['ord_det_price'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
				$item_data[$key]['price_total'] = $this->flexi_cart->get_currency_value($value['ord_det_price_total'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
				$item_data[$key]['has_tax'] = ($value['ord_det_tax'] > 0) ? true : false;
				$item_data[$key]['tax'] = $this->flexi_cart->get_currency_value($value['ord_det_tax'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
				$item_data[$key]['has_discount'] = ($value['ord_det_discount_price'] > 0) ? true : false;
				$item_data[$key]['discount'] = $this->flexi_cart->get_currency_value($value['ord_det_discount_price'], $format = true, $decimals = 2, $inverse = false, $summary_data[0]['ord_currency']);
				$item_data[$key]['quantity'] = round($value['ord_det_quantity'], 1);
				$item_data[$key]['quantity_shipped'] = round($value['ord_det_quantity_cancelled'], 1);
				$item_data[$key]['quantity_cancelled'] = round($value['ord_det_quantity_cancelled'], 1);
			}

			$this->data['item_data'] = $item_data;
			
			// Get an array of all order statuses that can be set for an order.
			// The data is then to be displayed via a html select input to allow the user to update the orders status.
			$this->data['status_data'] = $this->flexi_cart_admin->get_db_order_status_query()->result_array();

			// Get the row array of any refund data that may be available for the order, filtered by the order number in the url.
			$this->data['refund_data'] = $this->flexi_cart_admin->get_refund_summary_query($order_number)->result_array();
			$this->data['refund_data'] = $this->data['refund_data'][0];

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/dashboard/order_details_view', $this->data);
		}

		/**
		 * User Carts.
		 * Manage user's saved carts
		 */ 
		function carts()
		{
			if ( ! $this->data['user'])
			{
				$this->flexi_cart->set_error_message('You must login to view saved carts.', 'public', TRUE);
				redirect('login');
			}

			// The load/save/delete cart data functions require the flexi cart ADMIN library.
			$this->load->library('flexi_cart_admin');

			// Create an SQL WHERE clause to list all previously saved cart data for a specific user.
			// This examples also prevents cart session data from confirmed orders being loaded, by checking the readonly status is set at '0'.
			$sql_where = array(
				$this->flexi_cart->db_column('db_cart_data', 'user') => $this->data['user']->id,
				$this->flexi_cart->db_column('db_cart_data', 'readonly_status') => 0
			);
			// Get a list of all saved carts that match the SQL WHERE statement.
			$this->data['saved_cart_data'] = $this->flexi_cart_admin->get_db_cart_data_query(FALSE, $sql_where)->result_array();

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/dashboard/carts_view', $this->data);
		}

		/**
		 * Points and Vouchers.
		 * Manage user's points and vouchers
		 */ 
		function points_vouchers()
		{
			if ( ! $this->data['user'])
			{
				$this->flexi_cart_admin->set_error_message('You must login to view reward points and vouchers.', 'public', TRUE);
				redirect('login');
			}

			$user_id = $this->data['user']->id;

			$this->load->library('flexi_cart_admin');

			$this->load->model('demo_cart_admin_model');

			// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
			if ($this->input->post('convert_reward_points'))
			{
				$this->demo_cart_admin_model->demo_convert_reward_points($user_id);

				$this->flexi_cart->set_status_message($this->input->post('convert_reward_points').' points converted', 'public', TRUE);
				$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
				
				redirect(current_url());
			}

			$this->load->model('users_model');

			// Variable "person" is used because "user" is already being used for currently signed in user.
			$this->data['person'] = $this->users_model->get_details($user_id);

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

			$this->load->view('public/dashboard/points_and_vouchers_view', $this->data);
		}


	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// PRODUCTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###<

		/**
		 * Index Page
		 * Home or Landing page
		 */
		function index($slug = FALSE)
	    {
			$categories = $this->store->menu();

			foreach ($categories as $item)
			{
				$products = $this->store->products(array(
					'limit' => 10,
					'category_id' => $item->id,
				));
				$item->products = $products['rows'];	
			}
			$this->data['categories'] = $categories;
			$this->data['latest'] = $this->product_model->get_latest_in_category(4);

			$this->load->model('banners_model');
			$this->data['banners'] = $this->banners_model->get_banners(array(
				'limit' => 4,
				'running' => TRUE
			));

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/home_view', $this->data);
		}

		/**
		 * Search Page.
		 */ 
		function search()
	    {
			$product_options = array(
				'search' => $this->input->get('q')
			);
			
			// Get products.
			$products = $this->store->products($product_options);
			
			$this->data['products'] = $products['rows'];	
			$this->data['total'] = $products['total'];	
			$this->data['pagination'] = $products['pagination'];

			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/products/search_view', $this->data);
		}

		/**
		 * Category Page.
		 * Browse and filter items by category and/or attributes
		 */ 
		function category($slug = FALSE)
	    {
			if ($this->input->post('price_range'))
			{
				$url = current_url().'?'.($this->input->get('price') ? preg_replace('/(^|&)price=[^&]*/', '&price='.$this->input->post('price'), $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&price='.$this->input->post('price'));
				// redirect to back here.
				redirect($url, 'refresh');
			}

			$this->data['category'] = $this->category_model->get_categories($slug);

			if (! $this->data['category'])
			{

				// Get any status message that may have been set.
				$this->data['message'] = $this->session->flashdata('message');
				$this->load->view('public/errors_view', $this->data);
			}
			else
			{
				$product_options = array(
					'attribute' => $this->input->get('ATB')
				);
				if ($slug) $product_options['category_id'] = $this->data['category']->id;
				
				// Get products.
				$products = $this->store->products($product_options);
				
				$this->data['products'] = $products['rows'];	
				$this->data['total'] = $products['total'];	
				$this->data['pagination'] = $products['pagination'];

				$this->data['min_price'] = $this->product_model->min_price($this->data['category']->id);
				$this->data['max_price'] = $this->product_model->max_price($this->data['category']->id);
				$this->data['price_range'] = ($this->input->get('price')) ? $this->input->get('price') : $this->data['max_price'];

				// Get any status message that may have been set.
				$this->data['message'] = $this->session->flashdata('message');

				$this->load->view('public/products/category_view', $this->data);
			}
		}

	    /**
	     * Product Page.
	     * View a single product.
	     */
		function product($slug)
		{
			$product = $this->product_model->get_details($slug);

			$this->data['category'] = $this->category_model->get_categories($product->category->id);

			/**
			*
			* Handle submitted data for Cart insert.
			*
			 */
			if ($this->input->post('add_to_cart'))
			{
				$this->flexi_cart->insert_items(array(
					'id'      => $this->input->post('id'),
					'name'    => $this->input->post('name'),
					'thumb'   => $this->input->post('thumb'),
					'quantity'=> $this->input->post('quantity'),
					'price'   => $this->input->post('price'),
					'weight'  => $this->input->post('weight'),
					'options' => $this->input->post('options')
				));

				// Set a message to the CI flashdata so that it is available after the page redirect.
				$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

				redirect(current_url());
			}

			/**
			*
			* Handle submitted data for Product inquirues.
			*
			 */
			if ($this->input->post('inquiry_product'))
			{
				// validate form input
				$this->form_validation->set_rules('target_price', 'above', 'required');
				$this->form_validation->set_rules('order_quantity', 'above', 'required');
				$this->form_validation->set_rules('inquiry', 'above', 'required');
				
				if ( ! $this->data['user'])
				{
					// For users who are no logged in, require more form details.
					$this->form_validation->set_rules('name', 'above', 'required');
					$this->form_validation->set_rules('email', 'above', 'required|valid_email');
					$this->form_validation->set_rules('phone', 'above', 'required|trim');
				}
				else
				{
					$user = $this->users_model->get_details($this->data['user']->id);
				}


				if ($this->form_validation->run() == true)
				{
					if ($this->data['user'])
					{
						// Get users details from the database.
						$this->data['buyer_name']   	= (isset($user->first_name)) ? ($user->first_name.' '.$user->first_name) : $user->company_name;
						$this->data['buyer_email']  	= (isset($user->email)) ? $user->email : $user->company_email;
						$this->data['buyer_phone']  	= (isset($user->phone)) ? $user->phone : $user->company_phone;
						$this->data['buyer_location']  	= (isset($user->address)) ? $user->address : $user->company_address;
					}
					else
					{
						// Get users details from the form.
						$this->data['buyer_name']  = $this->input->post('name');
						$this->data['buyer_email'] = $this->input->post('email');
						$this->data['buyer_phone'] = $this->input->post('phone');
						$this->data['buyer_location'] = $this->input->post('location');
					}
					
					$this->data['buyer_price'] = $this->input->post('target_price');
					$this->data['buyer_order'] = $this->input->post('order_quantity');
					$this->data['buyer_inquiry'] = $this->input->post('inquiry');


					$this->load->helper('email');

					$this->email->clear();
					$this->email->from($this->data['app']['email']);
					$this->email->to($product->seller->company_email);
					$this->email->subject('['.$this->data['app']['name'].'] Your item received an inquiry');
					$this->email->message($this->load->view('public/email/product_inquiry', $this->data, TRUE));

					// Send email to the vendor.
					if ($this->email->send())
					{
						$this->session->set_flashdata('alert',
							array('type' => 'success', 'message' => 'Your inquiry has been sent to the seller')
						);
						redirect(current_url(), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('alert',
							array('type' => 'danger', 'message' => 'Your inquiry could not been sent.')
						);
						redirect(current_url(), 'refresh');
					}
				}
			}

			/**
			*
			* Formatting Product Variable to create thumbnails with links
			* which can then be used to point to the product variants.
			*
			 */
			// Get related items.
			$related_meta = $this->product_model->get_products(array(
				'exclude' => $product->id,
				'limit' => 5,
				'start' => 0,
				'category_id' => $product->category->id,
			));
			$related_products = $related_meta->products;

			/**
			*
			* Get some random items for the user to view
			*
			 */
			$user_items_meta = $this->product_model->get_products(array(
				'limit' => 5,
				'random' => TRUE,
				'start' => 0,
			));
			$random_products = $user_items_meta->products;

			

			/**
			*
			* Formatting Product Variable to create thumbnails with links
			* which can then be used to point to the product variants.
			*
			 */
			// Thumbnails linking to a product variant
			$variant_thumbs = array();

			$product_variants = $this->product_model->get_product_variants($product->id);
			foreach ($product_variants as $variant)
			{
				// Generate the URI string to show product variants
				$variant_slug = implode("-", $variant->options_set);
				$variant_link = current_url().'?&OPT='.$variant_slug;

				$thumb_img = (!empty($variant->images)) ? $variant->images[0]->url : NULL ;
				// Add Formatted link and image to thumbnail variation array
				array_push($variant_thumbs, array(
					'link'  => $variant_link,
					'image' => $thumb_img
				));
			}

			/**
			*
			* Formatting Product Options to add a link which can then be used to point
			* to the product variant.
			*
			 */
			// Get Product Options
			$product_options  = $this->product_model->get_product_options($product->id);
			// Get Product Defaults
			$product_defaults = $this->product_model->get_product_defaults($product->id);

			// Get selected variant. Typical selected by the user, or if set, use admin selected default.
			if ($this->input->get('OPT'))
			{
				$variant_selected = explode('-', $this->input->get('OPT'));
			}
			else
			{
				$variant_selected = $product_defaults;
			}

			foreach ($product_options as $key => $option)
			{
				$curr_ids  = array();
				foreach ($option['values'] as $index => $value)
				{
					array_push($curr_ids, $value['id']);
				}

				// Define current option attributes.
				$curr_attr = $variant_selected;

				// Add a link to each option attribute value that the user will in
				// Selecting the product variation.
				foreach ($option['values'] as $index => $value)
				{
					// Define option attributes IDs in the URI string that are different from
					// those in the current option attributes ID. (There should only be one ID per option):
					$curr_attr = array_diff($curr_attr, $curr_ids);
					// Add current option attribute id.
					array_push($curr_attr, $value['id']);
					// Add the link to the option attribute values.
					$product_options[$key]['values'][$index]['link'] = current_url().'?&OPT='.implode('-', $curr_attr);
				}
			}

			/**
			*
			* Get the product variant - this is just the variated image, price and weight
			*
			 */
			if ($this->input->get('OPT'))
			{
				// For user defined options
				$product_variant = $this->product_model->get_product_variant_by_slug($product->id, $this->input->get('OPT'));
			}
			else
			{
				// For default options
				$product_variant = $this->product_model->get_product_variant_by_slug($product->id, implode('-', $product_defaults));
			}


			/**
			*
			* Collect all data for the page view file.
			*
			 */
			$this->data['variant_selected'] = $variant_selected;
			$this->data['product_options']  = $product_options;
			$this->data['product_variants'] = $product_variants;
			$this->data['$product_defaults'] = $product_defaults;
			$this->data['variant_thumbs'] 	= $variant_thumbs;
			$this->data['product'] 			= $product;
			$this->data['random_products']  = $random_products;
			$this->data['related_products'] = $related_products;
			$this->data['variant'] = $product_variant;
			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');
			
			$this->load->view('public/products/product_view', $this->data);
		}


	    /**
	     * View Cart and Cart actions.
	     */
		function cart($slug = NULL)
		{
			// Remove PayPal result data.
			$this->session->unset_userdata('PayPalResult');
			
			if ($slug == 'set_currency')
			{
				$this->flexi_cart->update_currency($this->input->get('currency'));
				redirect($this->input->get('redirect'));
			}
			elseif ($slug == 'add_to_cart')
			{
				$this->flexi_cart->insert_items(array(
					'id'      => $this->input->post('id'),
					'name'    => $this->input->post('name'),
					'thumb'   => $this->input->post('thumb'),
					'quantity'=> $this->input->post('quantity'),
					'price'   => $this->input->post('price'),
					'options' => array()
				));
				
				if ($this->input->is_ajax_request())
				{

					// Get any status message that may have been set.
					$this->data['message'] = $this->session->flashdata('message');

					$this->load->view('public/cart/cart_data', array(
		                'cart_data' => $this->flexi_cart->cart_contents()
		            ));
				}
				else
				{
					redirect($this->input->get('redirect'));
				}
			}
			else
			{
				if ($this->input->post('checkout'))
				{
					$this->checkout();
				}

				// Update cart contents and settings.
				if ($this->input->post('update'))
				{
					$this->update_cart();
				}
				// Update discount codes.
				else if ($this->input->post('update_discount'))
				{
					$this->update_discount_codes();
				}
				// Remove discount code.
				else if ($this->input->post('remove_discount_code'))
				{
					$this->remove_discount_code();
				}
				// Remove all discount codes.
				else if ($this->input->post('remove_all_discounts'))
				{
					$this->remove_all_discounts();
				}
				// Clear / Empty cart contents.
				else if ($this->input->post('clear'))
				{
					$this->clear_cart();
				}
				// Destroy all cart items and settings and reset to default settings.
				else if ($this->input->post('destroy'))
				{
					$this->destroy_cart();
				}

				###+++++++++++++++++++++++++++++++++###
				
				// Get required data on cart items, discounts and surcharges to display in the cart.
				$this->data['cart_items'] = $this->flexi_cart->cart_items(); 
				$this->data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
				$this->data['discounts'] = $this->flexi_cart->summary_discount_data();
				$this->data['surcharges'] = $this->flexi_cart->surcharge_data();

				###+++++++++++++++++++++++++++++++++###

				// This example shows how to lookup countries, states and post codes that can be used to calculate shipping rates.
				$sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name')); 	
				$this->data['countries'] = $this->flexi_cart->get_shipping_location_query($sql_select, 0)->result_array();
				$this->data['states'] = $this->flexi_cart->get_shipping_location_query($sql_select, 1)->result_array();
				$this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_query($sql_select, 2)->result_array();
				$this->data['shipping_options'] = $this->flexi_cart->get_shipping_options(); 
				
				// Uncomment the lines below to use the manual shipping example. Read more below.
				# $this->load->model('demo_cart_model');
				# $this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options(); 
				
				/**
				 * By default, this demo is setup to show how to implement shipping rates with a database.
				 * In the 2 steps below is an example showing how to manually set and define shipping options and rates.
				 *
				 * To use this example follow these steps:
				 * #1: Replace the four "$this->data" arrays set above with "$this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options();".
				 * #2: Set "$config['database']['shipping_options']['table']" and "$config['database']['shipping_rates']['table']" to FALSE via the config file.
				*/
				
				###+++++++++++++++++++++++++++++++++###

				// The load/save/delete cart data functions require the flexi cart ADMIN library.
				$this->load->library('flexi_cart_admin');
				

				if ($this->data['user'])
				{
					// Create an SQL WHERE clause to list all previously saved cart data for a specific user.
					// This examples also prevents cart session data from confirmed orders being loaded, by checking the readonly status is set at '0'.
					$sql_where = array(
						$this->flexi_cart->db_column('db_cart_data', 'user') => $this->data['user']->id,
						$this->flexi_cart->db_column('db_cart_data', 'readonly_status') => 0
					);

					// Get a list of all saved carts that match the SQL WHERE statement.
					$this->data['saved_cart_data'] = $this->flexi_cart_admin->get_db_cart_data_query(FALSE, $sql_where)->result_array();
				}
				else
				{
					$this->data['saved_cart_data'] = array();	
				}

				###+++++++++++++++++++++++++++++++++###

				// Get any status message that may have been set.
				$this->data['message'] = $this->session->flashdata('message');
				
				$this->load->view('public/cart/cart_view', $this->data);
			}
		}

		public function add_to_cart()
		{
			$added = $this->flexi_cart->insert_items(
				[
					'id'      => $this->input->post('id'),
					'name'    => $this->input->post('name'),
					'thumb'   => $this->input->post('thumb'),
					'quantity'=> 1,
					'price'   => $this->input->post('price'),
					'options' => array()
				]
			);

			if ($this->input->is_ajax_request()) {
				$this->flexi_cart->recalculate_cart();
				// Get any status message that may have been set.
				$this->data['message'] = $this->session->flashdata('message');

				$this->load->view('public/cart/cart_data', array(
					'cart_data' => $this->flexi_cart->cart_contents()
				));
			} else {
				redirect('cart');
			}
		}

	    /**
	     * Load Store Pages.
	     */
		function page($slug = NULL)
		{
			$this->load->model('pages_model');

			$this->data['page_data'] = $this->pages_model->get_pages($slug);
			// Get any status message that may have been set.
			$this->data['message'] = $this->session->flashdata('message');

			$this->load->view('public/page_view', $this->data);
		}


	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CART CONTROLS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

		/**
		 * update_cart
		 * Gets the carts item and shipping data from form inputs, and updates the cart.
		 */ 
		function update_cart()
		{
			// Load custom demo function to retrieve data from the submitted POST data and update the cart.
			$this->load->model('demo_cart_model');
			$this->demo_cart_model->demo_update_cart();
			
			// If the cart update was posted by an ajax request, do not perform a redirect.
			if (! $this->input->is_ajax_request())
			{
				// Set a message to the CI flashdata so that it is available after the page redirect.
				$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
						
				redirect('cart');
			}
		}

		/**
		 * delete_item
		 * Deletes and item from the cart using the '$row_id' supplied via the url link.
		 */ 
		function delete_cart_item($row_id = FALSE) 
		{
			$this->flexi_cart->delete_items($row_id);
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			redirect('cart');		
		}
		
		/**
		 * clear_cart
		 * Clears (Empties) all item, discount and surcharge data from the cart.
		 */ 
		function clear_cart()
		{
			// The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.
			$this->flexi_cart->empty_cart(TRUE);

			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			redirect('cart');
		}
		
		/**
		 * destroy_cart
		 * Destroys all cart items and settings and resets cart to its default settings.
		 */ 
		function destroy_cart()
		{
			$this->flexi_cart->destroy_cart();

			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
			
			redirect('cart');
		}


	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// SAVE / LOAD CART DATA
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

		/**
		 * save_cart_data
		 * Saves the users current cart to the database so that it can be reloaded at a later date.
		 */ 
		function save_cart_data() 
		{
			if (!$this->data['user'])
			{
				// Users that are not logged in cannot save cart data.
				$this->flexi_cart->set_error_message('You must be logged in to save your cart.', 'public');
			}
			else
			{
				// The load/save/delete cart data functions require the flexi cart ADMIN library.
				$this->load->library('flexi_cart_admin');
			
				// Save the cart data to the database.
				$this->flexi_cart_admin->save_cart_data($this->data['user']->id);
			}

			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
			
			redirect('cart');
		}

		/**
		 * load_cart_data
		 * Loads saved cart data into the users current cart, overwriting any existing cart data in their current session.
		 * A custom function 'demo_update_loaded_cart_data()' has been included to ensure that all loaded item data is up-to-date with the current item database table. 
		 */ 
		function load_cart_data($cart_data_id = 0, $dashboard_redirect = FALSE) 
		{
			if (!$this->data['user'])
			{
				// Users that are not logged in cannot save cart data.
				$this->flexi_cart->set_error_message('You must be logged in to load saved carts.', 'public');
			}
			else
			{
				// The load/save/delete cart data functions require the flexi cart ADMIN library.
				$this->load->library('flexi_cart_admin');
				$this->load->model('demo_cart_model');

				// Load saved cart data array.
				// This data is loaded into the browser session as if you were shopping with the cart as normal.
				$this->flexi_cart_admin->load_cart_data($cart_data_id);
				
				// To ensure that the prices and other data of all loaded items are still correct, a custom demo function has been made to loop through each item in the cart, 
				// query the demo item database table and retrieve the current item data.
				// As flexi cart does not manage item tables, this function has to be custom made to suit each sites requirements, this is an example of how it can be achieved.
				// Note that cart items including selectable options would potentially require a more complex query.	
				$this->demo_cart_model->demo_update_loaded_cart_data();
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			($dashboard_redirect) ? redirect('user_dashboard/carts') : redirect('cart');
		}

		/**
		 * delete_cart_data
		 * Deletes specific saved cart data from the database.
		 * This function is accessed from the 'Save / Load Cart Data' page.
		 */ 
		function delete_cart_data($cart_data_id = 0, $dashboard_redirect = FALSE) 
		{
			// The load/save/delete cart data functions require the flexi cart ADMIN library.
			$this->load->library('flexi_cart_admin');

			// Delete the saved cart data from the database.
			$this->flexi_cart_admin->delete_db_cart_data($cart_data_id);
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			($dashboard_redirect) ? redirect('user_dashboard/carts') : redirect('cart');
		}
 

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// DISCOUNTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

		/**
		 * update_discount_codes
		 * Updates all discount codes that have been submitted to the cart.
		 * This function is accessed from the 'View Cart' page via a form input field named 'update_discount'.
		 */ 
		function update_discount_codes()
		{
			// Get the discount codes from the submitted POST data.
			$discount_data = $this->input->post('discount');
			
			// The 'update_discount_codes()' function will validate each submitted code and apply the discounts that have activated their quantity and value requirements.
			// Any previously set codes that have now been set as blank (i.e. no longer present) will be removed.
			// Note: Only 1 discount can be applied per item and per summary column. 
			// For example, 2 discounts cannot be applied to the summary total, but 1 discount could be applied to the shipping total, and another to the summary total.
			$this->flexi_cart->update_discount_codes($discount_data);
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			redirect('cart');
		}

		/**
		 * set_discount
		 * Set a manually defined discount to the cart, rather than using the discount database table.
		 * This function is accessed from the 'Discounts / Surcharges' page.
		 * The settings for each discount are defined via the custom demo function 'demo_set_discount()'.
		 */ 
		function set_discount($discount_id = FALSE)
		{
			$this->load->model('demo_cart_model');
			
			$this->demo_cart_model->demo_set_discount($discount_id);
			
			redirect('cart');
		}
		
		/**
		 * remove_discount_code
		 * Removes a specific discount code from the cart.
		 * This function is accessed from the 'View Cart' page via a form input field named 'remove_discount_code'.
		 */ 
		function remove_discount_code()
		{
			// This examples gets the discount code from the array key of the submitted POST data.
			$discount_code = key($this->input->post('remove_discount_code'));

			// The 'unset_discount()' function can accept an array of either discount ids or codes to delete more than one discount at a time.
			// Alternatively, if no data is submitted, the function will delete all discounts that are applied to the cart.
			// This example uses the 1 discount code that was supplied via the POST data.
			// $this->flexi_cart->unset_userdata_discount($discount_code); // Can't remeber why this 'stock code' didn't work - said 'undefined method' or something		
			$this->flexi_cart->unset_discount($discount_code);
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			redirect('cart');
		}
		
		/**
		 * remove_all_discounts
		 * Removes all discounts from the cart, including discount codes, manually applied discounts and reward vouchers.
		 * This function is accessed from the 'View Cart' page via a form input field named 'remove_all_discounts'.
		 */ 
		function remove_all_discounts()
		{
			// The 'unset_discount()' function can accept an array of either discount ids or codes to delete more than one discount at a time.
			// Alternatively, if no data is submitted, the function will delete all discounts that are applied to the cart.
			// This example removes all discount data.
			// $this->flexi_cart->unset_userdata_discount(); // Can't remeber why this 'stock code' didn't work - said 'undefined method' or something		
			$this->flexi_cart->unset_discount();
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			redirect('cart');
		}

		/**
		 * unset_discount
		 * Removes a specific active item or summary discount from the cart.
		 * This function is accessed from the 'View Cart' page via a 'Remove' link located in the description of an active discount.
		 */ 
		function unset_discount($discount_code = FALSE)
		{
			// The 'unset_discount()' function can accept an array of either discount ids or codes to delete more than one discount at a time.
			// Alternatively, if no data is submitted, the function will delete all discounts that are applied to the cart.
			// This example uses the 1 discount id that was supplied via the url link.
			// $this->flexi_cart->unset_userdata_discount($discount_id); // Can't remeber why this 'stock code' didn't work - said 'undefined method' or something		
			$this->flexi_cart->unset_discount($discount_code);

			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
			
			redirect('cart');
		}
	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// SURCHARGES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
		/**
		 * set_surcharge
		 * Set a manually defined surcharge to the cart.
		 * This function is accessed from the 'Discounts / Surcharges' page.
		 * The settings for each surcharge are defined via the custom demo function 'demo_set_surcharge()'.
		 */ 
		function set_surcharge($surcharge_id = FALSE)
		{
			$this->load->model('demo_cart_model');
			
			$this->demo_cart_model->demo_set_surcharge($surcharge_id);
			
			redirect('cart');
		}

		/**
		 * unset_surcharge
		 * Removes a specific surcharge from the cart.
		 * This function is accessed from the 'View Cart' page via a 'Remove' link located in the description of a surcharge.
		 */ 
		function unset_surcharge($surcharge_id = FALSE)
		{
			// The 'unset_surcharge()' function can accept an array of surcharge ids to delete more than one surcharge at a time.
			// Alternatively, if no data is submitted, the function will delete all surcharges that are applied to the cart.
			// This example uses the 1 surcharge id that was supplied via the url link.
			$this->flexi_cart->unset_userdata_surcharge($surcharge_id);
			
			redirect('cart');
		}



	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// PAYMENT PROCESSING
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
		function checkout() 
		{
			$user = $this->ion_auth->user()->row();

			//validate card information was posted correctly.
			$this->form_validation->set_rules('card_name', 'Card name', 'required');
			$this->form_validation->set_rules('card_number', 'Card number', 'required');
			$this->form_validation->set_rules('card_year', 'Card year', 'required');
			$this->form_validation->set_rules('card_month', 'Card month', 'required');
			$this->form_validation->set_rules('card_cvv', 'Security code', 'required');
			
			//validate billing information was posted correctly.
			$this->form_validation->set_rules('billing[country]', 'Country', 'required');
			$this->form_validation->set_rules('billing[state]', 'State', 'required');
			$this->form_validation->set_rules('billing[postal_code]', 'Zip code', 'required');
			$this->form_validation->set_rules('bill_city', 'City', 'required');
			
			if( ! $this->ion_auth->logged_in()) {
				$this->form_validation->set_rules('first_name', 'First Name', 'required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'required');
				$this->form_validation->set_rules('email', 'Email', 'required');
			}
			

			if ($this->form_validation->run() == true) {
				$country = $this->db->where('loc_id', $this->input->post('billing[country]'))->get('locations')->result();
				$countryname = (! empty($country)) ? $country[0]->loc_name : '';
				$state = $this->db->where('loc_id', $this->input->post('billing[state]'))->get('locations')->result();
				$statename = (! empty($state)) ? $state[0]->loc_name : '';

				// Format chechout data
				if(isset($user->id)) $checkout_data['ord_user_fk'] = $user->id;
				$checkout_data['ord_demo_phone'] = $user ? $user->phone : $this->input->post('phone');
				$checkout_data['ord_demo_email'] = $user ? $user->email : $this->input->post('email');
				$checkout_data['ord_demo_bill_name'] = $this->input->post('card_name');
				$checkout_data['ord_demo_bill_address_01'] = $this->input->post('bill_street');
				$checkout_data['ord_demo_bill_post_code'] = $this->input->post('billing[postal_code]');
				$checkout_data['ord_demo_bill_country'] = $countryname;
				$checkout_data['ord_demo_bill_state'] = $statename;
				$checkout_data['ord_demo_bill_city'] = $this->input->post('bill_city');

				if( ! $this->ion_auth->logged_in()) {
					$checkout_data['ord_demo_email'] = $this->input->post('email');
					$checkout_data['ord_demo_phone'] = $this->input->post('phone');
				}

				if($this->input->post('same_address')) {
					// Shipping address is the same as billing address
					$checkout_data['ord_demo_ship_name'] = $this->input->post('card_name');
					$checkout_data['ord_demo_ship_address_01'] = $this->input->post('bill_street');
					$checkout_data['ord_demo_ship_post_code'] = $this->input->post('billing[postal_code]');
					$checkout_data['ord_demo_ship_country'] = $countryname;
					$checkout_data['ord_demo_ship_state'] = $statename;
					$checkout_data['ord_demo_ship_city'] = $this->input->post('bill_city');
				}else{
					$checkout_data['ord_demo_ship_name'] = $this->input->post('card_name');
					$checkout_data['ord_demo_ship_address_01'] = $this->input->post('shipping[street]');
					$checkout_data['ord_demo_ship_post_code'] = $this->input->post('shipping[postal_code]');
					$checkout_data['ord_demo_ship_country'] = $this->input->post('shipping[country]');
					$checkout_data['ord_demo_ship_city'] = $this->input->post('shipping[city]');
					$checkout_data['ord_demo_ship_state'] = $this->input->post('shipping[state]');
				}

				$checkout_card = [
					'number' => $this->input->post('card_number'),
					'expiryMonth' => $this->input->post('card_month'),
					'expiryYear' => $this->input->post('card_year'),
					'cvv' => $this->input->post('card_cvv'),
				];
				
				$this->load->library('payment');
				
				$purchased = $this->payment->purchase(
					[
						'card' => $checkout_card,
						// A three-character currency code. Default is USD.
						'currency' => $this->flexi_cart->currency_name(),
						// Required. The total cost of the transaction to the customer including shipping cost and tax charges.
						'amount' => $this->flexi_cart->total($discounts = TRUE, $format_value = FALSE),
						'returnUrl' => site_url('complete_pay'),
						'cancelUrl' => site_url('cancel_pay'),
					]
				);

				if($purchased) {
					$order_id = $this->payment->response['TRANSACTIONID'];
					
					$this->session->set_userdata('order_num', $order_id);
					$this->session->set_userdata('order_amt', $this->flexi_cart->total($discounts = true, $format_value = true));

					// Save cart and customer details.
					$this->load->library('flexi_cart_admin');
					$this->flexi_cart_admin->save_order($checkout_data, [], $order_id);
					// Remove the shopping cart.
					$this->flexi_cart->destroy_cart();

					redirect('checkout_complete');
				} else {
					$this->data['error'] = $this->payment->error_message();
				}
			}
		}

		public function paypal()
		{
			$this->load->library('payment');

			$cart_pay_data = [
				'currency' => $this->flexi_cart->currency_name(),
				'amount' => $this->flexi_cart->total($discounts = TRUE, $format_value = FALSE),
				'returnUrl' => site_url('complete_pay'),
				'cancelUrl' => site_url('cancel_pay'),
			];

			$purchased = $this->payment->purchase($cart_pay_data);

			if($purchased) {
				// The gateways will redirect as directed above.
			} else {
				$this->flexi_cart->set_error_message($this->payment->error_message(), 'public');
				$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
				redirect('cart');
			}
		}
		
		public function complete_pay()
		{
			$this->load->library(['flexi_cart_admin', 'payment']);
			
			// This data must be exactly the same as above (in the previous function).
			$cart_pay_data = [
				'currency' => $this->flexi_cart->currency_name(),
				'amount' => $this->flexi_cart->total($discounts = TRUE, $format_value = FALSE),
			];

			if($this->payment->done($cart_pay_data)) {
				
				$user = $this->ion_auth->user()->row();
				$response = $this->payment->response;
				$order_id = $response['TRANSACTIONID'];

				// Format chechout data
				if(isset($user->id)) $checkout_data['ord_user_fk'] = $user->id;
				
				$checkout_data['ord_demo_phone'] = isset($response['PHONENUM']) ? $response['PHONENUM'] : '';
				$checkout_data['ord_demo_email'] = isset($response['EMAIL']) ? $response['EMAIL'] : '';
				$checkout_data['ord_demo_ship_name'] = isset($response['PAYMENTREQUEST_0_SHIPTONAME']) ? $response['PAYMENTREQUEST_0_SHIPTONAME'] : '';
				$checkout_data['ord_demo_ship_address_01'] = isset($response['PAYMENTREQUEST_0_SHIPTOSTREET']) ? $response['PAYMENTREQUEST_0_SHIPTOSTREET'] : '';
				$checkout_data['ord_demo_ship_post_code'] = isset($response['PAYMENTREQUEST_0_SHIPTOZIP']) ? $response['PAYMENTREQUEST_0_SHIPTOZIP'] : '';
				$checkout_data['ord_demo_ship_country'] = isset($response['PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME']) ? $response['PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME'] : '';
				$checkout_data['ord_demo_ship_state'] = isset($response['PAYMENTREQUEST_0_SHIPTOSTATE']) ? $response['PAYMENTREQUEST_0_SHIPTOSTATE'] : '';
				$checkout_data['ord_demo_ship_city'] = isset($response['PAYMENTREQUEST_0_SHIPTOCITY']) ? $response['PAYMENTREQUEST_0_SHIPTOCITY'] : '';
				
				// Save cart and customer details.
				$this->flexi_cart_admin->save_order($checkout_data, [], $order_id);
				
				// Setup session variables for the complete purchase page
				$this->session->set_userdata('order_num', $order_id);
				$this->session->set_userdata('order_amt', $this->flexi_cart->total($discounts = true, $format_value = true));
				
				// Remove the shopping cart.
				$this->flexi_cart->destroy_cart();

				redirect('checkout_complete');
			} else {
				$this->flexi_cart->set_error_message($this->payment->error_message(), 'public');
				// Set a message to the CI flashdata so that it is available after the page redirect.
				$this->session->set_flashdata('message', $this->flexi_cart->get_messages());
				redirect('cart');
			}
		}

		/**
		 * Order Complete - Pay Return Url
		 */
		function checkout_complete()
		{
			// Get products.
			$this->load->library('store');
			
			$products = $this->store->products(array(
				'random' => TRUE,
				'limit' => 12
			));
			
			$this->data['total'] = $products['total'];	
			$this->data['products'] = $products['rows'];	
			$this->data['pagination'] = $products['pagination'];

			$this->data['order_number'] = $this->session->userdata('order_num');
			$this->data['order_amount'] = $this->session->userdata('order_amt');

			// Display to the user the success page.
			$this->load->view('public/cart/checkout_complete', $this->data);
		}

		function cancel_pay()
		{
			$this->flexi_cart->set_error_message('You cancelled the order', 'public', TRUE);
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages('public'));
			$this->session->set_flashdata('token', $this->input->get('token'));

			redirect('cart');
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
}

/* End of file Front.php */
/* Location: ./application/controllers/Front.php */