<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership 
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
	}

	public function is_logged_in()
	{		
		$is_logged_in = $this->CI->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != true)
		{
			return '';
			//echo 'You don\'t have permission to access this page. <a href="'.site_url('login').'">Login</a>';	
			//die();		
			//$this->load->view('login_form');
		}
		else
			return $this->CI->session->userdata('username');	
	}	

}