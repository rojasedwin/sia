<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Usuarios_model extends CI_Model {

	public function __construct(){
        parent::__construct();
	}

    public function getItem($id){

			return $this->db->from('users as s')
			->select('s.*')
			->limit(1)
    	->where('s.user_id', $id)->get()->row_array();
    }

	public function getFields(){
		$fields = $this->db->list_fields('users');
		$return_data = indexar_array_vacio($fields);
		return $return_data;
	}

	
	

	public function saveItem()
	{
		$return_data = array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "Usuario guardado";
		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if (strpos($key,"user_") !== false) {
				$ins_data[$key] = $this->input->post($key);
			}
		}

		$user_id = $this->input->post('user_id');
		$ins_data['user_pwd'] = password_hash($this->input->post('pass'),PASSWORD_DEFAULT);
	
		$ins_data['user_active'] = 1;
		$ins_data['user_type'] = 1;
	
		$sql_blog = $this->db->insert('users', $ins_data);

		if($sql_blog)
		{
			//Devolver el id creado.
			$return_data['user_id'] = $this->db->insert_id();
			$return_data['user_id'] = $return_data['user_id'];

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
		$return_data 						= array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "Usuario editado con éxito";

		$this->db->trans_start();

		$ins_data = array();
		foreach($_POST as $key=>$datos_post)
		{
			if (strpos($key,"user_") !== false) {
				$ins_data[$key] = $this->input->post($key);
			}
		}

		if ($this->input->post('pass') != "")
		{
			$ins_data['user_pwd'] = password_hash($this->input->post('pass'),PASSWORD_DEFAULT);
			$ins_data['user_selectorvalidator'] = "";
			$ins_data['user_hashedvalidator'] = "";
		}

		$user_id = $this->input->post('user_id');

		$sql_blog = $this->db->where('user_id',$this->input->post('user_id'))->update('users', $ins_data);


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

		$this->db->select('u.*')
		->from('users as u')
		->where('u.user_id !=',1)
		->where('u.user_borrado',0)
		->order_by('u.user_name Asc')
		
		;
		

    	$return_data['items'] = $this->db->get()->result_array();

			return $return_data;
	}

	public function extraFilters()
	{
		//Datos Registro
		if ($this->input->post('search_fecha_ini_registro') != "") {
			$this->db->where('date(u.user_create_time) >=',cambiar_formato($this->input->post('search_fecha_ini_registro')));
		}

		if ($this->input->post('search_fecha_fin_registro') != "") {
			$this->db->where('date(u.user_create_time) <=',cambiar_formato($this->input->post('search_fecha_fin_registro')));
		}

		//Datos Personales

		if($this->input->post('search_nombre') != "") {
				$this->db->like("CONCAT_WS(' ',u.user_name,u.user_lastname)",$this->input->post('search_nombre'));
		}

		if ($this->input->post('search_fecha_ini_nacimiento') != "") {
			$this->db->where('u.user_fecha_nacimiento >=',cambiar_formato($this->input->post('search_fecha_ini_nacimiento')));
		}

		if ($this->input->post('search_fecha_fin_nacimiento') != "") {
			$this->db->where('u.user_fecha_nacimiento <=',cambiar_formato($this->input->post('search_fecha_fin_nacimiento')));
		}




	}

	public function getUsuariosExcel($pagina = 1, $mostrar = 50)
	{
		$return_data = array();

		$return_data['items'] = array();
		$init = ($pagina-1)*$mostrar;
		$return_data['item_per_page'] = $mostrar;

		$this->db->from('users as u')
		->join('provincias as p','u.user_id_provincia = p.id_provincia','left outer')
		->select('u.*, p.id_provincia, p.provincia')
		->where('u.user_id !=',1)->where('u.user_type',2)
		->order_by('u.user_id', 'DESC');

		prepararConsultaGenerica();
			$this->extraFilters();

		$this->db->limit($mostrar,$init);
		$return_data['items'] = $this->db->get()->result_array();

		return $return_data;
	}


	public function activarItem()
	{
		$return_data 						= array();
		$return_data['result']  = 1;
		$return_data['message'] = "";

		if($this->input->post('item_id')==""){
			$return_data['result']  = 0;
			$return_data['message'] = "No encontrado";
			return $return_data;
		}

		$del_data = $this->db->where($this->item_id,$this->input->post('item_id'))->update($this->tabla_principal,array("user_active"=>"1"));

		if($del_data){
			$return_data['result']  = 1;
			$return_data['message'] = "Activado";
		}
		else {
			$return_data['result']  = 0;
			$return_data['message'] = "Error";
		}

		return $return_data;
	}
	public function desactivarItem()
	{
		$return_data 						= array();
		$return_data['result']  = 1;
		$return_data['message'] = "";

		if($this->input->post('item_id')==""){
			$return_data['result']  = 0;
			$return_data['message'] = "No encontrado";
			return $return_data;
		}

		$del_data = $this->db->where($this->item_id,$this->input->post('item_id'))->update($this->tabla_principal,array("user_active"=>"0"));

		if($del_data){
			$return_data['result']  = 1;
			$return_data['message'] = "Desactivado";
		}
		else {
			$return_data['result']  = 0;
			$return_data['message'] = "Error";
		}

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
		$del_data = $this->db->where('user_id',$this->input->post('item_id',TRUE))->update('users',array("user_borrado"=>"1"));

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

	public function getProvincias(){
		$this->db->select('p.*')->from('provincias as p')->order_by('provincia ASC');
		return $this->db->get()->result_array();
	}

	public function getUsuarios(){
		$this->db->select('*')->from('users')->order_by('user_id ASC');
		return $this->db->get()->result_array();
	}

	/*
	FRONT INICIO REGISTRO E INSCRIPCION
	*/
	public function getExisteEmail($user_email){
        $this->db->select('user_email')
          ->from("users")
          ->limit(1)
          ->where('user_email', $user_email);
        $sel_item = $this->db->get();
        if ($sel_item->num_rows()=="0") {
            return 0;
        } else {
            return 1;
        }
    }

	public function getExisteDNI($user_dni){
        $this->db->select('user_dni')
          ->from("users")
          ->limit(1)
          ->where('user_dni', $user_dni);
        $sel_item = $this->db->get();
        if ($sel_item->num_rows()=="0") {
            return 0;
        } else {
            return 1;
        }
    }

	/*
	FRONT FIN REGISTRO E INSCRIPCION
	*/


	/*
	IMPORTAR USUARIOS
	*/
	public function verificaProvinciaId($nombreprovincia){


		$this->db->select('*')
		->from('provincias p')
		->like('provincia',$nombreprovincia)
		->limit(1);

		$sel_item=$this->db->get();

		if($sel_item->num_rows()==0){
			return 0;
		}else{
			$data = $sel_item->row_array();

			return $data['id_provincia'];
		}

	}

	public function saveUsersImport($datos){

		  $return_data= array();

		$this->db->trans_start();



		$each=200;//el nro de elementos a tomar del array
		$num = count($datos);        //  Datos totales

		$step = ceil( $num/$each);  //  El número total de ejecuciones de inserciones

		$j = 1;

		$s = $step;


		//USERS
		if(count($datos)>0){

			foreach($datos as $i){
				 if($j > $step) break;
				  $arr2 = array_slice($datos, ($step - $s) * $each, $each);     //  Toma 500 cada vez

					$sql_data = $this->db->insert_batch('users', $arr2);

			$j++;
			 $s--;
			}


		}else{
			$return_data['result'] = -2;
				$return_data['message'] = "No existen usuarios a importar.";
				return $return_data;exit;

		}



		  $this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] = 0;
				$return_data['message'] = "Error guardando datos data";
			}else{
				$return_data['result'] = 1;
				$return_data['message'] = "Usuarios Importados";

			}
			//debug($ins_tabla);exit;
			return $return_data;
	}

	public function getItemsMonedero($id){

		return
		$this->db->select('s.*,u.*,concat_ws(" ",useradd.user_name,useradd.user_lastname) as add_by')
			->from('users_monedero as s')
			->join('users as u','u.user_id=s.user_id')
			->join('users as useradd','useradd.user_id=s.monedero_add_by','left outer')
			->where('s.user_id',$id)
			->order_by('s.monedero_created_time','DESC')
			->get()->result_array()
			;

    }

	public function updateItemMonedero(){
			$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "Datos Guardados";
			$this->db->trans_start();

			$sql_blog = $this->db->where('user_id',$this->input->post('user_id'))->update('users', array('user_monedero'=>$this->input->post('cantidad')));
			$return_data['cantidad']=$this->input->post('cantidad');
			if($sql_blog)
			{


				if($this->input->post('cantidad')!="" and $this->input->post('cantidad')>=0){
					$cantidadindicada=$this->input->post('cantidad')-$this->input->post('aux_user_monedero');

					//Insert into historico
					$ins_historico=array();
					//$ins_historico['user_id']=$stock_id;
					$ins_historico['user_id']=$this->input->post('user_id');
					$ins_historico['monedero_add_by']=$this->session->user_id;
					$ins_historico['cantidad']=$cantidadindicada;
					$ins_historico['concepto']=$this->input->post('concepto');

					$sql_historico = $this->db->insert('users_monedero', $ins_historico);
					//Devolver el id creado.
					$monedero_id = $this->db->insert_id();
					$return_data['monedero_id'] = $monedero_id;

					$monedero_user_cantidad = $this->input->post('cantidad');
					$return_data['monedero_user_cantidad'] = $monedero_user_cantidad;
				}

			}

			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;
	}

	public function getItemsRecomendados($id){

		return
		$this->db->select('*')
			->from('users_recomendaciones as s')
			->join('users as u','u.user_id=s.user_id')
			->where('s.user_id',$id)
			->order_by('s.recomendacion_created_time','Desc')
			->get()->result_array()
			;

    }

	public function getItemsDirecciones($id){

		return
		$this->db->select('*')
			->from('users_addresses as s')
			->join('users as u','u.user_id=s.user_id')
			->join('paises as p','p.pais_id=s.address_pais_id','left outer')
			->join('provincias as pr','pr.id_provincia=s.address_idprovincia','left outer')
			->where('s.user_id',$id)
			->where('s.address_deleted',0)
			->order_by('s.address_created_time','Desc')
			->get()->result_array()
			;

    }

	public function getPaises(){
			$this->db->select('*')
			->from('paises')
			->order_by('pais_name ASC');

			$resultado = $this->db->get()->result_array();

			return $resultado;
	}

	public function getFieldsAddress(){
			$fields 		 = $this->db->list_fields('users_addresses');
			$return_data = indexar_array_vacio($fields);
			return $return_data;
    }

	public function getAddress($user_address_id){

		$this->db->select('*')
			->from('users_addresses')
			 ->where('address_id',$user_address_id);

			$resultado = $this->db->get()->row_array();

			return $resultado;
	}

	public function saveAddress(){
			$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$this->db->trans_start();

			$ins_data = array();
			foreach($_POST as $key=>$datos_post){
				$ins_data[$key] = $datos_post;
			}



			unset($ins_data['address_id']);
			unset($ins_data['direccion_default']);
			unset($ins_data['direccion_seleccionada']);
			unset($ins_data['mi_direccion_seleccionada']);
			unset($ins_data['id_provincia']);
			unset($ins_data['tipo_envio']);
			$ins_data['address_idprovincia']=$this->input->post('address_idprovincia');
			unset($ins_data['id_tipo_via']);
			if($this->input->post('mi_direccion_seleccionada')==1){
				$ins_data['address_default']=1;
				$ins_data['address_billing']=0;

			}
			elseif($this->input->post('mi_direccion_seleccionada')==0){
				$ins_data['address_default']=0;
				$ins_data['address_billing']=0;

			}
			elseif($this->input->post('mi_direccion_seleccionada')==2){
				$ins_data['address_default']=0;
				$ins_data['address_billing']=1;

			}
			elseif($this->input->post('mi_direccion_seleccionada')==3){
				$ins_data['address_default']=1;
				$ins_data['address_billing']=1;

			}
			$ins_data['address_pais_id']=6;

			$sql_ins = $this->db->insert('users_addresses', $ins_data);

			$address_id = $this->db->insert_id();
			$return_data['address_id'] = $address_id;



			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;
	}

	public function updateAddress(){
			$return_data 							 = array();
			$return_data['result'] 		 = 1;
			$return_data['message'] 	 = "";

			$this->db->trans_start();

			$ins_data = array();
			foreach($_POST as $key=>$datos_post){
				$ins_data[$key] = $datos_post;
			}

			unset($ins_data['address_id']);

			unset($ins_data['direccion_default']);
			unset($ins_data['direccion_seleccionada']);
			unset($ins_data['mi_direccion_seleccionada']);
			unset($ins_data['id_provincia']);
			$ins_data['address_idprovincia']=$this->input->post('id_provincia');
			unset($ins_data['id_tipo_via']);
			$ins_data['address_tipo_via']=$this->input->post('id_tipo_via');

			if($this->input->post('mi_direccion_seleccionada')==1){
				$ins_data['address_default']=1;
				$ins_data['address_billing']=0;

			}elseif($this->input->post('mi_direccion_seleccionada')==2){
				$ins_data['address_default']=0;
				$ins_data['address_billing']=1;

			}
			elseif($this->input->post('mi_direccion_seleccionada')==0){
				$ins_data['address_default']=0;
				$ins_data['address_billing']=0;

			}
			elseif($this->input->post('mi_direccion_seleccionada')==3){
				$ins_data['address_default']=1;
				$ins_data['address_billing']=1;

			}


			$this->db->where('address_id',$this->input->post('address_id'))
				->update('users_addresses', $ins_data);

			$address_id = $this->input->post('address_id');
			$return_data['address_id'] = $address_id;

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
			$del_data								= false;
		  if($this->input->post('item_id',TRUE)==""){
		    $return_data['result']  = 0;
		    $return_data['message'] = "No encontrado";
		    return $return_data;
		  }

			// Dependiendo de la acción a realizar se hace una acción distinta sobre la BD
			switch ($this->input->post('item_id_accion')) {
		    case "Eliminar Dirección": // Se hace la acción de eliminar, ya sea con un delete o con un update
					$del_data = $this->db->where('address_id',$this->input->post('item_id',TRUE))->update('users_addresses',array('address_deleted'=>1));

	        break;


			}


		  if($del_data){
		    $return_data['result'] 	= 1;
				if(strpos($this->input->post('item_id_accion'),'Principal')){
	    		$return_data['message'] = substr($this->input->post('item_id_accion'), 0, -22) . "do"; // Transformamos Activar Dirección Facturación por Activado ... con todas las acciones igual
				}
				else{
					if(strpos($this->input->post('item_id_accion'),'Factura')){
		    		$return_data['message'] = substr($this->input->post('item_id_accion'), 0, -25) . "do"; // Transformamos Activar Dirección Facturación por Activado ... con todas las acciones igual
					}
					else{
						if(strpos($this->input->post('item_id_accion'),'Direcci'))
			    		$return_data['message'] = substr($this->input->post('item_id_accion'), 0, -12) . "do"; // Transformamos Eliminar Dirección por Eliminado ... con todas las acciones igual
						else {
			    		$return_data['message'] = substr($this->input->post('item_id_accion'), 0, -1) . "do"; // Transformamos Eliminar por Eliminado ... con todas las acciones igual
						}
					}
				}
		  }
		  else {
		    $return_data['result'] 	= 0;
		    $return_data['message'] = "Error";
		  }

		  return $return_data;
	}

	public function saveUserExterno(){
		$return_data = array();
		$return_data['result'] 	= 1;
		$return_data['message'] = "El usuario se ha creado correctamente";
		$this->db->trans_start();

		$ins_data = array();


		$ins_data['user_email'] = $this->input->post('email');
		$ins_data['user_name'] = $this->input->post('nombre');
		$ins_data['user_pwd'] = password_hash($this->input->post('pass'),PASSWORD_DEFAULT);
		$ins_data['user_active'] = 1;
		$ins_data['user_type'] = 2;

		$existeEmail=$this->existeEmail($this->input->post('email'));

		if($existeEmail>0){
			$return_data['result'] 	= -1;
			$return_data['message'] = "Email ya esta registrado";

		}else{

			//Si existia el email como invitado, lo quitamos y le actualizamos contraseña.
			$invitado = $this->db->where('user_email',$ins_data['user_email'])->where('user_invited',1)
			->from('users')->limit(1)->get()->row_array();
			if(isset($invitado['user_id']))
			{
				$ins_data['user_invited'] = 0;
				$sql = $this->db->where('user_id',$invitado['user_id'])
				->update('users',$ins_data);
			}
			else
				$sql = $this->db->insert('users', $ins_data);
				$return_data['user_id'] = $this->db->insert_id();
		}


		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$return_data['result'] 	= 0;
			$return_data['message'] = "Error guardando datos data";
		}

		return $return_data;
	}

	public function existeEmail($email){
		return $this->db->select('*')->from('users')
		->where('user_email',$email)
		->where('user_invited',0)
		->get()->num_rows();

	}

	public function deleteAddress(){
		  $return_data= array();
		  $return_data['result']  = 1;
		  $return_data['message'] = "Eliminado";
			$del_data= false;


		$del_data = $this->db->where('address_id',$this->input->post('address_id',TRUE))->update('users_addresses',array('address_deleted'=>1));

		return $return_data;
	}

	public function saveDatosUserFront(){
			$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$this->db->trans_start();

			$ins_data = array();
			foreach($_POST as $key=>$datos_post){
				$ins_data[$key] = $datos_post;
			}



			unset($ins_data['user_id']);
			unset($ins_data['original_user_email']);

			$this->db->where('user_id',$this->input->post('user_id'))
				->update('users', $ins_data);

			$return_data['user_id'] = $this->input->post('user_id');



			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;
	}

	public function getAuthenticateUser($password,$user_id){

		$return_data = array();
		$return_data['result'] = "1";
		$return_data['message'] = "";

		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$sel_user = $this->db->get('users');
		if($sel_user->num_rows()=='1'){
			//Get user_id.
			$user_id = $sel_user->row_array();

			if(!password_verify($password,$user_id['user_pwd']))
			{
				$return_data['result'] = "-1";
				$return_data['message'] = "Contraseña actual es incorrecta";
			}
		}

		return $return_data;

	}

	public function saveContraUserFront(){
			$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$this->db->trans_start();

			$ins_data = array();
			$ins_data['user_pwd'] = password_hash($this->input->post('nueva_contrasena'),PASSWORD_DEFAULT);

			$this->db->where('user_id',$this->input->post('user_id'))
				->update('users', $ins_data);

			$return_data['user_id'] = $this->input->post('user_id');



			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;
	}

	public function getExisteEmailAmigo($email){
		return $this->db->select('*')->from('users_recomendaciones')
		->where('recomendacion_email',$email)
		->get()->num_rows();

	}

	public function saveDatosRecomendacionFront(){

		$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$this->db->trans_start();

			$ins_data = array();
			$ins_data['user_id'] = $this->session->user_id;
			$ins_data['recomendacion_email'] = $this->input->post('email_amigo');

			 $this->db->insert('users_recomendaciones', $ins_data);


			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;

	}

	public function saveOpinionProducto(){

		$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$return_data['opinion_id'] = 0;
			$this->db->trans_start();

			$ins_data = array();
			$ins_data['user_id'] = $this->session->user_id;
			$ins_data['opinion_objetc_id'] = $this->input->post('product_id');
			$ins_data['order_line_id'] = $this->input->post('order_line_id');
			$ins_data['opinion_resumen'] = $this->input->post('opinion_resumen');
			$ins_data['opinion_descripcion'] = $this->input->post('opinion_descripcion');
			$ins_data['opinion_puntuacion'] = $this->input->post('opinion_puntuacion');


			 $sql=$this->db->insert('users_opiniones', $ins_data);
			 $return_data['opinion_id'] = $this->db->insert_id();
			 //echo last_query();exit;
			 if($sql){
				 $this->db->where('order_line_id',$this->input->post('order_line_id'))->update('orders_lines',array("order_line_commented"=>1));

			 }


			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;

	}

	public function setSeedRecover($email){
			//Initialize return values
			$return_data = array();
			$return_data['data'] = "";
			$return_data['result'] = "1";

				//Configure query
				$this->db->select('*')
				->from('users as s')
				->where('s.user_email', $email)->where('s.user_type',2);
				$sel_item = $this->db->get();
				//Prepare output
				$return_data['num_rows'] = $sel_item->num_rows();

				if($sel_item->num_rows()=="0"){
					$return_data['result'] = 0;
				}
				else{
					$usuario = $sel_item->row_array();
					//Insertamos la nueva semilla.
					$datos_upd = array();
					$datos_upd['user_pwd_seed'] = substr(md5(rand(0,99999)),0,75);
					$datos_upd['user_pwd_seed_time'] = date("Y-m-d H:i:s");
					$this->db->where('user_id',$usuario['user_id']);
					$this->db->update("users",$datos_upd);
					$return_data['user_id'] = $usuario['user_id'];
					$return_data['email'] = $usuario['user_email'];
					$return_data['user_pwd_seed'] = $datos_upd['user_pwd_seed'];
				}


			return $return_data;
	}

	public function getUserById($id){
				//Initialize return values
				$return_data = array();
				$return_data['data'] = "";
				$return_data['error'] = "";
				$return_data['message'] = "";
				$return_data['num_rows'] = "";

				//Configure query
				$this->db->select('*');
				$this->db->where('user_id', $id);
				$sel_item = $this->db->get('users');

				//Prepare output
				$return_data['num_rows'] = $sel_item->num_rows();

				if($sel_item->num_rows()=="0"){
						$return_data['error'] = true;
						$return_data['message'] = "No encontrado";
				}
				else if($sel_item->num_rows()>"1"){
						$return_data['error'] = true;
						$return_data['message'] = "Multiples usuarios encontrados";
				}
				else{
						$return_data['data'] = $sel_item->row_array();
				}

				return $return_data;
	}

	public function setNewPassword($newpass){

			$return_data = array();
			$return_data['result'] = 0;
			$return_data['message'] = "";
			$upd_data = array();
			$upd_data['user_pwd'] = password_hash($newpass,PASSWORD_DEFAULT);
			$upd_data['user_pwd_seed'] = "";
			//We also remove the cookie tooken for other active sessions
			$upd_data['user_hashedvalidator'] = "";
			$upd_data['user_selectorvalidator'] = "";

			$this->db->where('user_id', $this->input->post('user_id',TRUE));
			$this->db->where('user_email', $this->input->post('user_email',TRUE));
			$this->db->where('user_pwd_seed', $this->input->post('user_pwd_seed'));
			$upd_password = $this->db->update('users', $upd_data);

			if($upd_password)
			{
				$return_data['result'] = 1;
			}
			return $return_data;
	}

	public function saveOpinionCita(){

		$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$return_data['opinion_id'] = 0;
			$this->db->trans_start();

			$ins_data = array();
			$ins_data['user_id'] = $this->session->user_id;
			$ins_data['opinion_objetc_id'] = $this->input->post('cita_id');
			//$ins_data['order_line_id'] = $this->input->post('order_line_id');
			$ins_data['opinion_resumen'] = $this->input->post('opinion_resumen');
			$ins_data['opinion_descripcion'] = $this->input->post('opinion_descripcion');
			$ins_data['opinion_puntuacion'] = $this->input->post('puntuacion_cita');
			$ins_data['opinion_tipo'] = 1;


			 $sql=$this->db->insert('users_opiniones', $ins_data);
			 $return_data['opinion_id'] = $this->db->insert_id();
			 if($sql){
				 $this->db->where('cita_id',$this->input->post('cita_id'))->update('citas',array("cita_valorada"=>1));

			 }


			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;

	}

	public function saveDejarTestimonio(){

		$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$return_data['opinion_id'] = 0;
			$this->db->trans_start();

			$ins_data = array();
			$ins_data['user_id'] = $this->session->user_id;

			$ins_data['opinion_tipo'] = $this->input->post('tipo_opinion');
			if($this->input->post('tipo_opinion')==2){
				$ins_data['opinion_resumen'] = $this->input->post('opinion_resumen_envios');
				$ins_data['opinion_descripcion'] = $this->input->post('opinion_descripcion_envios');
				$ins_data['opinion_puntuacion'] = $this->input->post('puntuacion_envios');
			}else{
				$ins_data['opinion_resumen'] = $this->input->post('opinion_resumen_cliente');
				$ins_data['opinion_descripcion'] = $this->input->post('opinion_descripcion_cliente');
				$ins_data['opinion_puntuacion'] = $this->input->post('puntuacion_cliente');
			}

			 $sql=$this->db->insert('users_opiniones', $ins_data);
			
			 if($sql){
				 $return_data['opinion_id'] = $this->db->insert_id();

			 }


			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;

	}

	public function saveSuscribirse(){

		$return_data = array();
			$return_data['result'] 	= 1;
			$return_data['message'] = "";
			$this->db->trans_start();

			$existeEmail=$this->db->select('*')->from('users_subscriptions')
			->where('subscription_email',$this->input->post('email_news'))->get()->num_rows();

			$ins_data = array();

			$ins_data['subscription_email'] = $this->input->post('email_news');

			if($existeEmail==0){
			 $sql=$this->db->insert('users_subscriptions', $ins_data);
			}else{
				$return_data['result'] 	= -1;
				$return_data['message'] = "Esta email ya se encuentra suscrito.";
			}



			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$return_data['result'] 	= 0;
				$return_data['message'] = "Error guardando datos data";
			}
			return $return_data;

	}

	public function getNewsSusbscriptions(){

			$return_data= array();

			$this->db->select('*')->from('users_subscriptions')->order_by('subscription_created_time Desc');

			prepararConsultaGenerica();


    	$return_data['items'] = $this->db->get()->result_array();
			return $return_data;
    }


	public function suscripciones_NoAtendidas(){
		return $this->db->select('*')->from('users_subscriptions')->where('subscription_attended',0)
			->get()->num_rows();
	}

	public function adeItemSuscripciones(){

		$return_data 						= array();
		  $return_data['result']  = 1;
		  $return_data['message'] = "";
			$del_data								= false;
		  if($this->input->post('item_id',TRUE)==""){
		    $return_data['result']  = 0;
		    $return_data['message'] = "No encontrado";
		    return $return_data;
		  }

			// Dependiendo de la acción a realizar se hace una acción distinta sobre la BD
			switch ($this->input->post('item_id_accion')) {
		    case "Atender Suscripción": // Se hace la acción de eliminar, ya sea con un delete o con un update
					$del_data = $this->db->where('subscription_id',$this->input->post('item_id',TRUE))->update('users_subscriptions',array('subscription_attended'=>1));

	        break;


			}


		  if($del_data){
		    $return_data['result'] 	= 1;

			    $return_data['message'] = "Datos guardados";

		  }
		  else {
		    $return_data['result'] 	= 0;
		    $return_data['message'] = "Error";
		  }

		  return $return_data;

	}

	public function updateAvatarUserFront($destination){

		$mi_imagen=$this->db->select('user_avatar')->from('users')->where('user_id',$this->session->user_id)->get()->row_array();
		if($mi_imagen['user_avatar']!="")
			if(file_exists($mi_imagen['user_avatar']))
				unlink($mi_imagen['user_avatar']);

		$this->db->where('user_id',$this->session->user_id)->update('users',array('user_avatar'=>$destination));

	}
	
	public function getItemOpinion($opinion_id){
		return $this->db->select('*')->from('users_opiniones')->where('opinion_id',$opinion_id)
			->get()->row_array();
	}
	
	public function getItemOpinionProducto($opinion_id){
		return 
		$this->db->select('uo.*,pd.product_name,pi.product_image_path')->from('users_opiniones uo')
		->join('products_details as pd','pd.product_id = uo.opinion_objetc_id and language="es"')
		->join('products_images as pi','pi.product_id = pd.product_id and pi.product_image_order=1')
		->where('uo.opinion_id',$opinion_id)
			->get()->row_array();

	}






}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
