<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Laboratorios_model extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

	public function getItems(){

		$return_data = array();

		$this->db->from('laboratorios l')
		->select('*')
		->order_by('l.laboratorio_create_time Desc')
		;
		$return_data['items'] = $this->db->get()->result_array();
		return $return_data;
	}

	public function getFields(){
		$fields = $this->db->list_fields('laboratorios');
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
			if(strpos($key,"laboratorio_")!==false) //Details POST
			{

				$ins_data[$key] = $this->input->post($key);
			}
		}
		

		if($this->input->post('pwd')!="")
		{
			$ins_data['laboratorio_pwd'] = password_hash($this->input->post('pwd'),PASSWORD_DEFAULT);
		}
					
		$sql_ = $this->db->insert('laboratorios', $ins_data);

		if($sql_){
			
			$laboratorio_id=$this->db->insert_id();
			$return_data['laboratorio_id'] = $laboratorio_id;
			
			
			
			
		}

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] = 0;
			$return_data['message'] = "Error guardando datos data";
		}
		return $return_data;
			
			
	}	

	public function getItem($id){

		return $this->db->from('laboratorios')
		->select('*')
		->limit(1)
	->where('laboratorio_id', $id)->get()->row_array();
	}

	public function updateItem(){
		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if(strpos($key,"laboratorio_")!==false) //Details POST
			{

				$ins_data[$key] = $this->input->post($key);
			}
		}
		

		if($this->input->post('pwd')!="")
		{
			$ins_data['laboratorio_pwd'] = password_hash($this->input->post('pwd'),PASSWORD_DEFAULT);
		}

		unset($ins_data['laboratorio_id']);
		
		$sql_ =  $this->db->where('laboratorio_id',$this->input->post('laboratorio_id'))->update('laboratorios', $ins_data);

		if($sql_){
			
			$laboratorio_id=$this->input->post('laboratorio_id');
			$return_data['laboratorio_id'] = $laboratorio_id;
			
			
			
			
		}

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
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
				  $del_data = $this->db->where('laboratorio_id',$this->input->post('item_id',TRUE))->delete('laboratorios');
				  $return_data['message'] = "Eliminado";
		  break;
		  case "Activar":
				  $del_data = $this->db->where('laboratorio_id',$this->input->post('item_id'))->update('laboratorios',array("laboratorio_activo"=>"1"));
				  $return_data['message'] = "Activado";
		  break;
		  case "Desactivar":
				  $del_data = $this->db->where('laboratorio_id',$this->input->post('item_id'))->update('laboratorios',array("laboratorio_activo"=>"0"));
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

	public function getLaboratoriosActivos(){

		return $this->db->from('laboratorios')
		->select('*')
		->where('laboratorio_activo',1)
		->get()->result_array();
	
	}





		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
