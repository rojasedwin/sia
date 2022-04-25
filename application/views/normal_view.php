<?php
	$this->load->view('themes/'.$this->config->item('app_theme').'/header');
	//Header
	if(!isset($no_header))
	if(isset($custom_header)){
		$this->load->view('themes/'.$this->config->item('app_theme').'/'.$custom_header);
	}
	else{
		if(!isset($no_default_header))
		$this->load->view('themes/'.$this->config->item('app_theme').'/default_header');
	}
	//View
	$this->load->view('themes/'.$this->config->item('app_theme').'/'.$view);

	//Footer
	if(!isset($no_footer))
	if(isset($custom_footer)){
		$this->load->view('themes/'.$this->config->item('app_theme').'/'.$custom_footer);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme').'/default_footer');
	}

	$this->load->view('themes/'.$this->config->item('app_theme').'/footer');
?>
