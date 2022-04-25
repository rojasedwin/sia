<div class="row form_reduced form_color_inputs">

    <div class='form-group <?=$bootstrap['col-12']?> validation_inline nopadding' id='validation_item_errors'></div>

    <div style='clear:both;height:1px;'>&nbsp;</div>
		
	<div class='listado_accione <?=$bootstrap['col-12']?>' style='padding-top:10px;background-color:#fff !important;' id='contenido_detalle_pedido'>
        <?php
           $this->load->view('themes/'.$this->config->item('app_theme_admin').'/dashboardexterno/getPedidos');
        ?>
	
 
    </div>

    <div style='clear:both;height:1px;'>&nbsp;</div>

</div>

