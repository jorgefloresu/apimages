<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// main ajax back end
class Time extends CI_Controller {
  // just returns time
  public function index()
  {
  	echo time();
  } 
}
