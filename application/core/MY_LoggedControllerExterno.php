<?php
class MY_LoggedControllerExterno extends CI_Controller {
  // List of classes that can be accessed when the user is
  // not authenticated
  protected $_open_controllers = array('auth'
  ,'adminsite/provexterno/refrescarItemsPedidos'

  );


  public function __construct(){
        parent::__construct();
            // Check auth
      $this->load->helper(array('commun','cookie'));
      $this->_check_auth();

      $global_data = array('menu_externo_app'=>$this->config->item('menu_externo_app'));
      $this->load->vars($global_data);

      $global_data = array('bootstrap'=>$this->config->item('bootstrap'));
      $this->load->vars($global_data);

    
  }

  // ----------------------------------------------------------------
  private function _check_auth(){

      if ( ! ($this->session->logged_inExterno))
     {

       if ( ! in_array($this->router->class, $this->_open_controllers) and !(in_array($this->uri->uri_string(),$this->_open_controllers))){
         if($this->input->cookie('auth_token', TRUE)!="")
         {
           $CI =& get_instance();
           $CI->load->model('auth_model');
           $respuesta = $CI->auth_model->check_authTokenExterno($this->input->cookie('auth_token', TRUE),1,1);
           if($respuesta['result']==1)
           {
             if(($this->session->logged_inExterno) and $this->uri->segment(1)=="")
             {
               if($this->session->url_redirect!="") redirect($this->session->url_redirect);
             }
             else
               return;
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

           //echo "Lo echaría con ".$this->uri->uri_string();

           // You're gone, buddy.
           //echo "Te redireccionaria!!!";
           redirect('/authExterno');
         }
       }
      }
  }
}
