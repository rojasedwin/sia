<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');
class Clientes extends MY_LoggedController {

	public function __construct(){
		parent::__construct('clientes');
		$this->load->helper('commun');
		$this->load->model('clientes_model');

	}

	public function index(){
		$datos['js_data'] = array('clientes/index.js?'.$this->config->item('js_version'));
		$datos['view'] = "clientes/index";

		$this->load->view('admin_view', $datos);

	}
	
	public function getItems(){
		$datos= array();
		$datos['view'] = "clientes/getItems";

		$datos['items']= $this->clientes_model->getItems();

		$this->load->view('ajax_admin_view', $datos);
	}
	
	public function getFormItem(){

		$datos= array();
		$datos['view'] = "clientes/getFormItem";
		if($this->input->post('item_id')==""){
			$datos['item'] = $this->clientes_model->getFields();
			
		}else{
			$datos['item'] = $this->clientes_model->getItem($this->input->post('item_id'));
		}

		$this->load->view('ajax_admin_view', $datos);
	}
	
	public function saveItem(){
	
		 $this->load->library('form_validation');
		 $is_unique = "";
			if($this->input->post('cliente_email')!=$this->input->post('original_email') or $this->input->post('original_email')=="")
			$is_unique = "|is_unique[clientes.cliente_email]";		 
		 $this->form_validation->set_rules(
			 'cliente_email','Email',
			 'required'.$is_unique,
				 array(
						'is_unique'      => '%s ya existe',
						'required'      => 'No has indicado %s.'
		 		 )
	 	 );
		 

		if ($this->form_validation->run() == FALSE)
		{
			$return_data 						= array();
			$return_data['result']  = -1;
			$return_data['message'] = validation_errors();
			echo json_encode($return_data);
		
		}
		else
		{
			if($this->input->post('cliente_id')!="")
			{
				$respuesta = $this->clientes_model->updateItem();
			}
			else {
				$respuesta = $this->clientes_model->saveItem();
			}
			$datos= array();
			$datos['view'] = "clientes/getItems";
			$datos['items']= $this->clientes_model->getItems();
			$respuesta['html_clientes'] = $this->load->view('ajax_admin_view', $datos, TRUE);
			echo json_encode($respuesta);
		}
	}
	
	public function adeItem(){
		$datos= array();
		$datos['view'] = "clientes/getItems";
		$respuesta=$this->clientes_model->delItem();	
		$datos['items']= $this->clientes_model->getItems();
		
		$respuesta['html_clientes'] = $this->load->view('ajax_admin_view', $datos, TRUE);
		echo json_encode($respuesta);
	}

}
