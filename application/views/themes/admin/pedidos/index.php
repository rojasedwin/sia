<script>
var vista = "<?=$this->vista?>";
</script>
<div class="content-wrap">
  <main id="content" class="content" role="main">
    <div class="row"  name='pantalla_principal' id='pantalla_principal'>
      <div class="<?=$bootstrap['col-12']?>">
        <section class="widget">
          <header>
           <h4>Gestión de Pedidos
             <!--<button class='btn btn-amarillosuave boton_flotante_pantallas' title='New product' onclick='fichaItem()'>+ Nuevo Producto</button>-->
			
           </h4>
         </header>
         <div class="widget-body mt">
           <?php
             $this->load->view('themes/'.$this->config->item('app_theme_admin')."/".$this->vista."/filter");
           ?>
         </div>
         <div class="widget-body mt-40">
            <div class="row"  name='pantalla_principal' style='margin:0px;' id='resultados_pedidos'>
            </div> <!-- Pantalla Principal -->
            <!-- Pantalla Principal -->

         </div>
      </section>
    </div>
  </div>
  <div class="row"  name='pantalla_principal' style='display:none;margin:0px;' id='formulario_pedido'></div>


</main>
</div>