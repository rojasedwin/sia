<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/MY_LoggedController.php');
class Dashboard extends MY_LoggedController {

	public function __construct(){
		parent::__construct('dashboard');
		$this->load->helper(array('commun','notification'));
	}

	public function index($predatos=null){
		//Load login form.
		//$this->load->view('welcome_message');
		if($predatos==null)
			$datos = array();
		else {
				$datos = $predatos;
		}
		$datos['view'] = "dashboard/index";
		$datos['js_data'] = array('dashboard/dashboardadmin.js?1.'.$this->config->item('js_version'));
		$datos['message'] = "";
		
		$this->load->view('admin_view', $datos);

	}

	function check_pass($pass1,$pass2)
	{
		if($pass1!=$pass2)
		{
			$this->form_validation->set_message('check_pass', 'Las contraseñas no coinciden');
		 return false;
		}
		else {
			return true;
		}

	}

	// ###########################################
	// ###########################################
	// 	MY PROFILE
	// ###########################################
	// ###########################################

	public function my_profile($mensaje = ""){
		$datos = array();
		$datos['view'] = "dashboard/miperfil-index";
		$datos['css_data'] = array('admin/css/jquery.Jcrop.min.css');
		$datos['js_data'] = array('dashboard/miperfil.js?5'.rand(0,999),'vendor/switchery/dist/switchery.min.js','comun/jquery.Jcrop.min.js');
		$datos['message'] = $mensaje;
		$this->load->view('admin_view', $datos);
	}

	public function my_profile_form()
	{
		$datos['view'] = "dashboard/miperfil";
		$this->load->view('ajax_admin_view', $datos);
	}

	public function save_profile()
	{
		$datos = array();
		$datos['error'] = 0;
		$datos['message'] = "";
		$datos['view'] = "dashboard/miperfil-index";
		$datos['css_data'] = array('admin/css/jquery.Jcrop.min.css');
		$datos['js_data'] = array('dashboard/miperfil.js?5'.rand(0,999),'vendor/switchery/dist/switchery.min.js','comun/jquery.Jcrop.min.js');
		$datos['cambiarclave'] = $this->input->post('cambiarclave');

		$this->load->library('form_validation');

		// $dia = $this->input->post('fecha_nac_dia');
		// $mes = $this->input->post('fecha_nac_mes');
		// $year = $this->input->post('fecha_nac_year');
		// $fecha = $dia."-".$mes."-".$year;
		$fecha = $this->input->post('user_fecha_nacimiento');

		// echo "valid date: ".var_dump($this->validateDate($fecha,'d-m-Y'));

		if($this->validateDate($fecha,'d-m-Y')!=1){
			unset($_POST['user_fecha_nacimiento']);


		}


		$this->form_validation->set_rules(
			'user_name',
			'Nombre',
			'required|min_length[2]|max_length[200]',
			array(
				'required'      => '%s: No has indicado %s.',
				'max_length' => '%s: Limite  200 caracteres',
				'min_length' => '%s: Al menos 2 caracteres'

			)
		);

		$this->form_validation->set_rules(
			'user_lastname',
			'Apellido',
			'min_length[2]|max_length[200]',
			array(
				'max_length' => '%s: Limite  200 caracteres',
				'min_length' => '%s: Al menos 2 caracteres'

			)
		);

		$this->form_validation->set_rules(
			'user_phone',
			'Número Telefono ',
			'regex_match[/^[0-9]{9}$/]',
			array(
				'regex_match' => '%s: debe colocar 6 número sin guiones ni puntos ni espacios'
			)
		); //{10} for 10 digits number

		$this->form_validation->set_rules(
			'user_about',
			'Descripcion',
			'min_length[2]|max_length[500]',
			array(
				'max_length' => '%s: Limite  500 caracteres',
				'min_length' => '%s: Al menos 2 caracteres'

			)
		);

//debug($_POST);exit;
		//si le activo el checkbox cambiarclave, entonce validamos clave y su confirmacion
		if ($this->input->post('cambiarclave') == "1") {

			$this->form_validation->set_rules(
				'nuevapass1',
				'Nueva contraseña',
				'trim|required|min_length[6]|max_length[20]|callback_check_pass[' . $this->input->post('nuevapass2') . ']',
				array(
					'required'      => 'No has indicado %s.',
					'max_length' => 'Limite  20 caracteres',
					'min_length' => 'Al menos 6 caracteres'

				)
			);

			$this->form_validation->set_rules(
				'nuevapass2',
				'Confirmar contraseña',
				'trim|required|min_length[6]|max_length[20]',
				array(
					'required'      => 'No has indicado %s.',
					'max_length' => '%s: Limite  20 caracteres',
					'min_length' => '%s: Al menos 6 caracteres'

				)
			);
		}

		if ($this->form_validation->run() == FALSE) {
			$datos['message'] = "";

		} else {
			$this->load->model('usuarios_model');
			$this->load->helper('imagenes');
			$return_data = $this->usuarios_model->editUserAdmin($this->session->user_id);
			$datos['error'] = $return_data['error'];
			$datos['message'] = $return_data['message'];
		}


		$this->load->view('admin_view', $datos);
	}

	// UPLOAD IMAGE // BEGIN
	public function subirObjeto()
	{
		$tipos_validos_img = array('jpg', 'jpeg', 'png');
		$mensaje_ok = "ok";
		$preview = "preview_cartel";

		$min_width = 300;
		$min_height = 300;
		$error_tam = "error_tam";
		$index_object = "user_object";
		$tmp = explode(".", $_FILES[$index_object]['name']);
		$extension = strtolower(end($tmp));
		$mensaje = "format";
		$error_prefix = '<div class="alert alert-danger alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		$success_prefix = '<div class="alert alert-success alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		$error_suffix = '</div>';


		$resp = array();


		if (in_array($extension, $tipos_validos_img)) $mensaje = "image";
		if ($mensaje != "format") {

			$name_object = substr(md5(rand(0, 99999)), 0, 25) . "." . $extension;
			$destination = "attachments/tmp/" . $name_object;

			$this->load->helper('imagenes');
			//if(!copy($_FILES[$index_object]['tmp_name'],$destination))
			/*$respuesta = resizeImagen($_FILES[$index_object]['tmp_name'], 1900,1500,$destination,$extension);
			if($respuesta['error'])
			*/
			if (!copy($_FILES[$index_object]['tmp_name'], $destination)) {
				// echo "<script>window.parent.object_uploaded('error','preview_cartel','','" . $error_prefix . $this->traducciones['error_al_copiar'][$this->idioma] . $error_suffix . "');</script>";
				$resp = array(
					"mensaje" => 'error',
					"preview" => $preview,
					"name_object" => $name_object,
					"ancho" => $ancho,
					"alto" => $alto
				);
			} else {
				list($ancho, $alto) = getimagesize($_FILES[$index_object]['tmp_name']);
				if ($ancho < $min_width || $alto < $min_height){
					// echo "<script>window.parent.object_uploaded('" . $error_tam . "','" . $preview . "','" . $name_object . "','" . $ancho . "-" . $alto . "');</script>";
					$resp = array(
						"mensaje" => $error_tam,
						"preview" => $preview,
						"name_object" => $name_object,
						"ancho" => $ancho,
						"alto" => $alto
					);
				}else {
					//  echo "<script type='text/javascript'>window.parent.object_uploaded('" . $mensaje_ok . "','" . $preview . "','" . $name_object . "','" . $ancho . "-" . $alto . "');</script>";
					 $resp = array(
						 "mensaje" => $mensaje_ok,
						 "preview" => $preview,
						 "name_object" => $name_object,
						 "ancho" => $ancho,
						 "alto" => $alto
					 );

				}
			}
		} else{
			// echo "<script>window.parent.object_uploaded('format','preview_cartel','','" . $error_prefix . $this->traducciones['formato_imagen'][$this->idioma] . $error_suffix . "');</script>";
			$resp['mensaje'] = "format";
		}

			echo json_encode($resp);
	}

	public function uploadImagePerfil()
	{
		$dir_name = "attachments/img_post_perfil/";
		$tmp = explode('.', $_FILES['file']['name']);
		$extension = end($tmp);
		$name = uniqid('f_img_blog_');
		$name .= ".".$extension;

		move_uploaded_file($_FILES['file']['tmp_name'],$dir_name.$name);
		echo base_url()."/attachments/img_post_perfil/".$name;
		$rand = rand(0,99);
	}


	public function delImgPost()
	{

		$this->load->model('users_model');

		$userid = $this->input->post('user_id');

		echo  json_encode($this->users_model->eliminarImagenPerfil($userid));
	}

	public function delImgTemporal()
	{
		$this->load->model('users_model');
		$img = $this->input->post('user_imagen');
		$this->users_model->eliminarImagenTmp($img);
	}
	// UPLOAD IMAGE // END

	

	public function validateDate($date, $format = 'Y-m-d'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}

}
