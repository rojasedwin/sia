<h4 class='form_title_color'>Paso 2
<a id="delbtnpaso2" type='button' onclick='borrarAllPaso2(2)' class='btn btn-xs btn-rojosuave' style='float:right;margin-top:-4px;margin-left:5px; <?=((empty($items_paso_2))?'display:none':'')?>'>Borrar Almacén Externo</a>
	</h4>
<table id='' class="table table-striped table-hover datatable tabla_informes_datatable"><thead>
<tr>

<th>Código Nacional</th>
<th>Nro Unidades</th>

</tr>
</thead>
<tbody>
<?php
//debug($items_paso_1['items']);
$cont = 0;
if(!empty($items_paso_2))
  foreach($items_paso_2 as $a)
  {
    $item_id = $a['cod_nacional']; 
    $style= "";
    
    echo "<tr class='fila_paso2 fila_datos' style='".$style."' id=''>";

    echo "<td>".$a['cod_nacional']."</td>";
    echo "<td>".$a['num_unidades']."</td>";

    
    /*echo utf8_encode("<td style='cursor:pointer;text-align:right;' class='news-list'>");
    
       echo "<span onclick='eliminarItem(".$item_id.")' class='icon bg-danger text-white' title='Eliminar'><i class='fa fa-trash'></i></span>";

    echo "</td>";*/
    echo "</tr>";
    $cont++;
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay Resultados ---</td></tr>";
?>
</tbody>
</table>

