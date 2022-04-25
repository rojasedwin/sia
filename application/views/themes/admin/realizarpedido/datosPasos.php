
    <div class="row form_reduced form_color_inputs pestania_proyecto pestania_acelerador">
        <div class="<?=$bootstrap['col-6']?>" id="resultados_paso_1">
            
            <div style='clear:both;height:1px;'>&nbsp;</div>
			
        </div>

        <div class="<?=$bootstrap['col-6']?>" id="resultados_paso_2">
            			
            <div style='clear:both;height:1px;'>&nbsp;</div>
			
        </div>
		
		
    </div>


    <iframe name="cartel_evento_paso_1" id="cartel_evento_paso_1" style="display:none"></iframe>
	<form name="upload_paso_1" id="upload_paso_1" action="<?php echo base_url();?>adminsite/realizarpedido/subirDocumentoPaso1" enctype="multipart/form-data" target="cartel_evento_paso_1" method="post">
        <div class='<?=$bootstrap['col-12']?>'>
        
         <input style='display:none;' type='file' name='file_paso_1' id='file_paso_1'>

         <input type="hidden" id="aux_paso_1" name="aux_paso_1" value="">
         
        </div>
    </form>

    <iframe name="cartel_evento_paso_2" id="cartel_evento_paso_2" style="display:none"></iframe>
	<form name="upload_paso_2" id="upload_paso_2" action="<?php echo base_url();?>adminsite/realizarpedido/subirDocumentoPaso2" enctype="multipart/form-data" target="cartel_evento_paso_2" method="post">
        <div class='<?=$bootstrap['col-12']?>'>
        
         <input style='display:none;' type='file' name='file_paso_2' id='file_paso_2'>

         <input type="hidden" id="aux_paso_2" name="aux_paso_2" value="">
         
        </div>
    </form>


