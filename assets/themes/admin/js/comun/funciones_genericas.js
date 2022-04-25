
/************************************************************************
  FUNCION PARA CONTROLAR EVENTOS EN FORMULARIO DE BUSQUEDA
************************************************************************/
function loadSearchForm(form,mifunction)
{
  //La funcion buscar_listado se sobreescribirá en cada página.
	$('#'+form+' .mifecha').on('changeDate',function() {
		mifunction();
	});
	$('#'+form+' .selectpicker').change(function(){
		mifunction();
	});
	$('#'+form+' input[type=text]').keyup(function() {
		$('#page_actual').val(1);
		delay(
		mifunction
	, 800 );});

}

/************************************************************************
  FUNCION PARA DAR ESTILO Y FORMATO A FORMULARIO
************************************************************************/
function loadWidzardForm(form)
{
  $('#'+form+' .selectpicker').selectpicker();
  $('#'+form+' .mifecha').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    language: 'es'
  });
  var tipos_text = ['text','email','password'];
  for(var i in tipos_text)
  {
    $('#'+form+' .form_color_inputs input[type='+tipos_text[i]+']').blur(function(){
       if($(this).val()=="") $(this).removeClass('has_value');
       else $(this).addClass('has_value');
    });
    //Inicializamos la primera vez.
    $('#'+form+' .form_color_inputs input[type='+tipos_text[i]+']').each(function(){
       if($(this).val()=="") $(this).removeClass('has_value');
       else $(this).addClass('has_value');
    });
  }

  $('#'+form+' .form_color_inputs textarea').blur(function(){
     if($(this).val()=="") $(this).removeClass('has_value');
     else $(this).addClass('has_value');
  });
  //Iniciamos la primera vez
  $('#'+form+' .form_color_inputs textarea').each(function(){
     if($(this).val()=="") $(this).removeClass('has_value');
     else $(this).addClass('has_value');
  });
  if($('#'+form+' .mitime').length)
  {
    $('#'+form+' .mitime').datetimepicker({
      format:'DD-MM-YYYY HH:mm',
    });
  }

  if($('#'+form+' .datatable tbody tr').length) initDataTables('#'+form);
  
  // Se activa el botón para que simule el click para abrir ventana de selección de archivos
  // Se hace la llamada a la función que se indica en el botón
  $('#'+form+' .subirDoc').on('click',function(){
    console.log("Lazon por aqui con "+form);
     $('#'+form).find(".fileSubirDoc").trigger('click');
     $('#cargar_archivos_locales #archivo_tmp_id').val($(this).data('idarchivo'));
     if(($(this).data('callback'))!=undefined)
       executeFunctionByName($(this).data('callback'),window);
	 

     //executeFunctionByName("prueba(1,2,3)",window);
     //executeFunctionByName("prueba1()",window);
  });
  
  // Esto es cuando se carga un solo archivo
  // Cuando se elige el archivo se hace el submit
  $('#'+form+' .fileSubirDoc').change(function(){
    var mensaje = "Cargando, por favor, espere...";
    if($(this).data('mensaje')!=undefined) mensaje = $(this).data('mensaje');
    mostrar_alerta("alerta_info",mensaje);
    $(this).parent().submit();
  });
  
   $('.subirImagen').on('click',function(){
     $('#'+form).find(".fileSubirImagen").trigger('click');
     if(($(this).data('callback'))!=undefined)
       executeFunctionByName($(this).data('callback'),window);


  });
  
   $('#'+form+' .fileSubirImagen').change(function(){
    var mensaje = "Cargando, por favor, espere...";
    if($(this).data('mensaje')!=undefined) mensaje = $(this).data('mensaje');
    //mostrar_alerta("alerta_info",mensaje);
    //$(this).parent().submit();
	$('#imagen').val(1);
  });
  
  /*
    SELECTPICKER POR AJAX
  */
  $('#'+form+' .selectpicker_ajax').each(function(){

		var placehoder = $(this).data('place-holder');
    var title = $(this).data('empty-title');
    var url_busqueda = $(this).data('ajax-url');
    var always_text = $(this).data('always-option-text');
    var always_value = $(this).data('always-option-value');
    var always_subtext = $(this).data('always-option-subtext');
		console.log("Esta es la url "+url_busqueda);
		var options = {
		  values: "a, b, c",
		  ajax: {
		    url: url_busqueda,
		    type: "POST",
		    dataType: "json",
		    data: {
					q: "{{{q}}}",
					always_text:always_text,
					always_value:always_value,
					always_subtext:always_subtext
		    }
		  },
		  locale: {
				emptyTitle: title || placehoder || "Escriba para empezar",
        searchPlaceholder: placehoder || "Buscar",
        statusInitialized: "", //Escriba para iniciar búsqueda
        statusNoResults: "No hay resultados",
        statusSearching: "Buscando...",
        currentlySelected: "Seleccionado"
		  },
		  log: 3,
		  preprocessData: function(data) {
		    var i,
		      l = data.length,
		      array = [];
		    if (l) {
		      for (i = 0; i < l; i++) {
		        array.push(
		          $.extend(true, data[i], {
		            text: data[i].text,
		            value: data[i].value,
		            data: {
		              subtext: data[i].subtext
		            }
		          })
		        );
		      }
		    }
		    // You must always return a valid array when processing data. The
		    // data argument passed is a clone and cannot be modified directly.
		    return array;
		  }
		};
		$(this).selectpicker()
	 .ajaxSelectPicker(options);
	});
	
	
	$('.subirDocMultiple').on('click',function(){
     $('#'+form).find(".fileSubirDocMultiple").trigger('click');
     if(($(this).data('callback'))!=undefined)
       executeFunctionByName($(this).data('callback'),window);

     //executeFunctionByName("prueba(1,2,3)",window);
     //executeFunctionByName("prueba1",window);
  });
  
  $('#'+form+' .fileSubirDocMultiple').change(function(){
    var mensaje = "Cargando, por favor, espere...";
    if($(this).data('mensaje')!=undefined) mensaje = $(this).data('mensaje');
    mostrar_alerta("alerta_info",mensaje);
    $(this).parent().submit();
  });

}

/************************************************************************
  FUNCION PARA DAR ESTILO Y FORMATO A FORMULARIO

  var options_custom = {
    'titulo': '-',
    'boton_cancelar': '1', //Mostrar 1 Ocultar 0
    'boton_cancelar_texto': 'Cancelar',
    'boton_cancelar_class': 'btn-gray',
    'boton_cancelar_callback': '', //Funcion a ejecutar
    'boton_guardar': '1',
    'boton_guardar_texto': 'Guardar',
    'boton_cancelar_class': 'btn-success',
    'boton_guardar_callback': 'guardarItem'
  }


************************************************************************/
function lanzarWizardFormModal(form,options_css,options_custom,html)
{
  $('#'+form+" .modal-body").html(html);
  loadWidzardForm(form);
  for(var css in options_css)
  {
    $('#'+form+" .modal-dialog").css(css,options_css[css]);
  }

  if('titulo' in options_custom) $('#'+form+' .modal-header h4').html(options_custom['titulo']);
  else $('#'+form+' .modal-header h4').html('-');

  // Texto botones
  if('boton_cancelar_texto' in options_custom)
    $('#'+form+' .modal-footer .boton_cancelar').html(options_custom['boton_cancelar_texto']);
  else
    $('#'+form+' .modal-footer .boton_cancelar').html('Cancelar');

  if('boton_guardar_texto' in options_custom)
    $('#'+form+' .modal-footer .boton_guardar').html(options_custom['boton_guardar_texto']);
  else
    $('#'+form+' .modal-footer .boton_guardar').html('Guardar');

    // Mostrar botones
  if('boton_cancelar' in options_custom)
  {
    if(options_custom['boton_cancelar']==1)
      $('#'+form+' .modal-footer .boton_cancelar').show();
    else
      $('#'+form+' .modal-footer .boton_cancelar').hide();
  }

  if('boton_guardar' in options_custom)
  {
    if(options_custom['boton_guardar']==1)
      $('#'+form+' .modal-footer .boton_guardar').show();
    else
      $('#'+form+' .modal-footer .boton_guardar').hide();
  }

  // Clases botones
  if('boton_cancelar_class' in options_custom)
    $('#'+form+' .modal-footer .boton_cancelar').removeClass().addClass(options_custom['boton_cancelar_class']+' btn boton_cancelar');
  else
    $('#'+form+' .modal-footer .boton_cancelar').removeClass().addClass('btn btn-gray boton_cancelar');

  if('boton_guardar_class' in options_custom)
    $('#'+form+' .modal-footer .boton_guardar').removeClass().addClass(options_custom['boton_guardar_class']+' btn boton_guardar');
  else
    $('#'+form+' .modal-footer .boton_guardar').removeClass().addClass('btn btn-success boton_guardar');

  // Funcion botones
  if('boton_cancelar_callback' in options_custom)
    $('#'+form+' .modal-footer .boton_cancelar').attr('onclick',options_custom['boton_cancelar_callback']);
  else
    $('#'+form+' .modal-footer .boton_cancelar').attr('onclick','');

  if('boton_guardar_callback' in options_custom)
  {
    $('#'+form+' .modal-footer .boton_guardar').attr('onclick',options_custom['boton_guardar_callback']);
  }
  else
    $('#'+form+' .modal-footer .boton_guardar').attr('onclick','');


  //Lanzamos modal
  $('#'+form).modal('show');
}



/************************************************************************
  FUNCION PARA DAR ESTILO Y FORMATO A FORMULARIO

  var options_custom = {
    'titulo': '-',
    'boton_cancelar': '1', //Mostrar 1 Ocultar 0
    'boton_cancelar_texto': 'Cancelar',
    'boton_cancelar_class': 'btn-gray',
    'boton_cancelar_callback': '', //Funcion a ejecutar
    'boton_guardar': '1',
    'boton_guardar_texto': 'Guardar',
    'boton_cancelar_class': 'btn-success',
    'boton_guardar_callback': 'guardarItem'
  }


************************************************************************/
function lanzarWizardFormPantalla(pantalla_mostrar,pantalla_ocultar,html)
{
  $('#'+pantalla_mostrar).html(html);
  loadWidzardForm(pantalla_mostrar);
  mostrarPantalla(pantalla_mostrar,pantalla_ocultar);

}

function mostrarPantalla(pantalla_mostrar,pantalla_ocultar)
{
  $('#'+pantalla_ocultar).hide();
  $('#'+pantalla_mostrar).effect('slide', { direction: 'right', mode: 'show' }, 800);
}

function cerrarPantalla(pantalla_mostrar,pantalla_ocultar)
{
  $('#'+pantalla_ocultar).hide();
  $('#'+pantalla_mostrar).effect('slide', { direction: 'left', mode: 'show' }, 800);
}




/************************************************************************
  FUNCION PARA PREGUNTAR SI ELIMINAR UN ITEM DE PANTALLA
************************************************************************/
function loadEliminarItem(item_id,confirmacion,titulo,mensaje,callback)
{

  confirmacion = typeof confirmacion !== 'undefined' ? confirmacion : 0;
  titulo = typeof confirmacion !== 'undefined' ? titulo : "Activar";
  mensaje = typeof mensaje !== 'undefined' ? mensaje : "Se procederá a activar";
  callback = typeof callback !== 'undefined' ? callback : "";

  $('#modal_eliminar_item #id_item_eliminar').val(item_id);
  $('#modal_eliminar_item #callback_function_eliminar').val(callback);
  if(confirmacion==1)
  {
    $('#modal_eliminar_item #titulo_eliminar_item').html(titulo);
    $('#modal_eliminar_item #mensaje_eliminar_item').html(mensaje);
    $('#modal_eliminar_item').modal('show');
  }
  else
  {
    confirmarEliminarItem();
  }

}
/************************************************************************
  FUNCION QUE MANDA AL CONTROLADOR ACTUAL EL ITEM A ELIMINAR
************************************************************************/
function confirmarEliminarItem(){
	var item_id = $('#modal_eliminar_item #id_item_eliminar').val();
	mostrar_alerta("alerta_info","Borrando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+vista+'/delItem',
	   data: { item_id:item_id},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1){
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
					 $('#modal_eliminar_item').modal('hide');
           var name_callback = $('#modal_eliminar_item #callback_function_eliminar').val();
           if(name_callback!="")
            executeFunctionByName(name_callback,window);
				 });
			 }
			 else {
			 		mostrar_alerta("alerta_error",res.message,2000);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}


/************************************************************************
  FUNCION PARA ACTIVAR ITEM
************************************************************************/
function loadActivarItem(item_id,confirmacion,titulo,mensaje,callback)
{
  confirmacion = typeof confirmacion !== 'undefined' ? confirmacion : 0;
  titulo = typeof confirmacion !== 'undefined' ? titulo : "Activar";
  mensaje = typeof mensaje !== 'undefined' ? mensaje : "Se procederá a activar";
  callback = typeof callback !== 'undefined' ? callback : "";

  $('#modal_activar_item #id_item_activar').val(item_id);
  $('#modal_activar_item #callback_function_activar').val(callback);
  if(confirmacion==1)
  {
    $('#modal_activar_item #titulo_activar_item').html(titulo);
    $('#modal_activar_item #mensaje_activar_item').html(mensaje);
  	$('#modal_activar_item').modal('show');
  }
  else
  {
    confirmarActivarItem();
  }
}
/************************************************************************
  FUNCION QUE MANDA AL CONTROLADOR ACTUAL EL ITEM A ELIMINAR
************************************************************************/
function confirmarActivarItem(){

	var item_id = $('#modal_activar_item #id_item_activar').val();
	mostrar_alerta("alerta_info","Activando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+vista+'/activarItem',
	   data: { item_id:item_id},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1){
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
					$('#modal_activar_item').modal('hide');
           var name_callback = $('#modal_activar_item #callback_function_activar').val();
           if(name_callback!="")
            executeFunctionByName(name_callback,window);
				 });
			 }
			 else {
			 		mostrar_alerta("alerta_error",res.message,2000);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

/************************************************************************
  FUNCION PARA DESACTIVAR ITEM
************************************************************************/
function loadDesactivarItem(item_id,confirmacion,titulo,mensaje,callback)
{
  confirmacion = typeof confirmacion !== 'undefined' ? confirmacion : 0;
  titulo = typeof confirmacion !== 'undefined' ? titulo : "Desactivar";
  mensaje = typeof mensaje !== 'undefined' ? mensaje : "Se procederá a desactivar";
  callback = typeof callback !== 'undefined' ? callback : "";

  $('#modal_desactivar_item #id_item_desactivar').val(item_id);
  $('#modal_desactivar_item #callback_function_desactivar').val(callback);
  if(confirmacion==1)
  {
    $('#modal_desactivar_item #titulo_desactivar_item').html(titulo);
    $('#modal_desactivar_item #mensaje_desactivar_item').html(mensaje);
  	$('#modal_desactivar_item').modal('show');
  }
  else
  {
    confirmarDesactivarItem();
  }
}
/************************************************************************
  FUNCION QUE MANDA AL CONTROLADOR ACTUAL EL ITEM A ELIMINAR
************************************************************************/
function confirmarDesactivarItem(){

	var item_id = $('#modal_desactivar_item #id_item_desactivar').val();
	mostrar_alerta("alerta_info","Activando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+vista+'/desactivarItem',
	   data: { item_id:item_id},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1){
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
					$('#modal_desactivar_item').modal('hide');
           var name_callback = $('#modal_desactivar_item #callback_function_desactivar').val();
           if(name_callback!="")
            executeFunctionByName(name_callback,window);
				 });
			 }
			 else {
			 		mostrar_alerta("alerta_error",res.message,2000);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}




function executeFunctionByName(functionName, context /*, args */) {
  var aux  = functionName.split('(');
  var aux2 = aux[1].split(')');

  var nombre_funcion = aux[0];
  var parametros     = aux2[0];

  var argumentos = parametros.split(',');

  console.log('Nombre:'+nombre_funcion+ ' Parámetros:'+argumentos);

  return context[nombre_funcion].apply(context, argumentos);
}

function loadAdeItem(item_id,accion,confirmacion,titulo,mensaje,callback,ctrlFuncion){
  console.log("Estoy en loadAdeItem");

  accion       = typeof accion       !== 'undefined' ? accion : "Eliminar";
  confirmacion = typeof confirmacion !== 'undefined' ? confirmacion : 0;
  titulo       = typeof confirmacion !== 'undefined' ? titulo : "Eliminar";
  mensaje      = typeof mensaje      !== 'undefined' ? mensaje : "Se procederá a " + accion;
  callback     = typeof callback     !== 'undefined' ? callback : "";
  ctrlFuncion  = typeof ctrlFuncion  !== 'undefined' ? ctrlFuncion : 'adeItem';

  $('#modal_ade_item #id_item_ade').val(item_id);
  $('#modal_ade_item #id_item_accion').val(accion);
  $('#modal_ade_item #callback_function_ade').val(callback);
  $('#modal_ade_item #ctrlFuncion_function_ade').val(ctrlFuncion);

  if(confirmacion==1){
    $('#modal_ade_item #titulo_ade_item').html(titulo);
    $('#modal_ade_item #mensaje_ade_item').html(mensaje);
    $('#modal_ade_item #boton_ade_item').html(accion);
    if(accion=="Eliminar")
      $('#modal_ade_item #boton_ade_item').removeClass().addClass('btn btn-danger');
    if(accion=="Activar")
      $('#modal_ade_item #boton_ade_item').removeClass().addClass('btn btn-success');
    if(accion=="Desactivar")
      $('#modal_ade_item #boton_ade_item').removeClass().addClass('btn btn-warning');
  	$('#modal_ade_item').modal('show');
  }
  else{
    confirmarAdeItem(ctrlFuncion);
  }
}

function confirmarAdeItem(ctrlFuncion){


    ctrlFuncion  = typeof ctrlFuncion  !== 'undefined' ? ctrlFuncion : $('#modal_ade_item #ctrlFuncion_function_ade').val();
    console.log(ctrlFuncion);
	var item_id        = $('#modal_ade_item #id_item_ade').val();
	var item_id_accion = $('#modal_ade_item #id_item_accion').val();
	mostrar_alerta("alerta_info", item_id_accion.slice(0, -1)  + "ndo...por favor, espere"); // Transformamos Eliminar por Eliminando ... con todas las acciones igual.
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+vista+'/'+ctrlFuncion,
	   data: { item_id:item_id, item_id_accion : item_id_accion},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1){
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
				   $('#modal_ade_item').modal('hide');
           var name_callback = $('#modal_ade_item #callback_function_ade').val();
           if(name_callback!="")
             executeFunctionByName(name_callback,window);
				 });
			 }
			 else {
			 	 mostrar_alerta("alerta_error",res.message,2000);
			 }
	   },
	   error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
  }); //AJAX
}

function cargarItemsPrincipal(callback){

  callback    = typeof callback !== 'undefined' ? callback : '';

 	mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+vista+'/getItems',
	   data: $('[name='+vista+'_filter]').serialize(),
	   success: function(res){
			 ocultar_alerta();
		   $('#resultados_'+vista).html(res);
			 loadWidzardForm('resultados_'+vista);
       if(callback!="") // Si no queremos ejecutar ninguna funcion se manda un espacio para que no ejecute cargarItems()
         executeFunctionByName(callback,window);

	   },
	   error: function(jqXHR, textStatus){
       $('#resultados_'+vista).html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function irPaginaDatatable(datatable_id){

  var table = $('#'+datatable_id).DataTable();
  var pagina = parseInt(localStorage.getItem(datatable_id));

  if (!isNaN(pagina)) {
      //Decimos a la table que cargue la página requerida
      table.page(pagina).draw(false);
      //Eliminamos la página del localStorage
      localStorage.removeItem(datatable_id);
  }
  

}

function ejecutarAjaxBD(datos){
  datos             = typeof datos !== 'undefined' ? datos : {}; // Si no le pasamos nada, es un array

  var controlador   = typeof datos.controlador   !== 'undefined' ? datos.controlador : '';
  var datos_aux     = typeof datos.datos_aux     !== 'undefined' ? datos.datos_aux : '';
  var callback      = typeof datos.callback      !== 'undefined' ? datos.callback : '';
  var texto_info    = typeof datos.texto_info    !== 'undefined' ? datos.texto_info : 'Realizando acción... por favor, espere';

	mostrar_alerta("alerta_info",texto_info); // Transformamos Eliminar por Eliminando ... con todas las acciones igual.
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
     url: base_url+vista+'/'+controlador,
	   data: {datos_aux : datos_aux},
     success: function(res){
			 ocultar_alerta();
			 if(res.result==1){
				 mostrar_alerta("alerta_correcto",res.message,1000,function(){
           if(callback!="")
             executeFunctionByName(callback,window);
				 });
			 }
			 else {
			 	 mostrar_alerta("alerta_error",res.message,2000);
			 }
	   },
	   error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
  }); //AJAX
}

function guardarPaginaDatatable(datatable_id){
  console.log("Voy a salir "+datatable_id);
  return 1;
  
  var pagina = $('#'+datatable_id).DataTable().page.info();

  if (typeof table.page.info() !== 'undefined'){
    var pagina_actual = table.page();
    localStorage.setItem(datatable_id, pagina_actual);
  }

}

/************************************************************************
  FUNCIONES GENERICAS PANTALLA DE fichaItem y  guardarItem
************************************************************************/
function fichaItemPantalla(item_id, datos){
   item_id         = typeof item_id !== 'undefined' ? item_id : "";
   datos           = typeof datos !== 'undefined' ? datos : {}; // Si no le pasamos nada, es un array

   var controlador = typeof datos.controlador !== 'undefined' ? datos.controlador : 'getFormItem';
   var callback    = typeof datos.callback    !== 'undefined' ? datos.callback : '';
   var datos_aux   = typeof datos.datos_aux   !== 'undefined' ? datos.datos_aux : '';

   console.log(datos);
	 mostrar_alerta("alerta_info","Guardando...por favor, espere");
	 $.ajax({
			type: 'POST',
			dataType: 'HTML',
			url: base_url+vista+'/'+controlador,
			data: {item_id:item_id, datos_aux: datos_aux},
			success: function(html){
				ocultar_alerta();
        lanzarWizardFormPantalla('formulario_'+vista,'pantalla_principal',html);
		
		$('.myinputenriquecido_red').summernote({
	height: 120,
	toolbar: [
	['font', ['bold', 'italic', 'underline', 'clear']],
	['fontsize', ['fontsize']],
	['color', ['color']],
	['para', ['ul', 'ol', 'paragraph']],
	['insert', ['link']], //
	['view', ['codeview']]
	]
	});
		
		
		if(datos_aux=='Direcciones')
		$('#pestanie_'+vista+'-4').trigger('click');
        if(callback!="")
          executeFunctionByName(callback,window);

			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
	 }); //AJAX
}

function guardarItemPantalla(controlador, name_item, callback){
  controlador = typeof controlador !== 'undefined' ? controlador : "saveItem";
  name_item   = typeof name_item   !== 'undefined' ? name_item : "item";
  name_item   = "item";
  controlador = "saveItem";
  callback    = typeof callback    !== 'undefined' ? callback : "cargarItems()";

  console.log(controlador);
  console.log(name_item);
  console.log(callback);

  //return;

  mostrar_alerta("alerta_info","Guardando...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+vista+'/'+controlador,
     data:$('[name='+vista+'_form_'+name_item+']').serialize(),
     success: function(res){
       ocultar_alerta();
       if(res.result==1){
         mostrar_alerta("alerta_correcto","Datos guardados",1000,function(){
           cerrarPantalla('pantalla_principal','formulario_'+vista);
           if(callback!="" && callback!=" ") // Si no queremos ejecutar ninguna funcion se manda un espacio para que no ejecute cargarItems()
             executeFunctionByName(callback,window);
         });
       }
       else {
          $('#validation_'+name_item+'_errors').html(res.message);
       }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}

/************************************************************************
  FUNCIONES GENERICAS MODALES DE fichaItem y  guardarItem
************************************************************************/
function fichaItemModal(item_id, datos){
   item_id         = typeof item_id !== 'undefined' ? item_id : "";
   datos           = typeof datos !== 'undefined' ? datos : {}; // Si no le pasamos nada, es un array

   var controlador = typeof datos.controlador !== 'undefined' ? datos.controlador : 'getFormItem';
   var datos_aux   = typeof datos.datos_aux   !== 'undefined' ? datos.datos_aux : '';

   var options_css = {	'min-width': '50%'};
   var options_custom = {
     'titulo': 'Guardar',
     'boton_cancelar': '0',
     'boton_cancelar_texto': 'Cancelar',
     'boton_cancelar_class': 'btn-gray',
     'boton_cancelar_callback': '',
     'boton_guardar': '1',
     'boton_guardar_texto': 'Guardar',
     'boton_guardar_class': 'btn-warning',
     'boton_guardar_callback': 'guardarItemModal()'
   }

   // Los css hay que pasarlos enteros, no se puede hacer por partes (El problema son los guiones medios). Prevalece lo que se le pasa por parámetros

   console.log(datos);
   console.log(options_css);
   console.log(options_custom);

   options_css = typeof datos.options_css !== 'undefined' ? datos.options_css : options_css;

   datos.options_custom = typeof datos.options_custom !== 'undefined' ? datos.options_custom : {};

   options_custom.titulo                  = typeof datos.options_custom.titulo                  !== 'undefined' ? datos.options_custom.titulo : options_custom.titulo;
   options_custom.boton_cancelar          = typeof datos.options_custom.boton_cancelar          !== 'undefined' ? datos.options_custom.boton_cancelar : options_custom.boton_cancelar;
   options_custom.boton_cancelar_texto    = typeof datos.options_custom.boton_cancelar_texto    !== 'undefined' ? datos.options_custom.boton_cancelar_texto : options_custom.boton_cancelar_texto;
   options_custom.boton_cancelar_class    = typeof datos.options_custom.boton_cancelar_class    !== 'undefined' ? datos.options_custom.boton_cancelar_class : options_custom.boton_cancelar_class;
   options_custom.boton_cancelar_callback = typeof datos.options_custom.boton_cancelar_callback !== 'undefined' ? datos.options_custom.boton_cancelar_callback : options_custom.boton_cancelar_callback;
   options_custom.boton_guardar           = typeof datos.options_custom.boton_guardar           !== 'undefined' ? datos.options_custom.boton_guardar : options_custom.boton_guardar;
   options_custom.boton_guardar_texto     = typeof datos.options_custom.boton_guardar_texto     !== 'undefined' ? datos.options_custom.boton_guardar_texto : options_custom.boton_guardar_texto;
   options_custom.boton_guardar_class     = typeof datos.options_custom.boton_guardar_class     !== 'undefined' ? datos.options_custom.boton_guardar_class : options_custom.boton_guardar_class;
   options_custom.boton_guardar_callback  = typeof datos.options_custom.boton_guardar_callback  !== 'undefined' ? datos.options_custom.boton_guardar_callback : options_custom.boton_guardar_callback;

   console.log(options_css);
   console.log(options_custom);

	 mostrar_alerta("alerta_info","Guardando...por favor, espere");
	 $.ajax({
			type: 'POST',
			dataType: 'HTML',
			url: base_url+vista+'/'+controlador,
			data: {item_id:item_id, datos_aux: datos_aux},
			success: function(html){
				ocultar_alerta();
				lanzarWizardFormModal('modal_guardar_item',options_css,options_custom,html);

			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX
}

function guardarItemModal(controlador, name_item, callback){

  controlador = typeof controlador !== 'undefined' ? controlador : "saveItem";
  name_item   = typeof name_item   !== 'undefined' ? name_item : "item";
  callback    = typeof callback    !== 'undefined' ? callback : "cargarItems()";

  console.log(controlador);
  console.log(name_item);
  console.log(callback);

  //return;

  mostrar_alerta("alerta_info","Guardando...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+vista+'/'+controlador,
     data:$('[name='+vista+'_form_'+name_item+']').serialize(),
     success: function(res){
       ocultar_alerta();
       if(res.result==1){
         mostrar_alerta("alerta_correcto","Datos guardados",1000,function(){
           $('.modal').modal('hide');
           if(callback!="" && callback!=" ") // Si no queremos ejecutar ninguna funcion se manda un espacio para que no ejecute cargarItems()
             executeFunctionByName(callback,window);
         });
       }
       else {
          $('#validation_'+name_item+'_errors').html(res.message);
       }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}

function enviarArchivoTemporal(response){

  console.dir(response);
  if(response.result==1)
  {
    $('#archivo_tmp_'+response.archivo_id).val(response.archivo_tmp);
    $('#preview_cartel_'+response.archivo_id).attr('src','/'+response.archivo_tmp);
    if(response.callback!='' && response.callback!=undefined)
        executeFunctionByName(response.callback,window);
    mostrar_alerta("alerta_info",response.message,1000);
  }
  else {
    mostrar_alerta("alerta_error",response.message,1000);
  }

}

// Esta funcion solo está pensada para cargar otras tablas dentro de un item principal. Solo admite parámetros simples
function cargarItemsSecundario(datos){

  datos             = typeof datos !== 'undefined' ? datos : {}; // Si no le pasamos nada, es un array

  var controlador   = typeof datos.controlador   !== 'undefined' ? datos.controlador : '';
  var datos_aux     = typeof datos.datos_aux     !== 'undefined' ? datos.datos_aux : '';
  var callback      = typeof datos.callback      !== 'undefined' ? datos.callback : '';
  var contenedor_id = typeof datos.contenedor_id !== 'undefined' ? datos.contenedor_id : '';

 	mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+vista+'/'+controlador,
	   data: {datos_aux : datos_aux},
	   success: function(res){
			 ocultar_alerta();
		   $('#'+contenedor_id).html(res);
			 loadWidzardForm(contenedor_id);
       if(callback!="")
         executeFunctionByName(callback,window);

	   },
	   error: function(jqXHR, textStatus){
       $('#'+contenedor_id).html('');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
  }); //AJAX
}
/************************************************************************
  FUNCION QUE EJECUTA LIMPIA EL CAMPO Y LA PREVIEW DE UN CAMPO IMAGEN
************************************************************************/
function eliminarImagenTemporal(id){

  $('#archivo_tmp_'+id).val('');
  $('#preview_cartel_'+id).attr('src','/attachments/no_imagen.jpg?2.');
}