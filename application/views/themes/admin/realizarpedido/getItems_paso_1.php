<h4 class='form_title_color'>Paso 1
 <a id="delbtnpaso1" type='button' onclick='borrarAllPaso1(1)' class='btn btn-xs btn-rojosuave' style='float:right;margin-top:-4px;margin-left:5px; <?=((empty($items_paso_1))?'display:none':'')?>'>Borrar todos los Excel Incrementales</a>
	</h4>

<table id='' class="table table-striped table-hover datatable tabla_informes_datatable"><thead>
<tr>

<th>Nombre Excel</th>
<th>Nro Registros</th>
<th style='width:50px;' class='no-sort'>-</th>
</tr>
</thead>
<tbody>
<?php
//debug($items_paso_1['items']);
$cont = 0;
if(!empty($items_paso_1))
  foreach($items_paso_1 as $a)
  {
    $item_id = $a['nombre_excel']; 
    $style= "";
    
    echo "<tr class='fila_paso1 fila_datos' style='".$style."' id=''>";

    echo "<td>".$a['nombre_excel']."</td>";
    echo "<td>".$a['num_registros']."</td>";

    
    echo utf8_encode("<td style='cursor:pointer;text-align:right;' class='news-list'>");
    
       echo "<span onclick='eliminarItem(\"".$item_id."\")' class='icon bg-danger text-white' title='Eliminar'><i class='fa fa-trash'></i></span>";
	   

    echo "</td>";
    echo "</tr>";
    $cont++;
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay Resultados ---</td></tr>";
?>
</tbody>
</table>


