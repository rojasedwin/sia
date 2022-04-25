var seleccionando_imagen = -1;

function seleccionar_imagen(id)
{
	seleccionando_imagen = id;
	document.body.style.cursor = "wait";
}
function eliminar_vehiculo(vehiculo_id)
{
  if(confirm("SE perderán todos los datos!!"))
  {
    mostrar_alerta("alerta_info","Eliminando... por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "JSON",
       url: base_url+'vehiculos/eliminarVehiculo/',
       data: { vehiculo_id:vehiculo_id
       },
       success: function(res){
        if(res.result==1)
        {
            buscar_vehiculos();
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
function ver_ficha_vehiculo(vehiculo_id){
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
  fichaTasActual = vehiculo_id;
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormVehiculo/',
	   data: {vehiculo_id: vehiculo_id},
	   success: function(res){
			ocultar_alerta();
      $('#contenido_ficha_vehiculo').html(res);
       $('#contenido_ficha_vehiculo .selectpicker').selectpicker();
       $('#contenido_ficha_vehiculo .mifecha').datepicker({
         autoclose: true,
         format:"dd-mm-yyyy",
         language: 'es'
       });
       $('#contenido_ficha_vehiculo .mifechaanio').datepicker({
         autoclose: true,
         format:"yyyy-mm",
         language: 'es'
       });

			 $("#etiqueta_vehiculo").keypress(function (e) {
						 if (e.which == 13) {
								 var tag_text = $(this).val();
								 if($('#contenedor_tags :input[value="'+tag_text+'"]').length)
								 {
									 mostrar_alerta("alerta_error","El extra ya existe",1200);
									 return 1;
								 }
								 if(!$('#contenedor_tags div').length) $('#contenedor_tags').html('');
								 var contenido = "<div>"+tag_text+"<img src='/attachments/remove.png' onclick='$(this).parent().remove();check_tags();'>";
								 contenido += "<input type='hidden' name='tags_text[]' value='"+tag_text+"'></div>";
								 $('#contenedor_tags').prepend(contenido);
								 $(this).val('');
						 }
				 });
				 /*
				 $('#summernote_cuerpo').summernote({
									 height: 300,
						 toolbar: [
							 ['font', ['bold', 'italic', 'underline', 'clear']],
							 ['fontsize', ['fontsize']],
							 ['color', ['color']],
							 ['para', ['ul', 'ol', 'paragraph']],
							 ['view', ['codeview']]
					 ]
					 });
					 */

					 $( "#contenedor_secciones").sortable({
							revert: true,
							handle: '.handle'
						});

			 $('#contenido_ficha_vehiculo #imagen_principal_veh .fa-arrow-left').on('click',function(){

 				var imagen_actual = parseInt($('#imagen_principal_veh #image_actual').val());
 				var max_images = parseInt($('#imagen_principal_veh #max_images').val());
 				imagen_actual--; if(imagen_actual<0)  imagen_actual = max_images - 1;
				var node_img = $('#contenedor_miniaturas div:eq('+imagen_actual+')');
				var src= node_img.find('img').prop('src');
				var id = node_img.prop('id');

 				$('#imagen_principal_veh #image_actual').val(imagen_actual);
				$('#imagen_principal_veh #id_image_actual').val(id);
 				$('#imagen_principal_veh .principal').prop('src',src);
 			});
 			$('#contenido_ficha_vehiculo #imagen_principal_veh .fa-arrow-right').on('click',function(){

 				var imagen_actual = parseInt($('#imagen_principal_veh #image_actual').val());
 				var max_images = parseInt($('#imagen_principal_veh #max_images').val());
 				imagen_actual++; if(imagen_actual>=max_images)  imagen_actual = 0;
				var node_img = $('#contenedor_miniaturas div:eq('+imagen_actual+')');
				var src= node_img.find('img').prop('src');
				var id = node_img.prop('id');

 				$('#imagen_principal_veh #image_actual').val(imagen_actual);
				$('#imagen_principal_veh #id_image_actual').val(id);
 				$('#imagen_principal_veh .principal').prop('src',src);
 			});

			 $('#contenido_ficha_vehiculo [name=imagenes_vehiculo]').on('click',function(){
				 var index =  $( "#contenido_ficha_vehiculo [name=imagenes_vehiculo]" ).index( this );
				 console.log("Tengo "+index);
				 var node_img = $('#contenedor_miniaturas div:eq('+index+')');
 				 var src= node_img.find('img').prop('src');
 				 var id = node_img.prop('id');
				 var src = $(this).prop('src');
				 $('#imagen_principal_veh #image_actual').val(index);
				 $('#imagen_principal_veh #id_image_actual').val(id);
				 $('#imagen_principal_veh .principal').prop('src',src);

				 if(seleccionando_imagen!=-1)
				 {
					 var mi_ruta = src.split('/').pop();

					 console.log("Voy a poner "+mi_ruta);
					 if(seleccionando_imagen==0)
					 {
						 $('#contenido_ficha_vehiculo .imagen_principal_veh').removeClass('imagen_principal_veh');
						 $('#contenido_ficha_vehiculo [name=veh_imagen_principal]').val(mi_ruta);
						 $(this).removeClass().addClass('imagen_principal_veh');
					 }
					 if(seleccionando_imagen==1)
					 {
						 $('#contenido_ficha_vehiculo .imagen_secundaria1').removeClass('imagen_secundaria1');
						 $('#contenido_ficha_vehiculo [name=veh_imagen_secundaria1]').val(mi_ruta);
						 $(this).removeClass().addClass('imagen_secundaria1');
					 }
					 if(seleccionando_imagen==2)
					 {
						 $('#contenido_ficha_vehiculo .imagen_secundaria2').removeClass('imagen_secundaria2');
						 $('#contenido_ficha_vehiculo [name=veh_imagen_secundaria2]').val(mi_ruta);
						 $(this).removeClass().addClass('imagen_secundaria2');
					 }

					 document.body.style.cursor = "default";
					 seleccionando_imagen = -1;
				 }
			 });
			 $('#contenido_ficha_vehiculo').on('click','[name=eliminar_video_vehiculo]',function(){
				 var index =	$(this).prop('id').split('_')[1];
				 var key = $('#key_video_'+index).val();
				if(confirm("Se eliminará el video "))
				{
					mostrar_alerta("alerta_info","Eliminado Video...por favor, espere");
					$.ajax({
						 type: 'POST',
						 dataType: "JSON",
						 url: base_url+'vehiculos/deleteVideoVeh/',
						 data: {key: key,vehiculo_id:vehiculo_id},
						 success: function(res){
							 ocultar_alerta();
							 if(res.result==1)
								{
									$('#contenido_ficha_vehiculo #contenedor_video_'+index).remove();
								}
							 else
								mostrar_alerta("alerta_error","No se ha podido eliminar...",1500);
						 },
						 error: function(){
							mostrar_alerta("alerta_error","No se ha podido eliminar...",1500);
						}
						}); //AJAX
				}
			}); //Eliminar video.

			 $('#contenido_ficha_vehiculo #eliminar_imagen_actual').on('click',function(){
				 var key =	$('#imagen_principal_veh #id_image_actual').val();
				 var index = $('#imagen_principal_veh #image_actual').val();

				if(confirm("Se eliminará la imagen "+key))
				{
					//var key =	$('#imagen_principal_veh #id_image_actual').val();
					var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
					mostrar_alerta("alerta_info","Eliminado Imagen...por favor, espere");
					$.ajax({
						 type: 'POST',
						 dataType: "JSON",
						 url: base_url+'vehiculos/deleteImagenVeh/',
						 data: {key: key,vehiculo_id:vehiculo_id},
						 success: function(res){
							 ocultar_alerta();
							 if(res.result==1)
								{

									$('#contenido_ficha_vehiculo #imagen_principal_veh .fa-arrow-right').trigger('click');
									var node_img = $('#contenedor_miniaturas div:eq('+index+')');
									node_img.remove();
									var max_images = parseInt($('#imagen_principal_veh #max_images').val());
									max_images--; $('#imagen_principal_veh #max_images').val(max_images);
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

			 $('#contenido_ficha_vehiculo #subir_imagenes_button').on('click',function(){
          $('#imagenes_vehiculo').trigger('click');
       });
			 $('#contenido_ficha_vehiculo #imagenes_vehiculo').on('change',function(){
          subirImagenesVehiculo();
       });

			 $('#contenido_ficha_vehiculo #subir_video_button').on('click',function(){
					$('#video_vehiculo').trigger('click');
			 });
			$('#contenido_ficha_vehiculo #video_vehiculo').on('change',function(){
					subirVideosVehiculo();
			 });

			 $('#contenido_ficha_vehiculo #veh_precioventa').on('keyup',function(){
				 	refrescarCostesVehiculo();
			 });
			 $('#contenido_ficha_vehiculo #precio_real').on('keyup',function(){
				 	refrescarCostesVehiculo();
			 });
			 refrescarCostesVehiculo();
       //habilitar_matricula_ppago("vehiculo_ppago_ficha","vehiculo_vehiculo_id_ficha");

       //autocomplete_vehiculos_stock_ficha();


			 $('#options_div_container .option_veh').on('click',function(){
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


      $('#modal_ficha_vehiculo').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function addDetalle(){
	mostrar_alerta("alerta_info","Cargando...por favor, espere");
	var ultimo = 0;
	if($('#contenedor_secciones .seccion_noticia').length)
		ultimo = parseInt($('#contenedor_secciones .seccion_noticia:last').prop('id').split('-')[1]);
	ultimo++;
	while($('#contenedor_secciones #seccion-'+ultimo).length)
	{
		ultimo++;
	}
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'vehiculos/addDetalle',
	   data: { idseccion:ultimo } ,
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 if(!$('#contenedor_secciones div').length) $('#contenedor_secciones').html(res.html);
				 else $('#contenedor_secciones').append(res.html);

				 $( "#contenedor_secciones").sortable({
					 revert: true,
					 handle: '.handle'
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
} //Add detalle
function check_detalles()
{
	if(!$('#contenedor_secciones div').length) $('#contenedor_secciones').html('-- No hay detalles --');
}
function check_tags()
{
	if(!$('#contenedor_tags div').length) $('#contenedor_tags').html('-- No hay extras --');
}

function ver_ficha_oferta(vehiculo_id,telefono){
	telefono = typeof telefono !== 'undefined' ? telefono : '';
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormOferta/',
	   data: {vehiculo_id: vehiculo_id,cliente_telefono:telefono},
	   success: function(res){
			ocultar_alerta();
      $('#contenido_ficha_oferta').html(res);
      $('#contenido_ficha_oferta .selectpicker').selectpicker();
			$('#contenido_ficha_oferta [name=imagenes_tasacion]').on('click',function(){
				var src = $(this).prop('src');
				$('#imagen_principal .principal').prop('src',src);
			});
			$('#contenido_ficha_oferta #imagen_principal .fa-arrow-left').on('click',function(){

				var imagen_actual = parseInt($('#imagen_principal #image_actual').val());
				var max_images = parseInt($('#imagen_principal #max_images').val());
				imagen_actual--; if(imagen_actual<0)  imagen_actual = max_images - 1;
				var src = $('#contenedor_imagenes_tasacion #idimg-'+imagen_actual).prop('src');
				$('#imagen_principal #image_actual').val(imagen_actual);
				$('#imagen_principal .principal').prop('src',src);
			});
			$('#contenido_ficha_oferta #imagen_principal .fa-arrow-right').on('click',function(){

				var imagen_actual = parseInt($('#imagen_principal #image_actual').val());
				var max_images = parseInt($('#imagen_principal #max_images').val());
				imagen_actual++; if(imagen_actual>=max_images)  imagen_actual = 0;
				var src = $('#contenedor_imagenes_tasacion #idimg-'+imagen_actual).prop('src');
				$('#imagen_principal #image_actual').val(imagen_actual);
				$('#imagen_principal .principal').prop('src',src);
			});


      $('#modal_ficha_oferta').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function comprobarTelefono(vehiculo_id){

	var telefono = $('#cliente_telefono_comprobar').val();
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormOferta/',
	   data: {vehiculo_id: vehiculo_id,cliente_telefono:telefono},
	   success: function(res){
			ocultar_alerta();
      $('#contenido_ficha_oferta').html(res);
      $('#contenido_ficha_oferta .selectpicker').selectpicker();
      $('#modal_ficha_oferta').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function guardar_accion(){

	var texto = $('#texto_accion').val();
	if(texto=="") return 1;
	var telefono = $('#cliente_telefono_ofer_abierta').val();
	var contenido = "<div class='message right'>";
	contenido += "<div class='msg-detail'><div class='msg-info'><p><span class='usuario'>Yo</span>Ahora</p></div>";
	contenido += "<div class='msg-content' style='width:90%'><span class='triangle'></span>";
	contenido += '<p class="line-breaker ">'+texto+'</p>';
	contenido += "</div></div></div>";
	$('#contenido_acciones').append(contenido);
	$('#texto_accion').val('');
	setTimeout(function(){
			$("#contenido_acciones").animate({ scrollTop: $('#contenido_acciones').prop("scrollHeight")}, 800);
	}
,200);
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'vehiculos/saveAccion/',
	   data: {texto:texto,telefono:telefono},
	   success: function(res){

			if(res.result==1)
			{
				if($('#contenedor_avisos_total').length)
				{
					if($('#boton_informe-3').hasClass('active')) //Esta activo
						buscar_avisos();
					else {
						refrescar_badge_avisos();
					}
				}

				//Si estamos en el inicio, eliminamos el aviso.
				if($('#pantalla_crm_inicio').length)
				{
					//$('#pantalla_crm_inicio #aviso_llamada-'+telefono).remove();
					refrescar_avisos_crm();
				}


			}
			else {
				mostrar_alerta("alerta_error","Ha ocurrido un problema",1500);
				$('#contenido_acciones .message').last().remove();
				$('#texto_accion').val(texto);
			}
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
			$('#contenido_acciones .message').last().remove();
			$('#texto_accion').val(texto);
		}
    }); //AJAX
}
function guardarOferta(imprimir)
{
	imprimir = typeof imprimir !== 'undefined' ? imprimir : 0;
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'vehiculos/saveOferta/',
	   data: $('[name=form_ficha_oferta]').serialize()+"&imprimir="+imprimir,
	   success: function(res){
			ocultar_alerta();
			if(res.result==1)
			{
				mostrar_alerta("alerta_correcto","Datos Guardados",1500,function(){
					if($('#contenedor_ofertas_total').length) buscar_ofertas();
					if($('#coches_ofertados').length) refrescarCochesCliente();
					if($('#contenedor_avisos_total').length)
					{
						if($('#boton_informe-3').hasClass('active')) //Esta activo
							buscar_avisos();
						else {
							refrescar_badge_avisos();
						}
					}


				});
				$('#validation_oferta_errors').html(res.message);

			}
			else {
				mostrar_alerta("alerta_error","Ha ocurrido un problema",1500);
				$('#validation_oferta_errors').html(res.message);
			}
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function generar_zip_fotos(vehiculo_id)
{
	mostrar_alerta("alerta_info","Preparando ficheros... por favor, espere");
	$.ajax({
		 type: 'POST',
		 dataType: "JSON",
		 url: base_url+'vehiculos/generarZipFotos/',
		 data: {vehiculo_id:vehiculo_id},
		 success: function(res){
			 ocultar_alerta();
			if(res.result==1)
			{
				$('#contenido_fotos_vehiculo').html(res.message);
				$('#modal_fotos_vehiculo').modal('show');
			}
			else {
					mostrar_alerta("alerta_error",res.message,1500);
			}

		 },
		 error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
		}); //AJAX
}

function guardarVehiculo(avisar)
{
	avisar = typeof avisar !== 'undefined' ? avisar : 0;
	mostrar_alerta("alerta_info","Guardando datos...por favor, espere");

	var detalles = [];
	var tmp = {}; var cont = 0;
	$('#contenedor_secciones .seccion_noticia').each(function(){
			tmp = {};
			tmp['order'] = cont;
			tmp['titulo'] = $(this).find('#titulo').val();
			tmp['texto'] = $(this).find('#texto').val();
			cont++;
			detalles.push(tmp);
	});

	var gastos_vehiculo = {}; var nuevos_gastos_vehiculo = {}; var cont =0;
	$('#contenedor_gastos .gasto_veh').each(function(){

		var veh_gasto_id = $(this).find('[name=veh_gasto_id]').val();
		var gasto_id = $(this).find('[name=gasto_id]').val();
		var cantidad = $(this).find('[name=cantidad]').val();
		if(veh_gasto_id=="" || veh_gasto_id==undefined)
		{
			nuevos_gastos_vehiculo[ gasto_id ] = cantidad;
		}
		else {
			gastos_vehiculo[ veh_gasto_id ] = veh_gasto_id;
		}
	});
	var veh_texto = encodeURIComponent($('#summernote_cuerpo').summernote('code'));
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'vehiculos/saveVehiculo/',
	   data: $('[name=form_ficha_vehiculo]').serialize()+"&"+$('[name=form_precios_vehiculo]').serialize()
		 +"&"+$('[name=form_extras]').serialize()+"&"+$('[name=form_web_youtube]').serialize()
		 +"&gastos_vehiculo="+JSON.stringify(gastos_vehiculo)+"&nuevos_gastos_vehiculo="+JSON.stringify(nuevos_gastos_vehiculo)
		 +"&avisar="+avisar+"&veh_texto="+veh_texto+"&detalles="+JSON.stringify(detalles),
	   success: function(res){
			 ocultar_alerta();
 			if(res.result==1)
 			{
 				$('#validation_vehiculo_errors').html('');
 				mostrar_alerta("alerta_correcto","Datos Guardados",1500,function(){
					if($('#contenedor_vehiculos_total').length) buscar_vehiculos();

 				});
 			}
 			else {
 				 $('#validation_vehiculo_errors').html(res.message);
 			}

	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function add_gasto()
{
	var gasto_id =  $('#gasto_id').val();
	var texto_gasto = $( "#gasto_id option:selected" ).text();
	var cantidad = parseFloat($('#importe_gasto').val());
	if(cantidad==0 || cantidad==""  || isNaN(cantidad)){
		mostrar_alerta("alerta_error","Indique una cantidad...",1000);
		return 1;
	}

	var contenido =  "<div class='gasto_veh'><div class='remove'><img src='/attachments/icons/remove.png' onclick='$(this).parent().parent().remove();del_gasto()'></div>";
	contenido +=  "<input type='hidden' name='gasto_id' value='"+gasto_id+"'>";
	contenido +=  "<input type='hidden' name='cantidad' value='"+cantidad+"'>";
	contenido +=  "<div class='concepto_gasto'>"+texto_gasto+"</div>";
	contenido +=  "<div class='cantidad_gasto'>"+cantidad+"€</div>";
	contenido +=  "</div>";

	if($('#contenedor_gastos div').length)
		$('#contenedor_gastos').append(contenido);
	else {
		$('#contenedor_gastos').html(contenido);
	}
	refrescarCostesVehiculo();

}
function del_gasto()
{
  if(!$('#contenedor_gastos div').length)
    $('#contenedor_gastos').html('-- No hay gastos --');
  refrescarCostesVehiculo();
}
function refrescarCostesVehiculo()
{
	var total = 0;
	$('#contenedor_gastos .gasto_veh').each(function(){
			var cantidad = parseFloat($(this).find('[name=cantidad]').val());
			total += cantidad;
	});
	var total_costes = total;
	var final = Math.round((total)*Math.pow(10,2))/Math.pow(10,2);
	$('#total_gastos').html(final+"€");
	$('#costes').val(final+"€");
	var margen = parseFloat($('#contenido_ficha_vehiculo #veh_precioventa').val());
	console.log("Refrescaría con marge "+margen);
	margen -= final;
	//console.log("menos final "+margen);
	var precio_real = parseFloat($('#contenido_ficha_vehiculo #precio_real').val());
	margen -= precio_real;
	//console.log("menos precio real "+margen);
	var costes_taller = parseFloat($('#contenido_ficha_vehiculo #costes_taller').val());
	console.log("Tengo costes taller "+costes_taller);
	margen -= costes_taller;
	total_costes += costes_taller;
	//console.log("restar "+margen);
	margen = Math.round((margen)*Math.pow(10,2))/Math.pow(10,2);
	console.log("final "+margen);
	$('#margen').val(margen+"€");
	$('#total_costes').val(total_costes+"€");

}

function subirImagenReserva()
{
  $('#cargar_imagen_reserva').submit();
  mostrar_alerta("alerta_info","Cargando Imagen...");
}
function imagenEntregaSubida(response)
{
  ocultar_alerta();
  if(response.result==1)
  {
		$('#contenedor_imagen_entrega').html("<img src='/attachments/web/entregas/"+response.name+"?"+Math.random()+"' style='max-height:80px;'>");
  }
  else
  {
    mostrar_alerta("alerta_error",response.message,1500);
  }

}
function subirImagenesVehiculo()
{
  $('#cargar_imagenes_vehiculo').submit();
  mostrar_alerta("alerta_info","Procesando Imágenes...");
}
function imagenes_subidas_vehiculo(response)
{
  if(response.result==1)
  {
    var vehiculo_id = $('#form_ficha_vehiculo [name=vehiculo_id]').val();
    mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
  	$.ajax({
  	   type: 'POST',
  	   dataType: "html",
  	   url: base_url+'vehiculos/refrescarImagenesVeh/',
  	   data: {vehiculo_id: vehiculo_id},
  	   success: function(res){
  			mostrar_alerta("alerta_correcto","Imagenes Subidas",1500);
        $('#contenedor_imagenes_tasacion').html(res);
				$('#contenido_ficha_vehiculo #imagen_principal_veh .fa-arrow-left').on('click',function(){

  				var imagen_actual = parseInt($('#imagen_principal_veh #image_actual').val());
  				var max_images = parseInt($('#imagen_principal_veh #max_images').val());
  				imagen_actual--; if(imagen_actual<0)  imagen_actual = max_images - 1;
 				var node_img = $('#contenedor_miniaturas div:eq('+imagen_actual+')');
 				var src= node_img.find('img').prop('src');
 				var id = node_img.prop('id');

  				$('#imagen_principal_veh #image_actual').val(imagen_actual);
 				$('#imagen_principal_veh #id_image_actual').val(id);
  				$('#imagen_principal_veh .principal').prop('src',src);
  			});
  			$('#contenido_ficha_vehiculo #imagen_principal_veh .fa-arrow-right').on('click',function(){

  				var imagen_actual = parseInt($('#imagen_principal_veh #image_actual').val());
  				var max_images = parseInt($('#imagen_principal_veh #max_images').val());
  				imagen_actual++; if(imagen_actual>=max_images)  imagen_actual = 0;
 				var node_img = $('#contenedor_miniaturas div:eq('+imagen_actual+')');
 				var src= node_img.find('img').prop('src');
 				var id = node_img.prop('id');

  				$('#imagen_principal_veh #image_actual').val(imagen_actual);
 				$('#imagen_principal_veh #id_image_actual').val(id);
  				$('#imagen_principal_veh .principal').prop('src',src);
  			});

 			 $('#contenido_ficha_vehiculo [name=imagenes_vehiculo]').on('click',function(){
 				 var index =  $( "#contenido_ficha_vehiculo [name=imagenes_vehiculo]" ).index( this );
 				 console.log("Tengo "+index);
 				 var node_img = $('#contenedor_miniaturas div:eq('+index+')');
  				 var src= node_img.find('img').prop('src');
  				 var id = node_img.prop('id');
 				 var src = $(this).prop('src');
 				 $('#imagen_principal_veh #image_actual').val(index);
 				 $('#imagen_principal_veh #id_image_actual').val(id);
 				 $('#imagen_principal_veh .principal').prop('src',src);

 				 if(seleccionando_imagen!=-1)
 				 {
 					 var mi_ruta = src.split('/').pop();

 					 console.log("Voy a poner "+mi_ruta);
 					 if(seleccionando_imagen==0)
 					 {
 						 $('#contenido_ficha_vehiculo .imagen_principal_veh').removeClass('imagen_principal_veh');
 						 $('#contenido_ficha_vehiculo [name=veh_imagen_principal]').val(mi_ruta);
 						 $(this).removeClass().addClass('imagen_principal_veh');
 					 }
 					 if(seleccionando_imagen==1)
 					 {
 						 $('#contenido_ficha_vehiculo .imagen_secundaria1').removeClass('imagen_secundaria1');
 						 $('#contenido_ficha_vehiculo [name=veh_imagen_secundaria1]').val(mi_ruta);
 						 $(this).removeClass().addClass('imagen_secundaria1');
 					 }
 					 if(seleccionando_imagen==2)
 					 {
 						 $('#contenido_ficha_vehiculo .imagen_secundaria2').removeClass('imagen_secundaria2');
 						 $('#contenido_ficha_vehiculo [name=veh_imagen_secundaria2]').val(mi_ruta);
 						 $(this).removeClass().addClass('imagen_secundaria2');
 					 }

 					 document.body.style.cursor = "default";
 					 seleccionando_imagen = -1;
 				 }
 			 });
 			 $('#contenido_ficha_vehiculo #eliminar_imagen_actual').on('click',function(){
 				 var key =	$('#imagen_principal_veh #id_image_actual').val();
 				 var index = $('#imagen_principal_veh #image_actual').val();

 				if(confirm("Se eliminará la imagen "+key))
 				{
 					//var key =	$('#imagen_principal_veh #id_image_actual').val();
 					var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
 					mostrar_alerta("alerta_info","Eliminado Imagen...por favor, espere");
 					$.ajax({
 						 type: 'POST',
 						 dataType: "JSON",
 						 url: base_url+'vehiculos/deleteImagenVeh/',
 						 data: {key: key,vehiculo_id:vehiculo_id},
 						 success: function(res){
 							 ocultar_alerta();
 							 if(res.result==1)
 								{

 									$('#contenido_ficha_vehiculo #imagen_principal_veh .fa-arrow-right').trigger('click');
 									var node_img = $('#contenedor_miniaturas div:eq('+index+')');
 									node_img.remove();
 									var max_images = parseInt($('#imagen_principal_veh #max_images').val());
 									max_images--; $('#imagen_principal_veh #max_images').val(max_images);
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

function subirVideosVehiculo()
{
  $('#cargar_videos_vehiculo').submit();
  mostrar_alerta("alerta_info","Procesando Videos...");
}
function videos_subidos_vehiculo(response)
{
  if(response.result==1)
  {
    var vehiculo_id = $('#form_ficha_vehiculo [name=vehiculo_id]').val();
    mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
  	$.ajax({
  	   type: 'POST',
  	   dataType: "html",
  	   url: base_url+'vehiculos/refrescarVideosVeh/',
  	   data: {vehiculo_id: vehiculo_id},
  	   success: function(res){
  			mostrar_alerta("alerta_correcto","Videos subidos",1500);
        $('#contenedor_videos_tasacion').html(res);
  	   },
  	   error: function(){
  			mostrar_alerta("alerta_error","Problemas de red...",1500);
  		}
      }); //AJAX
  }
  else {
    	mostrar_alerta("alerta_error",response.message,1500);
  }

} //Subir videos vehiculo


/********************************************************************
	FUNCIONES RESERVA
**********************************************************************/
function buscar_comprador()
{
	var dni = $('#contenido_ficha_reserva #dni_comprador').val();
	mostrar_alerta("alerta_info","Cargando datos de comprador...por favor, espere");
	$.ajax({
		 type: 'POST',
		 dataType: "JSON",
		 url: base_url+'vehiculos/getDatosComprador/',
		 data: {dni: dni},
		 success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 mostrar_alerta("alerta_correcto","Datos encontrados",1000);
				 $('#nombre_comprador').val(res.factura_nombre);
				 $('#apellidos_comprador').val(res.factura_apellidos);
				 $('#direccion_comprador').val(res.factura_direccion);
				 $('#cp_comprador').val(res.factura_cp);
				 $('#municipio_comprador').val(res.factura_municipio);
				 $('#provincia_comprador').val(res.factura_provincia);
				 $('#telefono_comprador').val(res.factura_telefono);
				 $('#email_comprador').val(res.factura_email);
				 $('#fnac_comprador').val(res.factura_fnac);
			 }
			 else {
				 mostrar_alerta("alerta_error","Datos NO encontrados",1500);
				}


		 },
		 error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
		}); //AJAX
}
function reserva_coche_b(vehiculo_id)
{
	$('#compraventa_reserva_b').val('');
	$('#compraventa_reserva_b').selectpicker('refresh');
	$('#vehiculo_id_reserva_b').val(vehiculo_id);
	$('#reserva_coche_b').modal('show');
}
function ver_ficha_reserva_b()
{
	ver_ficha_reserva( $('#vehiculo_id_reserva_b').val() );
}
function lanzar_reserva_compraventa()
{
	var compraventa_id = $('#compraventa_reserva_b').val();
	var vehiculo_id_reserva = $('#vehiculo_id_reserva_b').val();
	ver_ficha_reserva_compraventa(vehiculo_id_reserva,compraventa_id);
	$('#reserva_coche_b').modal('hide');
}
function reserva_cliente(vehiculo_id)
{
	$('#cliente_telefono_reserva').val('');
	$('#vehiculo_id_reserva').val(vehiculo_id);
	$('#cliente_reserva_modal').modal('show');
}

function comprobarClienteTelefono()
{
	var telefono =	$('#cliente_telefono_reserva').val();
	mostrar_alerta("alerta_info","Comprobando teléfono...por favor, espere");
	$.ajax({
		 type: 'POST',
		 dataType: "JSON",
		 url: base_url+'vehiculos/checkTelefonoCliente/',
		 data: {telefono: telefono},
		 success: function(res){
			ocultar_alerta();
			if(res.result==1)
			{
				$('#cliente_reserva_modal').modal('hide');

				ver_ficha_reserva($('#vehiculo_id_reserva').val(),telefono);
			}
			else {
				mostrar_alerta("alerta_error","Teléfono no encontrado. Si el cliente no existe, por favor, dalo de alta",2500);
			}
			$('#contenedor_docs_financiacion').html(res);
		 },
		 error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
		}); //AJAX
}
function ver_ficha_reserva_compraventa(vehiculo_id,compraventa_id){
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");

	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormReserva/',
	   data: {vehiculo_id: vehiculo_id, compraventa_id:compraventa_id},
	   success: function(res){
			ocultar_alerta();
      $('#contenido_ficha_reserva').html(res);
			/* No permitimos cambiar el dni
			$('#contenido_ficha_reserva #dni_comprador').blur(function(){
				buscar_comprador();
			});
			*/
			cargar_wizard_reserva();
      $('#modal_ficha_reserva').modal('show');
			cerrarModalPrincipal();
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function ver_ficha_reserva(vehiculo_id,telefono){
	telefono = typeof telefono !== 'undefined' ? telefono : '';
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");

	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormReserva/',
	   data: {vehiculo_id: vehiculo_id, telefono:telefono},
	   success: function(res){
			ocultar_alerta();
      $('#contenido_ficha_reserva').html(res);
			$('#contenido_ficha_reserva #dni_comprador').blur(function(){
				buscar_comprador();
			});
			cargar_wizard_reserva();



      $('#modal_ficha_reserva').modal('show');
			cerrarModalPrincipal();
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function cargar_wizard_reserva()
{
	$('#contenido_ficha_reserva .selectpicker').selectpicker();
	$('#contenido_ficha_reserva .mifecha').datepicker({
		autoclose: true,
		format:"dd-mm-yyyy",
		language: 'es'
	});
	$('#contenido_ficha_reserva .mifechaanio').datepicker({
		autoclose: true,
		format:"yyyy-mm",
		language: 'es'
	});
	$('#contenido_ficha_reserva .recalcular_pvpfinal').on('keyup',function(){
		 refrescarImporteFinal();
	});

	refrescarImporteFinal();
	$('#contenido_ficha_reserva #select_docs').on('click',function(){
		$('#nombre_doc').val('');
		 $('#contenido_ficha_reserva #docs_tas').trigger('click');
	});
	$('#contenido_ficha_reserva #select_doc_notificacion').on('click',function(){
		 $('#contenido_ficha_reserva #doc_notificacion').trigger('click');
	});
	$('#contenido_ficha_reserva #select_docs_fina').on('click',function(){
		$('#nombre_doc').val('');
		 $('#contenido_ficha_reserva #docs_tas_fina').trigger('click');
	});
	$('#contenido_ficha_reserva #docs_tas').on('change',function(){


		var files = $('#contenido_ficha_reserva #docs_tas')[0].files;
		var nombres = [];
		 for (var i = 0; i < files.length; i++)
		 {
			 var name = files[i].name.substr(files[i].name.lastIndexOf("\\") + 1);
			 name = name.substr(0,name.lastIndexOf("."));
				var doc_name = prompt("Introduzca el nombre para el documento nº "+(i+1)+":", name);
				if (doc_name != null) {
					nombres.push(doc_name);
				}
		 }
		 //Escribimos en el form
		 $('#cargar_docs_reserva .nombres_docs').remove();
		 for(var i in nombres)
		 {
			 var contenido = "<input type='hidden' class='nombres_docs' name='nombres_docs["+i+"]' value='"+nombres[i]+"'>";
			 $('#cargar_docs_reserva').append(contenido);
		 }
		 subirDocumentosReserva();
	});
	$('#contenido_ficha_reserva #docs_tas_fina').on('change',function(){


		var files = $('#contenido_ficha_reserva #docs_tas_fina')[0].files;
		var nombres = [];
		 for (var i = 0; i < files.length; i++)
		 {
			 var name = files[i].name.substr(files[i].name.lastIndexOf("\\") + 1);
			 name = name.substr(0,name.lastIndexOf("."));
				var doc_name = prompt("Introduzca el nombre para el documento nº "+(i+1)+":", name);
				if (doc_name != null) {
					nombres.push(doc_name);
				}
		 }
		 //Escribimos en el form
		 $('#cargar_docs_reserva_fina .nombres_docs').remove();
		 for(var i in nombres)
		 {
			 var contenido = "<input type='hidden' class='nombres_docs' name='nombres_docs["+i+"]' value='"+nombres[i]+"'>";
			 $('#cargar_docs_reserva_fina').append(contenido);
		 }
		 subirDocumentosReservaFina();
	});

	$('#contenido_ficha_reserva #subir_imagen_reserva').on('click',function(){
		 $('#imagen_reserva').trigger('click');
	});
	$('#contenido_ficha_reserva #imagen_reserva').on('change',function(){
		 subirImagenReserva();
	});
	$('#contenido_ficha_reserva #doc_notificacion').on('change',function(){
		 subirDocumentosNotificacion();
	});

	//Eliminamos , de cantidad financiar y cuota final.
	$('#contenido_ficha_reserva .is_decimal').on('keyup',function(){
		var tmp = $(this).val();
		if(tmp.indexOf(',')!=-1)
		{
			$(this).val(tmp.replace(",","."));
		}
 });



	habilitar_matricula_ppago("vehiculo_ppago_reserva","reserva_vehiculo_id_ficha");
	autocomplete_vehiculos_stock_reserva();


	$('#contenedor_docs_reserva').on('click','[name=eliminar_docreserva_s3]',function(){
		if(confirm("Se eliminará el documento"))
		{
			var key = $(this).prop('id');
			var mi_object = $(this).parent();
			var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
			mostrar_alerta("alerta_info","Eliminado Documento...por favor, espere");
			$.ajax({
				 type: 'POST',
				 dataType: "JSON",
				 url: base_url+'vehiculos/deleteDocumentReserva/',
				 data: {key: key,idfactura_venta:idfactura_venta},
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
	$('#contenedor_docs_financiacion').on('click','[name=eliminar_docreserva_s3]',function(){
		if(confirm("Se eliminará el documento"))
		{
			var key = $(this).prop('id');
			var mi_object = $(this).parent();
			var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
			mostrar_alerta("alerta_info","Eliminado Documento...por favor, espere");
			$.ajax({
				 type: 'POST',
				 dataType: "JSON",
				 url: base_url+'vehiculos/deleteDocumentReservaFina/',
				 data: {key: key,idfactura_venta:idfactura_venta},
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
}
function ver_reserva_cancelada(idfactura_venta){
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");

	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormReservaCancelada/',
	   data: {idfactura_venta: idfactura_venta},
	   success: function(res){
			ocultar_alerta();
      $('#contenido_ficha_reserva').html(res);
       $('#contenido_ficha_reserva .selectpicker').selectpicker();
       $('#contenido_ficha_reserva .mifecha').datepicker({
         autoclose: true,
         format:"dd-mm-yyyy",
         language: 'es'
       });
       $('#contenido_ficha_reserva .mifechaanio').datepicker({
         autoclose: true,
         format:"yyyy-mm",
         language: 'es'
       });
			 $('#contenido_ficha_reserva .recalcular_pvpfinal').on('keyup',function(){
				 	refrescarImporteFinal();
			 });

			 refrescarImporteFinal();
       $('#contenido_ficha_reserva #select_docs').on('click',function(){
         $('#nombre_doc').val('');
          $('#contenido_ficha_reserva #docs_tas').trigger('click');
       });
			 $('#contenido_ficha_reserva #select_docs_fina').on('click',function(){
				 $('#nombre_doc').val('');
					$('#contenido_ficha_reserva #docs_tas_fina').trigger('click');
			 });
       $('#contenido_ficha_reserva #docs_tas').on('change',function(){
          subirDocumentosReserva();
       });
			 $('#contenido_ficha_reserva #docs_tas_fina').on('change',function(){
					subirDocumentosReservaFina();
			 });
			 $('#contenido_ficha_reserva #doc_notificacion').on('change',function(){
					subirDocumentosNotificacion();
			 });
			 habilitar_matricula_ppago("vehiculo_ppago_reserva","reserva_vehiculo_id_ficha");
			 autocomplete_vehiculos_stock_reserva();


			 $('#contenedor_docs_reserva').on('click','[name=eliminar_docreserva_s3]',function(){
         if(confirm("Se eliminará el documento"))
         {
           var key = $(this).prop('id');
           var mi_object = $(this).parent();
					 var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
           mostrar_alerta("alerta_info","Eliminado Documento...por favor, espere");
           $.ajax({
              type: 'POST',
              dataType: "JSON",
              url: base_url+'vehiculos/deleteDocumentReserva/',
              data: {key: key,idfactura_venta:idfactura_venta},
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
			 $('#contenedor_docs_financiacion').on('click','[name=eliminar_docreserva_s3]',function(){
         if(confirm("Se eliminará el documento"))
         {
           var key = $(this).prop('id');
           var mi_object = $(this).parent();
					 var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
           mostrar_alerta("alerta_info","Eliminado Documento...por favor, espere");
           $.ajax({
              type: 'POST',
              dataType: "JSON",
              url: base_url+'vehiculos/deleteDocumentReservaFina/',
              data: {key: key,idfactura_venta:idfactura_venta},
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


      $('#modal_ficha_reserva').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
} //Ver reserva cancelada



function refrescarImporteFinal()
{
	var total = 0;

	var pvp = $('#contenido_ficha_reserva [name=factura_pvp]').val();
	if(pvp.indexOf(',')!=-1)
	{
		$('#contenido_ficha_reserva [name=factura_pvp]').val(pvp.replace(",","."));
	}
	pvp = parseFloat($('#contenido_ficha_reserva [name=factura_pvp]').val());
	console.log("pvp "+pvp);

	var transferencia = $('#contenido_ficha_reserva [name=factura_coste_transferencia]').val();
	if(transferencia.indexOf(',')!=-1)
	{
		$('#contenido_ficha_reserva [name=factura_coste_transferencia]').val(transferencia.replace(",","."));
	}
	transferencia = parseFloat($('#contenido_ficha_reserva [name=factura_coste_transferencia]').val());

	var dto_financiado = $('#contenido_ficha_reserva [name=factura_dto_financiacion]').val();
	if(dto_financiado.indexOf(',')!=-1)
	{
		$('#contenido_ficha_reserva [name=factura_dto_financiacion]').val(dto_financiado.replace(",","."));
	}
	dto_financiado = parseFloat($('#contenido_ficha_reserva [name=factura_dto_financiacion]').val());

	if(isNaN(dto_financiado)) dto_financiado = 0;
	console.log("dto_financiado "+dto_financiado);
	var dto_comercial = $('#contenido_ficha_reserva [name=factura_dto_comercial]').val();
	if(dto_comercial.indexOf(',')!=-1)
	{
		$('#contenido_ficha_reserva [name=factura_dto_comercial]').val(dto_comercial.replace(",","."));
	}
	dto_comercial = parseFloat($('#contenido_ficha_reserva [name=factura_dto_comercial]').val());
	if(isNaN(dto_comercial)) dto_comercial = 0;
	console.log("dto_comercial "+dto_comercial);
	var final = pvp + transferencia - dto_financiado - dto_comercial;
	var final = Math.round((final)*Math.pow(10,2))/Math.pow(10,2);
	console.log("Tengo el final"+final);
	$('#importe_final').val(final);
	$('#importe_final_ficticio').val(final+" €");

	refrescarIngresosVehiculo(); //Al cambiar el PVP se actualizan los margenes.
}


function add_ingreso()
{
	var ingreso_id =  $('#ingreso_id').val();
	var texto_ingreso = $( "#ingreso_id option:selected" ).text();
	var cantidad = parseFloat($('#importe_ingreso').val());
	if(cantidad==0 || cantidad==""  || isNaN(cantidad)){
		mostrar_alerta("alerta_error","Indique una cantidad...",1000);
		return 1;
	}
	var fecha_ingreso = $('#fecha_ingreso').val();
	if(fecha_ingreso==""){
		mostrar_alerta("alerta_error","Indique una fecha...",1000);
		return 1;
	}
	var contenido =  "<div class='ingreso_veh'><div class='remove'><img src='/attachments/icons/remove.png' onclick='$(this).parent().parent().remove();del_ingreso()'></div>";
	contenido +=  "<input type='hidden' name='ingreso_id' value='"+ingreso_id+"'>";
	contenido +=  "<input type='hidden' name='cantidad' value='"+cantidad+"'>";
	contenido +=  "<input type='hidden' name='fecha' value='"+fecha_ingreso+"'>";
	contenido +=  "<div class='concepto_ingreso'><div class='fecha_ingreso'>"+fecha_ingreso+"</div>"+texto_ingreso+"</div>";
	contenido +=  "<div class='cantidad_ingreso'>"+cantidad+"€</div>";
	contenido +=  "</div>";

	if($('#contenedor_ingresos div').length)
		$('#contenedor_ingresos').append(contenido);
	else {
		$('#contenedor_ingresos').html(contenido);
	}
	refrescarIngresosVehiculo();

}
function del_ingreso()
{
  if(!$('#contenedor_ingresos div').length)
    $('#contenedor_ingresos').html('-- No hay ingresos --');
  refrescarIngresosVehiculo();
}
function refrescarIngresosVehiculo()
{
	var total = 0; var total_comunes = 0;
	$('#contenedor_ingresos .ingreso_veh').each(function(){
			var cantidad = parseFloat($(this).find('[name=cantidad]').val());
			total += cantidad;
			var id = $(this).find('[name=ingreso_id]').val();
			if( $('#contenido_ficha_reserva #listado_ingresos_comunes #comun-'+id).length )
				total_comunes += cantidad;
	});
	var entrega_a_cuenta = parseFloat($('#contenido_ficha_reserva #entrega_a_cuenta').val());
	console.log("Tengo entrega cuenta "+entrega_a_cuenta);
	var final = Math.round((total)*Math.pow(10,2))/Math.pow(10,2);
	$('#total_ingresos').html(final+"€");
	var final_comunes = Math.round((total_comunes)*Math.pow(10,2))/Math.pow(10,2);
	$('#ingresos_comunes').val(final_comunes);
	var importe_final = parseFloat($('#contenido_ficha_reserva #importe_final').val());
	var margen = importe_final - final_comunes - entrega_a_cuenta;

	//NO QUITAR SOLO INFORMATIVO
	/*if($('#veh_ppliquidacion_cantidad').length && parseFloat($('#veh_ppliquidacion_cantidad').val())>0)
	{
		margen = margen + parseFloat($('#veh_ppliquidacion_cantidad').val());
	}
	*/

	margen = Math.round((margen)*Math.pow(10,2))/Math.pow(10,2);
	$('#restante_por_ingresar').val(margen);
}


function guardarReserva(){
	mostrar_alerta("alerta_info","Guardando Datos... por favor, espere");
	var ingresos_vehiculo = {}; var nuevos_ingresos_vehiculo = {}; var cont =0;
	$('#contenedor_ingresos .ingreso_veh').each(function(){

		var veh_ingreso_id = $(this).find('[name=veh_ingreso_id]').val();
		var ingreso_id = $(this).find('[name=ingreso_id]').val();
		var cantidad = $(this).find('[name=cantidad]').val();
		var fecha = $(this).find('[name=fecha]').val();
		if(veh_ingreso_id=="" || veh_ingreso_id==undefined)
		{
			nuevos_ingresos_vehiculo[ cont ] = {};
			nuevos_ingresos_vehiculo[ cont ]['cantidad'] = cantidad;
			nuevos_ingresos_vehiculo[ cont ]['ingreso_id'] = ingreso_id;
			nuevos_ingresos_vehiculo[ cont ]['fecha'] = fecha;
			cont++;
		}
		else {
			ingresos_vehiculo[ veh_ingreso_id ] = veh_ingreso_id;
		}
	});
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'vehiculos/saveReserva',
	   data: $('[name=form_ficha_reserva]').serialize()+'&'+$('[name=form_ficha_pago]').serialize()+"&ingresos_vehiculo="+JSON.stringify(ingresos_vehiculo)+"&nuevos_ingresos_vehiculo="+JSON.stringify(nuevos_ingresos_vehiculo),
	   success: function(res){
			 ocultar_alerta();

			 if(res.result==1)
			 {
         if(res.nueva_reserva==1)
         {
           ver_ficha_reserva(res.vehiculo_id);
					 $('#vehiculos_aviso_taller').val('');
         }
         else {
           $('#validation_reserva_errors').html('');
  				 mostrar_alerta("alerta_correcto","Datos Guardatos",1500,function(){
						 $('#vehiculos_aviso_taller').val('');
  				 });
         }

			 }
			 else {
			 		$('#validation_reserva_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function subirDocumentosReserva()
{
  $('#cargar_docs_reserva').submit();
  mostrar_alerta("alerta_info","Procesando Documento...");
}
function DocSubidoReserva(response)
{
  if(response.result==1)
  {
    var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
    mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "html",
       url: base_url+'vehiculos/refrescarDocsReserva/',
       data: {idfactura_venta: idfactura_venta},
       success: function(res){
        mostrar_alerta("alerta_correcto","Documento Subido",1500);
        $('#contenedor_docs_reserva').html(res);
				$('#cargar_docs_reserva .nombres_docs').remove();
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
function subirDocumentosReservaFina()
{
  $('#cargar_docs_reserva_fina').submit();
  mostrar_alerta("alerta_info","Procesando Documento...");
}
function subirDocumentosNotificacion()
{
  $('#cargar_notificacion').submit();
  mostrar_alerta("alerta_info","Procesando Documento...");
}
function DocSubidoReservaFina(response)
{
  if(response.result==1)
  {
    var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
    mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "html",
       url: base_url+'vehiculos/refrescarDocsReservaFina/',
       data: {idfactura_venta: idfactura_venta},
       success: function(res){
        mostrar_alerta("alerta_correcto","Documento Subido",1500);
        $('#contenedor_docs_financiacion').html(res);
				$('#cargar_docs_reserva_fina .nombres_docs').remove();
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
function refrescarDocsReserva()
{
	var idfactura_venta = $('#form_ficha_reserva [name=idfactura_venta]').val();
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
		 type: 'POST',
		 dataType: "html",
		 url: base_url+'vehiculos/refrescarDocsReserva/',
		 data: {idfactura_venta: idfactura_venta},
		 success: function(res){
			mostrar_alerta("alerta_correcto","Documento Subido",1500);
			$('#contenedor_docs_reserva').html(res);
		 },
		 error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
		}); //AJAX
}

function firmarDocsReserva(idfactura_venta)
{
  mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'vehiculos/firmarDocsReserva/',
     data: {idfactura_venta: idfactura_venta},
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
function volver_a_firmar_entrega(idfactura_venta)
{
  if(confirm('¿Has guardado los nuevos datos para la firma?.\nEs recomendable borrar el antiguo contrato firmado.\nSi sigues viendo el antiguo documento asegurate de borrar la cache'))
  {
    mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "JSON",
       url: base_url+'vehiculos/volverAFirmarEntrega/',
       data: {idfactura_venta: idfactura_venta},
       success: function(res){
         ocultar_alerta();
         if(res.result==1)
         {
           	 mostrar_alerta("alerta_correcto","Firma habilitada",1500);
						 $('#volverAFirmarEntrega').hide();
						 $('#firmaEntrega').show();
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

function firmaEntrega(idfactura_venta)
{
  mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'vehiculos/firmarDocsEntrega/',
     data: {idfactura_venta: idfactura_venta},
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

function firmaEntregaCompraventa(idfactura_venta)
{
  mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'vehiculos/firmarDocsEntregaCompraventa/',
     data: {idfactura_venta: idfactura_venta},
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

function autocomplete_vehiculos_stock_reserva(){

  var tmp = {};
  vehiculos_stock = [];
  $('#contenedor_tasaciones_finalizadas [name=los_vehiculos]').each(function(){
    var id= $(this).val();
    tmp = {};
    tmp['id'] = id;
    tmp['label'] = $('#contenedor_tasaciones_finalizadas #matricula-'+id).val();
    tmp['marca'] = $('#contenedor_tasaciones_finalizadas #marca-'+id).val();
    tmp['modelo'] = $('#contenedor_tasaciones_finalizadas #modelo-'+id).val();
    tmp['precio'] = $('#contenedor_tasaciones_finalizadas #precio-'+id).val();
    vehiculos_stock.push(tmp);
  });
var tmp = {};
  if($('#contenido_ficha_reserva #reserva_vehiculo_id_ficha').length)
		$( "#modal_ficha_reserva #reserva_vehiculo_id_ficha").autocomplete({
		      minLength: 0,
		      source: vehiculos_stock,
					open: function() {$(this).autocomplete("widget").width(500)  },
		      focus: function( event, ui ) {

            return false;
		      },
		      select: function( event, ui ) {
            var contenido = "Vehículo seleccionado:<br> <b>"+ui.item.label+" (" + ui.item.marca + " - " + ui.item.modelo + " " + ui.item.precio + "€)</b>";
            contenido += "<input type='hidden' name='veh_ppago' value='"+ui.item.id+"'>";
            $(this).val('');
            $('#vehiculo_a_comprar_reserva').html(contenido);
						$('#entrega_a_cuenta').val(ui.item.precio);
						refrescarIngresosVehiculo();
						addFormLiquidacion();
		        return false;
		      }
		    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
		      return $( "<li>" )
		        .append( "<div>" + item.label + " <b>(" + item.marca + " - " + item.modelo + ")</b></div>" )
		        .appendTo( ul );
		    };
}

function addFormLiquidacion()
{
	$.ajax({
		 type: 'POST',
		 dataType: "html",
		 url: base_url+'vehiculos/addFormLiquidacion/',
		 data: {},
		 success: function(res){
			 $('#vehiculo_a_comprar_liquidacion').html(res);
			 load_widzard_form('vehiculo_a_comprar_liquidacion');
			 cambiar_liquidacion();
			 $('#vehiculo_a_comprar_liquidacion .recalcular_pvpfinal').on('keyup',function(){
				 var tmp = $(this).val();
	 				if(tmp.indexOf(',')!=-1)
	 				{
	 					$(this).val(tmp.replace(",","."));
	 				}
				 	refrescarImporteFinal();
			 });
		 },
		 error: function(){
		}
		}); //AJAX
}
function cambiar_liquidacion()
{
	if($('#veh_ppliquidacion').val()!='1')
	{
		$('#veh_ppliquidacion_cantidad').val('').prop('disabled',true);
		$('#veh_ppliquidacion_entidad').val('').prop('disabled',true);
		//refrescarImporteFinal();
	}
	else {
		$('#veh_ppliquidacion_cantidad').prop('disabled',false);
		$('#veh_ppliquidacion_entidad').prop('disabled',false);
	}
}

function permitirEntrega(idfactura_venta)
{
	if(confirm("¿Has revisado los pagos?. ¿Todo correcto?"))
	{
		mostrar_alerta("alerta_info","Preparando para entrega...por favor, espere");
	  $.ajax({
	     type: 'POST',
	     dataType: "JSON",
	     url: base_url+'vehiculos/validarEntrega/',
	     data: {idfactura_venta: idfactura_venta},
	     success: function(res){
	       ocultar_alerta();
	       if(res.result==1)
				 {
					 $('#validarEntrega').hide();
					 $('#firmaEntrega').show();
				 }
				 else {
					mostrar_alerta("alerta_error",res.message,1500);
				}
	     },
	     error: function(){
	      mostrar_alerta("alerta_error","Problemas de red...",1500);
	    }
	    }); //AJAX
	}
}

function cancelarReserva(idfactura_venta)
{
	if(confirm("Se cancelará la reserva, y el vehículo parasá de nuevo a Stock"))
	{
		mostrar_alerta("alerta_info","Cancelando...por favor, espere");
	  $.ajax({
	     type: 'POST',
	     dataType: "JSON",
	     url: base_url+'vehiculos/cancelarReserva/',
	     data: {idfactura_venta: idfactura_venta},
	     success: function(res){
	       ocultar_alerta();
	       if(res.result==1)
				 {
					 	mostrar_alerta("alerta_correcto","RESERVA CANCELADA",2500,function(){
								$('.modal').modal('hide');
						});

				 }
				 else {
				 	 mostrar_alerta("alerta_error",res.message,1500);
				 }

	     },
	     error: function(){
	      mostrar_alerta("alerta_error","Problemas de red...",1500);
	    }
	    }); //AJAX
	}
}

function prepararFactura(idfactura_venta)
{
	//if(confirm("¿Estas seguro?"))
	//{
		mostrar_alerta("alerta_info","Preparando Factura...por favor, espere");
	  $.ajax({
	     type: 'POST',
	     dataType: "HTML",
	     url: base_url+'vehiculos/prepararFactura/',
	     data: {idfactura_venta: idfactura_venta},
	     success: function(res){
				 ocultar_alerta();
	       $('#contenido_descargar_docs').html(res);
	       $('#modal_descargar_dosc').modal('show');

	     },
	     error: function(){
	      mostrar_alerta("alerta_error","Problemas de red...",1500);
	    }
	    }); //AJAX
	//}
}


function ver_docFactura(idfactura_venta){

	mostrar_alerta("alerta_info","Generando Factura... Por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	    url: base_url+'facturas/verDocFactura/',
	   data: {idfactura_venta: idfactura_venta},
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

function ver_doc_rectificada(idrectificada){

	mostrar_alerta("alerta_info","Generando Factura... Por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	    url: base_url+'facturas/verDocRectificada/',
	   data: {idrectificada: idrectificada},
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
