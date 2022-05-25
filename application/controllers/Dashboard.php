<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');
class Dashboard extends MY_LoggedController {

	public function __construct(){
		parent::__construct('dashboard');
		$this->load->helper('commun');
		$this->load->model('clientes_model');

	}

	public function index(){
		
		$datos['view'] = "back/dashboard";
		$datos['items_clientes']=$this->clientes_model->getNumClientes();
		$this->load->view('admin_view', $datos);

	}

}
