<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

	function __construct(){
		parent::__construct();
		require_once(APPPATH . 'libraries/2CO/Twocheckout.php');
        require_once(APPPATH . 'libraries/PayU.php');
	}

    function init_payu(){
        PayU::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c"; //Ingrese aquí su propio apiKey.
        PayU::$apiLogin = "11959c415b33d0c"; //Ingrese aquí su propio apiLogin.
        PayU::$merchantId = "500238"; //Ingrese aquí su Id de Comercio.
        PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
        PayU::$isTest = true; //Dejarlo True cuando sean pruebas.
        // URL de Pagos
        Environment::setPaymentsCustomUrl("https://stg.api.payulatam.com/payments-api/4.0/service.cgi");
        // URL de Consultas
        Environment::setReportsCustomUrl("https://stg.api.payulatam.com/reports-api/4.0/service.cgi");
        // URL de Suscripciones para Pagos Recurrentes
        Environment::setSubscriptionsCustomUrl("https://stg.api.payulatam.com/payments-api/rest/v4.3/");

        PayU::$isTest = true;        
    }

    function test_payu(){
        $this->init_payu();
        $reference = "payment_test_002";
        $value = "1000";
        $deviceSessionId = md5(session_id().microtime());
        //para realizar un pago con tarjeta de crédito---------------------------------
        $parameters = array(
            //Ingrese aquí el identificador de la cuenta.
            PayUParameters::ACCOUNT_ID => "500538",
            //Ingrese aquí el código de referencia.
            PayUParameters::REFERENCE_CODE => $reference,
            //Ingrese aquí la descripción.
            PayUParameters::DESCRIPTION => "payment test",

            // -- Valores --
            //Ingrese aquí el valor.        
            PayUParameters::VALUE => $value,
            //Ingrese aquí la moneda.
            PayUParameters::CURRENCY => "COP",

            // -- Comprador 
            //Ingrese aquí el nombre del comprador.
            PayUParameters::BUYER_NAME => "First name and second buyer  name",
            //Ingrese aquí el email del comprador.
            PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
            //Ingrese aquí el teléfono de contacto del comprador.
            PayUParameters::BUYER_CONTACT_PHONE => "7563126",
            //Ingrese aquí el documento de contacto del comprador.
            PayUParameters::BUYER_DNI => "5415668464654",
            //Ingrese aquí la dirección del comprador.
            PayUParameters::BUYER_STREET => "calle 100",
            PayUParameters::BUYER_STREET_2 => "5555487",
            PayUParameters::BUYER_CITY => "Medellin",
            PayUParameters::BUYER_STATE => "Antioquia",
            PayUParameters::BUYER_COUNTRY => "CO",
            PayUParameters::BUYER_POSTAL_CODE => "000000",
            PayUParameters::BUYER_PHONE => "7563126",

            // -- pagador --
            //Ingrese aquí el nombre del pagador.
            PayUParameters::PAYER_NAME => "APPROVED",
            //Ingrese aquí el email del pagador.
            PayUParameters::PAYER_EMAIL => "payer_test@test.com",
            //Ingrese aquí el teléfono de contacto del pagador.
            PayUParameters::PAYER_CONTACT_PHONE => "7563126",
            //Ingrese aquí el documento de contacto del pagador.
            PayUParameters::PAYER_DNI => "5415668464654",
            //Ingrese aquí la dirección del pagador.
            PayUParameters::PAYER_STREET => "calle 93",
            PayUParameters::PAYER_STREET_2 => "125544",
            PayUParameters::PAYER_CITY => "Bogota",
            PayUParameters::PAYER_STATE => "Bogota",
            PayUParameters::PAYER_COUNTRY => "CO",
            PayUParameters::PAYER_POSTAL_CODE => "000000",
            PayUParameters::PAYER_PHONE => "7563126",

            // -- Datos de la tarjeta de crédito -- 
            //Ingrese aquí el número de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_NUMBER => "4097440000000004",
            //Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2016/12",
            //Ingrese aquí el código de seguridad de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_SECURITY_CODE=> "321",
            //Ingrese aquí el nombre de la tarjeta de crédito
            //VISA||MASTERCARD||AMEX||DINERS
            PayUParameters::PAYMENT_METHOD => "VISA",

            //Ingrese aquí el número de cuotas.
            PayUParameters::INSTALLMENTS_NUMBER => "1",
            //Ingrese aquí el nombre del pais.
            PayUParameters::COUNTRY => PayUCountries::CO,

            //Session id del device.
            PayUParameters::DEVICE_SESSION_ID => $deviceSessionId,
            //IP del pagadador
            PayUParameters::IP_ADDRESS => "127.0.0.1",
            //Cookie de la sesión actual.
            PayUParameters::PAYER_COOKIE=>session_id(),
            //Cookie de la sesión actual.        
            PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );
            
        //solicitud de autorización y captura
        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        //  -- podrás obtener las propiedades de la respuesta --
        if($response){
            $response->transactionResponse->orderId;
            $response->transactionResponse->transactionId;
            $response->transactionResponse->state;
            if($response->transactionResponse->state=="PENDING"){
                $response->transactionResponse->pendingReason;  
            }
            //$response->transactionResponse->paymentNetworkResponseCode;
            //$response->transactionResponse->paymentNetworkResponseErrorMessage;
            $response->transactionResponse->trazabilityCode;
            $response->transactionResponse->responseCode;
            //$response->transactionResponse->responseMessage; 
            echo "<pre>";print_r($response->transactionResponse);echo "</pre>";   
        }
    }

    function consulta_payu(){
        //Esta funcion devuelve muchos mas datos de la transaccion
        $this->init_payu();
        //Ingresa aquí el código de referencia de la orden.
        //history id: 7765626
        $parameters = array(PayUParameters::ORDER_ID => "7765642");

        $order = PayUReports::getOrderDetail($parameters);    

        if ($order) {
            $order->accountId;
            $order->status;
            $order->referenceCode;
            $order->additionalValues->TX_VALUE->value;
            $order->additionalValues->TX_TAX->value;
            if ($order->buyer) {
                $order->buyer->emailAddress;
                $order->buyer->fullName;
            }
            $transactions=$order->transactions;
            foreach ($transactions as $transaction) {
                $transaction->type;
                $transaction->transactionResponse->state;
                //$transaction->transactionResponse->paymentNetworkResponseCode;
                $transaction->transactionResponse->trazabilityCode;
                $transaction->transactionResponse->responseCode;
                if ($transaction->payer) {
                    $transaction->payer->fullName;
                    $transaction->payer->emailAddress;
                }
            }
        }
        echo "<pre>";print_r($order);echo "</pre>"; 

    }

    function trans_payu(){
        //Esta funcion devuelve los mismos datos que se obtienen al hacer un pago
        //history tran: 788ddc83-cf24-427f-b68a-5be75c5befa5
        $this->init_payu();
        $parameters = array(PayUParameters::TRANSACTION_ID => "e7cac6f4-a5f8-474c-8756-25517e405904");

        $response = PayUReports::getTransactionResponse($parameters);

        if ($response) {
            $response->state;
            $response->trazabilityCode;
            $response->authorizationCode;
            $response->responseCode;
            $response->operationDate;
        }
        echo "<pre>";print_r($response);echo "</pre>"; 
    }

	function test_f1(){
		$valor = "";
		echo '<iframe name="myFrame" style="display:none"></iframe>';
		echo form_open('order/test_f2', array('method'=>'post', 'id'=>'myForm', 'target'=>'myFrame'));
		echo form_input('valor', $valor);
		echo form_submit('submit', 'submit');
		echo form_close();
	}

	function test_f2(){
		//echo '<iframe style="display:none;" name="target"></iframe>';
		echo '<script>alert("'.$this->input->post('valor').'");</script>';
		//echo $this->input->post('valor');
	}

	function testForm(){
		$this->load->view('pages/order_intan');
	}

	function pay(){
		$this->load->view('pages/payment_form');
	}

	function dummy_payment(){
		if ($this->input->post('token') == 'TokenDePrueba')
		{
			$this->load->model('membership_model');
			echo $this->membership_model->record_payment();
		}
		else
			echo "Error with token";
	}

	function testPay(){
        Twocheckout::privateKey('04327A71-E9DD-4350-9520-A09680D20C5D');
        Twocheckout::sellerId('901331385');
        Twocheckout::sandbox(true);

        try {
            $charge = Twocheckout_Charge::auth(array(
                "sellerId" => "901331385",
                "merchantOrderId" => "123",
                "token" => 'MWNlMmNhYjItZDJhOC00MmUzLWE0NmItZGZiZDNiZGJhMDkx',
                "currency" => 'USD',
                "total" => '0.10',
                "billingAddr" => array(
                    "name" => 'Testing Tester',
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => 'testingtester@2co.com',
                    "phoneNumber" => '555-555-5555'
                ),
                "shippingAddr" => array(
                    "name" => 'Testing Tester',
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => 'testingtester@2co.com',
                    "phoneNumber" => '555-555-5555'
                )
            ));
            //$this->assertEquals('APPROVED', $charge['response']['responseCode']);
			echo "<pre>";print_r($charge);echo "</pre>";
        } catch (Twocheckout_Error $e) {
            //$this->assertEquals('Bad request - parameter error', $e->getMessage());
            echo "<pre>";print_r($e);echo "</pre>";
            echo "<pre>";print_r($charge);echo "</pre>";
        }
	}
	function payment(){
        //echo $this->input->post('username');
        $this->load->model('membership_model');
        $userinfo = $this->membership_model->get_fullname($this->input->post('username'));

		Twocheckout::username('jfloresu');
		Twocheckout::password('Jafu6921');
		Twocheckout::privateKey('04327A71-E9DD-4350-9520-A09680D20C5D');
		Twocheckout::sellerId('901331385');
		Twocheckout::sandbox(true); // Set to false for production accounts.
		//echo $this->input->post('token')."<br>";
        //echo $this->input->post('orderId')."<br>";
        $params = array(
                "sellerId"   => '901331385',
                "privateKey" => '04327A71-E9DD-4350-9520-A09680D20C5D',
                "merchantOrderId" => $this->input->post('orderId'),
                "token"      => $this->input->post('token'),
                "currency"   => 'USD',
                "lineItems"  => array(array('name'   => 'Demo Item', 
                                      'price'  => $this->input->post('totalId'),
                                      'type'   => 'product',
                                      'quantity' => '1',
                                      'productId' => $this->input->post('imageCode'),
                                      'name' => $this->input->post('imageCode'),
                                      'recurrence' => null,
                                      'startupFee' => '0.00'
                                )),
                "billingAddr" => array(
                    "name" => $userinfo->fname,
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => $userinfo->email_address,
                    "phoneNumber" => '555-555-5555'
                )
            );
		
        try {
		    $charge = Twocheckout_Charge::auth($params);
		    if ($charge['response']['responseCode'] == 'APPROVED') {
		        //echo "Thanks for your Order!";
		        //echo "<h3>Return Parameters:</h3>";
		        //echo "<pre>";
                $this->membership_model->record_payment();
		        print_r(json_encode($charge));
		        //echo "</pre>";
		    }
		} catch (Twocheckout_Error $e) {
            print_r(json_encode($params));
		    print_r($e->getMessage());
		}
	}


	function testChargeForm()
    {
        $params = array(
            'sid' => '901331385',
            'mode' => '2CO',
            'li_0_name' => 'Test Product',
            'li_0_price' => '0.01'
        );
        Twocheckout::sandbox(true);
        Twocheckout_Charge::form($params, "Click Here!");
    }

    function testDirectAuto()
    {
        Twocheckout::sandbox(true);
        $params = array(
            'sid' => '901331385', //'901313445',
            'mode' => '2CO',
            'li_0_type' => 'Product',
            'li_0_name' => 'Test Product',
            'li_0_price' => '0.01',
            'card_holder_name' => 'Jorge Flores',
            'email' => 'jorgefloresu@gmail.com',
            'phone' => '614-921-2450',
            'street_address' => '123 Test St',
            'city' => 'Columbus',
            'state' => 'OH',
            'zip' => '43123',
            'country' => 'USA',
            'lang' => 'es_la'
        );
        Twocheckout_Charge::direct($params, 'Buy');
    }

	function passback()
    {
        //Assign the returned parameters to an array.
        $params = array();
        foreach ($_REQUEST as $k => $v) {
            $params[$k] = $v;
        }

        //Check the MD5 Hash to determine the validity of the sale.
        $passback = Twocheckout_Return::check($params, "ZTA2OTFjNzAtYjQwNi00MzJiLThiNDQtYmQwZjFlZGZkZDk2");
        //print_r($passback);
        if ($passback['response_code'] == 'Success') {
            $order_number = $params['order_number'];
            $invoice_id = $params['invoice_id'];
            $credit_card_processed = $params['credit_card_processed'];
            $total = $params['total'];
        }
        $_POST['username'] = 'jfloresu';
        $_POST['activity_type'] = $order_number;
        $_POST['img_code'] = $invoice_id;
        $this->load->model('membership_model');
        $this->membership_model->record_transaction();
    }

    function testChargeLink()
    {
        Twocheckout::sandbox(true);
        $params = array(
            'sid' => '901331385',
            'mode' => '2CO',
            'li_0_name' => 'Test Product',
            'li_0_price' => '0.01'
        );
        $link = Twocheckout_Charge::link($params);
        echo anchor($link, 'Check out');
    }

}
