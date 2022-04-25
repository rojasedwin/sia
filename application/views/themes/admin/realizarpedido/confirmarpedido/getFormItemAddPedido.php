<style>

</style>



<div class="row form_reduced form_color_inputs">

    <div class='form-group <?=$bootstrap['col-12']?> validation_inline nopadding' id='validation_item_errors'></div>

    <div style='clear:both;height:1px;'>&nbsp;</div>

    <?php
		echo "<h4 class='form_title_color'>Productos";
	   echo "<span onclick='add_linea_pedido()' class='icon btn btn-xs bg-warning text-white' title='Añadir Producto' style='font-size:12px;float:right;margin-top:-5px;margin-right:20px;cursor:pointer;text-align:right;'>Añadir producto <i class='fa fa-plus-circle'></i></span>";

	   echo "</h4>";

    ?>
    <div style='clear:both;height:1px;'>&nbsp;</div>

	<div class="form-group col-md-12" style='height:400px;overflow-y:auto;'>
		<table id='tabla_add_pedido' class="tabla_add_pedido">
			<thead>
			<tr>
				<th style='width:20px;'>-</th>
				<th>Código Nacional</th>
				<th>Unidades</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$linea=1;
			if(empty($items)){
			echo "<tr class='linea_concepto' fila_verifica='0'>";
				echo "<td style='cursor:pointer;' class='eliminar_linea_producto'><i class='fa fa-times bg-danger text-white'></i></td>";
				echo "<td><input type='text' name='cod_nacional' value='' data-id='codnacional-0'></td>";
				echo "<td><input type='text' name='num_unidades' value=''></td>";

            echo "</tr>";
			}else{
				foreach($items as $fila){
					echo "<tr class='linea_concepto' fila_verifica='0'>";
					echo "<td style='cursor:pointer;' class='eliminar_linea_producto'><i class='fa fa-times bg-danger text-white'></i></td>";
					echo "<td><input type='text' name='cod_nacional' value='".$fila['cod_nacional']."' id='codnacional-".$linea."' data-id='".$linea."'></td>";
					echo "<td><input type='text' name='num_unidades' value='".$fila['num_unidades']."' id='numunidades-".$linea."' data-id='".$linea."'></td>";

					echo "</tr>";
					$linea++;
				}

			}

			?>
			</tbody>
		</table>

    </div>

</div>
