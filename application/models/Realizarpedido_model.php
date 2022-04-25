<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Realizarpedido_model extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

	public function getItems_paso_1(){

		return $this->db->from('excel_incrementales')
		->get()->result_array();
		;

	}

	public function getItems_paso_2(){

		return $this->db->from('stock_necesario_externo')
		->get()->result_array();
		;

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
				  $del_data = $this->db->where('nombre_excel',$this->input->post('item_id',TRUE))->delete('excel_incrementales');
				  $del_data = $this->db->where('nombre_excel',$this->input->post('item_id',TRUE))->delete('stock_necesario_incremental');
				  $return_data['message'] = "Eliminado";
		  break;
		  case "Eliminar Incrementales":
				  $del_data = $this->db->truncate('excel_incrementales');
				  $del_data = $this->db->truncate('stock_necesario_incremental');
				  $return_data['message'] = "Eliminado";
		  break;

		  case "Eliminar Almacén Externo":
				  $del_data = $this->db->truncate('stock_necesario_externo');
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

	public function getMisPasos1(){

		return $this->db->from('stock_necesario_incremental')
		->select('*')
		->get()->result_array();
		;

	}

	public function eliminarMisPasos2(){

		$this->db->truncate('stock_necesario_externo');

	}

	/*
	CONFIRMAR PEDIDO
	*/

	public function getStockExtra(){

		return $this->db->from('stock_extra')
		->select('*')
		->get()->result_array();
		;

	}

	public function saveLineasAddPedido(){
		$return_data = array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "";
		$this->db->trans_start();

		$items = json_decode($this->input->post('items'),true);
		$ins_items = array();
		$ins_items_traza = array();

		 $del_data = $this->db->truncate('stock_extra');

		if (!empty($items))
			$this->db->insert_batch('stock_extra', $items);

		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] 	= 0;
			$return_data['message'] = "Error guardando datos data";
		}
		return $return_data;
	}
	public function simularProductos()
	{
		$mis_cns = array();
		$necesarios = $this->db->from('stock_necesario_incremental s')
		->get()->result_array();
		$cont = 0;
		foreach($necesarios as $n)
		{
			if(!isset($mis_cns[ $n['cod_nacional'] ]))
			{
				$mis_cns[ $n['cod_nacional'] ]['cod_nacional'] = $n['cod_nacional'];
				$mis_cns[ $n['cod_nacional'] ]['producto_nombre'] = "Producto ".$cont;
				$mis_cns[ $n['cod_nacional'] ]['producto_pvp'] = rand(9,99);
				$cont++;
			}
		}
		$this->db->insert_batch('productos',$mis_cns);
	}
	public function obtenerProductosNecesarios()
	{
		$mis_cns = array();
		$necesarios = $this->db->from('stock_necesario_incremental s')
		->join('productos p','p.cod_nacional=s.cod_nacional')
		->where('s.num_unidades <',0)->get()->result_array();
		foreach($necesarios as $n)
		{
			if(!isset($mis_cns[ $n['cod_nacional'] ]))
			{
				$mis_cns[ $n['cod_nacional'] ]['unidades'] = 0;
				$mis_cns[ $n['cod_nacional'] ]['nombre'] = $n['producto_nombre'];
				$mis_cns[ $n['cod_nacional'] ]['pvp'] = $n['producto_pvp'];
			}
			$mis_cns[ $n['cod_nacional'] ]['unidades'] += $n['num_unidades']*-1;
		}

		$necesarios = $this->db->from('stock_necesario_externo s')
		->join('productos p','p.cod_nacional=s.cod_nacional')
		->get()->result_array();
		foreach($necesarios as $n)
		{
			if(!isset($mis_cns[ $n['cod_nacional'] ]))
			{
				$mis_cns[ $n['cod_nacional'] ]['unidades'] = 0;
				$mis_cns[ $n['cod_nacional'] ]['nombre'] = $n['producto_nombre'];
				$mis_cns[ $n['cod_nacional'] ]['pvp'] = $n['producto_pvp'];
			}
			$mis_cns[ $n['cod_nacional'] ]['unidades'] -= $n['num_unidades'];
		}
		$necesarios = $this->db->from('stock_extra s')
		->join('productos p','p.cod_nacional=s.cod_nacional')
		->get()->result_array();
		foreach($necesarios as $n)
		{
			if(!isset($mis_cns[ $n['cod_nacional'] ]))
			{
				$mis_cns[ $n['cod_nacional'] ]['unidades'] = 0;
				$mis_cns[ $n['cod_nacional'] ]['nombre'] = $n['producto_nombre'];
				$mis_cns[ $n['cod_nacional'] ]['pvp'] = $n['producto_pvp'];
			}
			$mis_cns[ $n['cod_nacional'] ]['unidades'] += $n['num_unidades'];
		}

		foreach($mis_cns as $cod_nacional=>$datos)
		{
			//Eliminamos de los que no necesitamos unidades.
			if($datos['unidades']<=0) unset($mis_cns[$cod_nacional]);
		}

		return $mis_cns;

	}

	public function getProveedores()
	{
		return indexar_array_por_campo(
			$this->db->select('proveedor_nombrecomercial,proveedor_id')->from('proveedores')->where('proveedor_activo',1)->order_by('proveedor_order ASC')->get()->result_array()
			,'proveedor_id'
		);
	}
	public function getCondiciones($cod_nacional,$proveedor_id)
	{
		$condiciones = indexar_array_por_campo(
			$this->db->select('c.*')->from('condiciones c')
		->join('condiciones_productos cp','c.condicion_id=cp.condicion_id')
		->join('condiciones_proveedor_multiple cpm','c.condicion_id=cpm.condicion_id')
		->where('cp.cod_nacional',$cod_nacional)
		->where('cpm.proveedor_id',$proveedor_id)->get()->result_array()
		,'condicion_id');
		return $condiciones;
	}
	public function checkUnidadesPedir($unidades,$condiciones)
	{
		if($condiciones['unidades_regalo_oferta']==0) return $unidades;

		$total_regalo = $condiciones['unidades_oferta']+$condiciones['unidades_regalo_oferta'];
		$paquetes = floor($unidades/$total_regalo);
		$resto = $unidades - $paquetes*$total_regalo;

		$total =  ($paquetes*$condiciones['unidades_oferta'] + $resto);
		return $total;
	}

	public function checkUnidadesObtener($unidades,$condiciones)
	{
		if($condiciones['unidades_regalo_oferta']==0) return $unidades;

		$total_regalo = $condiciones['unidades_oferta']+$condiciones['unidades_regalo_oferta'];
		$paquetes = floor($unidades/$condiciones['unidades_oferta']);
		$resto = $unidades - $paquetes*$condiciones['unidades_oferta'];

		$total =  ($paquetes*$total_regalo + $resto);
		return $total;
		//echo "Tengo ".$unidades." y ".$paquetes." y ".$resto." recibo ".$total;
	}
	public function calcularPedido()
	{
		//Obtenemos los productos que necesitamos.
		$cn_necesarios = $this->obtenerProductosNecesarios();

		//Obtenemos los proveedores disponibles.
		$proveedores = $this->getProveedores();

		$datos_pedido = array();

		$datos_pedido['cn_necesarios_original'] = $cn_necesarios;
		//Primera vuelta intentamos rellenar todo lo que podamos de pedido.
		foreach($cn_necesarios as $cod_nacional=>$pro)
		{
			foreach($proveedores as $prov_id=>$p)
			{
				if(	$cn_necesarios[ $cod_nacional ]['unidades']>0) //Todavía quedan unidades que asignar.
				{


				if(!isset($proveedores[$prov_id]['pedido']))
				{
					$proveedores[$prov_id]['pedido'] = array();
					$proveedores[$prov_id]['pedido']['productos'] = array();
					$proveedores[$prov_id]['pedido']['condiciones'] = array();
				} //Inicializamos el pedido

				//Check si el proveedor tiene condiciones sobre el producto.
				$condiciones = $this->getCondiciones($cod_nacional,$prov_id);
				if(!empty($condiciones))
				{
					//Iniciamos limite para este producto.
					$limite_uni = 999999999; $limite_uni_eur = 999999999;
					$uni_necesito = $cn_necesarios[ $cod_nacional ]['unidades'];
					$uni_pedir = $cn_necesarios[ $cod_nacional ]['unidades'];
					$obtendria = $uni_pedir;
					$cond_mas_beneficiosa = array();
					$cond_mas_beneficiosa['unidades_oferta'] = 0; $cond_mas_beneficiosa['unidades_regalo_oferta'] = 0;
					//Revisamos las condiciones unidades Max. y Unidades Min.
					foreach($condiciones as $condicion_id=>$datos_cond)
					{
						//Si no existe inicializamos
						if(!isset($proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]))
						{
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ] = array();
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['nombre'] = $datos_cond['condicion_nombre'];
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_oferta'] = $datos_cond['unidades_oferta'];
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_regalo_oferta'] = $datos_cond['unidades_regalo_oferta'];
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['condicion_cantidad_descuento'] = $datos_cond['condicion_cantidad_descuento'];
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['condicion_tipo_descuento'] = $datos_cond['condicion_tipo_descuento'];
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'] = 0;
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_obtener'] = 0;
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'] = 0;
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_min'] = 0;
							$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['eur_min'] = 0;

							if($datos_cond['condicion_cantidad_minima']>=0)
							{
								$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_min'] = $datos_cond['condicion_cantidad_minima'];
							}
							if($datos_cond['condicion_cantidad_minima_eur']>=0)
							{
								$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['eur_min'] = $datos_cond['condicion_cantidad_minima_eur'];
							}
						}
						$unidades_pedir_temp = $this->checkUnidadesPedir($uni_necesito,$datos_cond);
						$obtendria_tmp = $this->checkUnidadesObtener($unidades_pedir_temp,$datos_cond);

						if($uni_pedir>$unidades_pedir_temp or ($uni_pedir==$unidades_pedir_temp and $obtendria_tmp>$obtendria))
						{
							$uni_pedir = $unidades_pedir_temp;
							$obtendria = $obtendria_tmp;
							$cond_mas_beneficiosa['unidades_oferta'] = $datos_cond['unidades_oferta'];
							$cond_mas_beneficiosa['unidades_regalo_oferta'] = $datos_cond['unidades_regalo_oferta'];
						}

						$resto = 999999999; $resto_ud = 999999999;
						//Check si llegamos al máximo.
						if($datos_cond['condicion_cantidad_maxima']!=-1)
						{
							$resto = $datos_cond['condicion_cantidad_maxima'] - $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'];
						}

						if($datos_cond['condicion_cantidad_maxima_eur']!=-1)
						{
							$resto_eur = $datos_cond['condicion_cantidad_maxima_eur'] - $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'];
							$resto_ud = floor($resto_eur/$pro['pvp']);
						}
						if($resto>$resto_ud) $resto = $resto_ud;

						//Nos quedamos con el limite más bajo.
						if($limite_uni>$resto) $limite_uni = $resto;

					} //Bucle de condiciones

					//Perfecto. Necesito menos de las que puedo pedir
					if($uni_pedir<=$limite_uni)
					{
						$pedir = $uni_pedir;
					}
					else {
						$pedir = $limite_uni;
					}


					$obtendria = $this->checkUnidadesObtener($pedir,$cond_mas_beneficiosa);
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['pvp'] = $pro['pvp'];
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['nombre'] = $pro['nombre'];
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_pedir'] = $pedir;
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_obtener'] = $obtendria;
					$cn_necesarios[ $cod_nacional ]['unidades'] -= $obtendria;

					foreach($condiciones as $condicion_id=>$datos_cond)
					{
						$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'] += $pedir;
						$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_obtener'] += $obtendria;
						$proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'] += $pedir*$pro['pvp'];
					} //Segundo Bucle de condiciones



				}
				else {
					//No hay condiciones que cumplir. Le asignamos el total al proveedor.
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['pvp'] = $pro['pvp'];
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['nombre'] = $pro['nombre'];
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_pedir'] = $cn_necesarios[ $cod_nacional ]['unidades'];
					$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_obtener'] = $cn_necesarios[ $cod_nacional ]['unidades'];
					$cn_necesarios[ $cod_nacional ]['unidades'] = 0;
				}
			} //Todavia quedan unidades que asignar

		} //Para cada proveedor

		} //Para cada producto

		foreach($cn_necesarios as $cod_nacional=>$pro)
		{
			if(	$cn_necesarios[ $cod_nacional ]['unidades']<=0) //Ya estan cubiertos.
			{
					unset($cn_necesarios[ $cod_nacional ]);
			}
		}

		foreach($proveedores as $prov_id=>$datos_pro)
		{
			if(!isset($proveedores[$prov_id]['pedido'])) //No tiene pedido
			{
					unset($proveedores[$prov_id]);
			}
		}

		$datos_pedido['cn_necesarios'] = $cn_necesarios;


		$datos_pedido['proveedores'] = $proveedores;


		return $datos_pedido;
		//debug($cn_necesarios);
		//debug($proveedores);
	}

 public function calcularPedidoMinimo($pedido)
 {

	 //Obtenemos los productos que necesitamos.
	 $cn_necesarios = $pedido['cn_necesarios_original'];

	 //Trabajamos solo sobre los proveedores originales
	 $proveedores = array();
	 foreach($pedido['proveedores'] as $prov_id=>$datos_pro)
	 {
		 $proveedores[$prov_id] = $datos_pro;
		 //Iniciamos a 0
		 $proveedores[$prov_id]['pedido'] = array();
		 $proveedores[$prov_id]['pedido']['productos'] = array();
		 $proveedores[$prov_id]['pedido']['condiciones'] = array();
	 }

	 $datos_pedido = array();
	 $datos_pedido['cn_necesarios_original'] = $cn_necesarios;

	 //Primera vuelta intentamos rellenar todo lo que podamos de pedido.
	 foreach($cn_necesarios as $cod_nacional=>$pro)
	 {
		 foreach($proveedores as $prov_id=>$p)
		 {
			 if(	$cn_necesarios[ $cod_nacional ]['unidades']>0) //Todavía quedan unidades que asignar.
			 {


			 if(!isset($proveedores[$prov_id]['pedido']))
			 {
				 $proveedores[$prov_id]['pedido'] = array();
				 $proveedores[$prov_id]['pedido']['productos'] = array();
				 $proveedores[$prov_id]['pedido']['condiciones'] = array();
			 } //Inicializamos el pedido

			 //Check si el proveedor tiene condiciones sobre el producto.
			 $condiciones = $this->getCondiciones($cod_nacional,$prov_id);
			 if(!empty($condiciones))
			 {
				 //Iniciamos limite para este producto.
				 $limite_uni = 0; $limite_uni_eur = 0;
				 $uni_necesito = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $uni_pedir = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $obtendria = $uni_pedir;
				 $cond_mas_beneficiosa = array();
				 $cond_mas_beneficiosa['unidades_oferta'] = 0; $cond_mas_beneficiosa['unidades_regalo_oferta'] = 0;
				 //Revisamos las condiciones unidades Max. y Unidades Min.
				 foreach($condiciones as $condicion_id=>$datos_cond)
				 {
					 //Si no existe inicializamos
					 if(!isset($proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]))
					 {
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ] = array();
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['nombre'] = $datos_cond['condicion_nombre'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_oferta'] = $datos_cond['unidades_oferta'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_regalo_oferta'] = $datos_cond['unidades_regalo_oferta'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['condicion_cantidad_descuento'] = $datos_cond['condicion_cantidad_descuento'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['condicion_tipo_descuento'] = $datos_cond['condicion_tipo_descuento'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_obtener'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_min'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['eur_min'] = 0;

						 if($datos_cond['condicion_cantidad_minima']>=0)
						 {
							 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_min'] = $datos_cond['condicion_cantidad_minima'];
						 }
						 if($datos_cond['condicion_cantidad_minima_eur']>=0)
						 {
							 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['eur_min'] = $datos_cond['condicion_cantidad_minima_eur'];
						 }
					 }
					 $unidades_pedir_temp = $this->checkUnidadesPedir($uni_necesito,$datos_cond);
					 $obtendria_tmp = $this->checkUnidadesObtener($unidades_pedir_temp,$datos_cond);

					 if($uni_pedir>$unidades_pedir_temp or ($uni_pedir==$unidades_pedir_temp and $obtendria_tmp>$obtendria))
					 {
						 $uni_pedir = $unidades_pedir_temp;
						 $obtendria = $obtendria_tmp;
						 $cond_mas_beneficiosa['unidades_oferta'] = $datos_cond['unidades_oferta'];
						 $cond_mas_beneficiosa['unidades_regalo_oferta'] = $datos_cond['unidades_regalo_oferta'];
					 }

					 $resto = 0; $resto_ud = 0;

					 //Ahora comprobamos las mínimas para cumplir condicion. Sino. No pedimos en esta vuelta.
					 if($datos_cond['condicion_cantidad_minima']>=0)
					 {
						 $resto = $datos_cond['condicion_cantidad_minima'] - $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'];
					 }

					 if($datos_cond['condicion_cantidad_minima_eur']>=0)
					 {
						 $resto_eur = $datos_cond['condicion_cantidad_minima_eur'] - $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'];
						 $resto_ud = floor($resto_eur/$pro['pvp']);
					 }
					 //Aqui cambiamos, ahora tenemos que pedir como mínimo la más grande!.
					 if($resto<$resto_ud) $resto = $resto_ud;

					 //Nos quedamos con el limite más ALTO!!!!!.
					 if($limite_uni<$resto) $limite_uni = $resto;

				 } //Bucle de condiciones

				 //En limite_uni es las que debemos pedir como mínimo.
				 if($uni_pedir<=$limite_uni)
				 {
					 $pedir = $uni_pedir;
				 }
				 else {
					 $pedir = $limite_uni;
				 }


				 $obtendria = $this->checkUnidadesObtener($pedir,$cond_mas_beneficiosa);
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['pvp'] = $pro['pvp'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['nombre'] = $pro['nombre'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_pedir'] = $pedir;
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_obtener'] = $obtendria;
				 $cn_necesarios[ $cod_nacional ]['unidades'] -= $obtendria;

				 foreach($condiciones as $condicion_id=>$datos_cond)
				 {
					 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'] += $pedir;
					 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_obtener'] += $obtendria;
					 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'] += $pedir*$pro['pvp'];
				 } //Segundo Bucle de condiciones



			 }
			 else {
				 //No hay condiciones que cumplir. EN ESTA VUELTA NO ASIGNAMOS
				 /*$proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['pvp'] = $pro['pvp'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['nombre'] = $pro['nombre'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_pedir'] = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_obtener'] = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $cn_necesarios[ $cod_nacional ]['unidades'] = 0;
				 */
			 }
		 } //Todavia quedan unidades que asignar

	 } //Para cada proveedor

	 } //Para cada producto

	 foreach($cn_necesarios as $cod_nacional=>$pro)
	 {
		 if(	$cn_necesarios[ $cod_nacional ]['unidades']<=0) //Ya estan cubiertos.
		 {
				 unset($cn_necesarios[ $cod_nacional ]);
		 }
	 }

	 /*******************************************************

	 Ahora damos segunda vuelta COMPLETANDO
	 AL MAXIMO CON LAS RESTANTES.

	 ******************************************************************/


	 foreach($cn_necesarios as $cod_nacional=>$pro)
	 {
		 foreach($proveedores as $prov_id=>$p)
		 {
			 if(	$cn_necesarios[ $cod_nacional ]['unidades']>0) //Todavía quedan unidades que asignar.
			 {

			 if(!isset($proveedores[$prov_id]['pedido']))
			 {
				 $proveedores[$prov_id]['pedido'] = array();
				 $proveedores[$prov_id]['pedido']['productos'] = array();
				 $proveedores[$prov_id]['pedido']['condiciones'] = array();
			 } //Inicializamos el pedido

			 //Check si el proveedor tiene condiciones sobre el producto.
			 $condiciones = $this->getCondiciones($cod_nacional,$prov_id);
			 if(!empty($condiciones))
			 {
				 //Iniciamos limite para este producto.
				 $limite_uni = 999999999; $limite_uni_eur = 999999999;
				 $uni_necesito = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $uni_pedir = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $obtendria = $uni_pedir;
				 $cond_mas_beneficiosa = array();
				 $cond_mas_beneficiosa['unidades_oferta'] = 0; $cond_mas_beneficiosa['unidades_regalo_oferta'] = 0;
				 //Revisamos las condiciones unidades Max. y Unidades Min.
				 foreach($condiciones as $condicion_id=>$datos_cond)
				 {
					 //Si no existe inicializamos
					 if(!isset($proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]))
					 {
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ] = array();
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['nombre'] = $datos_cond['condicion_nombre'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_oferta'] = $datos_cond['unidades_oferta'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_regalo_oferta'] = $datos_cond['unidades_regalo_oferta'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['condicion_cantidad_descuento'] = $datos_cond['condicion_cantidad_descuento'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['condicion_tipo_descuento'] = $datos_cond['condicion_tipo_descuento'];
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_obtener'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_min'] = 0;
						 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['eur_min'] = 0;

						 if($datos_cond['condicion_cantidad_minima']>=0)
						 {
							 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_min'] = $datos_cond['condicion_cantidad_minima'];
						 }
						 if($datos_cond['condicion_cantidad_minima_eur']>=0)
						 {
							 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['eur_min'] = $datos_cond['condicion_cantidad_minima_eur'];
						 }
					 }
					 $unidades_pedir_temp = $this->checkUnidadesPedir($uni_necesito,$datos_cond);
					 $obtendria_tmp = $this->checkUnidadesObtener($unidades_pedir_temp,$datos_cond);

					 if($uni_pedir>$unidades_pedir_temp or ($uni_pedir==$unidades_pedir_temp and $obtendria_tmp>$obtendria))
					 {
						 $uni_pedir = $unidades_pedir_temp;
						 $obtendria = $obtendria_tmp;
						 $cond_mas_beneficiosa['unidades_oferta'] = $datos_cond['unidades_oferta'];
						 $cond_mas_beneficiosa['unidades_regalo_oferta'] = $datos_cond['unidades_regalo_oferta'];
					 }

					 $resto = 999999999; $resto_ud = 999999999;
					 //Check si llegamos al máximo.
					 if($datos_cond['condicion_cantidad_maxima']!=-1)
					 {
						 $resto = $datos_cond['condicion_cantidad_maxima'] - $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'];
					 }

					 if($datos_cond['condicion_cantidad_maxima_eur']!=-1)
					 {
						 $resto_eur = $datos_cond['condicion_cantidad_maxima_eur'] - $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'];
						 $resto_ud = floor($resto_eur/$pro['pvp']);
					 }
					 if($resto>$resto_ud) $resto = $resto_ud;

					 //Nos quedamos con el limite más bajo.
					 if($limite_uni>$resto) $limite_uni = $resto;

				 } //Bucle de condiciones

				 //Perfecto. Necesito menos de las que puedo pedir
				 if($uni_pedir<=$limite_uni)
				 {
					 $pedir = $uni_pedir;
				 }
				 else {
					 $pedir = $limite_uni;
				 }


				 $obtendria = $this->checkUnidadesObtener($pedir,$cond_mas_beneficiosa);
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['pvp'] = $pro['pvp'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['nombre'] = $pro['nombre'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_pedir'] = $pedir;
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_obtener'] = $obtendria;
				 $cn_necesarios[ $cod_nacional ]['unidades'] -= $obtendria;

				 foreach($condiciones as $condicion_id=>$datos_cond)
				 {
					 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_pedir'] += $pedir;
					 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['unidades_obtener'] += $obtendria;
					 $proveedores[$prov_id]['pedido']['condiciones'][ $condicion_id ]['importe'] += $pedir*$pro['pvp'];
				 } //Segundo Bucle de condiciones



			 }
			 else {
				 //No hay condiciones que cumplir. Le asignamos el total al proveedor.
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['pvp'] = $pro['pvp'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['nombre'] = $pro['nombre'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_pedir'] = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $proveedores[$prov_id]['pedido']['productos'][ $cod_nacional ]['unidades_obtener'] = $cn_necesarios[ $cod_nacional ]['unidades'];
				 $cn_necesarios[ $cod_nacional ]['unidades'] = 0;
			 }
		 } //Todavia quedan unidades que asignar

	 } //Para cada proveedor

	 } //Para cada producto

	 foreach($cn_necesarios as $cod_nacional=>$pro)
	 {
	 	if(	$cn_necesarios[ $cod_nacional ]['unidades']<=0) //Ya estan cubiertos.
	 	{
	 			unset($cn_necesarios[ $cod_nacional ]);
	 	}
	 }


	 $datos_pedido['cn_necesarios'] = $cn_necesarios;


	 $datos_pedido['proveedores'] = $proveedores;





	 return $datos_pedido;


 }

public function cargarPedidoTmp($pedido)
{
	$this->db->truncate('pedidostmp_productos');
	$this->db->truncate('pedidostmp_promociones');
	if(isset($pedido['proveedores']) and !empty($pedido['proveedores']))
	{

		foreach($pedido['proveedores'] as $prov_id=>$datos_prov)
		{
			$insert_products = array();
			$insert_promos = array();
			if(!empty($datos_prov['pedido']['productos']))
			{
				foreach($datos_prov['pedido']['productos'] as $cod_nacional=>$datos_ped)
				{
					if($datos_ped['unidades_pedir']!=0)
					{
						$tmp = array();
						$tmp['proveedor_id'] = $prov_id;
						$tmp['cod_nacional'] = $cod_nacional;
						$tmp['num_unidades'] = $datos_ped['unidades_pedir'];
						$tmp['num_obtener'] = $datos_ped['unidades_obtener'];
						array_push($insert_products,$tmp);
					}
				}

				$this->db->insert_batch('pedidostmp_productos',$insert_products);
			}//Hay Productos

			if(!empty($datos_prov['pedido']['condiciones']))
			{
				foreach($datos_prov['pedido']['condiciones'] as $condicion_id=>$datos_cond)
				{
					$texto_cond = "";
					if($datos_cond['condicion_cantidad_descuento']!=0)
					{
						if($datos_cond['condicion_tipo_descuento']==0) $texto_cond = "Descuento ".$datos_cond['condicion_cantidad_descuento']."%";
						if($datos_cond['condicion_tipo_descuento']==1) $texto_cond = "Descuento ".$datos_cond['condicion_cantidad_descuento']."€";
						$texto_cond .= "<br>";
					}
					if($datos_cond['unidades_regalo_oferta']!=0)
					{
						$texto_cond .= "Promoción por cada ".$datos_cond['unidades_oferta']." de regalo ".$datos_cond['unidades_regalo_oferta'];
					}

					$tmp = array();
					$tmp['proveedor_id'] = $prov_id;
					$tmp['nombre_promo'] = $datos_cond['nombre'];
					$tmp['beneficios'] = $texto_cond;
					array_push($insert_promos,$tmp);

				}
					$this->db->insert_batch('pedidostmp_promociones',$insert_promos);
			} //Hay promociones.

		}
	}

} //cargarPeditoTmp


public function finalizarPedido()
{
	$return_data = array();
	$return_data['result'] 	= 1;
	$return_data['message'] = "";
	$this->db->trans_start();

	//Copiamos todas las tablas temporales a pedidos.
	$lineas = $this->db->from('pedidostmp_productos')->get()->result_array();
	$idprov = 0; $pedido_id = 0;
	$insert_products = array();
	$insert_promos = array();
	foreach($lineas as $l)
	{
		if($idprov!=$l['proveedor_id'])
		{
			if(!empty($insert_products))
			{
				$this->db->insert_batch('pedidos_productos',$insert_products);
			}
			$insert_products = array();

			$new_pedido = array();
			$new_pedido['proveedor_id'] = $l['proveedor_id'];
			$this->db->insert('pedidos',$new_pedido);
			$pedido_id = $this->db->insert_id();
			$idprov = $l['proveedor_id'];

			//Calculamos todas sus promociones
			$promociones = $this->db->where('proveedor_id',$idprov)->from('pedidostmp_promociones')
			->get()->result_array();
			$insert_promos = array();
			foreach($promociones as $p)
			{
				$tmp = $p;
				unset($tmp['pedidopromotmp_id']);
				unset($tmp['proveedor_id']);
				$tmp['pedido_id'] = $pedido_id;
				array_push($insert_promos,$tmp);
			}
			if(!empty($insert_promos))
			{
				$this->db->insert_batch('pedidos_promociones',$insert_promos);
			}

		}

		$tmp = array();
		$tmp['pedido_id'] = $pedido_id;
		$tmp['cod_nacional'] = $l['cod_nacional'];
		$tmp['num_unidades'] = $l['num_unidades'];
		$tmp['num_obtener'] = $l['num_obtener'];
		array_push($insert_products,$tmp);


	}

	if(!empty($insert_products))
	{
		$this->db->insert_batch('pedidos_productos',$insert_products);
	}


	$this->db->truncate('pedidostmp_productos');
	$this->db->truncate('pedidostmp_promociones');

	$this->db->trans_complete();
	if($this->db->trans_status() === FALSE)
	{
		$return_data['result'] 	= 0;
		$return_data['message'] = "Error guardando datos data";
	}
	return $return_data;
}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
