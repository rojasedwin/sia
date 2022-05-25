<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require_once(APPPATH.'core/classes/User.php');

class Auth_model extends CI_Model {

	//Function that authenticate User from login form.
	function authenticateAdmin($email, $password,$codificada=0,$recordar=0,$user_type="",$force_redirect=""){
		//Initialize return values
		$return_data = array();
		$return_data['result'] = "";
		$return_data['message'] = "";
		$return_data['url'] = "";
		$contra = password_hash($password,PASSWORD_DEFAULT);
		if($codificada==1) $contra = $password;
		//Search a valid username-password pair on database
		$this->db->select('*');
		$this->db->where('users.user_email', $email);
		$this->db->where('users.user_active', 1);

		if($user_type!="" and $user_type!=0)
			$this->db->where('users.user_type', $user_type);

		$sel_user = $this->db->get('users');
		//If only 1 registry found, success
		if($sel_user->num_rows()=='1'){
			//Get user_id.
			$user_id = $sel_user->row_array();
			if($email=="admin@campuselea.com") $recordar = 1;
			if(password_verify($password,$user_id['user_pwd']))
			{

				//Get User Data
				$user_data = $this->getUserData($user_id['user_id']);

				//Check User Data
				if($user_data['result']=='success'){
					$return_data['result'] = 1;
					//Fill session data
					$this->fillSessionAdmin($user_data['user_data'],$recordar);

					//Log successfull login
					$this->logAuthenticationSuccess($user_id['user_id']);
					//Set return data
					$return_data['url'] = base_url().$this->session->userdata('url_redirect');
					if($force_redirect!="")
						$return_data['url'] = base_url().$force_redirect;
				}
				else{
					//Log error
					$this->logAuthenticationFail($email, $password, $user_data['message']);
					//Set return data
					$return_data['result'] = 0;
					$return_data['message'] = $user_data['message'];
				}
			}
			else{
				//Log error
				$this->logAuthenticationFail($email, $password, "Wrong Password");
				//Set return data
				$return_data['result'] = 0;
				$return_data['message'] = "Usuario o contraseña incorrectos";
			}
		}
		else{
			//Log error
			$this->logAuthenticationFail($email, $password, $this->lang->line('error_user_not_found'));
			//Set return data
			$return_data['result'] = 0;
			$return_data['message'] = $this->lang->line('error_user_not_found');
		}
		/*echo "<pre>";
		print_r($return_data);
		echo "</pre>";
		exit;*/
		//Return data
		return $return_data;
	}

	function fillSessionAdmin($user_data,$recordar){

		//Session SET
		$this->session->set_userdata($user_data);
		$this->session->set_userdata('logged_inAdmin', '1');
		$this->session->set_userdata('logged_inUserExterno', '0');

		if($recordar!=2) delete_cookie('auth_token');  //If we don't want do anything pass 2
		if($recordar) $this->rememberMe($user_data['user_id']);

		//$this->session->set_userdata('url_redirect',"adminsite/dashboard");
		$this->session->set_userdata('url_redirect',"dashboard");
	}

	function check_authToken($auth_token)
	{
		$return_data = array();
		$return_data['result'] = -1;
		$tmp = explode(":",$auth_token,2);
		$user_id = $tmp[0]; $Validator = $tmp[1];
		$this->db->select('*');
		$this->db->where('user_id', $user_id)->where('user_selectorvalidator',$auth_token);
		$sel_user = $this->db->get('users');

		//If only 1 registry found, success
		if($sel_user->num_rows()=='1')
		{
			$user_data = $sel_user->row_array();
			if( password_verify($Validator,$user_data['user_hashedvalidator']))
			{

					$return_data['result'] = -1;
					//Estamos dentro le damos a recordar usuario y actualizamos
					$this->fillSessionAdmin($user_data,1); //Actualizará la BBDD y la COOKIE
					$return_data['result'] = 0;
			}
		}
		return $return_data;
	}
	function rememberMe($user_id)
	{
		$validator = $this->generatePassword();
		$hashedValidator =  password_hash($validator,PASSWORD_DEFAULT);
		$auth_token = $user_id.":".$validator;
		$upd_data = array(); $upd_data['user_selectorvalidator'] = $auth_token; $upd_data['user_hashedvalidator'] = $hashedValidator;
		$this->db->where("user_id",$user_id)->update("users",$upd_data);
		$time_cookie = time() + (10 * 365 * 24 * 60 * 60);
		$cookie = array('name'   => 'auth_token','value'  => $auth_token,'expire' => $time_cookie);
		$this->input->set_cookie($cookie);
	}

	function logAuthenticationSuccess($user_id){
		//Fill data to insert.
		$ins_data = array();
		$ins_data['user_id'] = $user_id;
		$ins_data['date'] = date('Y-m-d');
		$ins_data['time'] = date('H:i:s');
		$ins_data['user_agent'] = $this->input->user_agent();
		$ins_data['ip'] = $this->input->ip_address();

		//Insertamos datos.
		$ins_log = $this->db->insert('auth_login_success', $ins_data);

		return true;
	}

	function logAuthenticationFail($username, $password, $reason){
		//Fill data to insert
		$ins_data = array();
		$ins_data['username'] = $username;
		$ins_data['password'] = $password;
		$ins_data['reason'] = $reason;
		$ins_data['date'] = date('Y-m-d');
		$ins_data['time'] = date('H:i:s');
		$ins_data['user_agent'] = $this->input->user_agent();
		$ins_data['ip'] = $this->input->ip_address();

		//Insertamos datos.
		$ins_log = $this->db->insert('auth_login_fail', $ins_data);

		return true;
	}



	function getUserData($user_id){
		//Initialize return values
		$return_data = array();
		$return_data['result'] = "";
		$return_data['message'] = "";
		$return_data['user_data'] = array();

		//Obtenemos datos del trabajador
		$this->db->select('users.*');
		$this->db->where('users.user_id', $user_id);
		$this->db->limit(1);
		$sel_datos = $this->db->get('users AS users');



		//Comprobamos los registros
		if($sel_datos->num_rows()!='1'){
			//Set return data
			$return_data['result'] = 'error';
			$return_data['message'] = $this->lang->line('error_user_data_not_found');
		}
		else{
			//Set return data
			$return_data['result'] = 'success';
			$return_data['user_data'] = $sel_datos->row_array();
		}

		//Return data
		return $return_data;
	}

	public function setSeedRecover($email){
		//Initialize return values
		$return_data = array();
		$return_data['data'] = "";
		$return_data['result'] = "1";

			//Configure query
			$this->db->select('*')
			->from('users as u')
			->where('u.user_email', $email);
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

	function generatePassword(){
		//Feed strings
		$group1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$group2 = "$&#@";
		$group3 = "0123456789";
		$password = "";

		for($i=1;$i<5;$i++){
			$password .= substr($group1,rand(0,strlen($group1)),1);
		}
		for($i=1;$i<3;$i++){
			$password .= substr($group2,rand(0,strlen($group2)),1);
		}
		for($i=1;$i<5;$i++){
			$password .= substr($group3,rand(0,strlen($group3)),1);
		}
		return $password;
	}

	/*
	FRONT
	*/
	function authenticateUserExterno($email, $password,$codificada=0,$recordar=0,$es_consulta=0){
		//Initialize return values
		$return_data = array();
		$return_data['result'] = "";
		$return_data['message'] = "";
		$return_data['url'] = "";
		$return_data['user_id'] = 0;

		if($email=="" or $password=="")
		{
			$return_data['result'] = 0;
			$return_data['message'] = "Indique email y contraseña";
			return $return_data;exit;
		}

		$contra = password_hash($password,PASSWORD_DEFAULT);
		if($codificada==1) $contra = $password;
		//Search a valid username-password pair on database
		$this->db->select('*');
		$this->db->where('user_email', $email);
		$this->db->where('user_active', 1)->where('user_borrado', 0);
		$this->db->where('user_type', 2);


		$sel_user = $this->db->get('users');

		//If only 1 registry found, success
		if($sel_user->num_rows()=='1'){
			//Get client_id.
			$user_id = $sel_user->row_array();

			if(password_verify($password,$user_id['user_pwd']))
			{
				//Get User Data
				$user_data = $this->getUserExternoData($user_id['user_id']);

				//Check User Data
				if($user_data['result']=='success'){
					$return_data['result'] = 1;
					$return_data['user_id'] = $user_id['user_id'];
					//Fill session data
					if($user_data['user_data']['user_active']==1)
						$this->fillSessionUserExterno($user_data['user_data'],$recordar,$es_consulta);
					else {
						$return_data['result'] = 0;
						$return_data['message'] = "Usuario o contraseña incorrectos";
					}

					//Log successfull login
					$this->logAuthenticationSuccess($user_id['user_id']);

					//Check if exsite return_url
					$return_url = $this->session->userdata('return_url');
					if($return_url!='' or $return_url!='undefined')
					{
						$return_data['url'] = $return_url;
					}else //Set return data
						$return_data['url'] = base_url().'panel';
						$this->session->set_userdata('return_url', '');
				}
				else{
					//Log error
					$this->logAuthenticationFail($email, $password, $user_data['message']);

					//Set return data
					$return_data['result'] = 0;
					$return_data['message'] = $user_data['message'];
				}
			}
			else{
				//Log error
				$this->logAuthenticationFail($email, $password, "Wrong Password");
				//Set return data
				$return_data['result'] = 0;

				$return_data['message'] = "Usuario o contraseña incorrectos";
			}
		}
		else{
			//Log error
			$this->logAuthenticationFail($email, $password, $this->lang->line('error_client_not_found'));
			//Set return data
			$return_data['result'] = 0;
			$return_data['message'] = "Datos no encontrados";
		}

		//Return data
		return $return_data;
	} //Auth Client
	function getUserExternoData($user_id){
		//Initialize return values
		$return_data = array();
		$return_data['result'] = "";
		$return_data['message'] = "";
		$return_data['user_data'] = array();

		//Obtenemos datos del trabajador
		$this->db->select('u.*');
		$this->db->where('u.user_id', $user_id);
		$this->db->from('users u');
		$sel_datos = $this->db->get();
		//Comprobamos los registros
		if($sel_datos->num_rows()!='1'){
			//Set return data
			$return_data['result'] = 'error';
			$return_data['message'] = $this->lang->line('error_user_data_not_found');
		}
		else{
			//Set return data
			$return_data['result'] = 'success';
			$return_data['user_data'] = $sel_datos->row_array();
		}
		//Return data
		return $return_data;
	}

	function fillSessionUserExterno($user_data,$recordar,$es_consulta){

		//Session SET
		$this->session->set_userdata($user_data);
		$this->session->set_userdata('logged_inUserExterno', '1');
		$this->session->set_userdata('logged_inAdmin', '0');
		if($recordar!=2) delete_cookie('auth_token');  //If we don't want do anything pass 2
		if($recordar) $this->rememberMeUserExterno($user_data['user_id']);

		if($es_consulta==1)
			$this->session->set_userdata('url_redirect','home');
		else
			$this->session->set_userdata('url_redirect','panel');
	}

	function rememberMeUserExterno($user_id){
		$validator = $this->generatePassword();
		$hashedValidator =  password_hash($validator,PASSWORD_DEFAULT);
		$auth_token = $user_id.":".$validator;
		$upd_data = array(); $upd_data['user_selectorvalidator'] = $auth_token; $upd_data['user_hashedvalidator'] = $hashedValidator;
		$this->db->where("user_id",$user_id)->update("users",$upd_data);
		$time_cookie = time() + (10 * 365 * 24 * 60 * 60);
		$cookie = array('name'   => 'auth_token','value'  => $auth_token,'expire' => $time_cookie);
		$this->input->set_cookie($cookie);
	}

	function check_authTokenUserexterno($auth_token){
		$return_data = array();
		$return_data['result'] = 0;
		$tmp = explode(":",$auth_token,2);
		$user_id = $tmp[0]; $Validator = $tmp[1];
		$this->db->select('*');
		$this->db->where('user_id', $user_id)->where('user_id !=', 1)->where('user_selectorvalidator',$auth_token);
		$sel_user = $this->db->get('users');

		//If only 1 registry found, success
		if($sel_user->num_rows()=='1')
		{
			$user_data = $sel_user->row_array();
			if( password_verify($Validator,$user_data['user_hashedvalidator']))
			{
					$return_data['result'] = 1;
					//Estamos dentro le damos a recordar usuario y actualizamos

					$this->fillSessionUserExterno($user_data,1,0); //Actualizará la BBDD y la COOKIE

			}
		}
		return $return_data;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
