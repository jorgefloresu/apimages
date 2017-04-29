<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

        function __construct()
        {
            parent::__construct();
			//$this->is_logged_in();
        }

        public function view($page = 'home')
        {
			$this->load->library('membership');
			$logged = $this->membership->is_logged_in();
            if (!$logged)
                redirect('login');			

            if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}
						
			if ( $page == 'home' )
			{
				$this->load->model('news_model');
				$data['totalnews'] = $this->db->count_all('news');
			}
			
			$data['title'] = ucfirst($page); // Capitalize the first letter
			$data['logged'] = $logged;

			//$this->load->view('templates/header', $data);
			//$this->load->view('pages/'.$page, $data);
			//$this->load->view('templates/footer', $data);

			$data['main_content'] = 'pages/'.$page;
			$this->load->view('templates/main_template', $data);
        }
		/*
		function is_logged_in()
		{
			$is_logged_in = $this->session->userdata('is_logged_in');
			if(!isset($is_logged_in) || $is_logged_in != true)
			{
				echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
				die();		
				//$this->load->view('login_form');
			}		
		}	
		*/
		public function index()
		{
			$this->load->model('membership_model');
			$data['username'] = 'jorgefloresu';
			$conteo = $this->membership_model->count_cart_items($data['username']);
			echo $conteo;

		}
        
}