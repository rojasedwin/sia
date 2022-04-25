/***************************************************************************************
**
**    CHAT VEHICULOS BEGIN
**
***************************************************************************************/

function verChatVehiculo(vehiculo_id, interesado_id) {

  console.log("===>>> verChatVehiculo");
  vehiculo_id_chatvehiculo = vehiculo_id;

  $("#modal_chatvehiculo #vehiculo_id_chatvehiculo").val(vehiculo_id);
  $("#modal_chatvehiculo #interesado_id_chatvehiculo").val(interesado_id);
  $('#modal_chatvehiculo #mensajes_chat_comerciales').html('');

  // Aquí se listan todos los mensajes por AJAX
  updateChatVehiculo(vehiculo_id, interesado_id);

  $("#modal_chatvehiculo").modal("show");

  //alertChatComercial(0); //alerta 0 para que quite el alerta del boton
  //$("#numMsg").val(0);

  //Si existe el div de pdte lo eliminamos.
  //$('#contenedor_chats_pdtes #tasacionchat-'+tasacion_id).remove();

}

function escribirChatVehiculo(){
  console.log("===>>> escribirChatVehiculo");

  vehiculo_id   = $("#modal_chatvehiculo #vehiculo_id_chatvehiculo").val();
  interesado_id = $("#modal_chatvehiculo #interesado_id_chatvehiculo").val();

  //Recojo las variables ocultas que he puesto en verChatVehiculo

  var message = $("#texto_chatvehiculo").val();

  $("#texto_chatvehiculo").val("");
  $("#texto_chatvehiculo").focus();

  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: base_url + "chat/nuevoMensaje/",
    data: { interesado_id: interesado_id, vehiculo_id: vehiculo_id, message: message },
    success: function(res) {
      console.dir(res);
      if (res["result"] == 1) {

        console.log("new mensaje grabado Ok....");
        var myuser_id = res.myuser_id;
        var chat_id   = res.chat_id;
        //Aquí tengo que poner el valor del chat_id en la ventana para que las notificaciones sepan si la ventana está abierta
        // Hasta que no se escribe la primera vez no tiene valor
        // Al cerrar la ventana tengo que ponerlo a '', es decir, vacío.
        $("#modal_chatvehiculo #chat_id_abierto").val(chat_id);

        var msgFormatted = formatMessageComercial(
          myuser_id,
          res.message[0].concesionario_nombre,
          res.message[0].chat_mensaje_escritor_id,
          res.message[0].concesionario_logo,
          res.message[0].chat_mensaje_texto,
          res.message[0].chat_mensaje_created_time
        );

        //console.log("Tengo esto "+msgFormatted);
        if ($("#contenido_chatvehiculo .message:last").length) {
          $("#contenido_chatvehiculo .message:last").after(msgFormatted);
        }
        else {
          $("#contenido_chatvehiculo").html(msgFormatted);
        }
        setTimeout(function(){
          animeScrollComercial("botton");
        } ,400);

      } else {
        console.log("Error, grabando mensaje en BD....");
      }
      //  updateChatComercial(tasacion_id);
    },
    error: function(jqXHR, textStatus) {}
  }); //AJAX
}

function updateChatVehiculo(vehiculo_id, interesado_id) {
  console.log("===>>> updateChatVehiculo");
  $.ajax({
    type: "POST",
    url: "chat/getListaMensajes",
    data: { vehiculo_id: vehiculo_id,  interesado_id: interesado_id },
    dataType: "JSON",
    success: function(resp) {
      console.dir(resp);
      myHTML = "";
      var myuser_id = resp.myuser_id;

      // Aquí pone la foto del concesionario con el que estoy hablando
      if (myuser_id == resp.fotos.interesado.user_id){
        $('#modal_chatvehiculo #logo_concesionario_chat').attr('src', resp.fotos.propietario.concesionario_logo);
        $('#modal_chatvehiculo #nombre_concesionario_chat').html(resp.fotos.propietario.concesionario_nombre);
      }
      else{
        $('#modal_chatvehiculo #logo_concesionario_chat').attr('src', resp.fotos.interesado.concesionario_logo);
        $('#modal_chatvehiculo #nombre_concesionario_chat').html(resp.fotos.interesado.concesionario_nombre);

      }

      // Lista cada una de las líneas del chat
      resp.listMessage.forEach(element => {
        myHTML += formatMessageComercial(
          myuser_id,
          element.concesionario_nombre,
          element.chat_mensaje_escritor_id,
          element.concesionario_logo,
          element.chat_mensaje_texto,
          element.fecha_formateada);

          $('#modal_chatvehiculo #chat_id_abierto').val(element.chat_id);

      });
      $("#contenido_chatvehiculo").html(myHTML);
      setTimeout(function(){
        animeScrollComercial("botton");
      }
    ,400);
    }
  });
}

function formatMessageComercial(user_id, user_name, chat_user_id, chat_user_img, message, time) {

  //console.log("===>>> formatMessageComercial");
  if (chat_user_id == user_id) {
    //message left
    msgClass = "message right";
  } else {
    //message right
    msgClass = "message left";
  }

  my_img = "";
  imgHtml = "";
  if (chat_user_img == "") {
    my_img = "../../attachments/web/imagenes/no_imagen.png";
  }
  else {
    my_img = "../../attachments/logos_concesionarios/" + chat_user_img;
  }

  imgHtml = "<img src=" + my_img + ' style="border-radius:50%;height:auto;width:6%;" alt="">';
  // imgHtml = '';

  // Esta es la versión original. La dejo por si hay que recuperar algo de ella
  var myMSG =
    '<div class="' +  msgClass +  '">' +
      '<div class="msg-detail">' +
        '<div class="msg-info">' +
          "<p>" +
           '<span class="usuario">' + imgHtml + "&nbsp;" + user_name + "</span>" +  time +
          "</p>" +
        "</div>" +
        '<div class="msg-content">' +
          '<span class="triangle"></span>' +
          '<p class="line-breaker">' + message + "</p>" +
        "</div>" +
      "</div>" +
    "</div>";

  // Esta es la versión nueva
    var myMSG =
      '<div class="' +  msgClass +  '">' +
        '<div class="msg-detail">' +
          '<div class="msg-info">' +
            "<p>" +
             time.slice(0, -5) +
            "</p>" +
          "</div>" +
          '<div class="msg-content">' +
            '<span class="triangle"></span>' +
            '<p class="line-breaker">' + message + '<br><span class="hora">' + time.slice(-5) + "</span>" +
            "</p>" +
          "</div>" +
        "</div>" +
      "</div>";



  return myMSG;
}

function animeScrollComercial(type) {
  console.log("===>>> animeScrollComercial 2");
  /*
  divHeight = $("#contenido_chatvehiculo").height();
  divScrollTop = $("#contenido_chatvehiculo").prop("scrollTop");
  divTall = parseInt(divHeight + divScrollTop);
  scrollHeight = parseInt($("#contenido_chatvehiculo").prop("scrollHeight"));
  diff = Math.abs(scrollHeight - divTall);

  if (type == "botton") {
    if (diff <= 200)
      $("#contenido_chatvehiculo").animate(
        { scrollTop: $("#contenido_chatvehiculo").prop("scrollHeight") },
        "1s"
      );
  }
  */
  $("#contenido_chatvehiculo").animate({ scrollTop: $('#contenido_chatvehiculo').prop("scrollHeight")}, 1000);

}

function alertChatComercial(numMsg) {
  console.log("===>>> alertChatComercial");
  if (numMsg > 0) {
    $("#btnChatComercial").html(
      "Chat Comerciales(" + numMsg + ')<i class="fa fa-comment nuevo_chat"></i>'
    );
  } else {
    $("#btnChatComercial").html("Chat Comerciales");
  }
}
