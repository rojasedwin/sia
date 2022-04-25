
<div class="content-wrap">
    <!-- main page content. the place to put widgets in. usually consists of .row > .col-md-* > .widget.  -->
    <main id="content" class="content" role="main">
    <section class="widget">
           <header>
               <h4>Gestión Condiciones
                 <button style='float:right;margin-left:10px;' class='btn btn-warning  mb-xs' title='New Condición' onclick='fichaItem()'>+ Nueva Condición</button>
               </h4>
           </header>
           <div class="widget-body mt">
       <?php
         $this->load->view('themes/'.$this->config->item('app_theme_admin')."/condiciones/filter");
       ?>
     </div>
           <div style='margin-top:20px;' class="widget-body">
           <div style='clear:both;height:10px;'>&nbsp;</div>
	
	
            <div id='mensajecondiciones' class="importar_content" style='display:none'>
            
                <div  class="importar_left">
                    <div id='' class="alert alert-warning ">
                      
                      <p id="respuesta_importar_fichero"></p>
                    </div>
                    
                </div>
                
            </div>

              <div class="row"  name='resultados_condiciones' style='margin:0px;' id='resultados_condiciones'>
              </div> <!-- Pantalla Principal -->

            </div>
          </section>
         </main>
</div>

