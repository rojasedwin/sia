<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct(){
        parent::__construct('auth');
        $this->load->helper(array('commun','cookie'));
    }

	public function index(){
    //echo "LLEgo a INDEX AUTH";
    redirect('auth/login');
	}

  public function test_pagina(){
      $this->load->view('test');
  }

    public function login(){
		    $this->load->view('login');
    }

    public function authenticate(){
    	//Load model
    	$this->load->model('auth_model');

      $this->session->set_userdata('logged_in', '0');
      delete_cookie('email_user');
      delete_cookie('pass_user');

      //Check credentials
    	$result = $this->auth_model->authenticateAdmin($this->input->post('email',TRUE), $this->input->post('pass',TRUE),0,$this->input->post('rememberme',TRUE));

      if($result['result'])
      {
          redirect($result['url']);
      }
      else {
        $datos['error'] = 1;
        $this->load->view('login',$datos);
      }

    }


    public function registerUser(){

      $this->load->library('form_validation');
  		//$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
  		$this->form_validation->set_rules(
  			'user_name','Name',
  				'required|min_length[2]|max_length[100]',
  					array(
  								'required'      => 'No has indicado %s.',
  								'max_length' => '%s: Limite  100 caracteres',
  								'min_length' => '%s: Al menos 2 caracteres'

  					)
  			);
  		  $is_unique = "|is_unique[users.user_email]";
  			$this->form_validation->set_rules(
  				'user_email','Email',
  					'required|valid_email|min_length[2]|max_length[100]'.$is_unique,
  						array(
  									'required'      => 'No has indicado %s.',
  									'is_unique'      => 'Email already registered',
  									'max_length' => '%s: Limite  100 caracteres',
  									'min_length' => '%s: Al menos 2 caracteres'

  						)
  				);
  			$required = "|required";
  			$this->form_validation->set_rules('password', 'Password',
  			'trim'.$required.'|min_length[6]|max_length[20]',
  			array(
  						'required'      => 'No has indicado %s.',
  						'max_length' => '%s: Limite  20 caracteres',
  						'min_length' => '%s: Al menos 6 caracteres'
  			)
  		  );
  		if ($this->form_validation->run() == FALSE)
  		{
  			$return_data = array();
  			$return_data['result'] = -1;
  			$return_data['message'] = validation_errors();
        echo json_encode($return_data);
        return;
  		}


      //Load model
      $this->load->model('auth_model');
      //Check credentials
      $result = $this->auth_model->registerUserWeb();
      if($result['result']==1)
      {
        $this->load->model('cart_model');
        $this->cart_model->mixMyCarts();
      }
      echo json_encode($result);
      return;
    }

    public function logout(){
        //Create logout logic.
        $this->session->sess_destroy();
        delete_cookie('auth_token');
        redirect(base_url().$this->config->item('app_default_uri'));
    }
    public function logoutExterno(){
        //Create logout logic.
        $this->session->sess_destroy();
        delete_cookie('auth_token');
        redirect(base_url()."auth/LoginExterno");
    }
    public function logoutWeb(){
        //Create logout logic.
        $this->session->sess_destroy();
        delete_cookie('email_user');
        delete_cookie('auth_token');
    		delete_cookie('pass_user');
        redirect('/');
    }

	/*
	FRONT
	*/
	public function authenticateUserExterno(){
    	//Load model
    	$this->load->model('auth_model');
      $this->session->set_userdata('logged_in', '0');
      $this->session->set_userdata('logged_inUserExterno', '0');
      delete_cookie('email_user');
      delete_cookie('pass_user');

      //Check credentials
    	$result = $this->auth_model->authenticateUserExterno($this->input->post('email',TRUE), $this->input->post('pass',TRUE),0,0,$this->input->post('es_consulta_online'));

      if($result['result']==1)
		  {
        $this->load->model('cart_model');

        if($this->session->cart_session_id!="")
        {
          $this->cart_model->trasladarCarrito();
        }

			  redirect($result['url']);
		  }
		  else {
  			$datos = array();
  				$datos['view'] = "cuenta/inicioSesion";
  			$datos['error'] = 1;
  			$datos['message'] = $result['message'];
  			$this->load->view('normal_view',$datos);
		  }
	}
  public function authExterno(){
        $this->load->view('loginExterno');
    }
	public function loginExterno(){
        $this->load->view('loginExterno');
    }

	public function authenticateExterno(){
    	//Load model
    	$this->load->model('auth_model');

      $this->session->set_userdata('logged_in', '0');
      delete_cookie('email_user');
      delete_cookie('pass_user');

      //Check credentials
    	$result = $this->auth_model->authenticateExterno($this->input->post('email',TRUE), $this->input->post('pass',TRUE),0,$this->input->post('rememberme',TRUE));

      if($result['result'])
      {
          redirect($result['url']);
      }
      else {
        $datos['error'] = 1;
        $this->load->view('loginExterno',$datos);
      }

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
