function cargarItems()
{
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'proveedores/getItems/',
	   data: {},
	   success: function(res){
			$('#resultados_proveedores').html(res);
			 loadWidzardForm('resultados_proveedores');

			 $('#cuerpo_sorttable').sortable({
				revert: true,
				handle: '.handle',
				update: function( event, ui ) {
				  var lista_id = '';
				  $(this).children().each(function(index) {
					lista_id = lista_id + $(this).find('[id^=celda_item-]').attr('value') + ':';
				  });
				  lista_id = lista_id.slice(0, -1);
				  console.log(lista_id);
				  ordenar(lista_id);
				 }
			  });


	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_proveedores').html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
	
	
	
}
function fichaItem(proveedor_id){
	proveedor_id = typeof proveedor_id !== 'undefined' ? proveedor_id : "";

	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $('#validation_proveedor_errors').html('');
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'proveedores/getFormItem',
			data: {proveedor_id:proveedor_id},
			success: function(html){
				ocultar_alerta();

				var options_css = {	'min-width': '85%'};
				var options_custom = {
			    'titulo': 'Ficha Proveedor',
					'boton_cancelar': '1',
			    'boton_cancelar_texto': 'Cancelar',
			    'boton_cancelar_class': 'btn-gray',
			    'boton_cancelar_callback': '',
			    'boton_guardar': '1',
			    'boton_guardar_texto': 'Guardar',
			    'boton_guardar_class': 'btn-success',
			    'boton_guardar_callback': 'guardarItem()'
			  }
				lanzarWizardFormModal('modal_guardar_item',options_css,options_custom,html);
			

			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX

}

function guardarItem(){
  mostrar_alerta("alerta_info","Guardando...por favor, espere");
  $('#validation_proveedor_errors').html('');
  
  
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'proveedores/saveItem',
     data: $('[name=proveedor_form_item]').serialize()
     ,
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
		   $('#proveedor_id').val(res.proveedor_id);
         mostrar_alerta("alerta_correcto","Datos guardados",1000,function(){
           $('.modal').modal('hide');
           cargarItems();
         });
       }
       else {
          $('#validation_proveedor_errors').html(res.message);
       }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function activarItem(item_id){
	vista="proveedores";
	loadAdeItem(item_id,"Activar",1,"Activar Proveedor","Se activará el Proveedor","cargarItems()");
	
}

function desactivarItem(item_id){
	vista="proveedores";
	loadAdeItem(item_id,"Desactivar",1,"Desactivar Proveedor","Se desactivará el Proveedor y no será público","cargarItems()");
	

}

function ordenar(lista_id){
	mostrar_alerta("alerta_info","Ordenando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'proveedores/ordenar',
	   data:{lista_id : lista_id},
	   success: function(res){
		 ocultar_alerta();
		 if(res.result==1)
		 {
		   mostrar_alerta("alerta_correcto","Ordenación realizada.",1000,function(){
		   });
		 }
		 else {
			$('#validation_item_errors').html(res.message);
		 }
	   },
	   error: function(){
		mostrar_alerta("alerta_error","Problemas de red...",1500);
	  }
	  }); //AJAX
  }

$( document ).ready(function() {
cargarItems();
});
