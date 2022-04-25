var cambios_rea = 0;
var tiempo_modificado_rea = "";
function ver_rea_vehiculo(vehiculo_id){
	mostrar_alerta("alerta_info","Cargando...por favor, espere");
	$.ajax({
	   type: 'POST',
	   dataType: "html",
	   url: base_url+'vehiculos/getFormuRea',
	   data: { vehiculo_id:vehiculo_id } ,
	   success: function(res){
			 ocultar_alerta();
			 $('#contenido_ficha_rea').html(res);
       tiempo_modificado_rea = $('#contenido_ficha_rea #tiempo_modificado_rea').val();
       load_wizard_rea('#contenido_ficha_rea');
       cambios_rea = 0;
       $('#modal_ficha_rea').modal('show');
	   },
	   error: function(){
			mostrar_alerta("alerta_error","Problemas de red...",1500);
		}
    }); //AJAX
} //get Formu REA

function save_time_rea(accion)
{
  console.log("TIME!! "+tiempo_modificado_rea);
  if(accion.parent().parent().find('.time').val()=="")
  {
    console.log("Esta vacio!!!");
    accion.parent().parent().find('.time').val(tiempo_modificado_rea);
  }

}

function load_wizard_rea(id)
{
  $(id+" .selectpicker").selectpicker();
  $(id+" [name=rea_completed]").click(function(){
    hay_cambios();
    if($(this).is(':checked'))
    {
      save_time_rea($(this));
      if(!$(this).parent().parent().parent().find('[name=rea_needed]').is(':checked'))
      {
        $(this).parent().parent().parent().find('[name=rea_needed]').prop('checked',true);
        save_time_rea($(this).parent().parent().parent().find('[name=rea_needed]'));
      }
    }
    check_estados_reas($(this).data('rea_family'));

  });

  $(id+" [name=rea_needed]").click(function(){
    if(!$(this).is(':checked') && $(this).parent().parent().parent().find('[name=rea_completed]').is(':checked'))
    {
      console.log("No debería dejarlo!!!");
      $(this).prop('checked',true);
    }
    else {
      hay_cambios();
      check_estados_reas($(this).data('rea_family'));
    }
    save_time_rea($(this));;
  });


  $(id+" [name=rea_libre_completed]").click(function(){
    hay_cambios();
    if($(this).is(':checked'))
    {
      if(!$(this).parent().parent().parent().find('[name=rea_libre_needed]').is(':checked'))
      {
        $(this).parent().parent().parent().find('[name=rea_libre_needed]').prop('checked',true);
        save_time_rea($(this).parent().parent().parent().find('[name=rea_libre_needed]'));
      }
      save_time_rea($(this));
    }

    check_estados_reas($(this).data('rea_family'));

  });
  $(id+" [name=rea_libre_needed]").click(function(event){
    if(!$(this).is(':checked') && $(this).parent().parent().parent().find('[name=rea_libre_completed]').is(':checked'))
    {
      console.log("No debería dejarlo!!!");
      $(this).prop('checked',true);
    }
    else {
      hay_cambios();
      check_estados_reas($(this).data('rea_family'));
    }
    save_time_rea($(this));
  });
  $(id+" [name=accion_libre]").keyup(function(){
    hay_cambios();
    if($(this).val()!='')
    {
      if(!$(this).parent().parent().find('[name=rea_libre_needed]').is(':checked'))
      {
        $(this).parent().parent().find('[name=rea_libre_needed]').prop('checked',true);
        console.log("Voy a guardar")
        save_time_rea($(this).parent().parent().find('[name=rea_libre_needed]'));
      }
      check_estados_reas($(this).data('rea_family'));
    }
  });
  $(id+" [name=texto_rea]").keyup(function(){
    hay_cambios();
    if($(this).val()!='')
    {
      if(!$(this).parent().parent().find('[name=rea_needed]').is(':checked'))
      {
        $(this).parent().parent().find('[name=rea_needed]').prop('checked',true);
        console.log("Voy a guardar")
        save_time_rea($(this).parent().parent().find('[name=rea_needed]'));
      }
      check_estados_reas($(this).data('rea_family'));
    }
  });

  $(id+" #veh_situacion").change(function(){
    hay_cambios();
  });



  //Cargamos por defecto.
  check_estados_reas(0);
  check_estados_reas(1);
  check_estados_reas(2);
  check_estados_reas(3);

}
function hay_cambios()
{
  cambios_rea = 1;
  $('#contenido_ficha_rea #btn_guardar').addClass('btn-warning');
}
function cerrar_ficha_rea()
{
  if(cambios_rea==1)
  {
    if(confirm("Hay cambios sin guardar. ¿Cerrar igualmente?"))
    {
      console.log("He aceptado!!!");
      $('#modal_ficha_rea').modal('hide');
    }

  }
  else {
    $('#modal_ficha_rea').modal('hide');
  }
}

function check_estados_reas(rea_family)
{
    var estado = "";
    console.log('Entro con '+rea_family);
    $('#collapseREA-'+rea_family+" [name=rea_needed]:checked").each(function(){
      //Está checkado...
      if(!$(this).parent().parent().parent().find('[name=rea_completed]').is(':checked'))
      {
         estado = "warning"; return false;
      }
      else if(estado=="") estado = "success";
    });
    $('#collapseREA-'+rea_family+" [name=rea_libre_needed]:checked").each(function(){
      //Está checkado...
      if(!$(this).parent().parent().parent().find('[name=rea_libre_completed]').is(':checked'))
      {
         estado = "warning"; return false;
      }
      else if(estado=="") estado = "success";
    });
    if(estado=="") $('#check_estado_'+rea_family+" input").prop('checked',false);
    else if(estado=="warning")
    {
        $('#check_estado_'+rea_family+" input").prop('checked',true);
        $('#check_estado_'+rea_family+" .checkmark").removeClass('checkmark_success').addClass('checkmark_warning');
    }
    else if(estado=="success")
    {
        $('#check_estado_'+rea_family+" input").prop('checked',true);
        $('#check_estado_'+rea_family+" .checkmark").addClass('checkmark_success').removeClass('checkmark_warning');
    }
    //console.log("devolvería "+estado);
    return estado;
}


function guardar_ficha_rea()
{
  var acciones = []; var acciones_libres = [];
  var tmp = {};
  $('#contenido_ficha_rea [name=rea_libre_needed]:checked').each(function(){


      tmp = {};
      var vehiculo_rea_accion_libre_id= $(this).data('accion_id');
      tmp['vehiculo_rea_accion_libre_id'] = vehiculo_rea_accion_libre_id;
      tmp['rea_needed'] = 1;
      tmp['rea_needed_time'] = $(this).parent().parent().find('.time').val();
      tmp['rea_completed'] = 0; tmp['rea_completed_time'] = null;
      if($(this).parent().parent().parent().find('[name=rea_libre_completed]').is(':checked'))
      {
        tmp['rea_completed'] = 1; tmp['rea_completed_time'] = $(this).parent().parent().parent().find('[name=rea_libre_completed_time]').val();
      }
      tmp['texto'] = $(this).parent().parent().parent().find('[name=accion_libre]').val();
      acciones_libres.push(tmp);
  });
  console.log("Tengo "+JSON.stringify(acciones_libres))
  $('#contenido_ficha_rea [name=rea_needed]:checked').each(function(){
    console.log("Entro con una rea cliccado  ");
      tmp = {};
      var rea_id= $(this).data('rea_id');
      tmp['rea_id'] = rea_id;
      tmp['rea_needed'] = 1;
      tmp['rea_needed_time'] = $(this).parent().parent().find('.time').val();
      tmp['rea_completed'] = 0; tmp['rea_completed_time'] = null;
      if($(this).parent().parent().parent().find('[name=rea_completed]').is(':checked'))
      {
        tmp['rea_completed'] = 1; tmp['rea_completed_time'] = $(this).parent().parent().parent().find('[name=rea_completed_time]').val();
      }
      tmp['texto'] = $(this).parent().parent().parent().find('[name=texto_rea]').val();
      acciones.push(tmp);
  });
  console.log("Acciones "+JSON.stringify(acciones,null,4));

  $.ajax({
	   type: 'POST',
	   dataType: "JSON",
	   url: base_url+'vehiculos/saveREA',
	   data: $('[name=form_ficha_rea]').serialize()+"&acciones="+JSON.stringify(acciones)
     +"&acciones_libres="+JSON.stringify(acciones_libres),
	   success: function(res){
			 ocultar_alerta();
			 if(res.result==1)
			 {
				 cambios_rea = 0;
				 $('#veh_rea_id_tratando').val(res.vehiculo_rea_id);
			   $('#contenido_ficha_rea #btn_guardar').removeClass('btn-warning');
         mostrar_alerta("alerta_correcto","Cambios guardados",1000,function(){

           if($('#contenedor_vehiculos_total').length) buscar_vehiculos();
            if($('#dashboard_rea_iniciados').length) getREAsInicio();


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


function getPartePintura(vehiculo_id)
{

}
