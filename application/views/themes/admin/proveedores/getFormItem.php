<form id='proveedor_form_item' name='proveedor_form_item'>
<input type='hidden' name='proveedor_id' id='proveedor_id' value='<?php echo $item['proveedor_id'];?>'>
<div class="form_reduced form_color_inputs">
     <div class='form-group <?=$bootstrap['col-12']?> validation_inline nopadding' id='validation_proveedor_errors'></div>

    <div class="form-group col-md-4">
      <label><strong>CIF</strong></label>
        <input type="text" name="proveedor_cif" class="form-control input-no-border "  value='<?php echo $item['proveedor_cif'];?>' placeholder="CIF">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Nombre</strong></label>
        <input type="text" name="proveedor_nombre" class="form-control input-no-border"  value='<?php echo $item['proveedor_nombre'];?>' placeholder="Nombre">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Nombre Comercial</strong></label>
        <input type="text" name="proveedor_nombrecomercial" class="form-control input-no-border"  value='<?php echo $item['proveedor_nombrecomercial'];?>' placeholder="Nombre Comercial">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Teléfono</strong></label>
        <input type="text" name="proveedor_telefono" class="form-control input-no-border "  value='<?php echo $item['proveedor_telefono'];?>' placeholder="Telefono">
    </div>
    <div class="form-group col-md-4">
      <label><strong>Email</strong></label>
        <input type="text" name="proveedor_email" class="form-control input-no-border"  value='<?php echo $item['proveedor_email'];?>' placeholder="Email">
    </div>
    <div class="form-group col-md-4">
      <label><strong>
        <?php echo ($item['proveedor_id']=="")?"Establecer Contraseña":"Cambiar contraseña"; ?>
         </strong></label>
        <input type="text" name='pwd' required class="form-control input-no-border"
               placeholder="  <?php echo ($item['proveedor_id']=="")?"Establecer Contraseña":"(deja en blanco si no quireres cambiarla)";?> " value=''>
    </div>
    <div class="form-group col-md-6">
      <label><strong>Dirección</strong></label>
        <input type="text" name="proveedor_direccion" class="form-control input-no-border"  value='<?php echo $item['proveedor_direccion'];?>' placeholder="Dirección">
    </div>
    <div class="form-group col-md-2">
      <label><strong>C.P</strong></label>
        <input type="text" name="proveedor_cp" class="form-control input-no-border"  value='<?php echo $item['proveedor_cp'];?>' placeholder="Código postal">
    </div>
	
    
	<div class="form-group col-md-4">
      <label><strong>Ciudad</strong></label>
        <input type="text" name="proveedor_poblacion" class="form-control input-no-border"  value='<?php echo $item['proveedor_poblacion'];?>' placeholder="Poblacion">
    </div>
	  <div class="form-group col-md-4">
      <label><strong>Municipio</strong></label>
        <input type="text" name="proveedor_municipio" class="form-control input-no-border"  value='<?php echo $item['proveedor_municipio'];?>' placeholder="Municipio">
    </div>
	
		
	 <div style='clear:both;height:10px;'>&nbsp;</div>
	
	
	
</div>
</form>
