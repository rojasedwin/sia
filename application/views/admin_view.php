<?php
	$this->load->view('themes/'.$this->config->item('app_theme_admin').'/header');

	//Header
	if(isset($custom_header)){
		$this->load->view('themes/'.$this->config->item('app_theme_admin').'/'.$custom_header);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme_admin').'/default_header');
	}
	//View
	$this->load->view('themes/'.$this->config->item('app_theme_admin').'/'.$view);

	//Footer
	if(isset($custom_footer)){
		$this->load->view('themes/'.$this->config->item('app_theme_admin').'/'.$custom_footer);
	}
	else{
		$this->load->view('themes/'.$this->config->item('app_theme_admin').'/default_footer');
	}

	$this->load->view('themes/'.$this->config->item('app_theme_admin').'/footer');
?>
