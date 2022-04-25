<?php

	$this->load->view('back/template/meta');
	echo '<div class="wrapper">';
	$this->load->view('back/template/header');
	$this->load->view('back/template/sidebar');
	$this->load->view($view);
	$this->load->view('back/template/footer');
	echo "</div>";

	


	/*//Header
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

	$this->load->view('themes/'.$this->config->item('app_theme_admin').'/footer');*/
	
	//echo "aqui";exit;
?>
