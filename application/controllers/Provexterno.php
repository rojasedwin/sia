<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedControllerExterno.php');

class Provexterno extends MY_LoggedControllerExterno {

	public function __construct(){
		parent::__construct('provexterno');
		$this->load->helper(array('commun','notification'));
		$this->load->model('proveedores_model');
	}


	public function index(){
		$datos = array();
		$datos['view'] = "dashboardexterno/index";

		$datos['js_data'] = array(
		'dashboardexterno/index.js?'.$this->config->item('js_version')
		);

		$this->load->view('admin_view', $datos);

	}



	public function cargarItems(){
		$this->load->model('pedidos_model');
		$datos = array();
		$datos['view'] = "dashboardexterno/getItems";

		$respuesta['result']=1;

		$datos['items']=$this->pedidos_model->getItems();

		$respuesta['html_pedidos'] = $this->load->view('ajax_admin_view', $datos, TRUE);

			echo json_encode($respuesta);
	}

	public function adeItem(){
		$this->load->model('pedidos_model');
		echo json_encode($this->pedidos_model->adeItem());
	}

	public function getFormDetalleItem(){
		$this->load->model('pedidos_model');
		$datos= array();
		$datos['view'] = "dashboardexterno/getFormItem";

		$datos['my_pedidos'] = $this->pedidos_model->getDetallePedido($this->input->post('item_id'));
		$datos['condiciones'] = $this->pedidos_model->getCondicionesPedido($this->input->post('item_id'));
		$this->load->view('ajax_admin_view', $datos);
	}







}
