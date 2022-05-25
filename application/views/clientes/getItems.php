<!--<table id='example1' class="table align-items-center table-flush table-hover" data-order="[[ 0, &quot;desc&quot; ]]" data-page-length='10'>-->
<table id='tableClientes' class="table align-items-center table-flush table-hover" >
<thead class="thead-light">
  <tr>
    <th>Nombre Cliente</th>
	 <th>Email</th>
    <th>Teléfono</th>
  


    <th style='' class='no-sort'>-</th>
  </tr>
</thead>
<tbody>
<?php
//debug($items['items']);
if(!empty($items['items']))
  foreach($items['items'] as $a)
  {
    $item_id = $a['cliente_id'];
    $class      = "";


    echo "<tr class='".$class."' id='fila_cliente-".$item_id."'>";
    echo "<td>".$a['cliente_nombre']."<br>".$a['cliente_rif']."</td>";
	echo "<td>".$a['cliente_email']."</td>";
    echo "<td>".$a['cliente_telefono']."</td>";



    echo "<td>";
	
	//echo '<button type="button" onclick="fichaItem('.$item_id.')" class="btn btn-block btn-outline-primary btn-sm">Editar</button>';
	
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
