<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Gestión de Clientes</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form_datos_cliente" name="form_datos_cliente" method="POST">
			  <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$item['cliente_id']?>">
			  <input type="hidden" name="original_email" id="original_email" value="<?=$item['cliente_email']?>">
                <div class="card-body">
				 <div class='form-group validation_inline nopadding' id='validation_item_errors'></div>
                 
				  
				   <div class="form-group">
                    <label for="exampleInputEmail1">Razón Social</label>
                    <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" placeholder="Razón Social" value="<?=$item['cliente_nombre']?>">
                  </div>
				  
				  <div class="form-group">
                    <label for="exampleInputEmail1">RIF</label>
                    <input type="text" class="form-control" id="cliente_rif" name="cliente_rif" placeholder="RIF" value="<?=$item['cliente_rif']?>">
                  </div>
				  
				   <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control " id="cliente_email" name="cliente_email" placeholder="Enter email" value="<?=$item['cliente_email']?>">
                  </div>
				  
				   <div class="form-group">
                    <label for="exampleInputEmail1">Teléfono</label>
                    <input type="text" class="form-control " id="cliente_telefono" name="cliente_telefono" placeholder="Teléfono" value="<?=$item['cliente_telefono']?>">
                  </div>
                  
                  
                </div>
                <!-- /.card-body -->

               
              </form>
            </div>