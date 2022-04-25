
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">

        <div class=""  name='pantalla_principal' id='pantalla_principal'>
        <!--<ol class="breadcrumb">
            <li>Bienvenido</li>
            <li class="active"><?php echo ucwords($this->session->userdata('nombreUsuario'));?></li>
        </ol>
      -->
    <?php
      if(isset($error_404) and $error_404!="")
      {
        ?>
        <div class="alert alert-danger alert-sm">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <span class="fw-semi-bold">Pagina No Encontrada:</span> Compruebe la url.
        </div>
        <?php
      }
      if(isset($mensaje))
      {
         ?>
         <div class="alert alert-<?php echo $mensaje_tipo;?> alert-sm">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <span class="fw-semi-bold"><?php echo $mensaje;?></span>
         </div>
         <?php
      }
     
    ?>
    <input type='hidden' id='pantalla_dashboard' value='1'>
    <section class="widget">
       <header>
           <h4>pedidoslab Dashboard - Bienvenido <b><?php echo ucwords($this->session->user_name);?></b></h4>
       </header>
    
         <div style='margin-top:20px;' class="widget-body" >

             <div class="form-group <?=$bootstrap['col-12']?>" style='padding-left:0px;'>
              <a class='btn btn-warning  ' title='Proveedores' href='<?=base_url()?>adminsite/proveedores'>Proveedores</a>
              <a class='btn btn-info  ' title='Laboratorio' href='<?=base_url()?>adminsite/laboratorios'>Laboratorios</a>
              <a class='btn btn-primary  ' title='Condiciones' href='<?=base_url()?>adminsite/condiciones'>Condiciones</a>
              <a class='btn btn-inverse  ' title='Pedidos' href='<?=base_url()?>adminsite/pedidos'>Pedidos</a>
              <a class='btn btn-rojosuave  ' title='Realizar Pedidos' href='<?=base_url()?>adminsite/realizarpedido'>Realizar Pedido</a>

              
             </div>
            
        </div>
           <div style='clear:both;height:1px'>&nbsp;</div>
 
       
      </section>

  </div>  <!-- Pantalla PRINCIPAL -->
  <div class="row"  name='pantalla_principal' id='pantalla_datos_cliente' style='display:none;'></div>
   </main>
</div>

