<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Notifications
*
* Author: Ignatius Yesigye
*		  ignatiusyesigye@gmail.com
*/

class App
{
	/**
	 * __construct
	 */
	public function __construct()
	{
		// $this->load->model(array('notification_model'));
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	/**
	 * Return object of admin details
	 *
	 * @access	public
	 * @return object
	 **/
	public function owner()
	{
		$this->load->model('users_model');
		return $this->users_model->owner();
	}
}
