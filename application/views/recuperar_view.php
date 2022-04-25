<?php
	$this->load->view('themes/'.$this->config->item('app_theme').'/header');

	//Header
	if(isset($custom_header)){
		$this->load->view('themes/'.$this->config->item('app_theme').'/'.$custom_header);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme').'/default_header');
	}

	//View
	$this->load->view('themes/'.$this->config->item('app_theme').'/'.$view);

	//Footer
	if(isset($custom_footer)){
		$this->load->view('themes/'.$this->config->item('app_theme').'/'.$custom_footer);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme').'/default_footer');
	}
	//Lo unico que se ha hecho es cambiar el pie para eliminar las funciones AJAX por defecto
	$this->load->view('themes/'.$this->config->item('app_theme').'/footer_recuperar');
?>
