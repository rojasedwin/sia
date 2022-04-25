var marker;
var mapOptions = {
		zoom: 11
	  };
var map;
var mapa_cargado = 0;
function nuevo_evento(idevento,operacion){
	idevento = typeof idevento !== 'undefined' ? idevento : '';
	operacion = typeof operacion !== 'undefined' ? operacion : '';
	mostrar_alerta("alerta_info","Cargando Formulario...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'eventos/getFormuEvento/',
	   data: {idevento: idevento,operacion:operacion},
	   success: function(res){
			ocultar_alerta();
			$('#contenido_formulario_evento').html(res);
			cargar_wizard_formu_evento();

			$('#modal_editar_evento').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function readURL(input,idimagen) {
		 if (input.files && input.files[0]) {
				 var reader = new FileReader();

				 reader.onload = function (e) {
						 $('#'+idimagen).attr('src', e.target.result);
				 }
				 reader.readAsDataURL(input.files[0]);
		 }
 }

function cargar_wizard_formu_evento(){
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
	$("#upload_cartel").click(function() {
    $("#cartel").click();
	});
	$("#preview_cartel").click(function() {
    $("#cartel").click();
	});
	$('#cartel').change(function() {
			subiendo_imagen("cambio_foto_cartel","Subiendo Cartel Carrera");
	});
	mapa_cargado = 0;

	wizard_tabs();
	/******
			GOOGLE
	*****/
	var input = /** @type {HTMLInputElement} */(
		 document.getElementById('buscador_google'));

		 var options = {
	componentRestrictions: {country: "es"}
	};
	var searchBox = new google.maps.places.Autocomplete(input,options);

	 google.maps.event.addListener(searchBox, 'place_changed', function() {
		 var place = searchBox.getPlace();
		 var ccaa,ciudad,poblacion;
		 mapOptions = {
				 zoom: 13
				 };
		 for(var i in place['address_components'])
		 {
			 if("types" in place['address_components'][i])
			 {
				 if(place['address_components'][i]['types'][0]=="administrative_area_level_1")
					 ccaa = place['address_components'][i]['long_name'];
				 if(place['address_components'][i]['types'][0]=="locality")
					 poblacion = place['address_components'][i]['long_name'];
				 if(place['address_components'][i]['types'][0]=="administrative_area_level_2")
 					ciudad = place['address_components'][i]['long_name'];
					if(place['address_components'][i]['types'][0]=="route" || place['address_components'][i]['types'][0]=="street_number")
					{
						mapOptions = {
								zoom: 17
							  };
					}
			 }


		 }
		 if(ciudad=="") ciudad = poblacion;

		 $('#ccaa').val(ccaa);
		 $('#ciudad').val(ciudad);
		 $('#poblacion').val(poblacion);
		 $('#latitud_evento').val(place['geometry']['location']['lat']);
		 $('#longitud_evento').val(place['geometry']['location']['lng']);
		 cargar_mapa();
	 });
		 $("#buscador_google").keypress(function (e) {
					 if (e.which == 13) {
							 var firstResult = $(".pac-container .pac-item:first").text();
							 // $("#buscar_ciudad").val(firstResult);

					 }
			 });


}

function wizard_tabs(){
	var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn'),
					btnDirecto = $('a.directBtn');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);
			var isValid = true;
			var orden_siguiente = parseInt($target.attr('id').split('-')[1]);
			var $target_actual = $('.setup-content:visible');
			var orden_actual = 0;
			if($target_actual.attr('id')!=undefined)
			{
				orden_actual = parseInt($target_actual.attr('id').split('-')[1]);
			}

			var funcion = $target_actual.find('[name=funcion_validar]').val();
			if(funcion!=undefined && funcion!="undefined" && $target_actual!=undefined && orden_siguiente>orden_actual)
			{
				isValid = window[funcion]();
			}
      if (!$item.hasClass('disabled') && isValid) {
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
					console.log("Tengo "+$target.attr('id'));
					if($target.attr('id')=="step-2"){
						mapOptions = {
			 				 zoom: 10
			 				 };
							 cargar_mapa();  //Cargamos mapa de inicio
					}
      }
  });

	btnDirecto.click(function (e){
		e.preventDefault();
		var $target = $('[name='+$(this).attr('href')+']');
		$target.click();
	});


  allNextBtn.click(function(){
			var funcion = $(this).closest(".setup-content").find('[name=funcion_validar]').val();

			console.log("Tengo assssd "+funcion);
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
					console.log("Tengo el id "+curStepBtn);
          isValid = true;

			if(funcion!=undefined && funcion!="undefined")
			{
				isValid = window[funcion]();
			}

      if (isValid)
			{
          nextStepWizard.removeAttr('disabled').trigger('click');

			}
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
}

function cargar_mapa(){

	if(mapa_cargado==0)
	{
		mapa_cargado = 1;
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	}
	else {
		map.setZoom(mapOptions['zoom']);
	}

	var pos = new google.maps.LatLng($('#latitud_evento').val(),
									 $('#longitud_evento').val());
	if(marker!=undefined) marker.setMap(null);
	 marker = new google.maps.Marker({
		position: pos,
		draggable:true,
		title: 'Mi Evento',
		map: map
	});
	map.setCenter(pos);
	google.maps.event.addListener(marker, "dragend", function(event) {
		var lat = event.latLng.lat();
		var lng = event.latLng.lng();
		$('#latitud_evento').val(lat);
		$('#longitud_evento').val(lng);
	});
}

function eliminar_imagen(idimagen)
{
	$('#'+idimagen).attr('src',"attachments/web/imagenes/no_imagen.jpg");
	$('#'+idimagen).parent().find('.icono_absolute').hide();
	$('#imagenEvento').val('');
}
function subiendo_imagen(idformulario,mensaje)
{
	$('#'+idformulario).submit();
	mostrar_alerta("alerta_info",mensaje);
}
function imagen_subida(mensaje, url, idimagen)
{
	if(mensaje=="ok")
	{
		mostrar_alerta("alerta_correcto","Imagen subida",1500);
		$('#'+idimagen).attr('src', url);
		$('#imagenEvento').val(url);
		$('#'+idimagen).parent().find('.icono_absolute').show();
	}
	if(mensaje=="formato")
	{
		mostrar_alerta("alerta_error","Formato No Válido",1500);
	}
	if(mensaje=="error")
	{
		mostrar_alerta("alerta_error","Ha ocurrido un error",1500);
	}

}

function validar_paso_1(){

	var fallo = false;
	$('#evento_paso_1 .error_input').removeClass('error_input');
	$('#evento_paso_1 .requerido').each(function(){

			if($(this).val()=="" && $(this).attr('name')!=undefined)
			{
				$(this).parent().addClass('error_input');
				console.log("Lo añado a "+$(this).attr('name')+" y tengo "+$(this).val());
			}
			if($(this).hasClass('email') && !EsEmail($(this).val()))
			{
				$(this).parent().addClass('error_input');
			}
			if($(this).hasClass('telefono_movil') && !EsTelefonoMovil($(this).val()))
			{
				$(this).parent().addClass('error_input');
			}

	});

	if($('#evento_paso_1 .error_input').length)
	{
			console.log("revise paso 1");
			mostrar_alerta("alerta_error","Revise Paso 1",1500);
			return false;
	}
	else {
		return true;
	}
}
function validar_paso_2(){

	$('#evento_paso_2 .requerido').each(function(){

			if($(this).val()=="" && $(this).attr('name')!=undefined)
			{
				$(this).parent().addClass('error_input');
				console.log("Lo añado a "+$(this).attr('name'));
			}
			if($(this).hasClass('email') && !EsEmail($(this).val()))
			{
				$(this).parent().addClass('error_input');
			}
			if($(this).hasClass('telefono_movil') && !EsTelefonoMovil($(this).val()))
			{
				$(this).parent().addClass('error_input');
			}

	});
	if($('#evento_paso_3 .error_input').length)
	{
			mostrar_alerta("alerta_error","Revise Paso 3",1500);
			return false;
	}
	return true;
}
function validar_paso_3(){

	var fallo = false;
	$('#evento_paso_3 .error_input').removeClass('error_input');
	$('#evento_paso_3 .requerido').each(function(){

			if($(this).val()=="" && $(this).attr('name')!=undefined)
			{
				$(this).parent().addClass('error_input');
				console.log("Lo añado a "+$(this).attr('name'));
			}
			if($(this).hasClass('email') && !EsEmail($(this).val()))
			{
				$(this).parent().addClass('error_input');
			}
			if($(this).hasClass('telefono_movil') && !EsTelefonoMovil($(this).val()))
			{
				$(this).parent().addClass('error_input');
			}

	});

	if($('#evento_paso_3 .error_input').length)
	{
			mostrar_alerta("alerta_error","Revise Paso 3",1500);
			return false;
	}
	else {
		confirmar_guardar_evento();
	}
}

function confirmar_guardar_evento(operacion){
	operacion = typeof operacion !== 'undefined' ? operacion : '';
	mostrar_alerta("alerta_info","Guardando Evento...por favor, espere");
	$('#validation_evento_errors').html('');
	//Obtenemos recordatorios y repeticiones
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'eventos/guardar',
	   data: $('[name=evento_paso_1]').serialize()+"&"+$('[name=evento_paso_2]').serialize()+"&"+$('[name=evento_paso_3]').serialize(),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1 || res.result==2)
			 {
				 var tipo_alerta = "alerta_correcto"; var tiempo = 1000;
				 if(res.result==2)
				 {
					 tipo_alerta = "alerta_warning"; tiempo = res.tiempo;
				 }
				 if($('#contenedor_eventos').is(':visible'))
					 buscar_eventos();
				 mostrar_alerta(tipo_alerta,res.message,tiempo,function(){
				  $('.modal').modal('hide');
					console.log("Voy a quitar la alerta");
					if($('#exito_alta_evento').length)
					{
						$('#formu_usu_evento').hide();
					  $('#exito_alta_evento').effect('slide', { direction: 'right', mode: 'show' }, 800);
					}
				 });
			 }
			 else {
				 	if(res.result==-1)
					{
			 			$('#validation_evento_errors').html(res.message);
						mostrar_alerta("alerta_error","Revise algunos campos",1500);
					}
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
