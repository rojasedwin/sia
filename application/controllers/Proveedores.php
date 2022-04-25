<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');

class Proveedores extends MY_LoggedController {

	var $vista = "proveedores";
	var $item_id = "proveedor_id";
	var $tabla_principal = "proveedores";

	public function __construct(){
		parent::__construct('proveedores');
		$this->load->helper(array('commun'));
		$this->load->model('proveedores_model');
	}

	public function index(){

		$datos = array();
		$datos['view'] = "proveedores/index";
		$datos['js_data'] = array('proveedores/index.js?'.$this->config->item('js_version'));
		$datos['message'] = "";
		$this->load->view('admin_view', $datos);
	}

	public function getItems(){
		$datos = array();
		$datos['view'] = "proveedores/getItems";

		$datos['items']=$this->proveedores_model->getItems();
		$this->load->view('ajax_admin_view', $datos);
	}

	public function getFormItem(){
		$datos = array();
		$datos['view'] = "proveedores/getFormItem";


		if($this->input->post('proveedor_id')=="")
		{
			$datos['item'] = $this->proveedores_model->getFields();

		}
		else {
			$datos['item'] = $this->proveedores_model->getItem($this->input->post('proveedor_id'));

		}


		$this->load->view('ajax_admin_view', $datos);
	}

	public function saveItem(){
		$this->load->library('form_validation');


		$verificaCif ="";
		 if( $this->input->post('proveedor_cif')!="" )
			$verificaCif = "|callback_ValidarCif";
		$this->form_validation->set_rules(
			'proveedor_cif','CIF',
			'required'.$verificaCif,
			array(
				'required'      => 'No has indicado %s.'
			)
		);
		$this->form_validation->set_rules(
			'proveedor_nombre','Nombre',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'proveedor_nombrecomercial','Nombre Comercial',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);
		/*
		$this->form_validation->set_rules(
			'proveedor_telefono','Telefono',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'proveedor_direccion','Direccion',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'proveedor_cp','Cod. Postal',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'proveedor_poblacion','Ciudad',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'proveedor_municipio','Municipio',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		*/

		if ($this->form_validation->run() == FALSE)
		{
			$return_data = array();
			$return_data['result'] = -1;
			$return_data['message'] = validation_errors();
			echo json_encode($return_data);
		}
		else
		{

			if($this->input->post('proveedor_id')!="")
				echo json_encode($this->proveedores_model->updateItem());
			else
				echo json_encode($this->proveedores_model->saveItem() );

		}
	}

	public function ordenar(){
		echo json_encode($this->proveedores_model->ordenar());
	}


	public function adeItem(){
		echo json_encode($this->proveedores_model->adeItem());
	}


	public function ValidarCif(){
		$cif= limpiarDniCifNie($this->input->post('proveedor_cif'));


		if(validDniCifNie($cif)){
				return TRUE;
		}
		else
		{
				$this->form_validation->set_message('ValidarCif', 'Cif es invalido');
				return FALSE;
		}
	}

}
