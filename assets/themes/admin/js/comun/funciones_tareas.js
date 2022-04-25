function nueva_tarea(idtarea,operacion){
	idtarea = typeof idtarea !== 'undefined' ? idtarea : '';
	operacion = typeof operacion !== 'undefined' ? operacion : '';
	mostrar_alerta("alerta_info","Cargando Formulario...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tareas/getFormuTarea/',
	   data: {idtarea: idtarea,operacion:operacion},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_formulario_tarea').html(res);
			cargar_wizard_formu_tarea();

			$('#modal_editar_tarea').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function cargar_wizard_formu_tarea(){
	$('.selectpicker').selectpicker();
	$('.mifecha').datepicker({
		autoclose: true,
		format:"dd-mm-yyyy",
		language: 'es'
	});
	$('#hora_recordatorio').change(function(){
		if($(this).val()==0)
		{
			$('#contenedor_fecha_recordatorio').effect('slide', { direction: 'right', mode: 'show' }, 500);
		}
		else {
			$('#contenedor_fecha_recordatorio').hide();
		}
	})
}

function cargar_wizar_formu_servicios(){
	cargar_wizard_formu_tarea();
	$('.check-box-ios').each(function(){
			new Switchery(document.getElementById( $(this).prop('id') ));
	});
	$('#descripcion').keyup(function(){
		$('#editada').val(1);
	});
	$('[name=f_inicio]').change(function(){
		$('#editada').val(1);
	});
	$('[name=hora]').change(function(){
		$('#editada').val(1);
	});
	$('[name=minuto]').change(function(){
		$('#editada').val(1);
	});

}


function confirmar_guardar_tarea_y_servicios(){

	//Tenemos que editar la Tarea y Despues Guardar Los servicios
	if($('#editada').val()==1)
		confirmar_guardar_tarea("servicios");
	else
		confirmar_guardar_servicios_tarea();

}

function formu_tarea_servicios(idtarea){
	idtarea = typeof idtarea !== 'undefined' ? idtarea : '';
	mostrar_alerta("alerta_info","Cargando Formulario...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tareas/getFormuTareaServicios/',
	   data: {idtarea: idtarea},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_formulario_tarea_servicios').html(res);
			cargar_wizar_formu_servicios();

			$('#modal_editar_servicios_tarea').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function confirmar_guardar_servicios_tarea(){
	mostrar_alerta("alerta_info","Guardando Servicios...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tareas/guardarServicios',
	   data: $('[name=guardar_servicios_tarea_form]').serialize(),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
					 $('.modal').modal('hide');
					if($('#pantalla_calendario').is(':visible'))
						$('#calendar').fullCalendar('refetchEvents');
					if($('#contenido_tablas').is(':visible'))
						cargar_mis_tablas();
					if($('#contenedor_tareas').is(':visible'))
						buscar_tareas();



				 });
			 }
			 else {
				 	if(res.result==-1)
			 			$('#validation_tarea_errors').html(res.message);
					else {
							mostrar_alerta("alerta_error",res.message,1500);
					}
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX

}

//AÑADIR RECORDATORIOS

function add_recordatorio(){
	$('#editada').val(1);
	var aviso = "";
	var tiempo_recordatorio = $('#hora_recordatorio').val();
	if($('#fecha_recordatorio').val()=="" && tiempo_recordatorio==0)
	{
		aviso += "<br> - Debe indicar una fecha";
	}
	if($('#texto_recordatorio').val()=="")
	{
		aviso += "<br> - Indique un texto";
	}
	if(aviso!="")
	{
		mostrar_alerta("alerta_error","Revise: "+aviso,1500);
		return 1;
	}

	var recordatorio = '<div class="divrecordatorio" name="los_recordatorios">';
	if(tiempo_recordatorio==0)
		recordatorio += '<h1>'+$('#fecha_recordatorio').val()+'</h1>';
	else {
		recordatorio += '<h1>'+tiempo_recordatorio+' min antes</h1>';
	}
	recordatorio += '<p>'+$('#texto_recordatorio').val()+'</p>';
	recordatorio += '<i onclick="$(this).parent().remove();" class="fa fa-remove"></i>';
	recordatorio += '<input type="hidden" name="tiempo_recordatorio" value="'+tiempo_recordatorio+'">';
	recordatorio += '<input type="hidden" name="fecha_recordatorio" value="'+$('#fecha_recordatorio').val()+'">';
	recordatorio += '<input type="hidden" name="texto_recordatorio" value="'+$('#texto_recordatorio').val()+'">';
	recordatorio += "</div>";
	$('#contenedor_recordatorios').append(recordatorio);

	$('#fecha_recordatorio').val('');
	$('#texto_recordatorio').val('');

}

function add_repeticion(){
	var aviso = "";
	if($('#fecha_repeticion').val()=="")
	{
		aviso += "<br> - Debe indicar una fecha";
	}
	if(aviso!="")
	{
		mostrar_alerta("alerta_error","Revise: "+aviso,1500);
		return 1;
	}
	var tipo = $('#tipo_repeticion').val();
	var recordatorio = '<div class="divrecordatorio" name="las_repeticiones" style="text-align:center;"><br>';

	if(tipo==0) recordatorio += '<p>Una Única vez: <br><b>'+$('#fecha_repeticion').val()+'</b></p>';
	if(tipo==1) recordatorio += '<p>Cada semana hasta: <br><b>'+$('#fecha_repeticion').val()+'</b></p>';
	if(tipo==2) recordatorio += '<p>Cada Mes hasta: <br><b>'+$('#fecha_repeticion').val()+'</b></p>';
	if(tipo==3) recordatorio += '<p>Cada Año hasta: <br><b>'+$('#fecha_repeticion').val()+'</b></p>';
	if(tipo==4) recordatorio += '<p>Laborables hasta: <br><b>'+$('#fecha_repeticion').val()+'</b></p>';
	recordatorio += '<i onclick="$(this).parent().remove();" class="fa fa-remove"></i>';
	recordatorio += '<input type="hidden" name="fecha_repeticion" value="'+$('#fecha_repeticion').val()+'">';
	recordatorio += '<input type="hidden" name="tipo_repeticion" value="'+$('#tipo_repeticion').val()+'">';
	recordatorio += "</div>"
	$('#contenedor_repeticiones').append(recordatorio);

	$('#fecha_repeticion').val('');

}

function confirmar_guardar_tarea(operacion){
	operacion = typeof operacion !== 'undefined' ? operacion : '';
	mostrar_alerta("alerta_info","Guardando Tarea...por favor, espere");
	$('#validation_tarea_errors').html('');
	//Obtenemos recordatorios y repeticiones
	var recordatorios = {}; var cont = 0;
	$('[name=los_recordatorios]').each(function(){
			recordatorios[ cont ] = {};
			if($(this).find('[name=id_recordatorio]').val()) recordatorios[ cont ]['id'] = $(this).find('[name=id_recordatorio]').val();
			else recordatorios[ cont ]['id'] = 0;
			recordatorios[ cont ]['tiempo'] = $(this).find('[name=tiempo_recordatorio]').val();
			recordatorios[ cont ]['texto'] = $(this).find('[name=texto_recordatorio]').val();
			recordatorios[ cont ]['fecha'] = $(this).find('[name=fecha_recordatorio]').val();
			cont++;
	});
	var repeticiones = {}; cont = 0;
	$('[name=las_repeticiones]').each(function(){
			repeticiones[ cont ] = {};
			if($(this).find('[name=id_repeticion]').val()) repeticiones[ cont ]['id'] = $(this).find('[name=id_repeticion]').val();
			else repeticiones[ cont ]['id'] = 0;
			repeticiones[ cont ]['fecha'] = $(this).find('[name=fecha_repeticion]').val();
			repeticiones[ cont ]['tipo'] = $(this).find('[name=tipo_repeticion]').val();
			cont++;
	});
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tareas/guardar',
	   data: $('[name=guardar_tarea_form]').serialize()+"&repeticiones="+JSON.stringify(repeticiones)+"&recordatorios="+JSON.stringify(recordatorios),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1 || res.result==2)
			 {
				 var tipo_alerta = "alerta_correcto"; var tiempo = 1000;
				 if(res.result==2)
				 {
					 tipo_alerta = "alerta_warning"; tiempo = res.tiempo;
				 }
				 mostrar_alerta(tipo_alerta,res.message,tiempo,function(){
					 if(operacion!="servicios")
					 {
						 $('.modal').modal('hide');
						 if($('#pantalla_calendario').is(':visible'))
							 $('#calendar').fullCalendar('refetchEvents');
						 if($('#contenido_tablas').is(':visible'))
							 cargar_mis_tablas();
						 if($('#contenedor_tareas').is(':visible'))
							 buscar_tareas();
					 }
					 else {
						 confirmar_guardar_servicios_tarea();
					 }

				 });
			 }
			 else {
				 	if(res.result==-1)
			 			$('#validation_tarea_errors').html(res.message);
					else {
							mostrar_alerta("alerta_error",res.message,1500);
					}
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}


function nueva_incidencia(idincidencia,operacion){
	idincidencia = typeof idincidencia !== 'undefined' ? idincidencia : '';
	operacion = typeof operacion !== 'undefined' ? operacion : '';
	mostrar_alerta("alerta_info","Cargando Formulario...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'incidencias/getFormuIncidencia/',
	   data: {idincidencia: idincidencia,operacion:operacion},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_formulario_incidencia').html(res);
			cargar_wizard_formu_incidencia();

			$('#modal_editar_incidencia').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function cargar_wizard_formu_incidencia(){
	$('.selectpicker').selectpicker();
	$('.mifecha').datepicker({
		autoclose: true,
		format:"dd-mm-yyyy",
		language: 'es'
	});
	$('.check-box-ios').each(function(){
			new Switchery(document.getElementById( $(this).prop('id') ));
	});
}

function confirmar_guardar_incidencia(){
	mostrar_alerta("alerta_info","Guardando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'incidencias/guardar',
	   data: $('[name=guardar_incidencia_form]').serialize(),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
					 $('.modal').modal('hide');
					 if($('#contenedor_incidencias').is(':visible'))
						 buscar_incidencias();
				 });
			 }
			 else {
				 	if(res.result==-1)
			 			$('#validation_incidencia_errors').html(res.message);
					else {
							mostrar_alerta("alerta_error",res.message,1500);
					}
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX

}

function nueva_recordatorio(idrecordatorio,operacion){
	idrecordatorio = typeof idrecordatorio !== 'undefined' ? idrecordatorio : '';
	operacion = typeof operacion !== 'undefined' ? operacion : '';
	mostrar_alerta("alerta_info","Cargando Formulario...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'recordatorios/getFormuRecordatorio/',
	   data: {idrecordatorio: idrecordatorio,operacion:operacion},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_formulario_recordatorio').html(res);
			cargar_wizard_formu_recordatorio();

			$('#modal_editar_recordatorio').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function cargar_wizard_formu_recordatorio(){
	$('.selectpicker').selectpicker();
	$('.mifecha').datepicker({
		autoclose: true,
		format:"dd-mm-yyyy",
		language: 'es'
	});
	$('.check-box-ios').each(function(){
			new Switchery(document.getElementById( $(this).prop('id') ));
	});
}

function confirmar_guardar_recordatorio(){
	mostrar_alerta("alerta_info","Guardando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'recordatorios/guardar',
	   data: $('[name=guardar_recordatorio_form]').serialize(),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
					 $('.modal').modal('hide');
					 if($('#contenedor_recordatorios').is(':visible'))
						 buscar_recordatorios();
				 });
			 }
			 else {
				 	if(res.result==-1)
			 			$('#validation_recordatorio_errors').html(res.message);
					else {
							mostrar_alerta("alerta_error",res.message,1500);
					}
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX

}
