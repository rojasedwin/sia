<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Proveedores_model extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

	public function getItems(){

		$return_data = array();

		$this->db->from('proveedores p')
		->select('*')
		->order_by('p.proveedor_order Asc')
		;
		$return_data['items'] = $this->db->get()->result_array();
		return $return_data;
	}

	public function getFields(){
		$fields = $this->db->list_fields('proveedores');
		$return_data = indexar_array_vacio($fields);
		return $return_data;
    }

	public function saveItem(){
		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if(strpos($key,"proveedor_")!==false) //Details POST
			{

				$ins_data[$key] = $this->input->post($key);
			}
		}
		

		if($this->input->post('pwd')!="")
		{
			$ins_data['proveedor_pwd'] = password_hash($this->input->post('pwd'),PASSWORD_DEFAULT);
		}
		$ins_data['proveedor_order'] = $this->getUltimoOrden();
			
		$sql_ = $this->db->insert('proveedores', $ins_data);

		if($sql_){
			
			$proveedor_id=$this->db->insert_id();
			$return_data['proveedor_id'] = $proveedor_id;
			
			
			
			
		}

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] = 0;
			$return_data['message'] = "Error guardando datos data";
		}
		return $return_data;
			
			
	}	

	public function getUltimoOrden(){

		$this->db->select('*')
		->from("proveedores")
		->limit(1)
		->order_by('proveedor_order', 'DESC');
		$sel_item = $this->db->get();

		if ($sel_item->num_rows() == "0") {
			return 1;
		}
		else {
			$data = $sel_item->row_array();
			return $data['proveedor_order']+1;
		}
	}

	public function getItem($id){

		return $this->db->from('proveedores')
		->select('*')
		->limit(1)
	->where('proveedor_id', $id)->get()->row_array();
	}

	public function updateItem(){
		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if(strpos($key,"proveedor_")!==false) //Details POST
			{

				$ins_data[$key] = $this->input->post($key);
			}
		}
		

		if($this->input->post('pwd')!="")
		{
			$ins_data['proveedor_pwd'] = password_hash($this->input->post('pwd'),PASSWORD_DEFAULT);
		}

		unset($ins_data['proveedor_id']);
		
		$sql_ =  $this->db->where('proveedor_id',$this->input->post('proveedor_id'))->update('proveedores', $ins_data);

		if($sql_){
			
			$proveedor_id=$this->input->post('proveedor_id');
			$return_data['proveedor_id'] = $proveedor_id;
			
			
			
			
		}

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] = 0;
			$return_data['message'] = "Error guardando datos data";
		}
		return $return_data;
			
			
	}

	public function ordenar(){
		$return_data= array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "";

		$lista_id = $this->input->post('lista_id');

		$orden_id = explode(':', $lista_id);

		$this->db->trans_start();

		$ins_data = array();
		$orden 		= 1;
		// Vamos ordenando de forma consecutiva los Sliders, según el orden que recibimos
		foreach($orden_id as $key=>$valor){
			$ins_data['proveedor_order'] = $orden;
			$sql_upd = $this->db->where('proveedor_id',$valor)
			->update('proveedores', $ins_data);
			$orden++;
		}

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$return_data['result'] = 0;
			$return_data['message'] = "Error guardando datos data";
		}

		return $return_data;
	}

	public function adeItem(){
		$return_data 						= array();
		$return_data['result']  = 1;
		$return_data['message'] = "";
		if($this->input->post('item_id',TRUE)==""){
		  $return_data['result']  = 0;
		  $return_data['message'] = "No encontrado";
		  return $return_data;
		}

		  // Dependiendo de la acción a realizar se hace una acción distinta sobre la BD
		  switch ($this->input->post('item_id_accion')) {
		  case "Eliminar": // Se hace la acción de eliminar, ya sea con un delete o con un update
				  $del_data = $this->db->where('proveedor_id',$this->input->post('item_id',TRUE))->delete('proveedores');
				  $return_data['message'] = "Eliminado";
		  break;
		  case "Activar":
				  $del_data = $this->db->where('proveedor_id',$this->input->post('item_id'))->update('proveedores',array("proveedor_activo"=>"1"));
				  $return_data['message'] = "Activado";
		  break;
		  case "Desactivar":
				  $del_data = $this->db->where('proveedor_id',$this->input->post('item_id'))->update('proveedores',array("proveedor_activo"=>"0"));
				  $return_data['message'] = "Desactivado";
		  break;


		  }


		if($del_data){
		  $return_data['result'] 	= 1;


		}
		else {
		  $return_data['result'] 	= 0;
		  $return_data['message'] = "Error";
		}
		return $return_data;
  	}
	
	public function getProveedoresActivos(){

		return $this->db->from('proveedores p')
		->select('*')
		->where('p.proveedor_activo',1)
		->order_by('p.proveedor_order Asc')
		->get()->result_array();

	}
	
	public function getMisProveedoresCondicion($condicion_id){
		return $this->db->from('condiciones_proveedor_multiple')
		->select('*')
		->where('condicion_id',$condicion_id)
		->get()->result_array();
		
	}
	
	






		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
