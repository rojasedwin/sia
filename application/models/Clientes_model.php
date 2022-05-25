<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Clientes_model extends CI_Model {

	public function __construct(){
        parent::__construct();
	}

    public function getItem($id){

			return $this->db->from('clientes as c')
			->select('c.*')
			->limit(1)
    	->where('c.cliente_id', $id)->get()->row_array();
    }

	public function getFields(){
		$fields = $this->db->list_fields('clientes');
		$return_data = indexar_array_vacio($fields);
		return $return_data;
	}

	
	

	public function saveItem()
	{
		$return_data = array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "Cliente guardado";
		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if (strpos($key,"cliente_") !== false) {
				$ins_data[$key] = $this->input->post($key);
			}
		}

		$cliente_id = $this->input->post('cliente_id');

	
		$sql_blog = $this->db->insert('clientes', $ins_data);

		if($sql_blog)
		{
			//Devolver el id creado.
			$return_data['cliente_id'] = $this->db->insert_id();
			$return_data['cliente_id'] = $return_data['cliente_id'];

		}

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] 	= 0;
			$return_data['message'] = "Error guardando datos data";
		}
		return $return_data;
	}

	public function updateItem()
	{
		$return_data= array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "Cliente editado con éxito";

		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if (strpos($key,"cliente_") !== false) {
				$ins_data[$key] = $this->input->post($key);
			}
		}


		$cliente_id = $this->input->post('cliente_id');

		$sql_blog = $this->db->where('cliente_id',$this->input->post('cliente_id'))->update('clientes', $ins_data);


		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] = 0;
			$return_data['message'] = "Error guardando datos data";
		}
		return $return_data;
	}

    public function getItems(){

		$return_data= array();
		$return_data['items']= array();

		$this->db->select('*')
		->from('clientes')
		->where('cliente_borrado',0)
		->order_by('cliente_nombre Asc')
		
		;
		

    	$return_data['items'] = $this->db->get()->result_array();

			return $return_data;
	}

	

	public function delItem()
	{
		$return_data = array();
		$return_data['result']  = 1;
		$return_data['message'] = "";
		if($this->input->post('item_id',TRUE)==""){
		$return_data['result']  = 0;
		$return_data['message'] = "No encontrado";
		return $return_data;
		}
		$del_data = $this->db->where('cliente_id',$this->input->post('item_id',TRUE))->update('clientes',array("cliente_borrado"=>"1"));

		if($del_data){
		$return_data['result'] 	= 1;
		$return_data['message'] = "Eliminado";
		}
		else {
		$return_data['result'] 	= 0;
		$return_data['message'] = "Error";
		}
		return $return_data;
	}
	
	public function getNumClientes(){
		return $this->db->select('*')
		->from('clientes')->where('cliente_borrado',0)->get()->num_rows();
	}

	


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
