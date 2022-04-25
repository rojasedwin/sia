
    <div class="row form_reduced form_color_inputs pestania_proyecto pestania_acelerador">
        <div class="<?=$bootstrap['col-12']?>" id="contenedor_confirmar_pedido">
          <form name='pedido_total' id='pedido_total'>
            <?php

              if(isset($pedido['cn_necesarios']) and !empty($pedido['cn_necesarios']))
              {
                ?>
                <h4 class='form_title_color'>Productos que quedan fuera del pedido</h4>
                <div class="<?=$bootstrap['col-12']?>">
                  <table class="table table-striped  table-hover mt tabla_informes_datatable" data-order="[[ 0, &quot;desc&quot; ]]">
                    <thead>
                    <tr>
                      <th>Cod. Nacional</th>
                      <th>Nombre</th>
                      <th>Unidades fuera de pedido</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($pedido['cn_necesarios'] as $cod_nacional=>$datos_ped)
                    {
                      ?>
                      <tr>
                        <td><?=$cod_nacional?></td>
                        <td><?=$datos_ped['nombre']?></td>
                        <td><?=$datos_ped['unidades']?></td>
                      </tr>
                      <?php
                    }

                     ?>
                  </tbody>
                  </table>
                </div>
                <?php
              }



              foreach($pedido['proveedores'] as $prov_id=>$datos_prov)
              {
                ?>
                <h4 class='form_title_color'>Pedido proveedor: <?=$datos_prov['proveedor_nombrecomercial']?></h4>
                <div class="<?=$bootstrap['col-6']?>">
                  <table class="table table-striped  table-hover mt tabla_informes_datatable" data-order="[[ 0, &quot;desc&quot; ]]">
                    <thead>
                    <tr>
                      <th>Cod. Nacional</th>
                      <th>Uds. Pedir</th>
                      <th>Uds. Obtener</th>
                      <th>Importe</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if(!empty($datos_prov['pedido']['productos']))
                      {
                        foreach($datos_prov['pedido']['productos'] as $cod_nacional=>$datos_ped)
                        {
                          if($datos_ped['unidades_pedir']!=0)
                          {
                            ?>
                            <tr>
                              <td><?=$cod_nacional?></td>
                              <td><?=$datos_ped['unidades_pedir']?></td>
                              <td><?=$datos_ped['unidades_obtener']?></td>
                              <td><?=formatear_numero_factura($datos_ped['unidades_pedir']*$datos_ped['pvp'],2)?></td>
                            </tr>
                            <?php
                          }
                        }
                      }
                      else {
                        echo "<tr><td colspan='4'>--Sin productos --</td></tr>";
                      }
                     ?>
                  </tbody>
                  </table>
                </div>
                <div class="<?=$bootstrap['col-6']?>">
                  <table class="table table-striped  table-hover mt tabla_informes_datatable" data-order="[[ 0, &quot;desc&quot; ]]">
                  	<thead>
                    <tr>
                      <th>Condiciones</th>
                      <th>Promoción</th>
                      <th>Pedir</th>
                      <th>Obtener</th>
                      <th>-</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if(!empty($datos_prov['pedido']['condiciones']))
                      {
                        foreach($datos_prov['pedido']['condiciones'] as $condicion_id=>$datos_cond)
                        {
                          $class="verde_suave";
                          $texto_no = "";
                          if($datos_cond['unidades_min']>$datos_cond['unidades_pedir'])
                          {
                            $texto_no = "Faltan ".($datos_cond['unidades_min'] - $datos_cond['unidades_pedir'])." uds.";
                            $class='rojo_suave';
                          }
                          if($datos_cond['eur_min']>$datos_cond['importe'])
                          {
                            if($texto_no!="") $texto_no .= "<br>";
                            $texto_no .= "Faltan ".formatear_numero_factura($datos_cond['eur_min'] - $datos_cond['importe'],2)."€";
                            $class='rojo_suave';
                          }
                          ?>
                          <tr class='<?=$class?>'>
                            <td><?=$datos_cond['nombre']?></td>
                            <td>
                            <?php
                              if($datos_cond['condicion_cantidad_descuento']!=0)
                              {
                                if($datos_cond['condicion_tipo_descuento']==0) echo "Dcto ".$datos_cond['condicion_cantidad_descuento']."%";
                                if($datos_cond['condicion_tipo_descuento']==1) echo "Dcto ".$datos_cond['condicion_cantidad_descuento']."€";
                                echo "<br>";
                              }
                              if($datos_cond['unidades_regalo_oferta']!=0)
                              {
                                echo "Promoción por cada ".$datos_cond['unidades_oferta']." de regalo ".$datos_cond['unidades_regalo_oferta'];
                              }
                            ?>
                           </td>
                              <td><?=$datos_cond['unidades_pedir']?></td>
                              <td><?=$datos_cond['unidades_obtener']?></td>
                            <td><?=$texto_no?></td>
                          </tr>
                          <?php
                        }
                      }
                      else {
                        echo "<tr><td colspan='2'>--Sin condiciones --</td></tr>";
                      }
                     ?>
                  </tbody>
                </table>

                </div>
                <div style='clear:both;height:1px;'>&nbsp;</div>
                <?php


              }

             ?>

            <div style='clear:both;height:1px;'>&nbsp;</div>
          </form>
        </div>
    </div>
