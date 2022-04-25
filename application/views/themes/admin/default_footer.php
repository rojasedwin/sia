<!-- The Loader. Is shown when pjax happens -->
<div class="loader-wrap">
	<i class="fa fa-circle-o-notch fa-spin-fast"></i>
</div>

<?php
	//Modales genéricos para pantallas
  $this->load->view('themes/'.$this->config->item('app_theme_admin')."/modales_genericos");

	//Modales que harán falta en varias pantallas.
	$this->load->view('themes/'.$this->config->item('app_theme_admin')."/modales_comunes");
 ?>


<input type='hidden' id='myUserId' value='<?php echo $this->session->user_id; ?>'>

</body>

