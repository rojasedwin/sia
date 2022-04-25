<table id='<?=$this->vista?>_table' class="table table-striped table-hover datatable tabla_informes_datatable" data-order="[[ 0, &quot;desc&quot; ]]">
<thead>
  <tr>
    <th>Fecha Pedido</th>
    <th>Pedido #</th>
   <th>Realizado</th>
  
    <th style='width:100px;' class='no-sort'>-</th>
  </tr>
</thead>
<tbody>
<?php
//debug($items);
if(count($items['items'])>0)
  foreach($items['items'] as $a)
  {
    $item_id = $a['pedido_id'];
    $class      = "";
	if($a['pedido_realizado']==0)
		$class      = "rojo_suave";

    echo "<tr class='".$class."' id='fila_almacen-".$item_id."'>";
    echo "<td data-sort='".$a['pedido_create_time']."'>".fecha_esp_red_hora($a['pedido_create_time'])."</td>";
	echo "<td>".rellenar_izq($a['pedido_id'],0)."</td>";
	echo "<td>".(($a['pedido_realizado']==1)?'Sí':'No')."</td>";


    echo utf8_encode("<td style='cursor:pointer;text-align:right;' class='news-list'>");
   
   if($a['pedido_realizado']==0)
    echo "<span onclick='marcarPedidoRealizado(".$item_id.")' class='icon bg-warning text-white' title='Borrar'><i class='fa fa-check-circle-o'></i></span>";
	
	 echo "<span onclick='fichaDetalleItem(".$item_id.")' class='icon bg-primary text-white' title='Detalle Pedido'><i class='fa fa-info'></i></span>";
    echo "</td>";
    echo "</tr>";
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay resultados ---</td></tr>";
?>
</tbody>
</table>
