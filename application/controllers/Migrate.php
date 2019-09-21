<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		// $this->load->library('migration');
		
		// if ( ! $this->migration->current())
		// {
		// 	show_error($this->migration->error_string());
		// }
		$this->_import();
	}

	private function _import(String $file = 'demo_cart.sql')
	{
		$this->load->database();
		
		if (file_exists($file)) {
			$lines = file($file);
			$statement = '';
			
			foreach ($lines as $line) {
				$statement .= $line;
				
				if (substr(trim($line), -1) === ';') {
					$this->db->simple_query($statement);
					$statement = '';
				}
			}
		}
	}
	
	private function _backup(String $file = 'demo_cart.sql')
	{
		$this->load->dbutil();
		$this->load->helper(['file', 'download']);
	
		$backup =& $this->dbutil->backup([
			'format' => 'txt',
			'add_insert' => true
		]);
	
		write_file($file, $backup);
		force_download($file, $backup);
	}
}