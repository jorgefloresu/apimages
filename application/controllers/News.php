<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

        function __construct()
        {
                parent::__construct();
	            $this->load->model('news_model');
        }
        
        function show_news()
        {
                $data['news'] = $this->news_model->get_news();
                $data['title'] = 'News archive';

				$this->load->view('templates/header', $data);
				$this->load->view('news/index', $data);
				$this->load->view('templates/footer');
        }

        function view($slug = NULL)
        {
                $data['news_item'] = $this->news_model->get_news($slug);
                if (empty($data['news_item']))
				{
						show_404();
				}

				$data['title'] = $data['news_item']['title'];

				$this->load->view('templates/header', $data);
				$this->load->view('news/view', $data);
				$this->load->view('templates/footer');
        }
        function edit($slug = NULL)
        {
                $data['news_item'] = $this->news_model->get_news($slug);
                if (empty($data['news_item']))
				{
						show_404();
				}

				$this->load->helper('form');		    			
				$this->load->library('form_validation');

				$data['title'] = $data['news_item']['title'];

				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('text', 'text', 'required');

				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('news/edit', $data);
					$this->load->view('templates/footer');
				}
        }
        
        function update($slug = NULL)
        {
				if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0)
				{
					$uploadData = $this->uploadImage();
				}
				else
				{
					if ($this->input->post('img_deleted'))
					{
						$uploadData['raw_name'] = $uploadData['file_ext'] = '';
						$source_img = '/Users/jorgeflores/Sites/CI/uploads/'.$this->input->post('img_edited');
						$source_ext = $this->input->post('ext_edited');
						unlink($source_img.$source_ext);
						unlink($source_img.'_thumb'.$source_ext);						
					}
					else
					{
						$uploadData = NULL;
					}
				}
				$this->news_model->upd_news($uploadData);

                $data['news'] = $this->news_model->get_news();
                $data['title'] = 'News archive';

				$this->load->view('templates/header', $data);
				$this->load->view('news/index', $data);
				$this->load->view('templates/footer');
        
        }
        
        function create()
		{
			$this->load->helper('form');		    			
			$this->load->library('form_validation');

			$data['title'] = 'Create a news item';
			//$data['title'] = defined('BASEPATH');

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('text', 'text', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('news/create');
				$this->load->view('templates/footer');

			}
			else
			{
				$uploadData = $this->uploadImage();
				$this->news_model->set_news($uploadData);
				$this->load->view('pages/upload_success');
			}
		}
		
		function uploadImage()
		{
		   $config['upload_path']   =   "uploads/";
		   $config['allowed_types'] =   "gif|jpg|jpeg|png"; 
		   $config['max_size']      =   "5000";
		   $config['max_width']     =   "5000";
		   $config['max_height']    =   "5000";

		   $this->load->library('upload',$config);

		   if( ! $this->upload->do_upload() )
		   {
			   $error = array('error' => $this->upload->display_errors());
			   $this->load->view('pages/upload_view', $error);
		   }
		   else
		   {
			   $finfo=$this->upload->data();
			   $this->_createThumbnail($finfo['file_name']);
			   $data['uploadInfo'] = $finfo;
			   $data['thumbnail_name'] = $finfo['raw_name']. '_thumb' .$finfo['file_ext'];
			   return $finfo; 
			   //$this->load->view('pages/upload_success',$data);

			   // You can view content of the $finfo with the code block below

			   /*echo '<pre>';
			   print_r($finfo);
			   echo '</pre>';*/
		   }
		}
		
		function _createThumbnail($filename)
		{
			$config['image_library']    = "gd2";      
			$config['source_image']     = "uploads/" .$filename;      
			$config['create_thumb']     = TRUE;      
			$config['maintain_ratio']   = TRUE;      
			$config['width'] = "80";      
			$config['height'] = "80";

			$this->load->library('image_lib',$config);

			if(!$this->image_lib->resize())
			{
				echo $this->image_lib->display_errors();
			}      
		}
		
		function delete_img()
		{
				
				$data['image_name'] = $this->input->post('image_name');
				$data['image_ext'] = $this->input->post('image_ext');
				//$source_img = '/Users/jorgeflores/Sites/CI/uploads/'.$data['image_name'];
				//if (unlink($source_img.$data['image_ext']))
				//{
				//	unlink($source_img.'_thumb'.$data['image_ext']);
				//	$this->news_model->clear_image_data();
					$this->load->view('pages/delete_img_success', $data);
				//}
		}

}