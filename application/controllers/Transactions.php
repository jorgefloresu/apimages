<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transactions extends CI_Controller {

    public function store_transaction()
    {
		$this->load->library('membership');
        if ($this->membership->is_logged_in())
		{
			$this->load->model('membership_model');
			if ( $query = $this->membership_model->record_transaction() )
			{
				$datares['recId'] = $this->membership_model->record_download();
				$datares['result'] = 'recorded';  
			}
		}
		else{
			$datares['recId'] = '';
			$datares['result'] = 'not recorded';
		}

		echo json_encode($datares);
	}

	public function set_license_id()
	{
		$this->load->library('membership');
		if ($this->membership->is_logged_in())
		{
			$this->load->model('membership_model');
			if ($this->membership_model->set_license_id())
				$datares['result'] = 'set';
			else
				$datares['result'] = '';
		}

		echo json_encode($datares);
	}

	public function save_to_cart()
	{
		$datares['recId'] = '';
		$datares['result'] = 'not logged';

		$this->load->library('membership');
        if ($this->membership->is_logged_in())
		{
			$this->load->model('membership_model');
			if ( ! $this->membership_model->cart_found() )
				$this->membership_model->save_cart();

			$datares['recId'] = $this->membership_model->save_cart_details();
			$datares['result'] = 'recorded';  
		}
		else{
			$datares['recId'] = '';
			$datares['result'] = 'not recorded';
		}

		echo json_encode($datares);
	}

	public function view_cart()
	{
		$cartitems = '';
		$this->load->library('membership');
        if ($this->membership->is_logged_in())
		{
			$this->load->model('membership_model');
			$cartitems = $this->membership_model->get_cart();
			$datares = $cartitems->result();
		}

		echo json_encode($datares);
	}

	public function items_in_cart()
	{
		$this->load->model('membership_model');
		$datares = $this->membership_model->count_cart_items();
		echo json_encode($datares);
	}

	public function item_cart_delete()
	{
		$this->load->model('membership_model');
		$datares = $this->membership_model->delete_cart_item();
		echo json_encode($datares);
	}
        
}