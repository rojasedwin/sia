<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');

class Laboratorios extends MY_LoggedController {

	var $vista = "laboratorios";
	var $item_id = "laboratorio_id";
	var $tabla_principal = "laboratorios";

	public function __construct(){
		parent::__construct('laboratorios');
		$this->load->helper(array('commun'));
		$this->load->model('laboratorios_model');
	}

	public function index(){

		$datos = array();
		$datos['view'] = "laboratorios/index";
		$datos['js_data'] = array('laboratorios/index.js?'.$this->config->item('js_version'));
		$datos['message'] = "";
		$this->load->view('admin_view', $datos);
	}

	public function getItems(){
		$datos = array();
		$datos['view'] = "laboratorios/getItems";

		$datos['items']=$this->laboratorios_model->getItems();
		$this->load->view('ajax_admin_view', $datos);
	}

	public function getFormItem(){
		$datos = array();
		$datos['view'] = "laboratorios/getFormItem";


		if($this->input->post('laboratorio_id')=="")
		{
			$datos['item'] = $this->laboratorios_model->getFields();

		}
		else {
			$datos['item'] = $this->laboratorios_model->getItem($this->input->post('laboratorio_id'));

		}


		$this->load->view('ajax_admin_view', $datos);
	}

	public function saveItem(){
		$this->load->library('form_validation');


		$verificaCif ="";
		 if( $this->input->post('laboratorio_cif')!="" )
			$verificaCif = "|callback_ValidarCif";
		$this->form_validation->set_rules(
			'laboratorio_cif','CIF',
			'required'.$verificaCif,
			array(
				'required'      => 'No has indicado %s.'
			)
		);
		$this->form_validation->set_rules(
			'laboratorio_nombre','Nombre',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);
		/*
		$this->form_validation->set_rules(
			'laboratorio_nombrecomercial','Nombre Comercial',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'laboratorio_telefono','Telefono',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'laboratorio_direccion','Direccion',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'laboratorio_cp','Cod. Postal',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'laboratorio_poblacion','Ciudad',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		$this->form_validation->set_rules(
			'laboratorio_municipio','Municipio',
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

			if($this->input->post('laboratorio_id')!="")
				echo json_encode($this->laboratorios_model->updateItem());
			else
				echo json_encode($this->laboratorios_model->saveItem() );

		}
	}


	public function adeItem(){
		echo json_encode($this->laboratorios_model->adeItem());
	}


	public function ValidarCif(){
		$cif= limpiarDniCifNie($this->input->post('laboratorio_cif'));


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
