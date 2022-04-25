<form name='condiciones_filter' id='condiciones_filter' class='form_filter'>
<div class="paddingred_hijos mb-10">

  <div class="<?=$bootstrap['col-5']?>">
		<label><strong>Laboratorio</strong></label>
		<select class="selectpicker"
			data-style="btn-info btn-sm"
			data-width="100%" data-live-search="true"
			tabindex="-1" name='buscar_laboratorio' multiple title='Filtrar por laboratorio' >
			<?php
			foreach ($laboratorios as $l){
				 echo "<option value='".$l['laboratorio_id']."'>".$l['laboratorio_nombre']."</option>";
			}
      ?>
		</select>
    <input type='hidden' name='laboratorio' value='l.laboratorio_id'>
	</div>

  

</div>
</form>
<div class='clear_form'>&nbsp;</div>
