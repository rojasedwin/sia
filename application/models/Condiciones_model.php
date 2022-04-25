<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Condiciones_model extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

	public function getItems(){

		$return_data = array();

		$this->db->from('condiciones c')
		->select('c.*,l.laboratorio_nombrecomercial')
		->join('laboratorios l','c.laboratorio_id=l.laboratorio_id','left outer')
		;

		prepararConsultaGenerica();

		$return_data['items'] = $this->db->get()->result_array();
		if(!empty($return_data['items'])){
			foreach($return_data['items'] as $index=>$fila){
				$return_data['items'][$index]['productos_asociados']=$this->getProductosAsociadosCondicion($fila['condicion_id']);		
				$return_data['items'][$index]['proveedores']=$this->getProveedoresCondicion($fila['condicion_id']);		
			}

		}
		
		return $return_data;
	}

	public function getProductosAsociadosCondicion($condicion_id){
		return $this->db->select('*')->from('condiciones_productos')
		->where('condicion_id',$condicion_id)->get()->num_rows();

	}
	
	public function getProveedoresCondicion($condicion_id){
		return $this->db->select('c.*,p.proveedor_nombre,p.proveedor_nombrecomercial')->from('condiciones_proveedor_multiple c')
		->where('c.condicion_id',$condicion_id)
		->join('proveedores p','p.proveedor_id=c.proveedor_id')
		->get()->result_array();

	}

	public function getFields(){
		$fields = $this->db->list_fields('condiciones');
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
			if(strpos($key,"condicion_")!==false) //Details POST
			{

				$ins_data[$key] = $this->input->post($key);
			}
		}
		unset($ins_data['condicion_id']);
		$ins_data['unidades_oferta']=$this->input->post('unidades_oferta');
		$ins_data['unidades_regalo_oferta']=$this->input->post('unidades_regalo_oferta');
		$ins_data['laboratorio_id']=$this->input->post('laboratorio_id');
		
		if($this->input->post('condicion_cantidad_minima')=="")
			$ins_data['condicion_cantidad_minima']=-1;
		if($this->input->post('condicion_cantidad_maxima')=="")
			$ins_data['condicion_cantidad_maxima']=-1;
		if($this->input->post('condicion_cantidad_minima_eur')=="")
			$ins_data['condicion_cantidad_minima_eur']=-1;
		if($this->input->post('condicion_cantidad_maxima_eur')=="")
			$ins_data['condicion_cantidad_maxima_eur']=-1;

		$sql_ = $this->db->insert('condiciones', $ins_data);

		if($sql_){
			
			$condicion_id=$this->db->insert_id();
			$return_data['condicion_id'] = $condicion_id;
			
			$proveedores=$this->input->post('proveedor_id[]');
			
			if(!empty($proveedores) ){
				foreach($proveedores as $p){
					$this->db->insert('condiciones_proveedor_multiple', array(
					'condicion_id'=>$condicion_id,
					'proveedor_id'=>$p
					));
			
				}
			}
			
			
			
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

		return $this->db->from('condiciones c')
		->select('c.*')
		->join('laboratorios l','c.laboratorio_id=l.laboratorio_id','left outer')
		->limit(1)
	->where('condicion_id', $id)->get()->row_array();
	}

	public function updateItem(){
		$return_data = array();
		$return_data['result'] = 1;
		$return_data['message'] = "";
		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if(strpos($key,"condicion_")!==false) //Details POST
			{

				$ins_data[$key] = $this->input->post($key);
			}
		}
	

		unset($ins_data['condicion_id']);
		$ins_data['unidades_oferta']=$this->input->post('unidades_oferta');
		$ins_data['unidades_regalo_oferta']=$this->input->post('unidades_regalo_oferta');
		$ins_data['laboratorio_id']=$this->input->post('laboratorio_id');
		if($this->input->post('condicion_cantidad_minima')=="")
			$ins_data['condicion_cantidad_minima']=-1;
		if($this->input->post('condicion_cantidad_maxima')=="")
			$ins_data['condicion_cantidad_maxima']=-1;
		if($this->input->post('condicion_cantidad_minima_eur')=="")
			$ins_data['condicion_cantidad_minima_eur']=-1;
		if($this->input->post('condicion_cantidad_maxima_eur')=="")
			$ins_data['condicion_cantidad_maxima_eur']=-1;
			
		
		$sql_ =  $this->db->where('condicion_id',$this->input->post('condicion_id'))->update('condiciones', $ins_data);


		if($sql_){
			
			$condicion_id=$this->input->post('condicion_id');
			$return_data['condicion_id'] = $condicion_id;
			
			$this->db->where('condicion_id',$this->input->post('condicion_id'))->delete('condiciones_proveedor_multiple');
			
			$proveedores=$this->input->post('proveedor_id[]');
			
			if(!empty($proveedores) ){
				foreach($proveedores as $p){
					$this->db->insert('condiciones_proveedor_multiple', array(
					'condicion_id'=>$condicion_id,
					'proveedor_id'=>$p
					));
			
				}
			}
			
				
			
			
			
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
				  $del_data = $this->db->where('condicion_id',$this->input->post('item_id',TRUE))->delete('condiciones_productos');
				  $return_data['message'] = "Eliminado";
		  break;
		  case "Activar":
				  $del_data = $this->db->where('condicion_id',$this->input->post('item_id'))->update('condiciones',array("condicion_activo"=>"1"));
				  $return_data['message'] = "Activado";
		  break;
		  case "Desactivar":
				  $del_data = $this->db->where('condicion_id',$this->input->post('item_id'))->update('condiciones',array("condicion_activo"=>"0"));
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

	  public function getMisCondiciones($condicion_id){

		return $this->db->from('condiciones_productos')
		->select('*')
		->where('condicion_id',$condicion_id)
		->get()->result_array();
		;
	
	}






		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
