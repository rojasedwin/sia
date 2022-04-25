function exportar_usuarios(){

	mostrar_alerta("alerta_info","Preparando Datos..., por favor, espere");
		$.ajax({
		   type: 'POST',
		   dataType: "html",
		   url: base_url+'dashboard/exportarNewsletter/',
		   data: {},
		   success: function(res){
				ocultar_alerta();
				$('#contenido_exportar_datos').html(res);

				$('#modal_exportar_datos').modal('show');
		   },
		   error: function(){
				ocultar_alerta();
				mostrar_alerta("alerta_error","Problemas de red",2500);
			},
			timeout: 30000
	    }); //AJAX
}

function cargar_calendario(){
	$('#calendar').fullCalendar({
		header: {
				left: 'prev,next today',
				center: 'title',
				right: 'agendaWeek,listWeek'
			},
		defaultView: 'agendaWeek',
		locale: 'es',
		allDaySlot:false,
		minTime:'07:00:00',
		maxTime:'23:00:00',
		 timeFormat: 'HH:mm', // uppercase H for 24-hour clock
		eventStartEditable: true,
		eventOverlap:false,
		eventLimit: true, // allow "more" link when too many events
		selectable: false,
		selectHelper: false,
		events: function(start, end, timezone, callback) {
				$.ajax({
						url: base_url+'misventas/getCitasCalendario/',
						dataType: 'json',
						data: "start="+start.unix()+"&end="+end.unix(),

						success: function(eventos) {
							/*$('#calendar').fullCalendar( 'removeEvents'); //borramos antes de solicitar de nuevo
							if(eventos!=null)
								$('#calendar').fullCalendar('addEventSource',eventos);
							*/
							 callback(eventos);
						}
				});
		},
		eventClick: function(calEvent, jsEvent, view) {
			console.log("Hago click con ",calEvent.id);
			//var datos
			console.log(JSON.stringify(calEvent.data_cita, null, 4))
			formulario_opciones_cita(calEvent.id,calEvent.data_cita);


		},
		eventMouseover: function(calEvent, jsEvent) {
				var tooltip = '<div id="tooltip_calendario" class="tooltip" style="width:100px;height:100px;position:absolute;z-index:10001;"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + calEvent.description + '</div></div>';
				var $tooltip = $(tooltip).appendTo('body');

				if(calEvent.id)
				{
				$(this).mouseover(function(e) {
						$(this).css('z-index', 10000);
						$tooltip.fadeIn('500');
						$tooltip.fadeTo('10', 1.9);
				}).mousemove(function(e) {
					$tooltip.fadeTo('10', 1.9);
					if(e.pageY>550)
						$tooltip.css('top', e.pageY - 170);
					else {
						$tooltip.css('top', e.pageY + 10);
					}
					if(e.pageX>550)
						$tooltip.css('left', e.pageX - 320);
					else
					$tooltip.css('left', e.pageX + 20);
				});
			}
		},
		eventDrop: function(event, delta, revertFunc) {
				if(event.date_state==2)
				{
					revertFunc();
					mostrar_alerta("alerta_error","Cita completada, no se puede editar...",1500);
					return 1;
				}
				var fecha = moment.utc(event.start.format()).format("YYYY-MM-DD HH:mm:ss");
				var res;
				$.when( res = cambiar_cita(event.id,fecha) ).then(function(  data, textStatus, jqXHR ) {
					console.log("Me esperando llega "+data+" y "+textStatus);
					if(data.result!=1)  revertFunc();
				});


    },
		eventMouseout: function(calEvent, jsEvent) {
				$('#tooltip_calendario').remove();
				$(this).css('z-index', 8);
				$(this).unbind("mouseover");
				$(this).unbind("mousemove");
		}
		/*,
		eventRender: function(event, element) {
				element.tooltip({
					trigger: 'click',
					title: event.description,
					html:"true",
					placement: "top"
				});
				//find('.fc-title').append("<br/>" + event.description);
		}*/
	});
}
function refrescar_calendario(){

	$('#calendar').fullCalendar('refetchEvents');
}

function check_avisos(){
	$.ajax({
		 type: 'POST',
		 dataType: "JSON",
		 url: base_url+'iniciocentros/check_avisos/',
		 data: {},
		 success: function(res){

					$('#avisos_citas').html(res.avisos_citas);
					$('#avisos_cabezales').html(res.avisos_cabezales);
					$('#avisos_orders_pdte').html(res.avisos_orders_pdte);


		 },
		 error: function(){
		},
		timeout: 30000
		}); //AJAX
		setTimeout(function(){ check_avisos(); }, 60000*10);

}
function check_pagos_pdtes(){
	$.ajax({
		 type: 'POST',
		 dataType: "JSON",
		 url: base_url+'iniciocentros/check_pagos_pdtes/',
		 data: {},
		 success: function(res){
					$('#avisos_orders_pdte').html(res.avisos_orders_pdte);
		 },
		 error: function(){
		},
		timeout: 30000
		}); //AJAX
		setTimeout(function(){ check_pagos_pdtes(); }, 60000*2);

}

function abrir_citas_pdte()
{
	mostrar_alerta("alerta_info","Cargando citas pendientes...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'misventas/getCitasPdtes/',
	   data: {},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_citas_pdtes').html(res);
       $('#modal_citas_pdtes_confirmar').modal('show');
	   },
	   error: function(jqXHR, textStatus){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function abrir_financiacion_pdte()
{
	mostrar_alerta("alerta_info","Cargando financiaciones completadas...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'misventas/getFinanciacionesCompletadas/',
	   data: {},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_finaciaciones_pdtes').html(res);
       $('#modal_financiaciones_pdtes_confirmar').modal('show');
	   },
	   error: function(jqXHR, textStatus){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

$( document ).ready(function() {
cargar_calendario();
check_avisos();
setTimeout(function(){ check_pagos_pdtes(); }, 60000*2);


});
