<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pedidos_model extends CI_Model {

	public function __construct(){
        parent::__construct();
    }



    public function getItems(){

			$return_data= array();
			$return_data['items']= array();

			$this->db->select('p.*,pr.proveedor_id,pr.proveedor_nombre, pr.proveedor_nombrecomercial')
			->from('pedidos as p')
			->join('proveedores pr','pr.proveedor_id=p.proveedor_id')
			;

			if($this->session->logged_inExterno)
				$this->db->where('p.proveedor_id',$this->session->proveedor_id);

			prepararConsultaGenerica();

			$this->extraFilters();
			//$this->db->get();


    	$return_data['items'] = $this->db->get()->result_array();

			return $return_data;
    }
	public function extraFilters()
	{

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
					$del_data = $this->db->where($this->item_id,$this->input->post('item_id',TRUE))->update($this->tabla_principal,array("almacen_borrado"=>"1"));
	        break;
		    case "Marcar":
					$del_data = $this->db->where('pedido_id',$this->input->post('item_id'))->update('pedidos',array("pedido_realizado"=>"1"));
	        break;
		    case "Desactivar":
					$del_data = $this->db->where($this->item_id,$this->input->post('item_id'))->update($this->tabla_principal,array("almacen_active"=>"0"));
	        break;
			}


		  if($del_data){
		    $return_data['result'] 	= 1;
		    $return_data['message'] = substr($this->input->post('item_id_accion'), 0, -1) . "do"; // Transformamos Eliminar por Eliminado ... con todas las acciones igual
		  }
		  else {
		    $return_data['result'] 	= 0;
		    $return_data['message'] = "Error";
		  }
		  return $return_data;
	}

	public function getDetallePedido($pedido_id){
		return	$this->db->select('pp.pedido_id,pp.cod_nacional, pp.num_unidades, pp.num_obtener, p.producto_nombre, p.producto_descripcion, p.producto_pvp')
		->from('pedidos_productos as pp')
		->join('productos p','p.cod_nacional=pp.cod_nacional','left outer')
		->where('pp.pedido_id',$pedido_id)
		->get()->result_array();
	}
	public function getCondicionesPedido($pedido_id){
		return	$this->db->select('*')
		->from('pedidos_promociones as pp')		
		->where('pp.pedido_id',$pedido_id)
		->get()->result_array();
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
