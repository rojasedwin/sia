function nuevo_cliente()
{
	$('#cliente_telefono_comprobar').val('');
	$('#tel_cliente_tratando').val('');
	$('#modal_nuevo_cliente').modal('show');
}
function cerrar_ficha_cliente()
{
	$('#pantalla_datos_cliente').hide().html('');
	$('#pantalla_principal').effect('slide', { direction: 'left', mode: 'show' }, 500);
}
function terminar_cliente()
{
	$('#tel_cliente_tratando').val('');
	$('#boton_nuevo_cliente').show();
	$('#boton_ficha_cliente').hide();
	cerrar_ficha_cliente();
}

function abrir_ficha_cliente()
{
	var telefono = $('#cliente_telefono_comprobar').val();
	if(!EsTelefono(telefono))
	{
			mostrar_alerta("alerta_error","El teléfono no es correcto...",1500);
			return 1;
	}
	comprobarTelefonoNuevo(telefono);
}

function add_vehiculo_cliente_telefono(vehiculo_id,telefono)
{
	$('#tel_cliente_tratando').val(telefono);
	$('#boton_nuevo_cliente').hide();
	$('#boton_ficha_cliente').html('Tratando Cliente: '+telefono).show();
	add_vehiculo_cliente(vehiculo_id);
}

function add_vehiculo_cliente(vehiculo_id)
{
	var cliente_telefono = $('#tel_cliente_tratando').val();
	if(cliente_telefono!='')
	{
		ver_ficha_oferta(vehiculo_id,cliente_telefono);
	}
	else {
		$('#vehiculo_id_oferta').val(vehiculo_id);
		$('#cliente_telefono_oferta').val('');
		$('#modal_nuevo_cliente_oferta').modal('show');
	}
}
function ver_ficha_oferta_modal()
{
	var telefono = $('#cliente_telefono_oferta').val();
	if(!EsTelefono(telefono))
	{
			mostrar_alerta("alerta_error","El tel�fono no es correcto...",1500);
			return 1;
	}
	var vehiculo_id = $('#vehiculo_id_oferta').val();
	$('#tel_cliente_tratando').val(telefono);
	$('#boton_nuevo_cliente').hide();
	$('#boton_ficha_cliente').html('Tratando Cliente: '+telefono).show();
	hideModal('modal_nuevo_cliente_oferta')
	ver_ficha_oferta(vehiculo_id,telefono);
}
function comprobarTelefonoNuevo(telefono){
	console.log("Telegono vale "+telefono+" y a comprobar vale "+$('#tel_cliente_tratando').val());
	telefono = typeof telefono !== 'undefined' ? telefono : $('#tel_cliente_tratando').val();
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'misofertas/getFichaCliente/',
	   data: {cliente_telefono:telefono},
	   success: function(res){
			ocultar_alerta();

			$('#tel_cliente_tratando').val(telefono);
			$('#boton_nuevo_cliente').hide();
			$('#boton_ficha_cliente').html('Tratando Cliente: '+telefono).show();

      $('#pantalla_datos_cliente').html(res);
			load_widzard_form('pantalla_datos_cliente');
			//Guardar las acciones con enter.
			$('#texto_accion').on( "keyup", function( event ) {
					if(event.which==13) guardar_accion();
				});

			//Guardar datos clientes con enter
			$('#form_ficha_cliente input').on( "keyup", function( event ) {
					if(event.which==13) guardarDatosCliente();
				});

			setTimeout(function(){
					$("#contenido_acciones").animate({ scrollTop: $('#contenido_acciones').prop("scrollHeight")}, 800);
			}
		,400);
			 $('#options_filter_client_container .option_veh').on('click',function(){
		 	 if($(this).hasClass('select'))
		 	 {
		 		 $(this).removeClass('select');

		 		 $(this).find('input').prop('checked',false);
		 	 }
		 	 else {
		 		 $(this).addClass('select');
		 		$(this).find('input').prop('checked',true);

		 	 }
		  });

			//Funcionalidad recomendador.
			$('#cliente_nosconocio').change(function(){
					if($(this).val()==5)
					{
						abrir_buscar_recomendador();
						$('#container_recomandor').show();
					}
					else {
						$('#container_recomandor').hide();
						$('#container_recomandor').html('');
						$('#buscar_recomendador').val('');
						$('#cliente_recomendador').val(0);
					}
			});


			$('#pantalla_principal').hide();
			$('#pantalla_datos_cliente').effect('slide', { direction: 'right', mode: 'show' }, 500);
      $('#modal_nuevo_cliente').modal('hide');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function cargar_tab_cliente(id){

	if($('#tabs_ficha_cliente .active').length)
	{
		console.log("Hay una activa");
		var id_activa = $('#tabs_ficha_cliente .active').prop('id').split('-')[1];
		if(id_activa==1) guardarDatosCliente(id);
		if(id_activa==2) guardarInteresesCliente(id);
		if(id_activa==3) cargar_tab_cliente_real(id);
		return 1;
	}
	cargar_tab_cliente_real(id);


}
function cargar_tab_cliente_real(id)
{
	$('.tabs_cliente .boton_informes').removeClass('active');
	$('#boton_cliente-'+id).addClass('active');

	$('.tab_cliente.contenedor_informes').removeClass('active');
	$('#pantalla_cliente-'+id).addClass('active');
}

function refrescarCochesCliente(telefono){
	telefono = typeof telefono !== 'undefined' ? telefono : $('#tel_cliente_tratando').val();
	mostrar_alerta("alerta_info","Actualizando vehiculos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'misofertas/refresVehiculosCliente/',
	   data: {cliente_telefono:telefono},
	   success: function(res){
			ocultar_alerta();
			if(res.result==1)
			{
				$('#coches_ofertados').html(res.ofertas);
				$('#coches_interes').html(res.coincidencias);
			}

	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function guardarDatosCliente(id_tab)
{
	id_tab = typeof id_tab !== 'undefined' ? id_tab : 0;
  $('#validation_cliente_errors').html('');
	mostrar_alerta("alerta_info","Cargando vehiculos... por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'misofertas/saveCliente/',
	   	data: $('[name=form_ficha_cliente]').serialize(),
	   success: function(res){
			ocultar_alerta();
			if(res.result==1)
			{
					mostrar_alerta("alerta_correcto","Cambios guardados",1500);
					if(id_tab!=0) cargar_tab_cliente_real(id_tab);
					//$('#coches_ofertados').html(res.ofertas);
					//$('#coches_interes').html(res.coincidencias);
					//buscar_ofertas(1,0);

			}
			else {
				mostrar_alerta("alerta_error","Revise el formulario",1500);
        $('#validation_cliente_errors').html(res.message);
			}
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function guardarInteresesCliente(id_tab)
{
	id_tab = typeof id_tab !== 'undefined' ? id_tab : 0;
	mostrar_alerta("alerta_info","Cargando vehiculos... por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'misofertas/saveIntereses/',
	   	data: $('[name=intereses_cliente]').serialize(),
	   success: function(res){
			ocultar_alerta();
			if(res.result==1)
			{
					mostrar_alerta("alerta_correcto","Cambios guardados",1500);
					$('#coches_ofertados').html(res.ofertas);
					$('#coches_interes').html(res.coincidencias);
					if($('#contenedor_ofertas_total').length)	buscar_ofertas(1,0);
					if(id_tab!=0) cargar_tab_cliente_real(id_tab);

			}
			else {
				mostrar_alerta("alerta_error","Fallo al guardar...",1500);
			}
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function abrir_buscar_recomendador()
{
  $('#contenedor_busqueda_recomendadores').html('');
  $('#buscar_recomendador_telefono').val('');
  $('#buscar_recomendador_matricula').val('');
  $('#modal_buscar_recomendador').modal('show');
}

function buscar_recomendador()
{
  mostrar_alerta("alerta_info","Buscando... por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'misofertas/buscarRecomendador/',
	   	data: $('[name=form_buscar_recomendador]').serialize(),
	   success: function(res){
			ocultar_alerta();
      $('#contenedor_busqueda_recomendadores').html(res);
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function seleccionar_recomendador(cliente_telefono,cliente_nombre)
{
  $('#cliente_recomendador').val(cliente_telefono);
  $('#container_recomandor').html("Recomendado por :<br><span style='color:#2ea34d;font-weight:bold;'>"+cliente_nombre+" ("+cliente_telefono+")</span><br><br>");
  $('#modal_buscar_recomendador').modal('hide');
}

function guardarDatosLlamadas()
{
	mostrar_alerta("alerta_info","Guardando Datos... por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'misofertas/saveClienteLlamadas/',
	   	data: $('[name=form_llamadas_user]').serialize(),
	   success: function(res){
			ocultar_alerta();
			if(res.result==1)
			{
					mostrar_alerta("alerta_correcto","Cambios guardados",1500);

					if(res.ocultar_aviso_llamada==1 && $('#pantalla_crm_inicio').length)
					{
						var telefono = $('#form_llamadas_user [name=cliente_telefono]').val();
						$('#pantalla_crm_inicio #fidelizacion-'+telefono).remove();
					}

					//$('#coches_ofertados').html(res.ofertas);
					//$('#coches_interes').html(res.coincidencias);
					//buscar_ofertas(1,0);
			}
			else {
				mostrar_alerta("alerta_error","Revise el formulario",1500);
			}
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function resumenOR(idor){
	mostrar_alerta("alerta_info","Cargando OR...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "HTML",
	   url: base_url+'misofertas/cargarResumenOR/',
	   data: {idor:idor},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_ficha_or').html(res);
			$('#modal_ficha_or').modal('show');

	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function descartarAviso(aviso_id)
{
	mostrar_alerta("alerta_info","Descartando... por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'misofertas/descartarAviso/',
	   	data: {aviso_id:aviso_id},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				if($('#contenedor_avisos_total').length) buscar_avisos();
				if($('#pantalla_crm_inicio').length)
				{
					$('#pantalla_crm_inicio #nuevo_veh-'+aviso_id).remove();
				}
			 }
				else
				mostrar_alerta("alerta_error","Problemas de red...",1500);
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function marcar_avisotaller_leido(aviso_id,estado)
{
	mostrar_alerta("alerta_info","Marcando... por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'dashboard/marcarAvisoTaller/',
	   	data: {vehiculo_aviso_id:aviso_id,estado:estado},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				if($('#pantalla_taller_inicio').length)
				{
					if(estado==2)
						$('#pantalla_taller_inicio #aviso_taller-'+aviso_id).remove();
					else {
						cargar_avisos_taller_reservas();
					}
				}

				if($('#contenedor_misavisos_taller').is(':visible'))
				{
					console.log("Refrescamos los avisos de usuario");
					cargar_mis_avisos_taller();
				}

				if(($("#modal_ficha_or").data('bs.modal') || {}).isShown)
				{
					var vehiculo_id = $('#modal_ficha_or #vehiculo_id').val();
					console.log("ES VISIBLE !! "+vehiculo_id);

					refrescar_avisos_coche_or(vehiculo_id);
				}


			 }
				else
				mostrar_alerta("alerta_error","Problemas de red...",1500);
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
