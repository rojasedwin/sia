<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');

class Pedidos extends MY_LoggedController {

	var $vista= "pedidos";


	public function __construct(){
		parent::__construct('pedidos');
		$this->load->helper(array('commun'));

		$this->load->model('pedidos_model');

	}

	public function index(){
		$this->load->model('proveedores_model');
		$datos = array();
		$datos['view'] 		= $this->vista."/index";
		$datos['js_data'] = array($this->vista.'/index.js?'.$this->config->item('js_version'));
		$datos['message'] = "";

		$datos['proveedores']=$this->proveedores_model->getProveedoresActivos();
		$this->load->view('admin_view', $datos);

	}

	public function getItems(){
		$datos 				 = array();
		$datos['view'] = $this->vista."/getItems";

		$datos['items']= $this->pedidos_model->getItems();

		$this->load->view('ajax_admin_view', $datos);
	}

	public function adeItem(){

		echo json_encode($this->order_model->adeItem());
	}

	public function getFormDetalleItem(){

		$datos= array();
		$datos['view'] = $this->vista."/getFormItem";

		$datos['my_pedidos'] = $this->pedidos_model->getDetallePedido($this->input->post('item_id'));
		$datos['condiciones'] = $this->pedidos_model->getCondicionesPedido($this->input->post('item_id'));
		$this->load->view('ajax_admin_view', $datos);
	}








}
