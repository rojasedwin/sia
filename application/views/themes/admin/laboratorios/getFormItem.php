<form id='laboratorio_form_item' name='laboratorio_form_item'>
<input type='hidden' name='laboratorio_id' id='laboratorio_id' value='<?php echo $item['laboratorio_id'];?>'>
<div class="form_reduced form_color_inputs">
     <div class='form-group <?=$bootstrap['col-12']?> validation_inline nopadding' id='validation_laboratorio_errors'></div>

    <div class="form-group col-md-4">
      <label><strong>CIF</strong></label>
        <input type="text" name="laboratorio_cif" class="form-control input-no-border "  value='<?php echo $item['laboratorio_cif'];?>' placeholder="CIF">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Nombre</strong></label>
        <input type="text" name="laboratorio_nombre" class="form-control input-no-border"  value='<?php echo $item['laboratorio_nombre'];?>' placeholder="Nombre">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Nombre Comercial</strong></label>
        <input type="text" name="laboratorio_nombrecomercial" class="form-control input-no-border"  value='<?php echo $item['laboratorio_nombrecomercial'];?>' placeholder="Nombre Comercial">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Teléfono</strong></label>
        <input type="text" name="laboratorio_telefono" class="form-control input-no-border "  value='<?php echo $item['laboratorio_telefono'];?>' placeholder="Telefono">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Email</strong></label>
        <input type="text" name="laboratorio_email" class="form-control input-no-border"  value='<?php echo $item['laboratorio_email'];?>' placeholder="Email">
    </div>
	
	<div class="form-group col-md-4">
      <label><strong>Ciudad</strong></label>
        <input type="text" name="laboratorio_poblacion" class="form-control input-no-border"  value='<?php echo $item['laboratorio_poblacion'];?>' placeholder="Poblacion">
    </div>
    
    <div class="form-group col-md-6">
      <label><strong>Dirección</strong></label>
        <input type="text" name="laboratorio_direccion" class="form-control input-no-border"  value='<?php echo $item['laboratorio_direccion'];?>' placeholder="Dirección">
    </div>
    <div class="form-group col-md-2">
      <label><strong>C.P</strong></label>
        <input type="text" name="laboratorio_cp" class="form-control input-no-border"  value='<?php echo $item['laboratorio_cp'];?>' placeholder="Código postal">
    </div>
	
    
	
	  <div class="form-group col-md-4">
      <label><strong>Municipio</strong></label>
        <input type="text" name="laboratorio_municipio" class="form-control input-no-border"  value='<?php echo $item['laboratorio_municipio'];?>' placeholder="Municipio">
    </div>
	
		
	 <div style='clear:both;height:10px;'>&nbsp;</div>
	
	
	
</div>
</form>
