function cargarItems(){

	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "json",
	   url: base_url+'provexterno/cargarItems/',
	   data: {},
	   success: function(res){
			 ocultar_alerta();
			  if(res.result==1){
				 $('#resultados_pedidos').html(res.html_pedidos);
				 loadWidzardForm('resultados_pedidos');
			  }
	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_pedidos').html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function marcarPedidoRealizado(item_id){
	vista="provexterno";
	loadAdeItem(item_id,"Marcar",1,"Gestión Pedidos","¿Desea marcar este pedido como realizado?","cargarItems()");
}

function fichaDetalleItem(item_id){
	 item_id = typeof item_id !== 'undefined' ? item_id : "";
	 mostrar_alerta("alerta_info","Guardando...por favor, espere");
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'provexterno/getFormDetalleItem',
			data: {item_id:item_id},
			success: function(html){
				ocultar_alerta();

				var options_css = {	'min-width': '95%'};
				var options_custom = {
			    'titulo': 'Detalle Pedidos',
				'boton_cancelar': '1',
			    'boton_cancelar_texto': 'Cancelar',
			    'boton_cancelar_class': 'btn-gray',
			    'boton_cancelar_callback': '',
			    'boton_guardar': '0',
			    'boton_guardar_texto': 'Guardar Almacén',
			    'boton_guardar_class': 'btn-warning',
			    'boton_guardar_callback': 'guardarItem()'
			  }

				lanzarWizardFormModal('modal_guardar_item',options_css,options_custom,html);


			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX



}


$( document ).ready(function() {

	cargarItems();

});
