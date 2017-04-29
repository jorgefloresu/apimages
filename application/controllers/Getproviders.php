<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('NO_XML', true);
define('DEF_NUMBER_OF_ROWS', 6);
define('DEF_MEDIA_SIZE', 450);


class Getproviders extends CI_Controller {

        function setupform(&$form)
        {
        	//Set attributes of the search form
         	$form['formattributes'] = array(
        		'class' => 'navbar-form navbar-left', 
        		'role' => 'search',
        		'method' => 'get',
        		'id' => 'navform'
        		);

			// Set filters in the search options
			$form['color_opt'] = array(
                  '1'  => 'Color',
                  '0'  => 'Blanco y Negro'
                );
			$form['orien_opt'] = array(
                  '1'  => 'Vertical',
                  '2'  => 'Horizontal',
                  '3'  => 'Cuadrada' 
                );

			// Adding attributes to the form and filters
            $selectpicker = 'class="selectpicker" form="navform" ';
            $form['color_tag'] = 'id="color" title="Color: Todos" ' . $selectpicker ;
            $form['orien_tag'] = 'id="orientation" title="Orientación: Todas" ' . $selectpicker;
            $form['search_source'] = __CLASS__ ;
            $form['form_action'] = __CLASS__ . '/search/0';       	
      	
        }

        function search($page=0)
        {
            $header['title'] = 'All API Providers Test';
            $this->load->library('session');

        	$this->setupform($data);
        	// Get the values of the search form
       		$data['keywords'] = $this->input->get('keywords');
			$data['color_sel'] = $this->input->get('color');
			$data['orien_sel'] = $this->input->get('orientation');

            // Search only if there´s content on keywords field
        	if ( !empty($data['keywords']) )
        	{
        		$rows['Fotosearch']   = $this->Fotosearch_Search($data, $page);        		
                $rows['Depositphoto'] = $this->Depositphoto_Search($data, $page);
        		$rows['Fotolia']      = $this->Fotolia_Search($data, $page);
                $rows['Ingimages']    = $this->Ingimages_Search($data, $page);

                $totalrows = array_sum($rows);

				// Create the pagination control using the total value from results
                if ($page == 0)
                    $this->session->set_userdata('totalrows', $totalrows);
                
                $data['totalrows'] = $this->session->totalrows;
                $this->pagination($data['totalrows']);
				$data['pagination'] = $this->pagination->create_links();
 
			}

        	$this->load->view('templates/header', $header);
			$this->load->view('templates/image_result', $data);						
			$this->load->view('templates/footer');

        }

		function imgdetail($provider, $imagecode)
		{
            switch ($provider) 
            {
				case 'Fotosearch':
					$image_data = $this->Fotosearch_Details($provider, $imagecode);           
					break;

				case 'Ingimages':
					$image_data = $this->Ingimages_Details($provider, $imagecode);
					break;

				case 'Fotolia':
					$image_data = $this->Fotolia_Details($provider, $imagecode);
					break;

 				case 'Depositphoto':
					$image_data = $this->Depositphoto_Details($provider, $imagecode);
					break;

            }			

			echo json_encode($image_data);

		}

        function Fotosearch_Search(&$data, $page, $addremain=0)
        {
            // Search in Fotosearch               
            $this->load->library('fotosearch_api');
        	$params = array(
        			FotosearchParams::SEARCH_QUERY  => $data['keywords'],
                    FotosearchParams::SEARCH_LIMIT => DEF_NUMBER_OF_ROWS + $addremain,
        			FotosearchParams::SEARCH_OFFSET => $page
        		);
        	
        	$res = $this->fotosearch_api->search($params);
            $rows = 0;
        	if ($res)
        	{	
                foreach ($res->objects as $value) {
                    $data['result'][] = array(
                    	'provider' => 'Fotosearch',
                        'code' => (string)$value->id,
                        'caption' => (string)$value->title,
                        'thumburl' => (string)$value->thumbnail_url
                        );
            	}
                $rows = $res->meta->total_count;
			}
            return $rows;
        }

        function Fotosearch_Details($provider, $imagecode)
        {
			$this->load->library('fotosearch_api');
			$res = $this->fotosearch_api->getMediaData($imagecode);
			
			foreach ($res->resolutions as $value) {
				$resolutions[] = $value->name;
			}
			
			$det = array(
				'url' => (string)$res->preview_url,
                'prop' => array(
                	'Source' => $provider,
    				'Image Type' => (string)$res->type,
    				'Artist' => (string)$res->artist,
                    'Resolutions' => implode($resolutions,',')
                    )
				);
			return $det;
        }

        function Depositphoto_Search(&$data, $page, $addremain=0)
        {
        	$this->load->library('depositclient');
        	$params = array(
        			RpcParams::SEARCH_QUERY  => $data['keywords'],
        			RpcParams::SEARCH_ORIENTATION => $data['orien_sel'],
        			RpcParams::SEARCH_LIMIT  => DEF_NUMBER_OF_ROWS + $addremain,
        			RpcParams::SEARCH_OFFSET => $page,
        			RpcParams::SEARCH_COLOR => urlencode($data['color_sel'])
        		);

        	// Convert search result from Object to Array (only the first result level)
            $res = $this->depositclient->search($params);

            foreach ($res->result as $value) {
                $data['result'][] = array(
                	'provider' => 'Depositphoto',
                    'code' => (string)$value->id,
                    'caption' => (string)$value->title,
                    'thumburl' => (string)$value->medium_thumbnail
                    );
            }

            return $res->count;
        }

        function Depositphoto_Details($provider, $imagecode)
        {
        	$this->load->library('depositclient');
            $res = $this->depositclient->getMediaData($imagecode);

			$det = array(
				'url' => $res->huge_thumb,
                'prop' => array(
                	'Source' => $provider,
    				'Image Type' => (string)$res->itype,
    				'Orientation' => (string)$res->level,
                    'Width' => (string)$res->width,
                    'Height' => (string)$res->height
                    )
				);

			return $det;
        }

        function Fotolia_Search(&$data, $page, $addremain=0)
        {
        	$this->load->library('fotolia_api');
            $params = array (
                FotoliaParams::SEARCH_QUERY => $data['keywords'],
                FotoliaParams::SEARCH_LIMIT => DEF_NUMBER_OF_ROWS + $addremain,
                FotoliaParams::SEARCH_OFFSET => $page,
                FotoliaParams::SEARCH_FILTERS => array(
                    FotoliaParams::SEARCH_ORIENTATION => $data['orien_sel'],
                    FotoliaParams::SEARCH_COLOR => $data['color_sel']
                    )
               );

            $res = $this->fotolia_api->getSearchResults($params);
            $totalrows = array_shift($res); //Quitamos el primer elemento ya que contiene el conteo de rows

            foreach ($res as $value) {
                $data['result'][] = array(
                	'provider' => 'Fotolia',
                    'code' => $value['id'],
                    'caption' => $value['title'],
                    'thumburl' => $value['thumbnail_160_url']
                    );
            }

            return $totalrows;
        }

        function Fotolia_Details($provider, $imagecode)
        {
        	$this->load->library('fotolia_api');
            $size = "400";

            $res = $this->fotolia_api->getMediaData($imagecode, $size);

            $det = array(
                'url' => $res['thumbnail_url'],
                'prop' => array(
                	'Source' => $provider,
                    'Image Type' => $res['media_type_id'],
                    'Width' => $res['thumbnail_width'],
                    'Height' => $res['thumbnail_height']
                    )
                );

            return $det;
        }

        function Ingimages_Search(&$data, $page, $addremain=0)
        {
            // Search in Ingimages
            $this->load->library('ingimages_api');
        	$params = array(
				IngimagesParams::SEARCH_QUERY => $data['keywords'],
				IngimagesParams::SEARCH_OFFSET => $page + $addremain + 1,
				IngimagesParams::SEARCH_COLOR => $data['color_sel'],
				IngimagesParams::SEARCH_ORIENTATION => $data['orien_sel']
        		);

        	$res = $this->ingimages_api->search($params);

        	foreach ($res as $value) {
	        	$data['result'][] = array(
	        		'provider' => 'Ingimages',
	        		'code' => (string)$value['code'],
	        		'caption' => (string)$value->imgcaption,
	        		'thumburl' => (string)$value->thumburl
	        		);
        	}

        	return $res->results['total'];

        }

        function Ingimages_Details($provider, $imagecode)
        {
			$this->load->library('ingimages_api');

			$res = $this->ingimages_api->getMediaData($imagecode);
			$imagecode .= '.jpg';

			$det = array(
				'url' => $this->ingimages_api->getMediaPreview($imagecode),
				'prop' => array(
                	'Source' => $provider,
					'Image Type' => (string)$res->availableAssetTypes,
					'Color Type' => (string)$res->colorType,
					'Orientation' => (string)$res->orientation,
					'Keywords' => (string)$res->keywords
					)
				);		

			return $det;       	
        }
 
        function pagination($totalrows)
        {
			//pagination settings
			$config['base_url'] = site_url('getproviders/search');
			$config['total_rows'] = $totalrows;
			$config['per_page'] = DEF_NUMBER_OF_ROWS;
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = 5; //floor($choice);
			$config['use_page_numbers'] = false;
			$config['first_url'] = site_url('getproviders/search/0').'?'.http_build_query($_GET);;
			if (count($_GET) > 0) 
			{
				$config['suffix'] = '?' . http_build_query($_GET, '', "&");
			}				

			//config for bootstrap pagination class integration
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);
        
        }

}