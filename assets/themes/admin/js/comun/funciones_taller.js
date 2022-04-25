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
function comprobarMatriculaOR()
{
  var matricula = $('#or_matricula').val();
  mostrar_alerta("alerta_info","Comprobando...por favor, espere");
  $.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'oreparacion/comprobarMatriculaOR/',
	   data: {matricula: matricula},
	   success: function(res){
       ocultar_alerta();
        $('#contenido_ficha_or').html(res);
        load_interfaz_OR();

	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}
function ficha_OR(idor){
	mostrar_alerta("alerta_info","Cargando datos...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'oreparacion/getFormOR/',
	   data: {idor: idor},
	   success: function(res){
			ocultar_alerta();

      $('#contenido_ficha_or').html(res);
       $('#contenido_ficha_or .selectpicker').selectpicker();

       load_interfaz_OR();

      $('#modal_ficha_or').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
}

function guardarOR(){


	mostrar_alerta("alerta_info","Guardando datos... por favor, espere");
  var lineas = []; var tmp = {};
  var error = false; var error_tipo_gasto = false;
  if($('#tabla_productos .linea_concepto').length) calcula_total();
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
	   url: base_url+'Oreparacion/saveOR',
	   data: $('[name=form_ficha_or]').serialize()+"&lineas="+JSON.stringify(lineas),
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

function load_interfaz_OR()
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

		hacer_autocomplete_or();
		$( "#tabla_productos" ).on('keydown','[name=codigo_gasto]',function(e){
			if(e.which != 13 && e.which != 9){
				$(this).parent().parent().find('[name=codigo_gasto_bbdd]').val('');
			}
		});
    $("#tabla_productos" ).on('blur','[name=tipo_gasto]',function(e){
        $(this).removeClass().addClass('tipogasto'+$(this).val());
		    $(this).parent().parent().removeClass().addClass('linea_concepto').addClass('tipogasto'+$(this).val());
        if($(this).val()==1) $(this).parent().parent().find('[name=mostrar_factura]').prop('checked',true);
        calcula_total();
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
				calcula_total();
		});
    $( "#tabla_productos" ).on('keyup','[name=tipo_gasto]',function(){
        calcula_total();
    });
		$( "#tabla_productos" ).on('blur','.recalcular_total',function(){
				if($(this).val()=="")
				{
					 $(this).val(0);
					 calcula_total();
				}
		});
		$( "#tabla_productos" ).on('click','.eliminar_concepto',function(){
					 $(this).parent().remove();
					 calcula_total();
		});
    calcula_total();
}

function hacer_autocomplete_or(){
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


						calcula_total();
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
function calcula_total(){

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
	check_ultima_fila_or();
}

function check_ultima_fila_or(){
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

function generarDocsOR(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  mostrar_alerta("alerta_info","Generando Documento...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'Oreparacion/generarDoc/',
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
function generarFactura(idor)
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
       url: base_url+'Oreparacion/generarFactura/',
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

function refrescarDocs(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'oreparacion/refrescarDocs/',
     data: {idor: idor},
     success: function(res){
      $('#contenedor_docs_or').html(res);
     },
     error: function(){
      //mostrar_alerta("alerta_error","Problemas de red...",1500);
    }
    }); //AJAX

}
function abrir_pago_or(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  $('#idorpagar').val(idor);
  $('#modal_pagar_or').modal('show');
}
function pagarOR(tipopago)
{
  var idor = $('#idorpagar').val();
  mostrar_alerta("alerta_info","Guardando Pago...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "JSON",
     url: base_url+'Oreparacion/pagarOR/',
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
function firmarResguardo(idor)
{
  idor = typeof idor !== 'undefined' ? idor : $('#idor').val();
  mostrar_alerta("alerta_info","Preparando Firma...por favor, espere");
  $.ajax({
     type: 'POST',
     dataType: "html",
     url: base_url+'Oreparacion/firmarDocs/',
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

function refrescar_avisos_coche_or(vehiculo_id)
{
  $.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'oreparacion/refreshAvisosTaller/',
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
