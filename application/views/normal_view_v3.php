<?php
	$this->load->view('themes/'.$this->config->item('app_theme_v3').'/header');

	//Header
	if(!isset($no_header))
	if(isset($custom_header)){
		$this->load->view('themes/'.$this->config->item('app_theme_v3').'/'.$custom_header);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme_v3').'/default_header');
	}
	//View
	$this->load->view('themes/'.$this->config->item('app_theme_v3').'/'.$view);

	//Footer
	if(!isset($no_footer))
	if(isset($custom_footer)){
		$this->load->view('themes/'.$this->config->item('app_theme_v3').'/'.$custom_footer);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme_v3').'/default_footer');
	}

	$this->load->view('themes/'.$this->config->item('app_theme_v3').'/footer');
?>
