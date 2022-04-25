function cargarItems()
{
	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+vista+'/getItems/',
	   data: {},
	   success: function(res){
			 ocultar_alerta();
		   $('#resultados_'+vista).html(res);
			 loadWidzardForm('resultados_'+vista);

	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_'+vista).html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function fichaItem(item_id){
   item_id = typeof item_id !== 'undefined' ? item_id : "";
	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+vista+'/getFormItemAddPedido',
			data: {item_id:item_id},
			success: function(html){
				ocultar_alerta();

				var options_css = {	'min-width': '30%'};
				var options_custom = {
			    'titulo': 'Gestión de Pedidos',
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



				wizard_addpedido();

			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX
}

function add_linea_pedido()
{
	var filas=$('#tabla_add_pedido :input[name="cod_nacional"]').length;
	console.log('Existen '+filas+' filas en la tabla.');
	filas++;
	console.log('Se añadira la fila: '+filas);


	//Añadimos una fila
	var contenido = "<tr class='linea_concepto' fila_verifica='0'>";

	contenido += "<td style='cursor:pointer;' class='eliminar_linea_producto'><i class='fa fa-times bg-danger text-white'></i></td>";
	contenido += "<td><input type='text' name='cod_nacional' value='' id='codnacional-"+filas+"' data-id='"+filas+"'></td>";
	contenido += "<td><input type='text' name='num_unidades' value='' id='numunidades-"+filas+"' data-id='"+filas+"'></td>";

	contenido += "</tr>";


	$('#tabla_add_pedido').append(contenido);
	wizard_addpedido();



}

function recalcularPedido()
{
	var tipo_algoritmo = $('#tipo_algoritmo').val();
	mostrar_alerta("alerta_info","Calculando...");
		$.ajax({
	    	type: 'POST',
	     	dataType: "JSON",
	     	url: base_url+vista+'/recalcularPedido',
	     	data:{tipo_algoritmo:tipo_algoritmo },
	     	success: function(res){
	       		ocultar_alerta();
	       		if(res.result==1){
	         		mostrar_alerta("alerta_correcto","Datos calculados",500,function(){
	           	$('#resumen_pedido').html(res.html);
	         		});
	       		} else {
	          		$('#validation_item_errors').html(res.message);
	       		}
	    	},
	     	error: function(){
	      		mostrar_alerta("alerta_error","Problemas de red...",1500);
	    	}
	    }); //AJAX

}

function guardarItem(){
  	mostrar_alerta("alerta_info","Guardando...por favor, espere");
  	var items = []; var tmp = {};
	var error = false;

	$('#validation_item_errors').html('');

	$('#tabla_add_pedido .linea_concepto').each(function(){


		$(this).find('[name=cod_nacional]').parent().removeClass('error_input');
		$(this).find('[name=num_unidades]').parent().removeClass('error_input');
		var cod_nacional=$(this).find('[name=cod_nacional]').val();

			tmp = {};
			var verifica =$(this).attr('fila_verifica');

		if(verifica==0){


			var tmpcodnacional = $(this).find('[name=cod_nacional]').val();
			tmp['cod_nacional'] = tmpcodnacional.trim();
			tmp['num_unidades'] = $(this).find('[name=num_unidades]').val();
			//console.log('codnacional: '+tmp['cod_nacional']+" num_unidades: "+tmp['num_unidades']);

			if(tmp['cod_nacional']==''){
				error = true;
				$(this).find('[name=cod_nacional]').parent().addClass('error_input');
			}

			if(tmp['num_unidades']==''){
				error = true;
				$(this).find('[name=num_unidades]').parent().addClass('error_input');
			}
			items.push(tmp);
		}


	});



	if(error)
	{
		mostrar_alerta("alerta_error","Algunos campos están vacíos...",2500);
		return false;
	}

	var filas=$('#tabla_add_pedido :input[name="cod_nacional"]').length;
	if (filas == 0){
	mostrar_alerta("alerta_error","Debe Agregar un producto...",1500);
	}
	else{
			var tipo_algoritmo = $('#tipo_algoritmo').val();
		$.ajax({
	    	type: 'POST',
	     	dataType: "JSON",
	     	url: base_url+vista+'/saveLineasAddPedido',
	     	data:{tipo_algoritmo:tipo_algoritmo,items:JSON.stringify(items) },
	     	success: function(res){
	       		ocultar_alerta();
	       		if(res.result==1){
	         		mostrar_alerta("alerta_correcto","Datos guardados",1000,function(){
	           	$('#resumen_pedido').html(res.html);

	         		});
	       		} else {
	          		$('#validation_item_errors').html(res.message);
	       		}
	    	},
	     	error: function(){
	      		mostrar_alerta("alerta_error","Problemas de red...",1500);
	    	}
	    }); //AJAX
	}
}

function wizard_addpedido(){

	$( "#tabla_add_pedido .eliminar_linea_producto" ).click(function(){
		$(this).parent().remove();
	});

	$( "#tabla_add_pedido [name=cod_nacional]" ).blur(function(){
		console.log(' perdio el foco el campo cod_nacional');
			var cod_nacional = $(this).val();
			$(this).val(cod_nacional.trim())

			if (cod_nacional != '') {
			var id = $(this).attr('data-id');
			verificaRepetido(cod_nacional,id);

			}
		});

		$( "#tabla_pml .eliminar_maquina_lote" ).click(function(){
		$(this).parent().remove();
	});

	$( "#tabla_add_pedido [name=num_unidades]" ).blur(function(){
		console.log(' perdio el foco el campo num_unidades');
			var num_unidades = $(this).val();
			var tmp_num_unidades = $(this).val();
			$(this).val(num_unidades.trim());

			if (num_unidades != '') {
				var id = $(this).attr('data-id');

				num_unidades=parseInt(num_unidades);
				if (isNaN(num_unidades)){
					console.log('el campo num_unidades no es entero: '+tmp_num_unidades);
					$('#numunidades-'+id).addClass('error_input_repetido');
					console.log('añado clase error al campo: '+tmp_num_unidades);

				}else{
					$('#numunidades-'+id).removeClass('error_input_repetido');
				}

			}
		});

		$( "#tabla_pml .eliminar_maquina_lote" ).click(function(){
		$(this).parent().remove();
	});



		$( "#tabla_pml .eliminar_maquina_lote" ).click(function(){
		$(this).parent().remove();
	});

}

function verificaRepetido(texto_buscado,id){

	var cant_texto=0;
	var aux_texto="";
	$('#tabla_add_pedido [name=cod_nacional]').each(function(){

		var codnacional=$(this).val();

		//console.log('verifico el cod_nacional: '+codnacional);
		if (codnacional != '') {
            codnacional = codnacional;
            texto_buscado = texto_buscado;
			if(codnacional==texto_buscado){

				cant_texto++;
				console.log('cod_nacional esta repetido : '+cant_texto+' veces');
			}

		}
	});


	if(cant_texto>1){
	$('#codnacional-'+id).addClass('error_input_repetido');
	console.log('agrego clase error al cod_nacional repetido de la fila: '+id+' que es codnacional-'+id);
	}else{
		$('#codnacional-'+id).removeClass('error_input_repetido');
	}
}


function confirmarPedido()
{
		if($('#resumen_pedido .rojo_suave').length)
		{
			mostrar_alerta("alerta_error","Hay condiciones sin cumplir.Revise y complete condiciones.",2500);
			return false;
		}
		var options_css = {	'min-width': '55%'};
		var options_custom = {
			'titulo': 'Confirmar pedido',
			'boton_cancelar': '1',
			'boton_cancelar_texto': 'Cancelar',
			'boton_cancelar_class': 'btn-gray',
			'boton_cancelar_callback': '',
			'boton_guardar': '1',
			'boton_guardar_texto': 'Guardar',
			'boton_guardar_class': 'btn-success',
			'boton_guardar_callback': 'realizarPedido()'
		}
		var html = "Se creará un pedido para cada proveedor asociado.";
		lanzarWizardFormModal('modal_guardar_item',options_css,options_custom,html);
}


function realizarPedido()
{
	if($('#resumen_pedido .rojo_suave').length)
	{
		mostrar_alerta("alerta_error","Hay condiciones sin cumplir.Revise y complete condiciones.",2500);
		return false;
	}
	mostrar_alerta("alerta_info","Realizando pedido..., por favor, espere");
		$.ajax({
	    	type: 'POST',
	     	dataType: "JSON",
	     	url: base_url+vista+'/finalizarPedido',
	     	data:{},
	     	success: function(res){
	       		ocultar_alerta();
	       		if(res.result==1){
	         		mostrar_alerta("alerta_correcto","Pedido realizado",500,function(){
	           		window.location = base_url+'pedidos';
	         		});
	       		} else {
	          		$('#validation_item_errors').html(res.message);
	       		}
	    	},
	     	error: function(){
	      		mostrar_alerta("alerta_error","Problemas de red...",1500);
	    	}
	    }); //AJAX
}

$( document ).ready(function() {

	//cargarItems();
	//loadSearchForm("orders_filter",cargarItems);

});
