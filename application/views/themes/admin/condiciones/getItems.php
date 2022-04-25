<table id='' class="table table-striped table-hover datatable tabla_informes_datatable"><thead>
<tr>

<th>Laboratorio</th><th>Nombre Condición</th><th>Proveedores</th>
<th>Cantidad Condiciones</th><th>Tipo Descuento</th><th>Cantidad Descuento</th><th style='width:110px;' class='no-sort'>-</th></tr>
</thead>
<tbody id='cuerpo_sorttable' class='ui-sortable'>
<?php
//debug($items['items']);
$cont = 0;
if(!empty($items['items']))
  foreach($items['items'] as $a)
  {
    $idcondicion = $a['condicion_id']; $style= "";
    if($a['condicion_activo']==0) $style='background-color:#d2d2d2';
    echo "<tr class='fila_condicion fila_datos' style='".$style."' id='fila_condicion-".$idcondicion."'>";

   

    echo "<td>".$a['laboratorio_nombrecomercial']."</td>";
    echo "<td>".$a['condicion_nombre']."</td>";
	
    echo "<td>";
		if(!empty($a['proveedores']))
			foreach($a['proveedores'] as $p){
				echo $p['proveedor_nombrecomercial']."<br>";
				
			}
	echo "</td>";

    echo "<td>";
	if($a['condicion_cantidad_minima']!=-1)
    echo "<span class='letra_pequenia'>Cant. Mín. Condición: ".$a['condicion_cantidad_minima']."</span>";
	if($a['condicion_cantidad_maxima']!=-1)
    echo "<br><span class='letra_pequenia'>Cant. Máx. Condición: ".$a['condicion_cantidad_maxima']."</span>";
	if($a['condicion_cantidad_minima_eur']!=-1)
    echo "<br><span class='letra_pequenia'>Cant. Mín. Condición €: ".$a['condicion_cantidad_minima_eur']."</span>";
	if($a['condicion_cantidad_maxima_eur']!=-1)
    echo "<br><span class='letra_pequenia'>Cant. Máx. Condición €: ".$a['condicion_cantidad_maxima_eur']."</span>";

	if($a['unidades_oferta']!=0)
    echo "<br><span class='letra_pequenia'>Por cada: ".$a['unidades_oferta']." Unidades</span>";

	if($a['unidades_regalo_oferta']!=0)
    echo "<br><span class='letra_pequenia'>Me regalan: ".$a['unidades_regalo_oferta']." Unidades</span>";
    echo "</td>";

    echo "<td>".(($a['condicion_tipo_descuento']==0)?'% Porcentaje':'€ Directo')."</td>";

    echo "<td>";
      echo $a['condicion_cantidad_descuento'];
    echo "</td>";

    echo utf8_encode("<td style='cursor:pointer;text-align:right;' class='news-list'>");
    echo "<span onclick='fichaItem(".$idcondicion.")' class='icon bg-primary text-white' title='Edit'><i class='fa fa-pencil'></i></span>";
    if($a['condicion_activo']==1)
      echo "<span onclick='desactivarItem(".$idcondicion.")' class='icon bg-warning text-white' title='Block User'><i class='fa fa-lock'></i></span>";
    else {
      echo "<span onclick='activarItem(".$idcondicion.")' class='icon bg-success text-white' title='Unblock User'><i class='fa fa-unlock'></i></span>";
    }
    echo "<span onclick='importarExcelCondicion(".$idcondicion.")' class='icon bg-info text-white' title='Edit'><i class='fa fa-file-excel-o'></i></span>";

    if($a['productos_asociados']!=0)
    echo "<span onclick='eliminarItem(".$idcondicion.")' class='icon bg-danger text-white' title='Eliminar'><i class='fa fa-trash'></i></span>";

    echo "</td>";
    echo "</tr>";
    $cont++;
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay Condiciones ---</td></tr>";
?>
</tbody>
</table>

<iframe name="cartel_evento" id="cartel_evento" style="display:none"></iframe>
	<form name="upload_condiciones_form" id="upload_condiciones_form" action="<?php echo base_url();?>adminsite/condiciones/subirDocumento" enctype="multipart/form-data" target="cartel_evento" method="post">
        <div class='<?=$bootstrap['col-12']?>'>
        
         <input style='display:none;' type='file' name='file_condiciones' id='file_condiciones'>

         <input type="hidden" id="aux_condicion_id" name="aux_condicion_id" value="">
         
        </div>
    </form>
