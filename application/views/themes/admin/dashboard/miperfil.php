<!-- PERFILE // BEGIN -->
<?php

//inicializamos las variables que se van a usar en las lista de fechas
if ($this->session->userdata['user_fecha_nacimiento'] != "") {
  $fecha = $this->session->userdata['user_fecha_nacimiento'];

  $arrTmp = explode("-", $fecha);
  $year = $arrTmp[0];
  $mes = $arrTmp[1];
  $dia = $arrTmp[2];
} else {
  $year = '00';
  $mes = '00';
  $dia = '00';
}

if($this->input->post('fecha_nac_dia')!="") $dia = $this->input->post('fecha_nac_dia');
if($this->input->post('fecha_nac_mes')!="") $mes = $this->input->post('fecha_nac_mes');
if($this->input->post('fecha_nac_year')!="") $year = $this->input->post('fecha_nac_year');

$fecha = $year."-".$mes."-".$dia;

if($this->input->post('user_name')!=""){
  $user_name = $this->input->post('user_name');
}else{
  $user_name = $this->session->userdata['user_name'];
}

if($this->input->post('user_lastname')!=""){
  $user_lastname = $this->input->post('user_lastname');
}else{
  $user_lastname = $this->session->userdata['user_lastname'];
}

if($this->input->post('user_phone')!=""){
  $user_phone = $this->input->post('user_phone');
}else{
  $user_phone = $this->session->userdata['user_phone'];
}


?>

<div id='alerta' style='display:none;'>
  <div name='contenido_alerta' style='margin-top:5px;' class=" col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">

  </div>
</div>


<!-- <div class="content-wrap">
  <main id="content" class="content" role="main"> -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">



        <section class="widget">
          <header>

            <h4>Mi Perfil</h4>

          </header>
          <div style='margin-top:15px;' class="widget-body">
            <div class="row bg-gray-lighter">


              <!-- DIV SHOW ERRORS -->
              <div class="col-sm-12">
                <?php
                if (isset($error) and $error and $message != "") {
                  echo '<div class="alert alert-danger alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $message . '</div>';
                } elseif ($message != "") {
                  echo '<div class="alert alert-success alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $message . '</div>';
                }

                ?>
              </div>



              <!-- FORM DATA -->
              <?php
              $attributes = array('id' => 'form_perfil', 'name' => 'form_perfil');
              echo form_open('dashboard/save_profile', $attributes);
              ?>
              <div class='separador_30'></div>

              <!-- <form name='user_form' id='user_form'> -->
              <div class="form-group col-md-12 validation_inline" id='validation_user_errors'></div>
              <!-- <label for="">user_id</label> -->
              <input type='hidden' name='user_id' value='<?php echo $this->session->userdata['user_id']; ?>'>
              <!-- <label for="">user_imagen</label> -->
              <input type='hidden' name='user_imagen' id='user_imagen' value='<?php echo $this->session->userdata['user_imagen']; ?>'>
              <!-- <label for="">path_modificado</label> -->
              <input type='hidden' name='path_modificado' id='path_modificado' value='0'>
              <input type="hidden" id="x_wide" name="x_wide" />
              <input type="hidden" id="y_wide" name="y_wide" />
              <input type="hidden" id="w_wide" name="w_wide" />
              <input type="hidden" id="h_wide" name="h_wide" />

              <div class="col-md-6">
              <div class="form-group col-md-12">
                <label><strong>Email</strong></label>
                <input type="text" name='user_email' id='user_email' required class="form-control input-no-border" placeholder="Email" value='<?php echo $this->session->userdata['user_email']; ?>' readonly>
              </div>
              <div class="form-group col-md-12">
                <label><strong>Nombre</strong></label>
                <input type="text" name='user_name' id='user_name' class="form-control input-no-border" placeholder="Nombre" value='<?php echo $user_name; ?>'>
              </div>
              <div class="form-group col-md-12">
                <label><strong>Apellido</strong></label>
                <input type="text" name='user_lastname' id='user_lastname' class="form-control input-no-border" placeholder="Apellido" value='<?php echo $user_lastname; ?>'>
              </div>
              <div class="form-group col-md-12">
                <label><strong>Teléfono</strong></label>
                <input type="text" name='user_phone' id='user_phone' class="form-control input-no-border" placeholder="Teléfono" value='<?php echo $user_phone; ?>'>
              </div>
              <div class="form-group col-md-12 nopadding_hijos">
                <label><strong>Fecha Nacimiento</strong></label>

                <div class="col-md-12 nopadding_hijos">
                  <div class="form-group col-md-4">


                      <label for="fecha_nac_dia">Dia</label>

                      <?php
                      $selected = $dia;
                      $control_name = 'fecha_nac_dia';

                      $options = array();
                      $options['00'] = '--';

                      for ($i = 1; $i <= 31; $i++) {
                        # code...
                        if ($i <= 9) {
                          $options['0' . $i] = '0' . $i;
                        } else {
                          $options[$i] = $i;
                        }
                      }

                      $attr = array(
                        'name' => $control_name,
                        'id' => $control_name,
                        'class' => 'form-control input-no-border',
                        'data-style' => 'btn-primary data-live-search="true" width=100% data-width="100%" data-container="body"
                        tabindex="-1"'
                      );

                      echo form_dropdown($control_name, $options, $selected, $attr);

                      ?>


                  </div>
                  <div class="form-group col-md-4">

                      <label for="">Mes</label>
                      <?php
                      $selected = $mes;
                      $control_name = 'fecha_nac_mes';

                      $options = array();
                      $options['00'] = '--';

                      for ($i = 1; $i <= 12; $i++) {
                        # code...
                        if ($i <= 9) {
                          $options['0' . $i] = '0' . $i;
                        } else {
                          $options[$i] = $i;
                        }
                      }

                      $attr = array(
                        'name' => $control_name,
                        'id' => $control_name,
                        'class' => 'form-control input-no-border',
                        'data-style' => 'btn-warning'
                      );

                      echo form_dropdown($control_name, $options, $selected, $attr);

                      ?>

                  </div>
                  <div class="form-group col-md-4">

                      <label for="">Año</label>
                      <?php
                      $selected = $year;
                      $control_name = 'fecha_nac_year';

                      $options = array();
                      $options['00'] = '--';
                      $anio_ini = date("Y") - 18;
                      $anio_fin = date("Y") - 65;
                      for ($i = $anio_ini; $i >= $anio_fin; $i--) {
                        # code...
                        $options[$i] = $i;
                      }

                      $attr = array(
                        'name' => $control_name,
                        'id' => $control_name,
                        'class' => 'form-control input-no-border maxheigh-450',
                        'data-style' => 'btn-success'

                      );

                      echo form_dropdown($control_name, $options, $selected, $attr);

                      ?>
                      <input type="hidden" name="user_fecha_nacimiento" id="user_fecha_nacimiento" value="<?php echo cambiar_formato($fecha); ?>">

                  </div>
                </div>
              </div>



            </div> <!-- Columna izquierda -->
              <div class="col-md-6 text-center">
                <div id='contenedor_preview' style='display:block;margin:auto;' class='preview_cartel_evento text-center'>
                  <div id='preview_cartel' class='text-center' style='height:250px;'>
                    <?php
                    if ($this->session->userdata['user_imagen'] != "")
                      echo "<img id='target_wide' style='border-radius:50%'  src='/attachments/perfil_usuario/" . $this->session->userdata['user_imagen'] . "'>";
                    else
                      echo "<img id='target_wide' src='/attachments/web/user_image_default.png?1.1'>";
                    ?>
                  </div>
                  <img id='icono_eliminar' class='icono_absolute' style='<?php echo ($this->session->userdata['user_imagen'] == "") ? "display:none;" : ""; ?>' src='/attachments/remove.png'>
                </div>
                <br>
                <div onclick='$("#user_object").trigger("click");' class='btn btn-success'>Subir Imagen
                </div>
                <div class="col-md-12 text-left" style='margin-top:10px;'>
                  <label for="user_about"><strong>Cuéntanos más de ti...</strong></label>
                  <textarea id="user_about" name="user_about" class="md-textarea form-control" rows="6" placeholder="Cargo que ocupa, aficiones..."><?php
                      if($this->input->post("user_about")!=""){
                        echo trim($this->input->post("user_about"));
                      }else{
                        echo trim($this->session->userdata['user_about']);
                      }
                    ?></textarea>
                </div>

              </div>
              <!-- CHECKBOX CAMBIAR CLAVE -->
              <div class="form-group  custom-control custom-checkbox col-md-12 ">
                <?php


                if ($cambiarclave == "1") {
                  $show_inputs = 'style="margin:0px;"';
                  echo '<input type="checkbox" class="custom-control-input" id="cambiarclave" name="cambiarclave" value="1" checked>';
                } else {
                  $show_inputs = 'style="display:none;margin:0px;"';
                  echo '<input type="checkbox" class="custom-control-input" id="cambiarclave" name="cambiarclave" value="1">';
                }


                ?>

                <label class="custom-control-label" for="defaultUnchecked">Cambiar Contraseña</label>

                <!-- INPUTS CAMBIO CLAVE -->
                <div <?php echo $show_inputs ?>  name='pantalla_inputs_clave' id='pantalla_inputs_clave' class="">

                  <div class="form-group col-md-6">
                    <label><strong>Nueva contraseña</strong></label>
                    <input class="form-control input-no-border" type="text" name="nuevapass1" id="nuevapass1" class="form-control" placeholder="Nueva Contraseña" value=''>
                  </div>
                  <div class="form-group col-md-6">
                    <label><strong>Confirme contraseña</strong></label>
                    <input class="form-control input-no-border" type="text" name="nuevapass2" id="nuevapass2" class="form-control" placeholder="Confirmar..." value=''>
                  </div>
                  <div style='clear:both;height:1px;'>&nbsp;</div>
                </div>

                <!-- BOTONERA -->
                <!-- <?php echo "userdata: " . $this->session->userdata['usermagd']; ?> -->


              </div>

              <div class="form-group  custom-control custom-checkbox col-md-12 text-center">
                <input type="submit" class="btn btn-info mb-xs" id="btnGuardar" name="btnGuardar" value="Guardar">
                <a style='' class='btn btn-inverse  mb-xs' href='/dashboard'>Cerrar Ficha</a>
              </div>

              </form>

              <!-- FORM FOTO -->
              <iframe name="cartel_evento" id="cartel_evento" name="cartel_evento" style="display:none"></iframe>
              <form name="cambio_foto_cartel" id="change_user_object" action="<?php echo base_url(); ?>dashboard/subirObjeto" enctype="multipart/form-data" target="cartel_evento" method="post">
                <input style='width:286px;display:none;' type='file' name='user_object' id='user_object'>
                <input type='hidden' id='path_subido' name='path_subido' value=''>
                <input type='hidden' name='tipo_imagen' value='wide'>
              </form>

            </div>

          </div>
        </section>




      </div>
    </div>
  <!-- </main>
</div> -->

<!-- PERFILE // END -->
