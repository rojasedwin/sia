<table id='' class="table table-striped table-hover datatable tabla_informes_datatable"><thead>
<tr>

<th>CIF</th><th>Nombre</th><th>Teléfono</th><th>Email</th><th>Dirección</th><th style='width:110px;' class='no-sort'>-</th></tr>
</thead>
<tbody id='cuerpo_sorttable' class='ui-sortable'>
<?php
$cont = 0;
if(!empty($items['items']))
  foreach($items['items'] as $a)
  {
    $idlaboratorio = $a['laboratorio_id']; $style= "";
    if($a['laboratorio_activo']==0) $style='background-color:#d2d2d2';
    echo "<tr class='fila_laboratorio fila_datos' style='".$style."' id='fila_laboratorio-".$idlaboratorio."'>";

   

    echo "<td>".$a['laboratorio_cif']."</td>";
    echo "<td>".$a['laboratorio_nombrecomercial']."</td>";

    echo "<td>".$a['laboratorio_telefono']."</td>";
    echo "<td>".$a['laboratorio_email']."</td>";
    echo "<td>";
    echo $a['laboratorio_direccion'].(($a['laboratorio_cp']!="")?"<br>".$a['laboratorio_cp']:"").(($a['laboratorio_poblacion']!="")?"<br>".$a['laboratorio_poblacion']:"");
    echo "</td>";
    echo utf8_encode("<td style='cursor:pointer;text-align:right;' class='news-list'>");
    echo "<span onclick='fichaItem(".$idlaboratorio.")' class='icon bg-primary text-white' title='Edit'><i class='fa fa-pencil'></i></span>";
    if($a['laboratorio_activo']==1)
      echo "<span onclick='desactivarItem(".$idlaboratorio.")' class='icon bg-warning text-white' title='Block User'><i class='fa fa-lock'></i></span>";
    else {
      echo "<span onclick='activarItem(".$idlaboratorio.")' class='icon bg-success text-white' title='Unblock User'><i class='fa fa-unlock'></i></span>";
    }
    //echo "<span onclick='eliminar_laboratorio(".$idlaboratorio.")' class='icon bg-danger text-white' title='Edit'><i class='fa fa-trash'></i></span>";
    echo "</td>";
    echo "</tr>";
    $cont++;
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay Laboratorios ---</td></tr>";
?>
</tbody>
</table>
