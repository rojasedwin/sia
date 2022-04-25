<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'core/MY_LoggedController.php');
class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct('dashboard');
		$this->load->helper();

	}

	public function index(){
		
		$datos['view'] = "back/dashboard";
		//$datos['js_data'] = array('dashboard/dashboardadmin.js?1.'.$this->config->item('js_version'));
		//$datos['message'] = "";
//print_r($datos);exit;		
		//$this->load->view('admin_view', $datos);
		//$this->template->load("back/template","back/dashboard");
		$this->load->view('admin_view', $datos);

	}

}
