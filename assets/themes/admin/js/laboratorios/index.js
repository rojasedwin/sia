function cargarItems()
{
	
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'laboratorios/getItems/',
	   data: {},
	   success: function(res){
			$('#resultados_laboratorios').html(res);
			 loadWidzardForm('resultados_laboratorios');

			 
	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_laboratorios').html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
	
	
	
}
function fichaItem(laboratorio_id){
	laboratorio_id = typeof laboratorio_id !== 'undefined' ? laboratorio_id : "";

	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $('#validation_laboratorio_errors').html('');
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'laboratorios/getFormItem',
			data: {laboratorio_id:laboratorio_id},
			success: function(html){
				ocultar_alerta();

				var options_css = {	'min-width': '85%'};
				var options_custom = {
			    'titulo': 'Ficha Laboratorio',
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
  $('#validation_laboratorio_errors').html('');
  
  
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'laboratorios/saveItem',
     data: $('[name=laboratorio_form_item]').serialize()
     ,
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
		   $('#laboratorio_id').val(res.laboratorio_id);
         mostrar_alerta("alerta_correcto","Datos guardados",1000,function(){
           $('.modal').modal('hide');
           cargarItems();
         });
       }
       else {
          $('#validation_laboratorio_errors').html(res.message);
       }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function activarItem(item_id){
	vista="laboratorios";
	loadAdeItem(item_id,"Activar",1,"Activar laboratorio","Se activará el Laboratorio","cargarItems()");
	
}

function desactivarItem(item_id){
	vista="laboratorios";
	loadAdeItem(item_id,"Desactivar",1,"Desactivar laboratorio","Se desactivará el Laboratorio y no será público","cargarItems()");
	

}


$( document ).ready(function() {
cargarItems();
});
