<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Gestión de Usuarios</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form_datos_user" name="form_datos_user" method="POST">
			  <input type="hidden" name="user_id" id="user_id" value="<?=$item['user_id']?>">
			  <input type="hidden" name="original_email" id="original_email" value="<?=$item['user_email']?>">
                <div class="card-body">
				 <div class='form-group validation_inline nopadding' id='validation_item_errors'></div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control " id="user_email" name="user_email" placeholder="Enter email" value="<?=$item['user_email']?>">
                  </div>
				  
				   <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nombre" value="<?=$item['user_name']?>">
                  </div>
				  
				  <div class="form-group">
                    <label for="exampleInputEmail1">Apellidos</label>
                    <input type="text" class="form-control" id="user_lastname" name="user_lastname" placeholder="Apellidos" value="<?=$item['user_lastname']?>">
                  </div>
                  <div class="form-group">
					<?php
					if($item['user_id']==""){
					?>
                    <label for="exampleInputPassword1">Password</label>
					<?php
					}else{
						?>
					<label for="exampleInputPassword1">Cambiar Password</label>		
					<?php	
					}
					?>
                    <input type="password" class="form-control" name="pass"  id="pass" placeholder="Password">
                  </div>
                  
                  
                </div>
                <!-- /.card-body -->

               
              </form>
            </div>