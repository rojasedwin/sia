<form name='pedidos_filter' id='pedidos_filter' class='form_filter'>
<div class="paddingred_hijos mb-10">
   <div class="form-group col-sm-4">
                <label><strong>Realizado</strong></label>
                <select class="selectpicker"
                    data-style="btn-primary btn-sm"
                    data-width="100%"
                    tabindex="-1" name='buscar_pedido_realizado' id='pedido_realizado' title='Filtrar por estado' >
                    <option value='' >Cualquiera</option>
                    <option value='1' >Sí</option>
                    <option value='0'>No</option>

                  
                </select>  
               <input type='hidden' name='pedido_realizado' value='p.pedido_realizado'>        
    </div>  

    <div class="form-group col-sm-4">
                <label><strong>Proveedor</strong></label>
                <select class="selectpicker"
                    data-style="btn-info btn-sm"
                    data-width="100%"
					data-live-search=true
                    tabindex="-1" name='buscar_proveedor_id' id='proveedor_id' title='Filtrar por proveedor' >
                    <option value='' >Cualquiera</option>
                   <?php
				   if(!empty($proveedores)){
					   foreach($proveedores as $p){
						   echo "<option value=".$p['proveedor_id']." >".$p['proveedor_nombrecomercial']."</option>";
						   
					   }
					   
				   }
				   ?>

                  
                </select>  
               <input type='hidden' name='proveedor_id' value='pr.proveedor_id'>        
    </div>  
    
    

</div>
</form>
