function cargarItems()
{
	
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'condiciones/getItems/',
	   data: $('[name=condiciones_filter]').serialize(),
	   success: function(res){
			$('#resultados_condiciones').html(res);
			 loadWidzardForm('resultados_condiciones');


			
			 
	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_condiciones').html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
	
	
	
}
function fichaItem(condicion_id){
	condicion_id = typeof condicion_id !== 'undefined' ? condicion_id : "";

	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $('#validation_condicion_errors').html('');
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'condiciones/getFormItem',
			data: {condicion_id:condicion_id},
			success: function(html){
				ocultar_alerta();

				var options_css = {	'min-width': '65%'};
				var options_custom = {
			    'titulo': 'Ficha Condición',
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
  $('#validation_condicion_errors').html('');
  
  
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'condiciones/saveItem',
     data: $('[name=condiciones_form_item]').serialize()
     ,
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
		   $('#condicion_id').val(res.condicion_id);
         mostrar_alerta("alerta_correcto","Datos guardados",1000,function(){
           $('.modal').modal('hide');
           cargarItems();
         });
       }
       else {
          $('#validation_condicion_errors').html(res.message);
       }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function activarItem(item_id){
	vista="condiciones";
	loadAdeItem(item_id,"Activar",1,"Activar Condición","Se activará la Condición","cargarItems()");
	
}

function desactivarItem(item_id){
	vista="condiciones";
	loadAdeItem(item_id,"Desactivar",1,"Desactivar Condición","Se desactivará la Condición y no será público","cargarItems()");
	

}

function eliminarItem(item_id){
	vista="condiciones";
	loadAdeItem(item_id,"Eliminar",1,"Eliminar Productos","¿Desea eliminar los productos asociados?","cargarItems()");
	

}

function importarExcelCondicion(condicion_id){
	
	$("#file_condiciones").trigger('click');

	$("#file_condiciones").change(function (e) {
		
		$('#aux_condicion_id').val(condicion_id);
		
		mostrar_alerta("alerta_info","Procesando...por favor, espere");
		$('#upload_condiciones_form').submit();
	});

}

function respuestaFicheroImportado(response){

	ocultar_alerta();
  if(response.result==1){
	/* $('#mensajecondiciones').show();
	  $('#respuesta_importar_fichero').text("Se han realizado "+response.lineas_procesados+" nuevas inserciones");*/
	  mostrar_alerta("alerta_correcto","Se han realizado "+response.lineas_procesados+" nuevas inserciones",1500);
	  cargarItems();
		
  }
  else {
    	mostrar_alerta("alerta_error",response.message,1500);
		$('#file_condiciones').val('')
  }

}



$( document ).ready(function() {
cargarItems();
loadSearchForm("condiciones_filter",cargarItems);
});
