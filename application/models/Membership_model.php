<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership_model extends CI_Model {

	public function __construct()
	{
			$this->load->database();
	}

	public function validate()
	{
		if ($this->input->post('external'))
			$condition['username'] = $this->input->post('email_address');
		else
			$condition = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password'))
			);

		$query = $this->db->get_where('membership', $condition);
		
		if($query->num_rows() == 1)
		{
			return $query;
		}
		else
		{
			if ($this->input->post('external'))
			{
				$new_member_insert_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email_address' => $this->input->post('email_address'),			
					'username' => $this->input->post('username'),
				);
				$insert = $this->db->insert('membership', $new_member_insert_data);
				return $insert;
			}
			else
			{
				//echo "user ".$this->input->post('username')." with pass ".$this->input->post('password')." not found";
				print_r ($query->row_array());
				die();
			}
		}
	}
	
	function create_member()
	{
		
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),			
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}

	function update_member($username)
	{
		$update_member_data = array(
			'deposit_userid' => $this->input->post('deposit_userid')
			);

		$this->db->where('username', $username);
		$query = $this->db->update('membership', $update_member_data);
		return $query;
	}

	function email_exists($email)
	{
		$condition = array(
			'email_address' => $email
		);
		$query = $this->db->get_where('membership', $condition);
		return ($query->num_rows() >= 1);
	}

	function other_member_id($username)
	{
		$query = $this->db->query("SELECT deposit_userid FROM membership WHERE username='".$username."'");
		$row = $query->row();
		return $row->deposit_userid;
	}

	function record_transaction()
	{
		$new_transaction_data = array(
			'username' => $this->input->post('username'),
			'session_date' => date("Y-m-d H:i:s"),
			'activity_type' => $this->input->post('activity_type'),
			'img_code' => $this->input->post('img_code')			
		);
		
		$insert = $this->db->insert('activities', $new_transaction_data);
		return $insert;
	}

	function record_download()
	{
		$new_download_data = array(
			'username' => $this->input->post('username'),
			'img_code' => $this->input->post('img_code'),
			'img_provider' => $this->input->post('img_provider'),
			'img_url' => $this->input->post('img_url'),
			'img_price' => $this->input->post('img_price'),
			'price_type' => $this->input->post('price_type'),			
			'resolution' => $this->input->post('resolution'),
			'size' => $this->input->post('size'),
			'img_dimension' => $this->input->post('img_dimension'),
			'img_pixels' => $this->input->post('img_pixels')
		);
		
		$insert = $this->db->insert('downloads', $new_download_data);
		return $this->db->insert_id();
		//return $insert;
	}

	function set_license_id(){
		$license_id = array(
			'license_id' => $this->input->post('licenseid')
			);

		$this->db->where('id', $this->input->post('recId'));
		$query = $this->db->update('downloads', $license_id);
		return $query;
	}

	function record_payment()
	{
		$new_payment_data = array(
			'username' => $this->input->post('username'),
			'order_number' => $this->input->post('orderNumber'),
			'date' => date("Y-m-d H:i:s"),
			'merchant_order_id' => $this->input->post('orderId'),
			'token' => $this->input->post('token'),
			'total' => $this->input->post('totalId'),
			'img_code' => $this->input->post('imageCode')
			);
		$insert = $this->db->insert('payments', $new_payment_data);
		return $insert;

	}

	function set_download_ref($id, $downloadRef, $orderId)
	{
		$upd_download_data = array(
			'download_ref' => $downloadRef,
			'order_id' => $orderId
			);
		$this->db->where('id', $id);
		$query = $this->db->update('downloads', $upd_download_data);
		return $query;
	}

	function save_cart()
	{
		$new_cart = array(
			'cart_id' => $this->input->post('cartid'),
			'username' => $this->input->post('username'),
			'creation_date' => date("Y-m-d H:i:s")
			);
		$insert = $this->db->insert('cart', $new_cart);
		return $insert;

	}

	function save_cart_details()
	{
		$new_cart_details = array(
			'cart_id' => $this->input->post('cartid'),
			'img_code' => $this->input->post('img_code'),
			'img_provider' => $this->input->post('img_provider'),
			'img_url' => $this->input->post('img_url'),
			'img_price' => $this->input->post('img_price'),
			'price_type' => $this->input->post('price_type'),
			'resolution' => $this->input->post('resolution'),
			'size' => $this->input->post('size'),
			'img_dimension' => $this->input->post('img_dimension'),
			'img_pixels' => $this->input->post('img_pixels'),
			'download_url' => $this->input->post('download_url')
		);
		
		$insert = $this->db->insert('cart_details', $new_cart_details);
		return $this->db->insert_id();

	}

	function cart_found()
	{
		$cart_name = array('username' => $this->input->post('username'));
		$query = $this->db->get_where('cart', $cart_name);
		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	function get_cart()
	{
		$cart_name = array('cart_id' => $this->input->post('username'));
		$query = $this->db->get_where('cart_details', $cart_name);
		return $query;
	}

	function count_cart_items($cart_id)
	{
		$query = $this->db->query("SELECT count(*) as conteo FROM cart_details WHERE cart_id = '".$cart_id."'");
		if ($query)
		{
			$row = $query->row();
			return $row->conteo;
		}
		else
			return 0;
	}

	function delete_cart_item()
	{
		$query = $this->db->delete('cart_details', array('id' => $this->input->post('id')));
		return $query;
	}

	function get_activities($username, $activity_type, $img_code)
	{
		$cart_activities = array(
			'username' => $username,
			'activity_type' => $activity_type,
			'img_code' => $img_code
		);
		$query = $this->db->get_where('activities', $cart_activities);
		return $query;
	}

	function all_activities($username=null, $activity_type=null, $img_code=null)
	{
		if (null != $username)
			$this->db->where('username', $username);
		if (null != $activity_type)
			$this->db->where('activity_type', $activity_type);
		if (null != $img_code)
			$this->db->where('img_code', $img_code);

		$query = $this->db->get('activities');
		return $query;
	}

	function get_downloads($username=null, $provider=null, $img_code=null)
	{
		if (null != $username)
			$this->db->where('username', $username);
		if (null != $provider)
			$this->db->where('img_provider', $provider);
		if (null != $img_code)
			$this->db->where('img_code', $img_code);

		$query = $this->db->get('downloads');
		return $query;

	}

	function get_fullname($username=null)
	{
		if (null != $username)		
			$query = $this->db->query(
				"SELECT CONCAT(first_name,' ',last_name) as fname, email_address 
				 FROM membership WHERE username='$username'");
		$row = $query->row();
		return $row;

	}

	function record_subscriptions()
	{
		$new_subscription_data = array(
			'subscription_id' => $this->input->post('subscription_id'),
			'provider' => $this->input->post('provider'),
			'fecha_compra' => $this->input->post('fecha_compra')
		);
		
		$insert = $this->db->insert('subscriptions', $new_subscription_data);
		return $this->db->insert_id();

	}

}