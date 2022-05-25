<!--<table id='example1' class="table align-items-center table-flush table-hover" data-order="[[ 0, &quot;desc&quot; ]]" data-page-length='10'>-->
<style>
table.tabla_informes_datatable thead th{
  background-color:#da9e23 !important;
  color:#fff;
  font-weight: bold;
  padding:5px 7px !important;
  font-size: 13px;
}
table.tabla_informes_datatable tbody{
  border:1px solid #d2d2d2;
}
table.tabla_informes tbody{
  border:1px solid #d2d2d2;
  border-right: 2px solid #d2d2d2;
}
table.tabla_informes_datatable thead tr  th:last-child{
  border-top-right-radius: 1em;
}
table.tabla_informes_datatable thead tr  th:first-child{
  border-top-left-radius: 1em;
}
table.tabla_informes_datatable{
  border-collapse: collapse !important;
  border-radius: 1em;
}
</style>
<table id='example1' class="table align-items-center table-hover table-bordered" >
<thead class="thead-light">
  <tr>
    <th>Usuario</th>
	 <th>Email</th>
   
  


    <th style='width:120px' class='no-sort'>-</th>
  </tr>
</thead>
<tbody>
<?php
//debug($items['items']);
if(!empty($items['items']))
  foreach($items['items'] as $a)
  {
    $item_id = $a['user_id'];
    $class      = "";


    echo "<tr class='".$class."' id='fila_almacen-".$item_id."'>";
    echo "<td>".$a['user_name']." ".$a['user_lastname']."</td>";
	echo "<td>".$a['user_email']."</td>";

    echo "<td>";
	
	
	echo '<a type="button" onclick="fichaItem('.$item_id.')" class="btn btn-info btn-sm" style="margin-right:5px;">
            <i class="fas fa-edit" ></i>
        </a>';
	
	echo '<a type="button" onclick="deleteItem('.$item_id.')" class="btn btn-danger btn-sm" style="margin-right:5px;">
            <i class="fas fa-trash"></i>
       </a>';
	
    echo "</td>";
    
	echo "</tr>";
  }
else
 echo "<tr><td colspan='9' style='text-align:center;'>--- No hay resultados ---</td></tr>";
?>
</tbody>
</table>

