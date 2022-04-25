
<div id='tareas_get' class='mt <?=$bootstrap['col-6']?>' >


<h4 class='form_title_color'>Detalle del Pedido

	</h4>

<table class="table table-striped  table-hover mt tabla_informes_datatable" data-order="[[ 0, &quot;desc&quot; ]]">
	<thead>
  <tr>
    <th>Cod. Nac.</th>
		<th>Nombre Producto</th>
		<th>Pvp</th>
    <th>Uds. Pedir</th>
		<th>Uds. Obtener</th>
  </tr>
</thead>
<tbody>
<?php

if (!empty($my_pedidos)){

  foreach($my_pedidos as $data) {


    $item_id = $data['pedido_id'];
	$class= "";

    echo "<tr class='".$class." fila_datos' id='fila_datos-".$item_id."'>";

	echo "<td>";
		echo $data['cod_nacional'];
	echo "</td>";

	echo "<td>";
		echo $data['producto_nombre'];
	echo "</td>";

	echo "<td>";
	if($data['producto_pvp']!="")
		echo $data['producto_pvp']."€";
	echo "</td>";


	echo "<td>";
		echo $data['num_unidades'];
	echo "</td>";
	echo "<td>";
		echo $data['num_obtener'];
	echo "</td>";




    echo "</tr>";

  }
}else{
	echo "<tr><td colspan='5' style='text-align:center;'>--- No hay resultados ---</td></tr>";
}
?>
</tbody>
</table>
</div>
<div id='promociones' class='mt <?=$bootstrap['col-6']?>' >
	<h4 class='form_title_color'>Detalle promociones aplicadas

		</h4>

	<table class="table table-striped  table-hover mt tabla_informes_datatable" data-order="[[ 0, &quot;desc&quot; ]]">
		<thead>
	  <tr>
			<th>Nombre promoción</th>
			<th>condiciones</th>
	  </tr>
	</thead>
	<tbody>
	<?php

	if (!empty($condiciones)){

	  foreach($condiciones as $data) {
		$class= "";

	    echo "<tr class='".$class." fila_datos'>";

		echo "<td>";
			echo $data['nombre_promo'];
		echo "</td>";

		echo "<td>";
			echo $data['beneficios'];
		echo "</td>";
	    echo "</tr>";

	  }
	}else{
		echo "<tr><td colspan='4' style='text-align:center;'>--- No hay condiciones ---</td></tr>";
	}
	?>
	</tbody>
	</table>
</div>
