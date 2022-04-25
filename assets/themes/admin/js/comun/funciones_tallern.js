function cambiar_usu_taller()
{
  var nuevo_usuario = $('#usu_taller_actual').val();
  $.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'auth/cambiar_usu_taller/',
	   data: {nuevo_usuario: nuevo_usuario},
	   success: function(res){
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function cargar_datos_or(id){

  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }

	$('#contenido_ficha_or .boton_informes').removeClass('active');
	$('#contenido_ficha_or #boton_informe-'+id).addClass('active');

	$('#contenido_ficha_or .contenedor_informes').removeClass('active');
	$('#contenido_ficha_or #pantalla_informes-'+id).addClass('active');
}
function cargar_informacion(id)
{
	console.log("Voy con "+id);
	mostrar_alerta("alerta_info","Cargando datos... por favor, espere");
	$.ajax({
		 type: 'POST',
		 dataType: "html",
		 url: base_url+'informes/getInformesCresta/',
		 data: $('[name=filter_informe-'+id+']').serialize()+"&informe="+id,
		 success: function(res){
			ocultar_alerta();
			$('#container_init').val(1);
			$('#contenedor_informes-'+id).html(res);
			if($('#contenedor_informes-'+id+' .fila_tabla').length) initDataTables('#contenedor_informes-'+id);


			$('.filter_datatables').remove();
			if(id!=3)	$('.dataTables_length').remove();

		 },
		 error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
		}); //AJAX
}

function New_comprobarMatriculaOR()
{
  var matricula = $('#or_matricula').val();
  mostrar_alerta("alerta_info","Comprobando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tallern/comprobarMatriculaOR/',
	   data: {matricula: matricula},
	   success: function(res){
       ocultar_alerta();
       if(!$('#modal_ficha_or').is(':visible'))
          $('#modal_ficha_or').modal('show');
        $('#contenido_ficha_or').html(res);
        load_interfaz_NEWOR();
        load_interfaz_piezas();
        load_interfaz_lineas();

	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function New_ficha_OR(idor){
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tallern/getFormOR/',
	   data: {idor: idor},
	   success: function(res){
			ocultar_alerta();

      $('#contenido_ficha_or').html(res);
      if(!$('#modal_ficha_or').is(':visible'))
         $('#modal_ficha_or').modal('show');
       $('#contenido_ficha_or .selectpicker').selectpicker();

       load_interfaz_NEWOR();
       load_interfaz_piezas();
       load_interfaz_lineas();
      $('#modal_ficha_or').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function refrescarPiezasOR(idor)
{
  mostrar_alerta("alerta_info","Actualizando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/refrescarPiezasOR/',
	   data: {idor: idor},
	   success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         $('#contenido_ficha_or #piezas_or').html(res.piezas_html);
         load_interfaz_piezas();
         $('#contenido_ficha_or #pantalla_informes-4').html(res.lineas_html);
         load_interfaz_lineas();
       }
       else
        mostrar_alerta("alerta_error","Problema al refrescar",1500);


	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function refrescarORs_y_Piezas()
{
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/actualizarMisOR_y_Piezas/',
	   data: {},
	   success: function(res){
       if(res.result==1)
       {
         $('#contenedor_or_pdte').html(res.or_pdte_html);
         $('#contenedor_piezas_pdte_taller').html(res.piezas_recibir);
         load_interfaz_initiotaller();
       }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

var productos_almacen = [];
function abrirPiezasAlmacen(idalmacen)
{
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  mostrar_alerta("alerta_info","Cargando Almacén... por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/cargarStockAlmacen',
	   data: {idalmacen:idalmacen},
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
         	productos_almacen = res.stocks;
          $('#contenido_stock_almacen').html(res.html);
          hacer_autocomplete_stock_almacen();
          $('#modal_or_almacen_stock').modal('show');

			 }
			 else {
			 		$('#validation_tareasor_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function abrirPedido(idproveedor,idpedido)
{
  var idor = $('#contenido_ficha_or #form_or_tareas [name=idor]').val();
  mostrar_alerta("alerta_info","Cargando Almacén... por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/cargarChatPedido',
	   data: {
       idproveedor:idproveedor,
       idpedido:idpedido,
       idor:idor
     },
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
          $('#el_pedido_'+idproveedor).find('span').html('');
          $('#contenido_chat_pedido').html(res.html);
          $('#modal_chat_pedido #idpedido_chat').val(res.idpedido);
          $('#modal_chat_pedido #idpedido_chat_foto').val(res.idpedido);
          $('#modal_chat_pedido #idproveedor_chat_sender').val(idproveedor);
          $('#modal_chat_pedido').modal('show');
          setTimeout(function(){
              $("#contenido_chat_pedido").animate({ scrollTop: $('#contenido_chat_pedido').prop("scrollHeight")}, 800);
        	}
        ,400);

			 }
			 else {
			 		$('#validation_tareasor_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function ficha_pedidoAlmacen(idpedido){
    mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $('#validation_almacen_errors').html('');
	 $.ajax({
			type: 'POST',
			dataType: "HTML",
			url: base_url+'tallern/getFormPedido',
			data: {
				idpedido:idpedido
			},
			success: function(res){
				ocultar_alerta();
				$('#contenedor_modal_pedido').html(res);

        $('#modal_pedido_almacen').on('keydown','#texto_chat_pedidoAlmacen',function(e){
    			if(e.which== 13){
            console.log('prevengo!!');
            e.preventDefault();
    				escribir_chat_pedidoAlmacen();
    			}
    		});

        var cameraAlmacen = document.getElementById('camera_chatAlmacen');
        cameraAlmacen.addEventListener('change', function(e) {
            document.getElementById('cargar_foto_chatAlmacen').submit();
          });



        //Preparamos para que se marque el checkbox al cliar en cada linea.
        $('#modal_pedido_almacen #tabla_lineas_pedido_almacen tbody tr').click(function(){
      		console.log("He clicado "+$(this).find('[name=seleccionado]').prop('checked'));
      		if($(this).find('[name=seleccionado]').prop('checked'))
      			$(this).find('[name=seleccionado]').prop('checked',false);
      		else
      			$(this).find('[name=seleccionado]').prop('checked',true);
          });




				$('#modal_pedido_almacen').modal('show');
        setTimeout(function(){
            $("#contenido_chat_pedidoAlmacen").animate({ scrollTop: $('#contenido_chat_pedidoAlmacen').prop("scrollHeight")}, 800);
        }
      ,400);
			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX

}
function tablaPiezasPedidoAlmacen(idpedido){
    mostrar_alerta("alerta_info","Cargando...por favor, espere");
	 $('#validation_almacen_errors').html('');
	 $.ajax({
			type: 'POST',
			dataType: "JSON",
			url: base_url+'tallern/getTablaPiezasPedido',
			data: {
				idpedido:idpedido
			},
			success: function(res){
				ocultar_alerta();
        if(res.result==1)
        {
          $('#contenedor_tabla_piezas').html(res.html);
          //Preparamos para que se marque el checkbox al cliar en cada linea.
          $('#modal_pedido_almacen #tabla_lineas_pedido_almacen tbody tr').click(function(){
        		console.log("He clicado "+$(this).find('[name=seleccionado]').prop('checked'));
        		if($(this).find('[name=seleccionado]').prop('checked'))
        			$(this).find('[name=seleccionado]').prop('checked',false);
        		else
        			$(this).find('[name=seleccionado]').prop('checked',true);
            });
        }
        else
				    mostrar_alerta("alerta_error","Problema al refrescar...",1500);
			},
			error: function(){
			 mostrar_alerta("alerta_error","Problemas de red...",1500);
		 }
		 }); //AJAX

} //tablaPiezasPedidoAlmacen

function escribir_chat_pedidoAlmacen()
{
  var idpedido = $('#modal_pedido_almacen #idpedidoAlmacen_chat').val();
  var texto = $('#modal_pedido_almacen #texto_chat_pedidoAlmacen').val();
  if(texto=="")
  {
    return 1;
  }
  $('#modal_pedido_almacen #texto_chat_pedidoAlmacen').val('');
  mostrar_alerta("alerta_info","Guardando... por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'tallern/guardarChatPedido',
     data: {
       idpedido:idpedido,
       texto:texto
     },
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         var contenido = "";
         contenido += "<div class='message ";
         contenido += " right'> ";
         contenido += '<div class="msg-detail"><div class="msg-info">';
         let usuchat = "Yo";
         contenido += '<p><span class="usuario">'+usuchat+'</span> Ahora</p></div>';
         contenido += '<div class="msg-content"><span class="triangle"></span><p class="line-breaker ">'+texto+'</p></div>';
         contenido += '  </div></div>';
          $('#contenido_chat_pedidoAlmacen').append(contenido);
          $("#contenido_chat_pedidoAlmacen").animate({ scrollTop: $('#contenido_chat_pedidoAlmacen').prop("scrollHeight")}, 1000);
       }
       else {
         $('#modal_pedido_almacen #texto_chat_pedidoAlmacen').val(texto);
        mostrar_alerta("alerta_error","No se ha podido mandar...",1500);
       }
     },
     error: function(){
       $('#modal_pedido_almacen #texto_chat_pedidoAlmacen').val(texto);
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX

}
function capturar_foto_chat()
{
  console.log("Voy a lanzar normal");
  //$('#camera_chat').trigger('change');
  $('#camera_chat').trigger('click');
}
function capturar_foto_chatAlmacen()
{
  console.log("Voy a lanzar almacen");
  //$('#camera_chat').trigger('change');
  $('#camera_chatAlmacen').trigger('click');
}

function imagenChatSubida(response)
{

  if(response.result==1)
  {
    if($('#modal_chat_pedido').is(':visible'))
      abrirPedido($('#modal_chat_pedido #idproveedor_chat_sender').val(),response.idpedido);
    else if($('#modal_pedido_almacen').is(':visible'))
    {
      ficha_pedidoAlmacen(response.idpedido)
    }
  }
  else {
    	mostrar_alerta("alerta_error",response.message,1500);
  }
}
function escribir_chat_pedido()
{
  var idpedido = $('#modal_chat_pedido #idpedido_chat').val();
  var texto = $('#modal_chat_pedido #texto_chat_pedido').val();
  if(texto=="")
  {
    return 1;
  }
  $('#modal_chat_pedido #texto_chat_pedido').val('');
  mostrar_alerta("alerta_info","Guardando... por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'tallern/guardarChatPedido',
     data: {
       idpedido:idpedido,
       texto:texto
     },
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         var contenido = "";
         contenido += "<div class='message ";
         contenido += " right'> ";
         contenido += '<div class="msg-detail"><div class="msg-info">';
         let usuchat = "Yo";
         contenido += '<p><span class="usuario">'+usuchat+'</span> Ahora</p></div>';
         contenido += '<div class="msg-content"><span class="triangle"></span><p class="line-breaker ">'+texto+'</p></div>';
         contenido += '  </div></div>';
          $('#contenido_chat_pedido').append(contenido);
          $("#contenido_chat_pedido").animate({ scrollTop: $('#contenido_chat_pedido').prop("scrollHeight")}, 1000);
       }
       else {
         $('#modal_chat_pedido #texto_chat_pedido').val(texto);
        mostrar_alerta("alerta_error","No se ha podido mandar...",1500);
       }
     },
     error: function(){
       $('#modal_chat_pedido #texto_chat_pedido').val(texto);
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX

}


function eliminar_linea(idor_linea)
{
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  if(confirm("Se devolverá la pieza al proveedor o al almacén correspondiente"))
  {


  var idor= $('#form_ficha_or #idor').val();
  var piezas_devolver = []; var tmp = {};
  piezas_devolver.push(idor_linea);
  var error = false;
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/devolverPiezas',
	   data: "idor="+idor+"&piezas_devolver="+JSON.stringify(piezas_devolver),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
         $('#contenido_ficha_or #piezas_or').html(res.piezas_html);
         load_interfaz_piezas();
         $('#contenido_ficha_or #pantalla_informes-4 #fila_linea_'+idor_linea).remove();
         New_calcula_total();
         //$('#contenido_ficha_or #pantalla_informes-4').html(res.lineas_html);
         //load_interfaz_lineas();
          mostrar_alerta("alerta_correcto","Pieza devuelta",500,function(){

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
} //Eliminar Linea

function devolverPiezas()
{
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  if(!$('#piezas_or .tasacion input:checked').length)
  {
    mostrar_alerta("alerta_error","No ha seleccionado ninguna pieza",1500);
    return 1;
  }
  if($('#piezas_or .tasacion  input.noconfirmada:checked').length)
  {
    mostrar_alerta("alerta_error","Ha seleccionado piezas no confirmadas",1500);
    return 1;
  }
  $('#modal_devolver_piezas').modal('show');
}
function confirmar_devolver_piezas()
{
  var idor= $('#form_ficha_or #idor').val();
  var piezas_devolver = []; var tmp = {};
  var error = false;

  $('#piezas_or .tasacion input:checked').each(function(){

			var idor_linea= $(this).val();
			piezas_devolver.push(idor_linea);
	});
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/devolverPiezas',
	   data: "idor="+idor+"&piezas_devolver="+JSON.stringify(piezas_devolver),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
         $('#contenido_ficha_or #piezas_or').html(res.piezas_html);
         load_interfaz_piezas();
         $('#contenido_ficha_or #pantalla_informes-4').html(res.lineas_html);
         load_interfaz_lineas();
         $('#modal_devolver_piezas').modal('hide');
         cerrarModalPrincipal();
          mostrar_alerta("alerta_correcto","Piezas devueltas",500,function(){

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
} //devolverPiezas

function confirmarPieza(idpedido_linea)
{
  if(confirm("Se avisará al proveedor para que envíe la pieza"))
  {
    $.ajax({
  	   type: 'POST',
  	   dataType: "JSON",
  	   url: base_url+'tallern/confirmarPieza',
  	   data: {idpedido_linea:idpedido_linea},
  	   success: function(res){
  			 ocultar_alerta();
  			 if(res.result==1)
  			 {
           if($('#modal_pedido_almacen').is(':visible')) //Refrescamos la vista
              tablaPiezasPedidoAlmacen( $('#idpedidoAlmacen_chat').val() );
          if($('#modal_ficha_or').is(':visible')) //Refrescamos la vista
              refrescarPiezasOR( $('#form_ficha_or #idor').val() );


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
function descartarPieza(idpedido_linea)
{
  if(confirm("Se eliminará la pieza del pedido"))
  {
    $.ajax({
  	   type: 'POST',
  	   dataType: "JSON",
  	   url: base_url+'tallern/descartarPieza',
  	   data: {idpedido_linea:idpedido_linea},
  	   success: function(res){
  			 ocultar_alerta();
  			 if(res.result==1)
  			 {
           if($('#modal_pedido_almacen').is(':visible')) //Refrescamos la vista
              tablaPiezasPedidoAlmacen( $('#idpedidoAlmacen_chat').val() );
            if($('#modal_ficha_or').is(':visible')) //Refrescamos la vista
                refrescarPiezasOR( $('#form_ficha_or #idor').val() );

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

function piezasRecibidas()
{
  var piezas_recibir = []; var tmp = {};
  var error = false;
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  if(!$('#piezas_or .piezas_pdte .tasacion input:checked').length)
  {
    mostrar_alerta("alerta_error","No ha seleccionado ninguna pieza",1500);
    return 1;
  }
  if($('#piezas_or .tasacion  input.noconfirmada:checked').length)
  {
    mostrar_alerta("alerta_error","Ha seleccionado piezas no confirmadas",1500);
    return 1;
  }
  $('#piezas_or .piezas_pdte .tasacion input:checked').each(function(){

			var idor_linea= $(this).val();
			piezas_recibir.push(idor_linea);
	});
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/recibirPiezas',
	   data: "idor="+idor+"&piezas_recibir="+JSON.stringify(piezas_recibir),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
         $('#contenido_ficha_or #piezas_or').html(res.piezas_html);
         load_interfaz_piezas();
         $('#contenido_ficha_or #pantalla_informes-4').html(res.lineas_html);
         load_interfaz_lineas();
         $('#contenedor_or_pdte').html(res.or_pdte_html);
         $('#contenedor_piezas_pdte_taller').html(res.piezas_recibir);
         load_interfaz_initiotaller();


          mostrar_alerta("alerta_correcto","Piezas recibidas",500,function(){

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
} //piezas recibidas

function piezasColocadas()
{
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  if(!$('#piezas_or .piezas_recibidas .tasacion input:checked').length)
  {
    mostrar_alerta("alerta_error","No ha seleccionado ninguna pieza",1500);
    return 1;
  }
  $('#modal_colocar_piezas #form_colocar_piezas').trigger('reset');
  $("#modal_colocar_piezas .selectpicker").selectpicker("refresh");
  $('#modal_colocar_piezas').modal('show');
}
function confirmar_piezasColocadas()
{
  var piezas_colocar = []; var tmp = {};
  var error = false;
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  if(!$('#piezas_or .piezas_recibidas .tasacion input:checked').length)
  {
    mostrar_alerta("alerta_error","No ha seleccionado ninguna pieza",1500);
    return 1;
  }
  if($('#modal_colocar_piezas #tipo_colocar_piezas').val()=="")
  {
    mostrar_alerta("alerta_error","Indique el tipo de trabajo",1500);
    return 1;
  }
  if($('#modal_colocar_piezas #horas_colocar_pieza').val()==0 && $('#modal_colocar_piezas #minutos_colocar_pieza').val()==0)
  {
    mostrar_alerta("alerta_error","Indique cuanto ha tardado",1500);
    return 1;
  }
  $('#piezas_or .piezas_recibidas .tasacion input:checked').each(function(){

			var idor_linea= $(this).val();
			piezas_colocar.push(idor_linea);
	});
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/colocarPiezas',
	   data: $('[name=form_colocar_piezas]').serialize()+"&idor="+idor+"&piezas_colocar="+JSON.stringify(piezas_colocar),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
         $('#contenido_ficha_or #piezas_or').html(res.piezas_html);
         load_interfaz_piezas();
         $('#contenido_ficha_or #pantalla_informes-4').html(res.lineas_html);
         load_interfaz_lineas();
          mostrar_alerta("alerta_correcto","Piezas colocadas",500,function(){
            $('#modal_colocar_piezas').modal('hide');
            cerrarModalPrincipal();

       });
			 }
			 else {
			 		$('#validation_or_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
} //Colocar piedas



function recibir_piezas_almacen(idpedido)
{
  var piezas_recibir = []; var error = false;
  $('#modal_pedido_almacen #tabla_lineas_pedido_almacen tbody input:checked').each(function(){

      if(!$(this).hasClass('pdte_recibir')) error = true;
			var idpedido_linea= $(this).val();
			piezas_recibir.push(idpedido_linea);
	});
  if(error)
  {
    mostrar_alerta("alerta_error","Seleccione solo piezas pdte recibir",1500);
    return 1;
  }
  if(piezas_recibir.length==0)
  {
    mostrar_alerta("alerta_error","No ha seleccionado ninguna pieza",1500);
    return 1;
  }
  if(confirm("Se marcarán las piezas como recibidas"))
  {
    $.ajax({
  	   type: 'POST',
  	   dataType: "JSON",
  	   url: base_url+'tallern/recibirPiezasAlmacen',
  	   data: "idpedido="+idpedido+"&piezas_recibir="+JSON.stringify(piezas_recibir),
  	   success: function(res){
  			 ocultar_alerta();
  			 if(res.result==1)
  			 {
           tablaPiezasPedidoAlmacen(idpedido);
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
function devolver_piezas_almacen(idpedido)
{
  var piezas_devolver = [];
  var error = false;
  $('#modal_pedido_almacen #tabla_lineas_pedido_almacen tbody input:checked').each(function(){

      if($(this).hasClass('devuelta')) error =true;

			var idpedido_linea= $(this).val();
			piezas_devolver.push(idpedido_linea);
	});
  if(error)
  {
    mostrar_alerta("alerta_error","Ha seleccionado piezas ya devueltas",1500);
    return 1;
  }
  if(piezas_devolver.length==0)
  {
    mostrar_alerta("alerta_error","No ha seleccionado ninguna pieza",1500);
    return 1;
  }
  if(confirm("Se avisará al proveedor para recogerlas"))
  {
    $.ajax({
  	   type: 'POST',
  	   dataType: "JSON",
  	   url: base_url+'tallern/devolverPiezasAlmacen',
  	   data: "idpedido="+idpedido+"&piezas_devolver="+JSON.stringify(piezas_devolver),
  	   success: function(res){
  			 ocultar_alerta();
  			 if(res.result==1)
  			 {
           tablaPiezasPedidoAlmacen(idpedido);
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
function he_terminado_or()
{
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  if(confirm("Se avisará para poder facturar la OR. ¿Estas seguro?"))
  {
    mostrar_alerta("alerta_info","Guardando datos... por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "JSON",
       url: base_url+'tallern/terminarOR',
       data: "idor="+idor,
       success: function(res){
         ocultar_alerta();
         if(res.result==1)
         {
             $('#contenido_ficha_or #boton_terminar_or').hide();
             mostrar_alerta("alerta_correcto","OR terminada",1500,function(){

           });
         }
         else {
            $('#validation_or_errors').html(res.message);
         }
       },
       error: function(){
        mostrar_alerta("alerta_error","Problemas de red...",1500);
      }
      }); //AJAX
  }



}
function guardar_lineas_or()
{
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  var lineas = []; var tmp = {};
  $('#modal_ficha_or #tabla_productos .linea_concepto').each(function(){
			var idor_linea= $(this).find('[name=idor_linea]').val();
			tmp = {};
			tmp['orlinea_tipo'] = $(this).find('[name=tipo_gasto]').val();
      if(tmp['orlinea_tipo']<1 || tmp['orlinea_tipo']>5 ) error_tipo_gasto = true
      tmp['mostrar_factura'] = 0;
      if($(this).find('[name=mostrar_factura]').is(':checked')) tmp['mostrar_factura'] = 1;
      //tmp['codigo_gasto'] = $(this).find('[name=codigo_gasto]').val();
			//tmp['codigo_gasto_bbdd'] = $(this).find('[name=codigo_gasto_bbdd]').val();
      tmp['descripcion'] = $(this).find('[name=descripcion]').val();
      tmp['idor_linea'] = $(this).find('[name=idor_linea]').val();
			tmp['unidades'] = $(this).find('[name=unidades]').val();
			tmp['or_importe_ud'] = $(this).find('[name=precio]').val();
      tmp['or_dto'] = $(this).find('[name=dto]').val();
      tmp['or_dto_2'] = $(this).find('[name=dto_2]').val();
			tmp['or_importe_linea'] = $(this).find('[name=precio_linea]').val();
			lineas.push(tmp);

	});
  mostrar_alerta("alerta_info","Guardando lineas... por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/saveLineasOR',
	   data: "idor="+idor+"&lineas="+JSON.stringify(lineas),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
          if($('#idor').val()=="")
          {
            $('#idor').val(res.idor);

          }
          $('#generarfactura').show();
          if($('#pantalla_principal_taller').length) buscar_or_abiertas();
           if($('#contenedor_or_total').length) buscar_ors();
           $('#validation_or_errors').html('');
           $('#apartado_docs').effect('slide', { direction: 'up', mode: 'show' }, 800);
           $('#apartado_costes').effect('slide', { direction: 'up', mode: 'show' }, 800);
           $('#boton_pago_or').show();
           mostrar_alerta("alerta_correcto","Datos Guardatos",1500,function(){

				 });
			 }
			 else {
			 		$('#validation_or_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}


function old_guardar()
{
  mostrar_alerta("alerta_info","Guardando datos... por favor, espere");
  var lineas = []; var tmp = {};
  var error = false; var error_tipo_gasto = false;
  if($('#tabla_productos .linea_concepto').length) New_calcula_total();
  $('#tabla_productos .linea_concepto').each(function(){
    if($(this).find('.coste_no_existe').length)
    {
      error = true;
    }
		if($(this).find('[name=precio_linea]').val()!="")
		{
			var id= $(this).val();
			tmp = {};
			tmp['tipo_gasto'] = $(this).find('[name=tipo_gasto]').val();
      if(tmp['tipo_gasto']<1 || tmp['tipo_gasto']>5 ) error_tipo_gasto = true

      tmp['mostrar_factura'] = 0;
      if($(this).find('[name=mostrar_factura]').is(':checked')) tmp['mostrar_factura'] = 1;
      tmp['codigo_gasto'] = $(this).find('[name=codigo_gasto]').val();
			tmp['codigo_gasto_bbdd'] = $(this).find('[name=codigo_gasto_bbdd]').val();
			tmp['descripcion'] = $(this).find('[name=descripcion]').val();
			tmp['cantidad'] = $(this).find('[name=unidades]').val();
			tmp['precio'] = $(this).find('[name=precio]').val();
      tmp['dto'] = $(this).find('[name=dto]').val();
      tmp['dto_2'] = $(this).find('[name=dto_2]').val();
			tmp['precio_linea'] = $(this).find('[name=precio_linea]').val();
			lineas.push(tmp);
		}
	});
  if(error)
  {
    mostrar_alerta("alerta_error","Hay códigos de producto que no existen",1500);
    return 1;
  }
  if(error_tipo_gasto)
  {
    mostrar_alerta("alerta_error","Revise los tipos de gasto",1500);
    return 1;
  }
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/saveOR',
	   data: $('[name=form_ficha_or]').serialize()+"&lineas="+JSON.stringify(lineas),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
          if($('#idor').val()=="")
          {
            $('#idor').val(res.idor);
            $('#contenedor_or_pdte').html(res.or_pdte_html);
            $('#contenedor_piezas_pdte_taller').html(res.piezas_recibir);
            load_interfaz_initiotaller();
          }
          $('#generarfactura').show();
          if($('#pantalla_principal_taller').length) buscar_or_abiertas();
           if($('#contenedor_or_total').length) buscar_ors();
           $('#validation_or_errors').html('');
           $('#apartado_docs').effect('slide', { direction: 'up', mode: 'show' }, 800);
           $('#apartado_costes').effect('slide', { direction: 'up', mode: 'show' }, 800);
           $('#boton_pago_or').show();
           mostrar_alerta("alerta_correcto","Datos Guardatos",1500,function(){

				 });
			 }
			 else {
			 		$('#validation_or_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function New_guardarOR(){
  $('#contenido_ficha_or #boton_crear_or').button('loading');
  $('#contenido_ficha_or #boton_guardar_cambios').button('loading');
	mostrar_alerta("alerta_info","Guardando datos... por favor, espere");
  var lineas = []; var tmp = {};
  var error = false; var error_tipo_gasto = false;
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/saveOR',
	   data: $('[name=form_ficha_or]').serialize(),
	   success: function(res){
			 ocultar_alerta();


			 if(res.result==1)
			 {

         if($('#form_ficha_or #idor').val()=="")
         {
           $('#contenedor_or_pdte').html(res.or_pdte_html);
           $('#contenedor_piezas_pdte_taller').html(res.piezas_recibir);
           load_interfaz_initiotaller();
         }

         $('#contenido_ficha_or .idor_tratada').val(res.idor);
         $('#contenido_ficha_or #boton_crear_or').hide();
         $('#contenido_ficha_or #boton_guardar_cambios').show();

         if($('#pantalla_principal_taller').length) buscar_or_abiertas();
         if($('#contenedor_or_total').length) buscar_ors();
         $('#validation_or_errors').html('');
         //$('#apartado_docs').effect('slide', { direction: 'up', mode: 'show' }, 800);
         //$('#apartado_costes').effect('slide', { direction: 'up', mode: 'show' }, 800);
         //$('#boton_pago_or').show();
           mostrar_alerta("alerta_correcto","Datos Guardatos",1500,function(){

				 });
			 }
			 else {
			 		$('#validation_or_errors').html(res.message);
			 }
       $('#contenido_ficha_or #boton_crear_or').button('reset');
       $('#contenido_ficha_or #boton_guardar_cambios').button('reset');
	   },
	   error: function(){
       $('#contenido_ficha_or #boton_crear_or').button('reset');
       $('#contenido_ficha_or #boton_guardar_cambios').button('reset');
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function saveTareasOR(){

  if($('#contenido_ficha_or #form_or_tareas [name=idor]').val()=="")
  {
      mostrar_alerta("alerta_error","Debe crear la OR primero");
      return 1
  }
  mostrar_alerta("alerta_info","Guardando datos... por favor, espere");

  var error = false; var error_tipo_gasto = false;
	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/saveTareasOR',
	   data: $('[name=form_or_tareas]').serialize(),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
			 }
			 else {
			 		$('#validation_tareasor_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function load_interfaz_piezas()
{
  $('#contenido_ficha_or #piezas_or input:checkbox').click(function(e) {
    e.stopPropagation();
  });
  $('#contenido_ficha_or #piezas_or .tasacion').click(function() {

    if($(this).find('.checkbox').prop('checked'))
      $(this).find('.checkbox').prop('checked',false);
    else
      $(this).find('.checkbox').prop('checked',true);

   });
}
function load_interfaz_lineas()
{
  $( "#tabla_productos" ).on('keydown','[name=codigo_gasto]',function(e){
    if(e.which != 13 && e.which != 9){
      $(this).parent().parent().find('[name=codigo_gasto_bbdd]').val('');
    }
  });
  $( "#tabla_productos" ).on('blur','[name=tipo_gasto]',function(e){
      $(this).removeClass().addClass('tipogasto'+$(this).val());
      $(this).parent().parent().removeClass().addClass('linea_concepto').addClass('tipogasto'+$(this).val());
      if($(this).val()==1) $(this).parent().parent().find('[name=mostrar_factura]').prop('checked',true);
      New_calcula_total();

  });
  $( "#tabla_productos" ).on('change','[name=tipo_gasto]',function(e){
    $('#generarfactura').hide();
  });
  $( "#tabla_productos" ).on('click','[name=mostrar_factura]',function(e){

      if(!$(this).is(':checked'))
      if($(this).parent().parent().find('[name=tipo_gasto]').val()==1)
      {
        $(this).prop('checked',true);
      }

  });
  $( "#tabla_productos" ).on('blur','[name=codigo_gasto]',function(e){

    if($(this).parent().find('[name=codigo_gasto_bbdd]').val()=="")
    {
      if($('#contenedor_productos_stock #producto_'+$(this).val()).length )
      {
        $(this).parent().find('[name=codigo_gasto_bbdd]').val( $(this).val() );
        $(this).parent().removeClass('coste_no_existe');
      }
      else
      {
        if($(this).val()!="")
          $(this).parent().addClass('coste_no_existe');
      }


    }

  });
  $( "#tabla_productos" ).on('keyup','.recalcular_total',function(){
      New_calcula_total();
  });
  $( "#tabla_productos" ).on('keyup','[name=tipo_gasto]',function(){
      New_calcula_total();
  });
  $( "#tabla_productos" ).on('blur','.recalcular_total',function(){
      if($(this).val()=="")
      {
         $(this).val(0);
         New_calcula_total();
      }
  });
/*  $( "#tabla_productos" ).on('click','.eliminar_concepto',function(){
         $(this).parent().remove();
         New_calcula_total();
  });
  */
}

function load_interfaz_NEWOR()
{
  $('#contenido_ficha_or .selectpicker').selectpicker();
  $('#contenido_ficha_or .mifecha').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    language: 'es'
  });
  $('#contenido_ficha_or .mifechaanio').datepicker({
    autoclose: true,
    format:"yyyy-mm",
    language: 'es'
  });

		New_hacer_autocomplete_or();

    New_calcula_total();
}

function New_hacer_autocomplete_or(){
  return 1;
	$( "#tabla_productos [name=codigo_gasto]").each(function(){
		if(!$(this).hasClass('ui-autocomplete-input'))
		{
			$(this).autocomplete({
		      minLength: 0,
		      source: productos_stock,
					open: function() {$(this).autocomplete("widget").width(500)  },
		      focus: function( event, ui ) {
		        $(this).val( ui.item.label );
		        return false;
		      },
		      select: function( event, ui ) {
						$(this).parent().parent().find('[name=codigo_gasto]').val( ui.item.id);
						$(this).parent().parent().find('[name=codigo_gasto_bbdd]').val( ui.item.id);
						$(this).parent().removeClass('coste_no_existe');
						$(this).parent().parent().find('[name=descripcion]').val( ui.item.nombre );

					  $( this).parent().parent().find('[name=precio]').val( ui.item.precio );
						$(this).parent().parent().find('[name=unidades]').val('1');


						New_calcula_total();
		        return false;
		      }
		    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
		      return $( "<li>" )
		        .append( "<div>" + item.label + " <b>(" + item.desc + ")</b></div>" )
		        .appendTo( ul );
		    };
		}

	});

}
function hacer_autocomplete_stock_almacen(){
	$( "#contenido_stock_almacen [name=referencia]").each(function(){
		if(!$(this).hasClass('ui-autocomplete-input'))
		{
			$(this).autocomplete({
		      minLength: 0,
		      source: productos_almacen,
					open: function() {$(this).autocomplete("widget").width(700)  },
		      focus: function( event, ui ) {
		        //$(this).val( ui.item.label );
		        return false;
		      },
		      select: function( event, ui ) {
            console.log("Añadir");
            var contenido = "<tr class='linea_add'>";
            contenido += "<td><input type='hidden' name='idalmacen' value='"+ui.item.idalmacen+"'>";
            contenido += "<input type='hidden' name='idproveedor' value='"+ui.item.idproveedor+"'>";
            contenido += "<input type='hidden' name='codigo_gasto' value='"+ui.item.id+"'>";
            contenido += ui.item.id+"</td>";
            contenido += "<td>"+ui.item.nombre+"</td>";
            contenido += "<td><select name='unidades'>";
            var max = ui.item.unidades;
            if(max>10) max=10;
            for(var i = 1; i<=max;i++) contenido += "<option value='"+i+"'>"+i+"</option>";
            contenido += "</select></td>";
            contenido += "<td><div onclick='$(this).parent().parent().remove();' class='btn btn-xs btn-warning'>Eliminar</div></td></tr>";
            $('#contenido_stock_almacen #tabla_carrito_stock tbody #fila_0').remove();
            $('#contenido_stock_almacen #tabla_carrito_stock tbody').append(contenido);
            $('#contenido_stock_almacen #boton_add_piezas_almacen').show();

		        return false;
		      }
		    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
		      return $( "<li class='li_stock_almacen'>" )
		        .append( "<div>" + item.label + " <b>(" + item.desc + ")</b></div>" )
		        .appendTo( ul );
		    };
		}

	});

}

function addPiezasAlmacen()
{
  var lineas = []; var tmp = {};
  var error = false; var error_tipo_gasto = false;
  if(!$('#contenido_stock_almacen #tabla_carrito_stock tbody .linea_add').length){
    mostrar_alerta("alerta_error","No hay piezas que añadir",1500);
    return 1;
  }
  var idor= $('#form_ficha_or #idor').val();
  if(idor==""){
    mostrar_alerta("alerta_error","Debe crear primero la OR",1500);
    return 1;
  }
  $('#contenido_stock_almacen #tabla_carrito_stock tbody .linea_add').each(function(){

			var id= $(this).val();
			tmp = {};
			tmp['idalmacen'] = $(this).find('[name=idalmacen]').val();
      tmp['idproveedor'] = $(this).find('[name=idproveedor]').val();
      tmp['codigo_gasto'] = $(this).find('[name=codigo_gasto]').val();
      tmp['unidades'] = $(this).find('[name=unidades]').val();
			lineas.push(tmp);

	});


	$.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'tallern/addPiezasAlmacen',
	   data: "idor="+idor+"&lineas="+JSON.stringify(lineas),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
          $('#contenido_ficha_or #piezas_or').html(res.piezas_html);
          load_interfaz_piezas();
          $('#contenido_ficha_or #pantalla_informes-4').html(res.lineas_html);
          load_interfaz_lineas();
           mostrar_alerta("alerta_correcto","Piezas Añadidas",500,function(){
             $('#modal_or_almacen_stock').modal('hide');
             cerrarModalPrincipal();
				 });
			 }
			 else {
			 		$('#validation_or_errors').html(res.message);
			 }
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function New_calcula_total(){

	var total_bi = 0; var total_precio_linea = 0; var  total_precio_cliente = 0;
	$('#tabla_productos .linea_concepto').each(function(){
		if($(this).find('[name=precio]').val()!="" && $(this).find('[name=unidades]').val()!="")
		{
			//Formateamos
			var precio = $(this).find('[name=precio]').val();
			if(precio.indexOf(',')!=-1)
			{
				$(this).find('[name=precio]').val(precio.replace(",","."));
			}
			precio = parseFloat($(this).find('[name=precio]').val());



			var unidades = $(this).find('[name=unidades]').val();
      if(unidades.indexOf(',')!=-1)
			{
				$(this).find('[name=unidades]').val(unidades.replace(",","."));
			}
			unidades = parseFloat($(this).find('[name=unidades]').val());


      var descuento = $(this).find('[name=dto]').val();
      if(descuento.indexOf(',')!=-1)
			{
				$(this).find('[name=dto]').val(descuento.replace(",","."));
			}
			descuento = parseFloat($(this).find('[name=dto]').val());
			var descuento_cantidad = 0;
			if(descuento>0)
			{
					descuento_cantidad = (precio*descuento)/100;
			}
			descuento_cantidad = descuento_cantidad.toFixed(2);
			precio -= descuento_cantidad;
      var descuento2 = $(this).find('[name=dto_2]').val();
      if(descuento2.indexOf(',')!=-1)
			{
				$(this).find('[name=dto_2]').val(descuento.replace(",","."));
			}
			descuento2 = parseFloat($(this).find('[name=dto_2]').val());
      descuento_cantidad = 0;
			if(descuento2>0)
			{
					descuento_cantidad = (precio*descuento2)/100;
			}
			descuento_cantidad = descuento_cantidad.toFixed(2);
      precio -= descuento_cantidad;
			//precio_linea = precio_linea.toFixed(2);
			var total = precio*unidades;
			total = total.toFixed(2);
			$(this).find('[name=precio_linea]').val(total);

      var total_con_iva = total*1.21;
      total_con_iva = total_con_iva.toFixed(2);
			$(this).find('[name=total_con_iva]').val(total_con_iva);

      var iva_linea = total*0.21;
      iva_linea = iva_linea.toFixed(2);
			$(this).find('[name=iva_linea]').val(iva_linea);

			total_precio_linea += parseFloat(total);
      if($(this).hasClass('tipogasto1'))
        total_precio_cliente += parseFloat(total);
		}
	});
  var total_cliente_iva = total_precio_cliente*1.21;
  total_cliente_iva = total_cliente_iva.toFixed(2);


  $('#or_importe_1_iva').val(total_cliente_iva);
  $('#or_importe_1').val(total_precio_cliente);

  var total_importe_iva = total_precio_linea*1.21;
  total_importe_iva = total_importe_iva.toFixed(2);
  $('#or_importe').val(total_precio_linea);
  $('#or_importe_iva').val(total_importe_iva);

  //check_ultima_fila_or(); Ya no añadimosuna ultima fila.
}

function New_check_ultima_fila_or(){
	var ultima = $('#tabla_productos .linea_concepto:last');
	if(ultima.find('[name=precio_linea]').val()!="")
	{
		var disabled = ""; var iva = 0;
		//Añadimos una fila
		var contenido = "<tr class='linea_concepto'>";
		contenido += "<td style='cursor:pointer;' class='eliminar_concepto'><i class='fa fa-times bg-danger text-white'></i></td>";
    contenido += "<td style='cursor:pointer;'><input type='checkbox' name='mostrar_factura' value='1' checked ></td>";
    contenido += "<td><input type='text' style='text-align:center;' class='recalcular_total' name='tipo_gasto'></td>";
		contenido += "<td><input autocomplete='nope' type='text' name='codigo_gasto'><input type='hidden' name='codigo_gasto_bbdd'></td>";
		contenido += "<td><input type='text' name='descripcion'></td>";
		contenido += "<td><input type='text' class='recalcular_total' name='unidades'></td>";
		contenido += "<td><input type='text' class='recalcular_total' name='precio'></td>";
    contenido += "<td><input type='text' class='recalcular_total' name='dto' value='0'></td>";
    contenido += "<td><input type='text' class='recalcular_total' name='dto_2' value='0'></td>";
		contenido += "<td><input type='text' style='width:100%;' readonly name='precio_linea'></td>";
    contenido += "<td><input type='text' style='width:100%;' readonly name='iva_linea'></td>";
    contenido += "<td><input type='text' style='width:100%;' readonly name='total_con_iva'></td>";

		contenido += "</tr>";
	}

	$('#tabla_productos').append(contenido);
	hacer_autocomplete_or();
}

function New_generarDocsOR(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  mostrar_alerta("alerta_info","Generando Documento...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tallern/generarDoc/',
     data: {idor: idor},
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
function New_generarFactura(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  var continuar = true;
  if($('#or_importe_1').val()>0)
  {
    continuar = false;
    if(confirm("Se va a generar FACTURA.Si no desea generar factura elimine los pagos del cliente"))
    {
      continuar = true;
    }
  }
  if(continuar)
  {
    mostrar_alerta("alerta_info","Generando Documento...por favor, espere");
    $.ajax({
       type: 'POST',
       dataType: "html",
       url: base_url+'tallern/generarFactura/',
       data: {idor: idor},
       success: function(res){
         ocultar_alerta();

         $('#contenido_descargar_docs').html(res);
         $('#modal_descargar_dosc').modal('show');
         refrescarDocs(idor)
       },
       error: function(){
        mostrar_alerta("alerta_error","Problemas de red...",1500);
      }
      }); //AJAX
  }

}

function New_refrescarDocs(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tallern/refrescarDocs/',
     data: {idor: idor},
     success: function(res){
      $('#contenedor_docs_or').html(res);
     },
     error: function(){
      //mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX

}
function New_abrir_pago_or(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  $('#idorpagar').val(idor);
  $('#modal_pagar_or').modal('show');
}
function New_pagarOR(tipopago)
{
  var idor = $('#idorpagar').val();
  mostrar_alerta("alerta_info","Guardando Pago...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'tallern/pagarOR/',
     data: {idor: idor,tipopago:tipopago},
     success: function(res){
       ocultar_alerta();
       if(res.result==1)
       {
         mostrar_alerta("alerta_correcto","Pago guardado.",1500,function(){
           $('#modal_pagar_or').modal('hide');
           cerrarModalPrincipal();
           $('#boton_pago_or').hide();
           $('#boton_guardar_cambios').hide();

           $('#generarfactura').hide();
           if($('#pantalla_principal_taller').length) buscar_or_abiertas();
           if($('#contenedor_or_total').length) buscar_ors();
         });
       }
       else {
         mostrar_alerta("alerta_error","No se ha podido cerrar la OR",1500);
       }
     },
     error: function(){
      mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX
}
function New_firmarResguardo(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'tallern/firmarDocs/',
     data: {idor: idor,tipoDoc:0},
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

function New_refrescar_avisos_coche_or(vehiculo_id)
{
  $.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'tallern/refreshAvisosTaller/',
	   data: {
       vehiculo_id:vehiculo_id
     },
	   success: function(res){
			$('#contenedor_or_avisos_vehiculo').html(res);
	   },
	   error: function(){
		}
    }); //AJAX
}
