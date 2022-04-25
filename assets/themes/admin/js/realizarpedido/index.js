function cargarItems(){
	mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'realizarpedido/getItems/',
	   data: {},
	   success: function(res){
		ocultar_alerta();	
		if(res.result==1)
       {
			$('#resultados_paso_1').html(res.html_paso_1);
			$('#resultados_paso_2').html(res.html_paso_2);
			loadWidzardForm('resultados_paso_1');
			loadWidzardForm('resultados_paso_2');
			
	   }

			
			 
	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_paso_1').html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
	
	
	
}


function eliminarItem(item_id){
	vista="realizarpedido";
	loadAdeItem(item_id,"Eliminar",1,"Eliminar Stock Incremental","¿Desea eliminar el Stock Incremental?","cargarItems()");
	

}

function importarPaso(paso_id){
	
	$("#file_paso_"+paso_id).trigger('click');

	$("#file_paso_"+paso_id).change(function (e) {
		
		$('#aux_paso_'+paso_id).val(paso_id);
		mostrar_alerta("alerta_info","Procesando...por favor, espere");
		$('#upload_paso_'+paso_id).submit();
	});

}

function respuestaFicheroImportado(response){

	ocultar_alerta();
  if(response.result==1){

	$('#resultados_paso_'+response.paso_id).html(response.html_paso);
	$('#file_paso_'+response.paso_id).val('')
	  mostrar_alerta("alerta_correcto","Se han realizado "+response.lineas_procesados+" nuevas inserciones",1500);

	  $('#file_paso_'+response.paso_id).val('');

	  loadWidzardForm('resultados_paso_'+response.paso_id);

	 
		
  }
  else {
    	mostrar_alerta("alerta_error",response.message,1500);
		$('#file_paso_'+response.paso_id).val('');
  }

}

function borrarAllPaso1(item_id){
	/*vista="realizarpedido";
	loadAdeItem(item_id,"Eliminar Incrementales",1,"Eliminar Excel Incrementales","¿Desea eliminar los ficheros excel Incrementales?","cargarItems()");
	$('#delbtnpaso1').hide();*/
	 $('#modal_delete_all #titleMensaje').text('Eliminar Excel Incrementales');
	 $('#modal_delete_all #btnDelete').text('Eliminar Incrementales');
	 $('#modal_delete_all #contenido_form').text('¿Desea eliminar los ficheros excel Incrementales?');
	 $('#modal_delete_all #item_id').val(item_id);
	 $('#modal_delete_all #item_id_accion').val('Eliminar Incrementales');
	 $('#modal_delete_all').modal('show');
}

function borrarAllPaso2(item_id){
	/*vista="realizarpedido";
	loadAdeItem(item_id,"Eliminar Almacén Externo",1,"Eliminar Almacén Externo","¿Desea eliminar Almacén Externo?","cargarItems()");
	$('#delbtnpaso2').hide();*/
	 $('#modal_delete_all #titleMensaje').text('Eliminar Almacén Externo');
	 $('#modal_delete_all #btnDelete').text('Eliminar Almacén Externo');
	 $('#modal_delete_all #contenido_form').text('¿Desea eliminar Almacén Externo?');
	 $('#modal_delete_all #item_id').val(item_id);
	 $('#modal_delete_all #item_id_accion').val('Eliminar Almacén Externo');
	 $('#modal_delete_all').modal('show');
}

function confirmar_delete_all(){
	mostrar_alerta("alerta_info","Eliminando...por favor, espere");
	var item_id= $('#modal_delete_all #item_id').val();
	var item_id_accion=  $('#modal_delete_all #item_id_accion').val();
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'realizarpedido/adeItem/',
	   data: {item_id:item_id, item_id_accion:item_id_accion},
	   success: function(res){
		ocultar_alerta();	
		if(res.result==1)
       {
		    $('#modal_delete_all').modal('hide');
			$('#delbtnpaso'+item_id).hide();
			 cargarItems();
			
			mostrar_alerta("alerta_correcto",res.message,1000,function(){

             
            });
			
	   }

			
			 
	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_paso_1').html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}



$( document ).ready(function() {
cargarItems();
loadSearchForm("realizarpedido_filter",cargarItems);
});
