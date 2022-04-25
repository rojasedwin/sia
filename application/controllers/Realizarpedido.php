<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');

class Realizarpedido extends MY_LoggedController {

	var $vista = "realizarpedido";

	public function __construct(){
		parent::__construct('realizarpedido');
		$this->load->helper(array('commun'));
		$this->load->model('realizarpedido_model');
	}

	public function index(){

		$datos = array();
		$datos['view'] = "realizarpedido/index";
		$datos['js_data'] = array('realizarpedido/index.js?'.$this->config->item('js_version'));
		$datos['message'] = "";
		$this->load->model('laboratorios_model');
		$datos['laboratorios']=$this->laboratorios_model->getLaboratoriosActivos();

		$this->load->view('admin_view', $datos);
	}

	public function getItems(){
		$datos = array();
		$respuesta['result']=1;
		$datos['view'] = "realizarpedido/getItems_paso_1";
		$datos['items_paso_1']=$this->realizarpedido_model->getItems_paso_1();

		$respuesta['html_paso_1'] = $this->load->view('ajax_admin_view', $datos, TRUE);

		$datos['view'] = "realizarpedido/getItems_paso_2";
		$datos['items_paso_2']=$this->realizarpedido_model->getItems_paso_2();

		$respuesta['html_paso_2'] = $this->load->view('ajax_admin_view', $datos, TRUE);

		echo json_encode($respuesta);
	}



	public function adeItem(){

		echo json_encode($this->realizarpedido_model->adeItem());
	}


	public function subirDocumentoPaso1(){

		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$paso_id=$this->input->post('aux_paso_1');

		$tmp = explode(".",$_FILES['file_paso_1']['name']);

		$error_formato=false;
		$extension=end($tmp);
		if($extension!="xls" and $extension!="xlsx" )
		$error_formato=true;

		$this->load->library('excel');
		$archivo = $_FILES['file_paso_1']['tmp_name'];
		$name_real = $_FILES['file_paso_1']['name'];

		$existe_fichero=false;

		$consulta=$this->db->select('*')->from('excel_incrementales')->where('nombre_excel',$name_real)->get()->num_rows();

		if($consulta>0){
			$existe_fichero=true;

		}

		$mis_lineas = $this->excel->leer_excelPasos($archivo, $name_real,  $paso_id );

		if($error_formato){
			$return_data['result'] = -2;
			$return_data['message'] = "Formato no válido";
			$response = json_encode($return_data);
			echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";exit;
		}

		if($mis_lineas['errores']==1){
			$return_data['result'] = -4;
			$return_data['message'] = "No existe la pestaña Balance Lista en el Fichero";
			$response = json_encode($return_data);
			echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";exit;
		}

		if($existe_fichero){
			$return_data['result'] = -3;
			$return_data['message'] = "Fichero ya fue procesado";
			$response = json_encode($return_data);
			echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";exit;
		}

		$return_data['result'] = 1;
		$return_data['message'] = "Plantilla de Excel Incrementales";
		$return_data['paso_id'] = $paso_id;

		$return_data['existe_fichero'] = $existe_fichero;

		//PROCESAMOS EL FICHERO
			$return_data['lineas_procesados']=$mis_lineas['resumen'][0]['num_registros'];
		if(!$error_formato){


				if(count($mis_lineas)>0){
					$sql= $this->db->insert_batch('stock_necesario_incremental',$mis_lineas['detalle']);
					$this->db->insert('excel_incrementales',$mis_lineas['resumen'][0]);

					$datos=array();
					$datos['view'] = "realizarpedido/getItems_paso_1";
					$datos['items_paso_1']=$this->realizarpedido_model->getItems_paso_1();

					$return_data['html_paso'] = $this->load->view('ajax_admin_view', $datos, TRUE);

					$response = json_encode($return_data);

					echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";

				}
				else {
					$return_data['result'] = -1;
					$return_data['message'] = "No existen filas nuevas para agregar";
					$response = json_encode($return_data);
					echo "<script>window.parent.respuestaFicheroImportado(".$response.");</script>";

				}

		}


	}

	public function subirDocumentoPaso2(){

		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$paso_id=$this->input->post('aux_paso_2');

		$tmp = explode(".",$_FILES['file_paso_2']['name']);

		$error_formato=false;
		$extension=end($tmp);
		if($extension!="xls" and $extension!="xlsx" )
		$error_formato=true;

		$this->load->library('excel');
		$archivo = $_FILES['file_paso_2']['tmp_name'];

		$this->realizarpedido_model->eliminarMisPasos2();



		$mis_lineas = $this->excel->leer_excelPasos2($archivo);

		$return_data['result'] = 1;
		$return_data['message'] = "Plantilla de Codigos Nacionales";
		$return_data['paso_id'] = $paso_id;


		//PROCESAMOS EL FICHERO
			$return_data['lineas_procesados']=count($mis_lineas['detalle']);
		if(!$error_formato){
			if(count($mis_lineas['detalle'])>0){
				$sql= $this->db->insert_batch('stock_necesario_externo',$mis_lineas['detalle']);

				$datos=array();
				$datos['view'] = "realizarpedido/getItems_paso_2";
				$datos['items_paso_2']=$this->realizarpedido_model->getItems_paso_2();

				$return_data['html_paso'] = $this->load->view('ajax_admin_view', $datos, TRUE);



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

	/*
	CONFIRMAR PEDIDO
	*/

	public function confirmarpedido(){

		$datos = array();
		$datos['view'] = "realizarpedido/confirmarpedido/index";
		$datos['js_data'] = array('confirmarpedido/index.js?'.$this->config->item('js_version'));
		$datos['message'] = "";

		/*
		$condiciones = array();
		$condiciones['unidades_oferta'] = 3;
		$condiciones['unidades_regalo_oferta'] = 2;
		echo $this->realizarpedido_model->checkUnidadesObtener(8,$condiciones);
		exit;
		*/
		/*
		1500397 23
		1504609 12
		 1502278 15
		*/
		$pedido = $this->realizarpedido_model->calcularPedido();
		//debug($pedido);
		//exit;
		$datos['pedido'] = $pedido;

		$this->load->view('admin_view', $datos);
	}

	public function getFormItemAddPedido(){
		$datos= array();
		$datos['view'] = $this->vista."/confirmarpedido/getFormItemAddPedido";



		$datos['items'] = $this->realizarpedido_model->getStockExtra();

		$this->load->view('ajax_admin_view', $datos);
	}

	public function saveLineasAddPedido(){

		$items = json_decode($this->input->post('items'),true);

			$verificarCodNacional=array();

			$totErrLargo=0;

			if(!empty($items)){


				foreach($items as $item){

					array_push($verificarCodNacional,strtolower($item['cod_nacional']));

				}

                 $entrada = $verificarCodNacional;
                 $resultado = array_unique($entrada);

				if(count($entrada) > count($resultado)){
					$respuestaDuplicado['result']= -1;
			        $respuestaDuplicado['message']= "<div class='alert alert-danger alert-sm'>Código Nacional está duplicado</div>";
				    echo json_encode($respuestaDuplicado);exit;
				}

				foreach($items as $linea){

					if(!is_numeric($linea['num_unidades'])){

						$respuestaDuplicado['result']= -2;
						$respuestaDuplicado['message']= "<div class='alert alert-danger alert-sm'>Número de unidades debe ser númerico</div>";
						echo json_encode($respuestaDuplicado);exit;
					}
				}

				$respuesta = $this->realizarpedido_model->saveLineasAddPedido();

				if($respuesta['result']==1)
				{
					$datos = array();
					$datos['view'] = "realizarpedido/confirmarpedido/getFormItem";

					$datos['message'] = "";
					$pedido = $this->realizarpedido_model->calcularPedido();

					$tipo_algoritmo =$this->input->post('tipo_algoritmo');
					if($tipo_algoritmo=="repartir")
					{
						//Repartir el pedido
						if($tipo_algoritmo=="repartir")
						{
							//Repartir el pedido
							$pedido = $this->realizarpedido_model->calcularPedidoMinimo($pedido);
						}
					}
					$this->realizarpedido_model->cargarPedidoTmp($pedido);
					//debug($pedido);
					//exit;
					$datos['pedido'] = $pedido;
					$respuesta['html'] = $this->load->view('ajax_admin_view', $datos,true);
				}


				echo json_encode($respuesta);


			}



	}
	public function recalcularPedido(){

		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";

		$tipo_algoritmo =$this->input->post('tipo_algoritmo');

		$datos = array();
		$datos['view'] = "realizarpedido/confirmarpedido/getFormItem";

		$datos['message'] = "";
		$pedido = $this->realizarpedido_model->calcularPedido();

		if($tipo_algoritmo=="repartir")
		{
			//Repartir el pedido
			$pedido = $this->realizarpedido_model->calcularPedidoMinimo($pedido);
		}
		$this->realizarpedido_model->cargarPedidoTmp($pedido);
		//debug($pedido);
		//exit;
		$datos['pedido'] = $pedido;
		$return_data['html'] = $this->load->view('ajax_admin_view', $datos,true);
		echo json_encode($return_data);

	} //Recalcular pedido


public function finalizarPedido()
{

	$return_data = $this->realizarpedido_model->finalizarPedido();
	echo json_encode($return_data);
}



}
