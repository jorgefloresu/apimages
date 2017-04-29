<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $this->load->library('membership');
        $logged = $this->membership->is_logged_in();
        if ($logged)
        {
			//$this->load->view('pages/home');
			redirect('pages/view');
		}
		else
		{ 
			//echo 'No logeado';
			//$data['main_content'] = "pages/login_form";
			//$data['title'] = "Login Page";
			$data['main_content'] = "pages/home";
			$data['title'] = "Home Page";
			$data['logged'] = $logged;
			$this->load->view('templates/main_template', $data);
		}
	}
	
	function validate_credentials()
	{		
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if($query) // if the user's credentials validated...
		{
			$data = array(
				//'username' => $this->input->post('username'),
				'username' => $query->row()->username,
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			$cart = $this->membership_model->count_cart_items($data['username']);
			echo $cart;
			//redirect('pages/view');
		}
		else // incorrect username or password
		{
			//$this->index();
			echo '';
		}
	}

	function signup()
	{
		$data['title'] = "Login Page";
		$data['main_content'] = 'pages/signup_form';
		$data['logged'] = false;
		$this->load->view('templates/main_template', $data);
		//$this->load->view('templates/header');
		//$this->load->view('pages/signup_form');
		//$this->load->view('templates/footer');

	}

	function forgot_pass()
	{
        $this->load->library('membership');
        $logged = $this->membership->is_logged_in();

		$data['title'] = "Login Page";
		$data['main_content'] = 'pages/forgot_pass';
		$data['logged'] = $logged;
		$this->load->view('templates/main_template', $data);

	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
			$this->load->view('pages/signup_form');
			$this->load->view('templates/footer');
		}
		
		else
		{			
			$this->load->model('membership_model');
			
			if($query = $this->membership_model->create_member())
			{
				$data['title'] = "Signup successful";
				$data['main_content'] = 'pages/signup_successful';
				$this->load->view('templates/main_template', $data);
			}
			else
			{
				$this->load->view('pages/signup_form');			
			}
		}
		
	}

	function forgot_pass_phpmailer()
	{
		//echo 'mail';

		date_default_timezone_set('Etc/UTC');
		$this->load->helper('PHPMailerAutoload.php');
		require PHP_BINDIR.'/vendor/autoload.php';

		$mail = new PHPMailerOAuth;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		//$mail->Debugoutput = 'html';

		$mail->isSMTP(); 
		//echo 'smtp';                                     // Set mailer to use SMTP
		//$mail->Host = 'mail.codemar.net';
		$mail->Host = 'smtp.gmail.com';   					  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;			// Enable SMTP authentication

		$mail->AuthType = 'XOAUTH2';
		$mail->oauthUserEmail = 'jorgefloresu@gmail.com';
		$mail->oauthClientId = '987744642536-gvtpepf2mv4us93dh0njve8kpge4jopc.apps.googleusercontent.com';
		$mail->oauthClientSecret = 'F8NcctssCSaGnPzWAu9bXR6j';
		$mail->oauthRefreshToken = '1/aMu6bIEtZnStQC1KNZYU0A57CvfzApKkzIxnhSqFe8o';
		                               
		//$mail->Username = 'jflores@codemar.net';                 // SMTP username
		//$mail->Password = 'jafu6921';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		//$mail->Port = 26;
		$mail->Port = 587;

		$mail->setFrom('jorgefloresu@gmail.net', 'Mailer');
		//$mail->addAddress('jorgefloresu@gmail.com', 'Jorge Flores');     // Add a recipient
		$mail->addAddress($this->input->post('email_address'), $this->input->post('username'));

		$mail->isHTML(true);                                  // Set email format to HTML
		//echo 'html';
		$mail->Subject = 'Password recovery';
		$mail->Body    = 'The new pasword for <b>'.$this->input->post('email_address').
						'</b> is: <b>'. $this->randomPassword().'</b>';
		
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}
	
	//echo json_encode($this->randomPassword());

	}
	
	function regenerate_pass_OFF() {
		$email = $this->input->get('email_address');
		$this->load->model('membership_model');
		if ($query = $this->membership_model->email_exists($email)) {
			$to = $email;
			//echo "your email is ::".$email;
			//Details for sending E-mail
			$from = "MySite";
			$url = "http://www.mysite.com/";
			$pass = $this->randomPassword();
			$body  =  "MySite user password recovery service
			-----------------------------------------------
			Url : $url;
			email Details is : $to;
			Here is your password  : $pass;
			Sincerely,
			MySite";
			$from = "admin@mysite.com";
			$subject = "MySite Password recovered";
			$headers1 = "From: $from\n";
			$headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
			$headers1 .= "X-Priority: 1\r\n";
			$headers1 .= "X-MSMail-Priority: High\r\n";
			$headers1 .= "X-Mailer: Just My Server\r\n";
			$sentmail = mail ( $to, $subject, $body, $headers1 );
		} 
		else {	
			echo "<span style='color: #ff0000;''> Not found your email in our database</span>";
		}
		
		if($sentmail==1)
			echo "<span style='color: #ff0000;'> Your Password Has Been Sent To Your Email Address.</span>";
		else 
			echo "<span style='color: #ff0000;'> Cannot send password to your e-mail address.Problem with sending mail...</span>";
	}

	function randomPassword() {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	function logout($action = 'index')
	{
		$this->session->sess_destroy();
		if ($action == 'index')
			$this->index();
		else
			redirect('getprovidersfull');
	}

	function is_logged(){
		$this->load->library('membership');
        if ($this->membership->is_logged_in())
        	return json_encode('1');
        else
        	return json_encode('0');
	}

}

?>