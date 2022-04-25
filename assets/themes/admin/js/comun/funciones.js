  var vehiculos_stock = [];
var myUserId = $('#myUserId').val();

var fichaTasActual = 0;
 var lastJQueryTS = 0 ;
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};



function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
function htmlEscape(text) {

    return text.trim()
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

var vis = (function(){
    var stateKey, eventKey, keys = {
        hidden: "visibilitychange",
        webkitHidden: "webkitvisibilitychange",
        mozHidden: "mozvisibilitychange",
        msHidden: "msvisibilitychange"
    };
    for (stateKey in keys) {
        if (stateKey in document) {
            eventKey = keys[stateKey];
            break;
        }
    }
    return function(c) {
        if (c) document.addEventListener(eventKey, c);
        return !document[stateKey];
    }
})();

function showModal(modal)
{
	$('#'+modal).show().addClass('in');
  $('body').addClass('modal-open2');
}
function hideModal(modal)
{
	$('#'+modal).modal('hide');
  cerrarModalPrincipal();
  //.removeClass('in').hide()
  //$('.modal-backdrop').first().remove();
}
function cambiar_formato(fecha)
{
	var tmp = fecha.split('-');
	return tmp[2]+"-"+tmp[1]+"-"+tmp[0];
}
function cargar_buscado_formu(form)
{
  //La funcion buscar_listado se sobreescribirá en cada página.
	$('#'+form+' .mifecha').on('changeDate',function() {
		buscar_listado();
	});
	$('#'+form+' .selectpicker').change(function(){
		buscar_listado();
	});
	$('#'+form+' input[type=text]').keyup(function() {
		$('#page_actual').val(1);
		delay(
		buscar_listado
	, 800 );});

}
function load_widzard_form(form)
{
  $('#'+form+' .selectpicker').selectpicker();
  $('#'+form+' .mifecha').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    language: 'es'
  });
  $('#'+form+' .form_color_inputs input[type=text]').blur(function(){
     if($(this).val()=="") $(this).removeClass('has_value');
     else $(this).addClass('has_value');
  });
  $('#'+form+' .form_color_inputs textarea').blur(function(){
     if($(this).val()=="") $(this).removeClass('has_value');
     else $(this).addClass('has_value');
  });
  if($('#'+form+' .mitime').length)
  {
    $('#'+form+' .mitime').datetimepicker({
      format:'DD-MM-YYYY HH:mm',
    });
  }
}
function cerrarModalPrincipal_old()
{
  $('body').addClass('modal-open2').addClass('modal-open');
  setTimeout(function(){
    if($('.modal').hasClass('in'))
    {
      console.log("Add class");
    }
    else {
      $('body').removeClass('modal-open2');
    }
  },100);
  /*  setTimeout(function(){
      if($('.modal').hasClass('in'))
      {
        console.log("Add class");
        $('body').addClass('modal-open');
      }},400);
      */
}


function ver_mensaje(id_mensaje)
{
  $('#asunto_mensaje_modal').html( $('#asunto_mensaje-'+id_mensaje).val() );
  $('#contenido_mensaje_modal').html( $('#texto_mensaje-'+id_mensaje).val() );
	$('#modal_ver_mensaje').modal('show');
  if($('#leido_mensaje-'+id_mensaje).val()==0)
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'iniciocentros/marcarMensajeLeido/',
	   data: {id_mensaje:id_mensaje},
	   success: function(res){
			if(res.result==1)
      {
        $('#leido_mensaje-'+id_mensaje).val(1);
        var num_mensajes = parseInt($('#nuevos_mensajes').html());
        num_mensajes--;
        if(num_mensajes<0) num_mensajes = 0;
        $('#nuevos_mensajes').html(num_mensajes);
        $('#link_mensaje-'+id_mensaje).removeClass('mensaje_nuevo');
      }

	   }
    }); //AJAX
}

function ficha_nuevo_usuario(){

  mostrar_alerta("alerta_info","Cargando formulario...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'misclientes/getFormCustomerUser/',
	   data: {},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_formulario').html(res);
      $('#dni_ficha_cliente').blur(function(){
        if($('#contenido_formulario #ficha_cliente_user_id').val()=="")
        {
          //Si es vacio buscamos
          buscar_cliente_dni($(this).val());
        }
      });
			 $('.selectpicker').selectpicker();
			 $('.mifecha').datepicker({
				 autoclose: true,
				 format:"dd-mm-yyyy",
				 language: 'es'
			 });
       $('#modal_editar_usuario').modal('show');
	   },
	   error: function(jqXHR, textStatus){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function buscar_cliente_dni(dni){
  if(dni!="")
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'misclientes/buscarClienteDni/',
	   data: {dni: dni},
	   success: function(res){
       if(res.encontrado==1)
       {
         mostrar_alerta("alerta_correcto","Cliente ya registrado",2500);
         $('#contenido_formulario').html(res.form);
          $('.selectpicker').selectpicker();
          $('.mifecha').datepicker({
            autoclose: true,
            format:"dd-mm-yyyy",
            language: 'es'
          });
       }


	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}
function aceptar_tasacion(tasacion_id){
  $('#contenido_aceptar_tasacion #tasacion_aceptar').val(tasacion_id);
  $('#modal_aceptar_tasacion').modal('show');
}
function confirmar_aceptar_tasacion()
{
  var tasacion_id = $('#contenido_aceptar_tasacion #tasacion_aceptar').val();

  mostrar_alerta("alerta_info","Aceptando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/aceptarTasacion/',
	   data: {
       tasacion_id: tasacion_id
      },
	   success: function(res){
       if(res.result==1)
       {
         ver_ficha_tasacion(tasacion_id);
         mostrar_alerta("alerta_correcto","Tasación Aceptada",2500,function(){
           if($('#pantalla_dashboard').length) refrescar_tasaciones();
           if($('#contenedor_tasaciones_total').length) buscar_tasaciones();
           $('#modal_aceptar_tasacion').modal('hide');
           cerrarModalPrincipal();

				 });

       }
       else{
         mostrar_alerta("alerta_error","No hemos podido guardar la oferta...",1500);
       }
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}
function descartar_tasacion(tasacion_id){
  $('#contenido_descartar_tasacion #tasacion_descartar').val(tasacion_id);
  $('#modal_descartar_tasacion').modal('show');
}
function confirmar_descartar_tasacion()
{
  var tasacion_id = $('#contenido_descartar_tasacion #tasacion_descartar').val();

  mostrar_alerta("alerta_info","Descartando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/descartarTasacion/',
	   data: {
       tasacion_id: tasacion_id
      },
	   success: function(res){
       if(res.result==1)
       {
         ver_ficha_tasacion(tasacion_id);
         mostrar_alerta("alerta_correcto","Tasación Descartada",2500,function(){
           if($('#pantalla_dashboard').length) refrescar_tasaciones();
           if($('#contenedor_tasaciones_total').length) buscar_tasaciones();

           $('#modal_descartar_tasacion').modal('hide');
           cerrarModalPrincipal();
				 });

       }
       else{
         mostrar_alerta("alerta_error","No hemos podido guardar los datos...",1500);
       }
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}
function formu_pago(tasacion_id,concesionario_type){
  concesionario_type = typeof concesionario_type !== 'undefined' ? concesionario_type : 0;

  $('#contenido_sol_pago #tasacion_sol_pago').val(tasacion_id);
  $('#contenido_sol_pago #tasacion_id_pedido').val(tasacion_id);
  $('#contenido_sol_pago .boton_subir').removeClass('btn-success').addClass('btn-default');
  document.getElementById("form_sol_pago").reset();

  //Establecemos si tiene libros o no.
  $('#tasacion_libros_solpago').val( $('#tasacion_libros').val() );
  $('#fvehiculo_solpago').val( $('#tasacion_fvehiculo').val() )
  if(concesionario_type==0){
    $('.datos_cliente_particular_modal').hide();
    $('#datos_cliente_profesional_modal').show();
  }
  else{
    $('.datos_cliente_particular_modal').show();
    $('#datos_cliente_profesional_modal').hide();
  }
  $('#contenido_sol_pago #validation_sol_pago').html('');
  $('#contenido_sol_pago #estado_foto_pedido_modal').html('');
  $("#contenido_sol_pago .selectpicker").selectpicker("refresh");

  $('#vehiculo_a_comprar').html('');
  $('#tasacion_vehiculo_id_solpago').prop('disabled',true);
  $('#modal_solicitar_pago').modal('show');
  setTimeout(function(){ autocomplete_vehiculos_stock(); }, 1000);


}
function habilitar_matricula_ppago(idpropio,idhabilitar)
{
  if($('#'+idpropio).is(':checked'))
  {
    $('#'+idhabilitar).prop('disabled',false);
    $('#grupo_del_coche').hide();
  }
  else
  {
    $('#grupo_del_coche').show();
    $('#'+idhabilitar).prop('disabled',true);
    $('#vehiculo_a_comprar').html('');
    $('#vehiculo_a_comprar_ficha').html('');
    $('#vehiculo_a_comprar_reserva').html('');
    $('#vehiculo_a_comprar_liquidacion').html('');

  }
}
function confirmar_solicitar_pago()
{
  mostrar_alerta("alerta_info","Solicitando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/solicitarPago/',
	   data:$('[name=form_sol_pago]').serialize(),
	   success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         ver_ficha_tasacion($('#contenido_sol_pago #tasacion_sol_pago').val());
         mostrar_alerta("alerta_correcto","Pago Solicitado",2500,function(){
          if($('#pantalla_dashboard').length) refrescar_tasaciones();
           $('#modal_solicitar_pago').modal('hide');
           cerrarModalPrincipal();
				 });

       }
       else{
         $('#validation_sol_pago').html(res.message);
       }
	   },
	   error: function(jqXHR, textStatus){
        ocultar_alerta();
		}
    }); //AJAX
}

function mandar_oferta(tasacion_id){
  var oferto_final = $('#oferto_final').val();
  if(oferto_final=="" || oferto_final==undefined) oferto_final = $('#tasacion_oferto').val();
  $('#contenido_mandar_oferta #tasacion_oferta_final').val(tasacion_id);
  $('#contenido_mandar_oferta #mi_oferta_final').val(oferto_final);
  $('#modal_mandar_oferta').modal('show');
}
function confirmar_enviar_oferta(avisar)
{
  var tasacion_id = $('#contenido_mandar_oferta #tasacion_oferta_final').val();
  var tasacion_oferto_final = $('#contenido_mandar_oferta #mi_oferta_final').val();
  var validate_by = $('#contenido_mandar_oferta #validate_by').val();
  mostrar_alerta("alerta_info","Procesando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/guardarOfertaFinal/',
	   data: {
       tasacion_id: tasacion_id,
       tasacion_oferto_final: tasacion_oferto_final,
       validate_by: validate_by,
       avisar: avisar
      },
	   success: function(res){
       if(res.result==1)
       {
         if(!$('#titulo_docs').length)
          $('#boton_aceptar_tasacion').show();

         $('#oferto_final').val(tasacion_oferto_final);
         mostrar_alerta("alerta_correcto","Datos guardados",2500,function(){
           if($('#pantalla_dashboard').length) refrescar_tasaciones();
           $('#modal_mandar_oferta').modal('hide');
           cerrarModalPrincipal();
				 });

       }
       else{
         if(res.message != undefined)
          mostrar_alerta("alerta_error",res.message,1500);
        else
          mostrar_alerta("alerta_error","No se ha podido completar la operación",1500);
       }


	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}
function aviso_urgente(tasacion_id)
{
  mostrar_alerta("alerta_info","Cargando Datos...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tasaciones/formuAvisoUrgente/',
	   data: {
       tasacion_id: tasacion_id},
	   success: function(res){
        ocultar_alerta();
         $('#contenido_aviso_urgente').html(res);
         $('#contenido_aviso_urgente .selectpicker').selectpicker();
         $('#modal_aviso_urgente').modal('show');
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}
function asegurarCoche(tasacion_id)
{
  mostrar_alerta("alerta_info","Marcando y Avisando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/asegurarCoche/',
	   data: {
       tasacion_id: tasacion_id},
	   success: function(res){
        ocultar_alerta();
        if(res.result==1)
        {
           mostrar_alerta("alerta_correcto",'Vehículo Asegurado',1500);
           $('#boton_asegurado').hide();
           $('#boton_asegurado_quitar').show();

        }
        else{
          mostrar_alerta("alerta_error","No hemos podido guardar el seguro...",1500);
        }
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}
function quitarSeguroCoche(tasacion_id)
{
  mostrar_alerta("alerta_info","Eliminando y Avisando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/quitarSeguroCoche/',
	   data: {
       tasacion_id: tasacion_id},
	   success: function(res){
        ocultar_alerta();
        if(res.result==1)
        {
           mostrar_alerta("alerta_correcto",'Seguro Eliminado',1500);
           $('#boton_asegurado_quitar').hide();
           $('#boton_asegurado').show();

        }
        else{
          mostrar_alerta("alerta_error","No hemos podido guardar el seguro...",1500);
        }
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}

function solicitar_notainfo(tasacion_id)
{
  mostrar_alerta("alerta_info","Solicitando nota....por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/solicitarNotainfo/',
	   data: {
       tasacion_id: tasacion_id},
	   success: function(res){
        ocultar_alerta();
        if(res.result==1)
        {
           mostrar_alerta("alerta_correcto",'Nota informativa seleccionada',1500);
           $('#boton_nota_info').hide();

        }
        else{
          mostrar_alerta("alerta_error","No hemos podido solicitar la nota...",1500);
        }
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
}

function confirmar_aviso_urgente(){
  mostrar_alerta("alerta_info","Avisando... por favor, espere");

	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/avisarUrgente',
	   data: $('[name=form_aviso_urgente]').serialize()
		 ,
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 mostrar_alerta("alerta_correcto",'Aviso enviado',1500,function(){
           $('#modal_aviso_urgente').modal('hide');
           cerrarModalPrincipal();
				 });
			 }
			 else {
			 			mostrar_alerta("alerta_error","No se ha podido enviar el aviso...",1500);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}


function subirImagenes()
{
  $('#cargar_imagenes_tasacion').submit();
  mostrar_alerta("alerta_info","Procesando Imágenes...");
}
function imagenes_subidas(response)
{
  if(response.result==1)
  {
    var tasacion_id = $('#form_ficha_tasacion [name=tasacion_id]').val();
    mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
  	$.ajax({
  	   type: 'POST',
  	   dataType: "html",
  	   url: base_url+'tasaciones/refrescarImagenesTas/',
  	   data: {tasacion_id: tasacion_id},
  	   success: function(res){
  			mostrar_alerta("alerta_correcto","Imagenes Subidas",1500);
        $('#contenedor_imagenes_tasacion').html(res);
         $('#contenido_ficha_tasacion [name=imagenes_tasacion]').on('click',function(){
           var src = $(this).prop('src');
           $('#imagen_principal .principal').prop('src',src);
         });
         $('#contenido_ficha_tasacion #imagen_principal .fa-arrow-left').on('click',function(){

           var imagen_actual = parseInt($('#imagen_principal #image_actual').val());
           var max_images = parseInt($('#imagen_principal #max_images').val());
           imagen_actual--; if(imagen_actual<0)  imagen_actual = max_images - 1;
           var src = $('#contenedor_imagenes_tasacion #idimg-'+imagen_actual).prop('src');
           $('#imagen_principal #image_actual').val(imagen_actual);
           $('#imagen_principal .principal').prop('src',src);
         });
         $('#contenido_ficha_tasacion #imagen_principal .fa-arrow-right').on('click',function(){

           var imagen_actual = parseInt($('#imagen_principal #image_actual').val());
           var max_images = parseInt($('#imagen_principal #max_images').val());
           imagen_actual++; if(imagen_actual>=max_images)  imagen_actual = 0;
           var src = $('#contenedor_imagenes_tasacion #idimg-'+imagen_actual).prop('src');
           $('#imagen_principal #image_actual').val(imagen_actual);
           $('#imagen_principal .principal').prop('src',src);
         });
  	   },
  	   error: function(){
  			mostrar_alerta("alerta_error","Problemas de red...",1500);
  		}
      }); //AJAX
  }
  else {
    	mostrar_alerta("alerta_error",response.message,1500);
  }

}
function copiar_fmatriculacion(){
  var fecha = $('#contenido_sol_pago [name=tasacion_fvehiculo]').val();
  //$('#contenido_sol_pago [name=tasacion_fitv]').val(fecha);
  $('#contenido_sol_pago [name=tasacion_prox_itv]').val(fecha);
}
function subirDocumentos()
{
  $('#cargar_docs_tasacion').submit();
  mostrar_alerta("alerta_info","Procesando Documento...");
}
function DocSubido(response)
{
  if(response.result==1)
  {
    if(response.es_nota==1) $('#aviso_nota_info').remove();
    var tasacion_id = $('#form_ficha_tasacion [name=tasacion_id]').val();
    mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "html",
       url: base_url+'tasaciones/refrescarDocs/',
       data: {tasacion_id: tasacion_id},
       success: function(res){
        mostrar_alerta("alerta_correcto","Documento Subido",1500);
        $('#contenedor_docs_tasacion').html(res);
       },
       error: function(){
        mostrar_alerta("alerta_error","Problemas de red...",1500);
      }
      }); //AJAX
  }
  else {
      mostrar_alerta("alerta_error",response.message,1500);
  }
}
function refrescarDocsTasacion(eliminar_cambio_pago)
{
  eliminar_cambio_pago = typeof eliminar_cambio_pago !== 'undefined' ? eliminar_cambio_pago : 0;
  console.log("Refresco docs con "+eliminar_cambio_pago);
  var tasacion_id = $('#form_ficha_tasacion [name=tasacion_id]').val();
  mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tasaciones/refrescarDocs/',
     data: {tasacion_id: tasacion_id},
     success: function(res){
      mostrar_alerta("alerta_correcto","Documento Subido",1500);
      $('#contenedor_docs_tasacion').html(res);
      if(eliminar_cambio_pago)
      {
        $('#form_datos_solicitud_pago #puedo_cambiar_pago').remove();
      }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function generarDoc(tasacion_id,tipoDoc)
{
  mostrar_alerta("alerta_info","Generando Documento...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tasaciones/generarDoc/',
     data: {tasacion_id: tasacion_id,tipoDoc:tipoDoc},
     success: function(res){
       ocultar_alerta();
       $('#contenido_descargar_docs').html(res);
       $('#modal_descargar_dosc').modal('show');

     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function volver_a_firmar(tasacion_id)
{
  if(confirm('¿Has guardado los nuevos datos para la firma?.\nEs recomendable borrar el antiguo contrato firmado.\nSi sigues viendo el antiguo documento asegurate de borrar la cache'))
  {
    mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "JSON",
       url: base_url+'tasaciones/volverAFirmar/',
       data: {tasacion_id: tasacion_id},
       success: function(res){
         ocultar_alerta();
         if(res.result==1)
         {
           	 mostrar_alerta("alerta_correcto","Firma habilitada",1500);
         }
         else {
           	mostrar_alerta("alerta_error","No se ha podido habilitar",1500);
         }

       },
       error: function(){
        mostrar_alerta("alerta_error","Problemas de red...",1500);
      }
      }); //AJAX
  }

}
function firmarDocs(tasacion_id)
{
  mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tasaciones/firmarDocs/',
     data: {tasacion_id: tasacion_id},
     success: function(res){
       ocultar_alerta();
       $('#contenido_firmar_docs').html(res);
       $('#modal_firmar_dosc').modal('show');

     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function cerrar_ficha_tasacion()
{
  fichaTasActual = 0;
}
function eliminar_tasacion(tasacion_id)
{
  if(confirm("SE perderán todos los datos!!"))
  {
    mostrar_alerta("alerta_info","Eliminando... por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "JSON",
       url: base_url+'tasaciones/eliminarTasacion/',
       data: { tasacion_id:tasacion_id
       },
       success: function(res){
        if(res.result==1)
        {
            buscar_tasaciones();
        }
        else {
          mostrar_alerta("alerta_error","Operación no completada",1500);
        }
       },
       error: function(){
        if(avisar)
          mostrar_alerta("alerta_error","Problemas de red...",1500);
      }
      }); //AJAX
  }
}
function ver_ficha_tasacion(tasacion_id,msgEspera){
  tasacion_id = typeof tasacion_id !== 'undefined' ? tasacion_id : "";
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
  fichaTasActual = tasacion_id;
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tasaciones/getFormTasacion/',
	   data: {tasacion_id: tasacion_id},
	   success: function(res){
			ocultar_alerta();
      refrescar_avisos(0);
      $('#contenido_ficha_tasacion').html(res);
       $('#contenido_ficha_tasacion .selectpicker').selectpicker();
       $('#contenido_ficha_tasacion .mifecha').datepicker({
         autoclose: true,
         format:"dd-mm-yyyy",
         language: 'es'
       });
       $('#contenido_ficha_tasacion .mifechaanio').datepicker({
         autoclose: true,
         format:"yyyy-mm",
         language: 'es'
       });

       $('#contenido_ficha_tasacion [name=imagenes_tasacion]').on('click',function(){
         var src = $(this).prop('src');
         var id = $(this).prop('id').split('-')[1];
         $('#imagen_principal #image_actual').val(id);
         $('#imagen_principal .principal').prop('src',src);
       });
       $('#contenido_ficha_tasacion #imagen_principal .fa-arrow-left').on('click',function(){

         var imagen_actual = parseInt($('#imagen_principal #image_actual').val());
         var max_images = parseInt($('#imagen_principal #max_images').val());
         imagen_actual--; if(imagen_actual<0)  imagen_actual = max_images - 1;
         var src = $('#contenedor_imagenes_tasacion #idimg-'+imagen_actual).prop('src');
         $('#imagen_principal #image_actual').val(imagen_actual);
         $('#imagen_principal .principal').prop('src',src);
       });
       $('#contenido_ficha_tasacion #imagen_principal .fa-arrow-right').on('click',function(){

         var imagen_actual = parseInt($('#imagen_principal #image_actual').val());
         var max_images = parseInt($('#imagen_principal #max_images').val());
         imagen_actual++; if(imagen_actual>=max_images)  imagen_actual = 0;
         var src = $('#contenedor_imagenes_tasacion #idimg-'+imagen_actual).prop('src');
         $('#imagen_principal #image_actual').val(imagen_actual);
         $('#imagen_principal .principal').prop('src',src);
       });
       $('#contenido_ficha_tasacion #select_images').on('click',function(){
          $('#contenido_ficha_tasacion #imagenes_tas').trigger('click');
       });
       $('#contenido_ficha_tasacion #download_images').on('click',function(){
          descargar_imagenes();
       });
       $('#contenido_ficha_tasacion #imagenes_tas').on('change',function(){
          subirImagenes();
       });

       $('#contenido_ficha_tasacion #upload_factura').on('click',function(){
          $('#nombre_doc').val('factura');
          $('#nombre_doc_renombrar').val('');
          $('#contenido_ficha_tasacion #docs_tas').trigger('click');
       });
       $('#contenido_ficha_tasacion #upload_facturaG').on('click',function(){
          $('#nombre_doc').val('fGestoria');
          $('#nombre_doc_renombrar').val('');
          $('#contenido_ficha_tasacion #docs_tas').trigger('click');
       });
       $('#contenido_ficha_tasacion #upload_pago').on('click',function(){
          $('#nombre_doc').val('justificante_pago');
          $('#nombre_doc_renombrar').val('');
          $('#contenido_ficha_tasacion #docs_tas').trigger('click');
       });
       $('#contenido_ficha_tasacion #upload_notaInfo').on('click',function(){
          $('#nombre_doc').val('notaInformativa');
          $('#nombre_doc_renombrar').val('');
          $('#contenido_ficha_tasacion #docs_tas').trigger('click');
       });
       $('#contenido_ficha_tasacion #select_docs').on('click',function(){
         $('#nombre_doc').val('');
         $('#nombre_doc_renombrar').val('preguntar nombre');
          $('#contenido_ficha_tasacion #docs_tas').trigger('click');
       });
       $('#contenido_ficha_tasacion #docs_tas').on('change',function(){
         if($('#nombre_doc_renombrar').val()=="")
            subirDocumentos();
          else {
            var name = $(this).val().substr($(this).val().lastIndexOf("\\") + 1);
            name = name.substr(0,name.lastIndexOf("."));
            var doc_name = prompt("Introduzca el nombre para el documento", name);
            if (doc_name != null) {
              $('#nombre_doc_renombrar').val(doc_name);
              subirDocumentos();
            }

          }
       });

       $('#contenedor_docs_tasacion [name=eliminar_doc_s3]').on('click',function(){
         if(confirm("Se eliminará el documento"))
         {
           var key = $(this).prop('id');
           var mi_object = $(this).parent();
           mostrar_alerta("alerta_info","Eliminado Documento...por favor, espere");
           $.ajax({
              type: 'POST',
              dataType: "JSON",
              url: base_url+'tasaciones/deleteDocument/',
              data: {key: key,tasacion_id:tasacion_id},
              success: function(res){
                ocultar_alerta();
                if(res.result==1)
                 {
                   mi_object.remove();
                 }
                else
                 mostrar_alerta("alerta_error","No se ha podido eliminar...",1500);
              },
              error: function(){
               mostrar_alerta("alerta_error","No se ha podido eliminar...",1500);
             }
             }); //AJAX
         }

       });

       escuchar_chat(tasacion_id);
       habilitar_matricula_ppago("tasacion_ppago_ficha","tasacion_vehiculo_id_ficha");

       autocomplete_vehiculos_stock_ficha();

      $('#modal_ficha_tasacion').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function ver_seguimiento_tasacion(tasacion_id)
{
  mostrar_alerta("alerta_info","Preparando imágenes...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tasaciones/getSeguimientoTasacion/',
     data: {tasacion_id: tasacion_id},
     success: function(res){
       ocultar_alerta();

         $('#contenido_seguimiento_tasacion').html(res);
         $('#contenido_seguimiento_tasacion .selectpicker').selectpicker();
         $('#modal_seguimiento_tasacion').modal('show');
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function guardar_seguimiento_tasacion()
{
  mostrar_alerta("alerta_info","Guardando...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'tasaciones/saveSeguimientoTasacion',
     data: $('[name=form_seguimiento_tasacion]').serialize(),
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         	 mostrar_alerta("alerta_correcto","Seguimiento guardado",1000,function(){
             $('#modal_seguimiento_tasacion').modal('hide');
             buscar_tasaciones();
           });
       }
       else {
         	mostrar_alerta("alerta_error","No se ha podido guardar el seguimiento",1500);
       }


     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function ver_video_tasacion(url)
{
  var contenido = '<video class="video_tasacion" autoplay controls><source src="'+url+'" type="video/mp4">Tu navegador no soporta la reproducción.</video>';
  $('#contenido_video_tasacion').html(contenido);
  $('#modal_video_tasacion').modal('show');
}
function descargar_imagenes()
{
  mostrar_alerta("alerta_info","Preparando imágenes...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'tasaciones/downloadImages/',
     data: {tasacion_id: fichaTasActual},
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         $('#contenido_descargar_docs').html(res.message);
         $('#modal_descargar_dosc').modal('show');
       }
       else {
         	mostrar_alerta("alerta_error","No se han podido descargar las fotos",1500);
       }


     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function eliminarDoc(key)
{

}
function refrescar_avisos(avisar){
	avisar = typeof avisar !== 'undefined' ? avisar : 1;
	if(avisar)
		mostrar_alerta("alerta_info","Nuevos Avisos... por favor, espere");
	var data = {};
	data[csrfName] = csrfHash;
	$.ajax({
		 type: 'POST',
		 dataType: "JSON",
		 url: base_url+'dashboard/getAvisos/',
		 data: {
		 },
		 success: function(res){
			if(avisar)
				ocultar_alerta();
			if(res.result==1)
			{
					$('#menu_notificaciones_header #listado_noti').remove();
					$('#menu_notificaciones_header').prepend(res.pantalla_avisos);
			}


		 },
		 error: function(){
			if(avisar)
				mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
		}); //AJAX
}


var chatListener;
var myChat = {};
var viendo_chat = 0;
function iniciar_firebase()
{
	var config = {
	    apiKey: "AIzaSyCprmYzc1OhEbbeKIf-vaZUiyXXowX9RMM",
	    authDomain: "crestanevada-tas.firebaseapp.com",
	    databaseURL: "https://crestanevada-tas.firebaseio.com",
	    projectId: "crestanevada-tas",
	    storageBucket: "crestanevada-tas.appspot.com",
	    messagingSenderId: "510458128753",
	  };
		var subscripcion;

	  firebase.initializeApp(config);
}
function escuchar_chat(tasacion_id)
{
  firebase.auth().signInAnonymously().then(response => {

      try{
        chatListener = firebase.database().ref('/Chats/chat-'+tasacion_id); //,'child_added'

        chatListener.on('value', function(snapshot) {

          var nuevosMensajes = 0;
          var contenido = "";
          var current = new Date();
          console.log("Nuevo Chat");
          if(viendo_chat)
          {
            //Tengo que actualizarTas
            let updateData = { [myUserId]:0};
            firebase.database().ref('/Tasaciones/'+tasacion_id).update(updateData);
          }
          snapshot.forEach(function(childSnapshot) {
            var childData = childSnapshot.val();

            contenido += "<div class='message ";
            if(childData['user_id']!=myUserId) contenido += " left'> ";
            if(childData['user_id']==myUserId) contenido += " right'> ";
            contenido += '<div class="msg-detail"><div class="msg-info">';
            let usuchat = "Yo";
            if(childData['user_id']!=myUserId) usuchat = $('#mis_companieros #companiero-'+childData['user_id']).val();
            contenido += '<p><span class="usuario">'+usuchat+'</span> '+timeDifference(current,new Date(childData['time']))+'</p></div>';
            contenido += '<div class="msg-content"><span class="triangle"></span><p class="line-breaker ">'+childData['message']+'</p></div>';
            contenido += '  </div></div>';
            if((childData[ myUserId ]==undefined || childData[ myUserId ]==0) && childData['id']!=undefined)
            {
              if(viendo_chat)
              {
                //console.log("Estoy viendo el chat, así que actualizo");
                let updateData = {};
                updateData['/'+childData['id']+'/'+myUserId] = 1;
                chatListener.update(updateData);
              }
              else
              {
                nuevosMensajes++;
              }

            }
          });
          $('#contenido_chat').html(contenido);
          //console.log('Tengo nuevos mensajes '+nuevosMensajes);
          var contenido = "Ver Chat";
          if(nuevosMensajes>0) contenido += " ("+nuevosMensajes+")  <i class='fa fa-comment nuevo_chat'></i>";
          $('#boton_chat').html(contenido);
          if(nuevosMensajes>0)
          {
            //’console.log("Hago Scroll");
            $("#contenido_chat").animate({ scrollTop: $('#contenido_chat').prop("scrollHeight")}, 1000);
          }

      });

      }catch(err){
        console.log(err.message);
          console.log("Error Itentando leer base datos  "+JSON.stringify(err, null, 4));
      }
    })
    .catch(error => {
        // handle error by showing alert
        console.log("Error Logueo  "+JSON.stringify(error, null, 4));
    });
}
function pararChat(){
  viendo_chat = 0;
  chatListener.off('value');
  setTimeout(function(){
    console.log("Add class");
    $('body').addClass('modal-open');
	}
,500);
}
function cerrarModalPrincipal()
{
  setTimeout(function(){

    if($('.modal').hasClass('in'))
    {
      console.log("Add class");
      $('body').addClass('modal-open');
    }


	}
,400);
}
function verChat(tasacion_id){
  viendo_chat = 1;
  chatListener.off('value');
  escuchar_chat(tasacion_id);
  var contenido = "Ver Chat";
  $('#boton_chat').html(contenido);
  $('#modal_chat').modal('show');
  setTimeout(function(){
			$("#contenido_chat").animate({ scrollTop: $('#contenido_chat').prop("scrollHeight")}, 800);
	}
,400);
}
function verChatOld(tasacion_id){


  mostrar_alerta("alerta_info","Cargando histórico chat...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "HTML",
     url: base_url+'tasaciones/getChatHistorico/',
     data: {tasacion_id: tasacion_id},
     success: function(res){
       ocultar_alerta();

         $('#contenido_chat_old').html(res);
         console.log("levanto el chat");
         $('#modal_chat_old').modal('show');
         setTimeout(function(){
       			$("#contenido_chat_old").animate({ scrollTop: $('#contenido_chat').prop("scrollHeight")}, 800);
       	  }
        ,400);
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX


}

function escribir_chat()
{
  var tasacion_id = $('#contenido_ficha_tasacion [name=tasacion_id]').val();
  let avisos_trabajador = {};
  $('#trabajadores_tasacion [name=trabajador]').each(function(){
    let trabajador = $(this).val();
    if(trabajador!=myUserId)
      avisos_trabajador[ trabajador ] = 1;
  });

  let newTasacionChat =firebase.database().ref('/Tasaciones/'+tasacion_id).update(avisos_trabajador);
  let newChat = chatListener.push({});
  // Mock message
  const id = Date.now().toString();
  newChat.set({
    id: newChat.key,
    user_id: myUserId,
    time: Date.now(),
    message: $('#modal_chat #texto_chat').val()
  });
  $('#modal_chat #texto_chat').val('');
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tasaciones/nuevoChat/',
	   data: {user_id: myUserId,tasacion_id:tasacion_id},
	   success: function(res){
	   },
	   error: function(jqXHR, textStatus){
		}
    }); //AJAX
  //this.api.nuevoChat(this.tasacion['tasacion_id'],this.myData.datosPersonales['user_id'])
}

function timeDifference(current, previous) {

    var msPerMinute = 60 * 1000;
    var msPerHour = msPerMinute * 60;
    var msPerDay = msPerHour * 24;
    var msPerMonth = msPerDay * 30;
    var msPerYear = msPerDay * 365;

    var elapsed = current - previous;
    if(Math.round(elapsed/1000)==0)
      return "Ahora";
    elapsed += 20*1000;
    if (elapsed < msPerMinute) {
         return 'hace ' + Math.round(elapsed/1000) + ' segundos';
    }

    else if (elapsed < msPerHour) {
         return 'hace ' + Math.round(elapsed/msPerMinute) + ' minutos';
    }

    else if (elapsed < msPerDay ) {
         return 'hace ' + Math.round(elapsed/msPerHour ) + ' horas';
    }

    else if (elapsed < msPerMonth) {
        return 'hace ' + Math.round(elapsed/msPerDay) + ' días';
    }

    else if (elapsed < msPerYear) {
        return 'hace ' + Math.round(elapsed/msPerMonth) + ' meses';
    }

    else {
        return 'hace ' + Math.round(elapsed/msPerYear ) + ' años';
    }
}

function verRespInscripcion(item_id){
   item_id = typeof item_id !== 'undefined' ? item_id : "";
	 mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'inscripciones/getFormItem',
			data: {item_id:item_id},
			success: function(html){
				ocultar_alerta();

				var options_css = {	'min-width': '80%'};
				var options_custom = {
			    'titulo': 'Respuestas Formulario de Inscripción',
					'boton_cancelar': '1',
			    'boton_cancelar_texto': 'Cancelar',
			    'boton_cancelar_class': 'btn-gray',
			    'boton_cancelar_callback': '',
			    'boton_guardar': '0',
			    'boton_guardar_texto': 'Guardar Usuario',
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
