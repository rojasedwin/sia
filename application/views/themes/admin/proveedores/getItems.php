
<table id='' class="table table-striped table-hover datatable tabla_informes_datatable"><thead>
<tr>
<th style='width:50px;' class='no-sort'>-</th>  
<th>CIF</th><th>Nombre</th><th>Teléfono</th><th>Email</th><th>Dirección</th><th style='width:110px;' class='no-sort'>-</th></tr>
</thead>
<tbody id='cuerpo_sorttable' class='ui-sortable'>
<?php
$cont = 0;
if(!empty($items['items']))
  foreach($items['items'] as $a)
  {
    $idproveedor = $a['proveedor_id']; $style= "";
    if($a['proveedor_activo']==0) $style='background-color:#d2d2d2';
    echo "<tr class='fila_proveedor ui-sortable-handle handle fila_datos' style='".$style."' id='fila_proveedor-".$idproveedor."'>";

    echo "<td id='celda_item-".$idproveedor."' value='".$idproveedor ."'><i class='fa fa-sort-amount-desc bg-success text-white handle ui-sortable-handle' style='border-radius:50%;width:30px;height:30px;text-align:center;padding-top:8px'></i></td>";

    echo "<td>".$a['proveedor_cif']."</td>";
    echo "<td>".$a['proveedor_nombrecomercial']."</td>";

    echo "<td>".$a['proveedor_telefono']."</td>";
    echo "<td>".$a['proveedor_email']."</td>";
    echo "<td>";
    echo $a['proveedor_direccion'].(($a['proveedor_cp']!="")?"<br>".$a['proveedor_cp']:"").(($a['proveedor_poblacion']!="")?"<br>".$a['proveedor_poblacion']:"");
    echo "</td>";
    echo utf8_encode("<td style='cursor:pointer;text-align:right;' class='news-list'>");
    echo "<span onclick='fichaItem(".$idproveedor.")' class='icon bg-primary text-white' title='Edit'><i class='fa fa-pencil'></i></span>";
    if($a['proveedor_activo']==1)
      echo "<span onclick='desactivarItem(".$idproveedor.")' class='icon bg-warning text-white' title='Block User'><i class='fa fa-lock'></i></span>";
    else {
      echo "<span onclick='activarItem(".$idproveedor.")' class='icon bg-success text-white' title='Unblock User'><i class='fa fa-unlock'></i></span>";
    }
    //echo "<span onclick='eliminar_proveedor(".$idproveedor.")' class='icon bg-danger text-white' title='Edit'><i class='fa fa-trash'></i></span>";
    echo "</td>";
    echo "</tr>";
    $cont++;
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay Proveedores ---</td></tr>";
?>
</tbody>
</table>
