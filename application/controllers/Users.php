<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'core/MY_LoggedController.php');
class Users extends CI_Controller {

	public function __construct(){
		parent::__construct('dashboard');
		$this->load->helper('commun');

	}

	public function index(){
		
		$datos['view'] = "users/index";

		$this->load->view('admin_view', $datos);

	}

}
