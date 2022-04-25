<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');

class Condiciones extends MY_LoggedController {

	var $vista = "condiciones";
	var $item_id = "condicion_id";
	var $tabla_principal = "condiciones";

	public function __construct(){
		parent::__construct('condiciones');
		$this->load->helper(array('commun'));
		$this->load->model('condiciones_model');
	}

	public function index(){

		$datos = array();
		$datos['view'] = "condiciones/index";
		$datos['js_data'] = array('condiciones/index.js?'.$this->config->item('js_version'));
		$datos['message'] = "";
		$this->load->model('laboratorios_model');
		$datos['laboratorios']=$this->laboratorios_model->getLaboratoriosActivos();

		$this->load->view('admin_view', $datos);
	}
	
	public function getItems(){
		$datos = array();
		$datos['view'] = "condiciones/getItems";
		
	
		$datos['items']=$this->condiciones_model->getItems();
		$this->load->view('ajax_admin_view', $datos);
	}
	
	public function getFormItem(){
		$datos = array();
		$datos['view'] = "condiciones/getFormItem";
		$this->load->model('proveedores_model');
	
		
		if($this->input->post('condicion_id')=="")
		{
			$datos['item'] = $this->condiciones_model->getFields();
			$datos['misproveedores'] =array();
		}
		else {
			$datos['item'] = $this->condiciones_model->getItem($this->input->post('condicion_id'));
			$datos['misproveedores'] = devolver_array_por_campo($this->proveedores_model->getMisProveedoresCondicion($this->input->post('condicion_id')),'proveedor_id');
			
		}
		$this->load->model('laboratorios_model');
		$datos['laboratorios']=$this->laboratorios_model->getLaboratoriosActivos();
		
		
		$datos['proveedores']=$this->proveedores_model->getProveedoresActivos();
		
		$this->load->view('ajax_admin_view', $datos);
	}
	
	public function saveItem(){
		$this->load->library('form_validation');
	
	
		$this->form_validation->set_rules(
			'laboratorio_id','Laboratorio',
			'required',
			array(
				'required'      => 'No has seleccionado %s.'

			)
		);
		
		$this->form_validation->set_rules(
			'condicion_nombre','Nombre de la Condición',
			'required|min_length[2]',
			array(
				'required'      => 'No has indicado %s.',
				'min_length' => '%s: Al menos 2 caracteres'
			)
		);

		if($this->input->post('condicion_cantidad_minima')!=""){
			$this->form_validation->set_rules(
				'condicion_cantidad_minima','Condición Cantidad Mínima',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}

		if($this->input->post('condicion_cantidad_maxima')!=""){
			$this->form_validation->set_rules(
				'condicion_cantidad_maxima','Condición Cantidad Máxima',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}

		if($this->input->post('condicion_cantidad_minima_eur')!=""){
			$this->form_validation->set_rules(
				'condicion_cantidad_minima_eur','Condición Cantidad Mínima €',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}

		if($this->input->post('condicion_cantidad_maxima_eur')!=""){
			$this->form_validation->set_rules(
				'condicion_cantidad_maxima_eur','Condición Cantidad Máxima €',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}

		if($this->input->post('condicion_cantidad_descuento')!=""){
			$this->form_validation->set_rules(
				'condicion_cantidad_descuento','Condición Cantidad Descuento',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}
		
		if($this->input->post('unidades_oferta')!=""){
			$this->form_validation->set_rules(
				'unidades_oferta','Por cada X Unidades',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}
		
		if($this->input->post('unidades_regalo_oferta')!=""){
			$this->form_validation->set_rules(
				'unidades_regalo_oferta','Me regalan',
				'integer',
				array(
					'integer'      => ' %s: Ingrese solo números'
				
				)
			);
		}
		
				
		
	
		if ($this->form_validation->run() == FALSE)
		{
			$return_data = array();
			$return_data['result'] = -1;
			$return_data['message'] = validation_errors();
			echo json_encode($return_data);
		}
		else
		{
	
				if($this->input->post('condicion_id')!="")
				echo json_encode($this->condiciones_model->updateItem());
			else
				echo json_encode($this->condiciones_model->saveItem() );
	
		}
	}

	
	
	public function adeItem(){

		echo json_encode($this->condiciones_model->adeItem());
	}


	public function subirDocumento(){

		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$tmp = explode(".",$_FILES['file_condiciones']['name']);

		$error_formato=false;
		$extension=end($tmp);
		if($extension!="xls" and $extension!="xlsx" )
		$error_formato=true;

		$this->load->library('excel');
		$archivo = $_FILES['file_condiciones']['tmp_name'];

		$miscodnacional=indexar_array_por_campo($this->condiciones_model->getMisCondiciones($this->input->post('aux_condicion_id')),'cod_nacional');


		
		$mis_lineas = $this->excel->leer_excelCondicionesProductos($archivo, $miscodnacional,$this->input->post('aux_condicion_id') );

		$return_data['result'] = 1;
		$return_data['message'] = "Plantilla de Codigos Nacionales";
		$return_data['condicion_id'] = $this->input->post('aux_condicion_id');


		//PROCESAMOS EL FICHERO
			$return_data['lineas_procesados']=count($mis_lineas);
		if(!$error_formato){
			if(count($mis_lineas)>0){
				$sql= $this->db->insert_batch('condiciones_productos',$mis_lineas);

				$response = json_encode($return_data);

				echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";

			} 
			else {
				$return_data['result'] = -1;
				$return_data['message'] = "No existen filas nuevas para agregar";
				$response = json_encode($return_data);
				echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";

			}
		}else{
			$return_data['result'] = -2;
			$return_data['message'] = "Formato no válido";
			$response = json_encode($return_data);
			echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";
		}

	}	


		
	
}
