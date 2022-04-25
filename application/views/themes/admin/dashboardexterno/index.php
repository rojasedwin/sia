<div class="col-sm-12">
  <?php
    if(isset($error) and $error and $message!="")
    {
      echo '<div class="alert alert-danger alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$message.'</div>';
    }
    elseif($message!="")
    {
      echo '<div class="alert alert-success alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$message.'</div>';
    }
   ?>
</div>
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
        <div class="row"  name='pantalla_principal' id='pantalla_principal'>

   		  <div class="col-md-12">
   		  <section class="widget">
               <header>
                   <h4>Dashboard Proveedor Externo
					
			        </h4>
					<div style='clear:both;height:10px;'>&nbsp;</div>
					<div class="form-group <?=$bootstrap['col-12']?> text-center">
					
					</div>
               </header>
			    <div style='clear:both;height:20px;'>&nbsp;</div>
				
				<div style='' class="widget-body" id='resultados_pedidos' style="">
				
				</div>
				
				
				
   			</section>
   		  </div>
   		 </div> <!-- Pantalla -->


         </main>
</div>
