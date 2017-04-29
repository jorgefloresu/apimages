<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function index()
	{
		
        $this->load->library('membership');
		$data['title'] = 'Reportes';
 		$data['logged'] = $this->membership->is_logged_in();

		$data['report_header'] = $this->load->view('templates/report_header', '', true);
		$data['report_sidebar'] = $this->load->view('templates/report_sidebar', '', true);
		$data['main_content'] = 'templates/reportes';
		$data['datares'] = $this->get_data($this->input->get('table'));
		$this->load->view('templates/main_template', $data); 
		

	}

	function get_data($table){
		$this->load->model('membership_model');
		switch ($table) {
			case 'activities':
				$datares = $this->membership_model->all_activities(null,null,null);
				break;
			case 'downloads':
				$datares = $this->membership_model->get_downloads(null,null,null);
				break;
			
		}
		return $datares->result();
		//print_r($datares->result());
		//echo json_encode($datares->result());
	}


}
