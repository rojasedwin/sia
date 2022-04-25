<?php
class MY_LoggedController extends CI_Controller {

    // List of classes that can be accessed when the user is
    // not authenticated
    protected $_open_controllers = array('auth','dashboard/my_profile','dashboard/save_profile');


protected $_total_controller_open = array();

    public function __construct(){
          parent::__construct();
              // Check auth
        $this->load->helper(array('commun','cookie'));
        $this->_check_auth();
        $global_data = array('menu_admin_app'=>$this->config->item('menu_admin_app'));
        $this->load->vars($global_data);

        $global_data = array('menu_comercial_app'=>$this->config->item('menu_comercial_app'));
        $this->load->vars($global_data);


        $this->load->vars(array('mostrar_paginacion'=>$this->config->item('mostrar_paginacion')));


        $global_data = array('bootstrap'=>$this->config->item('bootstrap'));
        $this->load->vars($global_data);


    }

    // ----------------------------------------------------------------
    private function _check_auth(){

        if ( ! $this->session->logged_inAdmin)
       {          //
          //    )
            if ( ! in_array($this->router->class, $this->_open_controllers) and !(in_array($this->uri->uri_string(),$this->_open_controllers))){

              //Si esta logueado y es vacio lo reenviamos a su pagina de inicio
              if( ($this->session->logged_inAdmin)

              and ($this->uri->segment(1)=="" or $this->uri->segment(1)=="gestion"))
              {
                if($this->session->url_redirect!="") redirect($this->session->url_redirect);
              }

              if($this->input->cookie('auth_token', TRUE)!="")
              {
                $CI =& get_instance();
                $CI->load->model('auth_model');
                $respuesta = $CI->auth_model->check_authToken($this->input->cookie('auth_token', TRUE),1,1);
                if(isset($respuesta['result']) and $respuesta['result']==0) //User type 0
                {
                  if(($this->session->logged_inAdmin) and ($this->uri->segment(1)=="" or $this->uri->segment(1)=="gestion"))
                  {
                    if($this->session->url_redirect!="") redirect($this->session->url_redirect);
                  }
                  else
                  {

                  }

                }
              }

              if($this->input->is_ajax_request())
              {
                http_response_code(401);
                return;
              }
              else {
                // Save the page we are on now to redirect if the user
                // successfully authenticates
                $this->session->set_userdata('return_url', current_url());

                // You're gone, buddy.
                redirect('/auth');
              }

            }

        }
    }
}
