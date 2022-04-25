/** @format */

$(document).ready(function () {
  const MIN_WIDTH = 300;
  const MIN_HEIGHT = 300;

  $(".check-box-ios").each(function () {
    new Switchery(document.getElementById($(this).prop("id")));
  });

  // init();

  function pantalla_perfil() {
    mostrar_alerta("alerta_info", "Cargando formulario...por favor, espere");
    $.ajax({
      type: "POST",
      dataType: "html",
      url: base_url + "dashboard/my_profile_form/",
      data: {},
      success: function (res) {
        init(res);
      },
      error: function () {
        mostrar_alerta("alerta_error", "Problemas de red...", 1500);
      }
    });
  }

  function init(res = "") {
    ocultar_alerta();
    console.log("ready");
    $("#pantalla_perfil").html(res);

    $("#fecha_nac_dia").selectpicker();
    $("#fecha_nac_mes").selectpicker();
    $("#fecha_nac_year").selectpicker();

    $("#cambiarclave").click(function () {
      if ($(this).prop("checked") == true) {
        $("#pantalla_inputs_clave").effect(
          "slide",
          { direction: "right", mode: "show" },
          800
        );
      } else {
        $("#nuevapass1").val("");
        $("#nuevapass2").val("");
        $("#pantalla_inputs_clave").effect(
          "slide",
          { direction: "right", mode: "hide" },
          800
        );
      }
    });
    $("#user_object").change(function () {
      uploadImg();
    });
    $("#icono_eliminar").click(function () {
      del_objetc();
    });
    $("#fecha_nac_dia").change(function (e) {
      e.preventDefault();
      buildDate();
    });
    $("#fecha_nac_mes").change(function (e) {
      e.preventDefault();
      buildDate();
    });
    $("#fecha_nac_year").change(function (e) {
      e.preventDefault();
      buildDate();
    });

    if (res && res.result == 1) {
      mostrar_alerta("alerta_correcto", res.message, 1000, function () {
        $(".modal").modal("hide");
        search_machines(1);
      });
    } else {
      $("#validation_adminuser_errors").html(res.message);
    }
  }

  function buildDate() {
    var dia = $("#fecha_nac_dia").val();
    var mes = $("#fecha_nac_mes").val();
    var year = $("#fecha_nac_year").val();
    var tmpFechaNac = dia + "-" + mes + "-" + year;
    $("#user_fecha_nacimiento").val(tmpFechaNac);
  }

  function uploadImg() {
    mostrar_alerta("alerta_info", "Cargando Imagen...por favor, espere");

    var fd = new FormData();
    var files = $("#user_object")[0].files[0];
    fd.append("user_object", files);

    $.ajax({
      type: "POST",
      dataType: "html",
      url: base_url + "dashboard/subirObjeto/",
      data: fd,
      contentType: false,
      processData: false,
      success: function (res) {
        var objTmp = JSON.parse(res);
        ocultar_alerta();
        console.log(objTmp);
        object_uploaded(
          objTmp.mensaje,
          objTmp.preview,
          objTmp.name_object,
          objTmp.ancho + "-" + objTmp.alto
        );
      },
      error: function () {
        mostrar_alerta("alerta_error", "Problemas de red...", 1500);
      }
    });
  }

  function changeCoordsWide(c) {
    $("#x_wide").val(c.x);
    $("#y_wide").val(c.y);
    $("#w_wide").val(c.w);
    $("#h_wide").val(c.h);
  }

  function object_uploaded(mensaje, idpreview, url, idimagen) {
    ocultar_alerta();
    if (mensaje == "ok") {
      mostrar_alerta("alerta_correcto", "Imagen subida", 1500);
      var tmp = idimagen.split("-");
      var w = tmp[0];
      var h = tmp[1];

      $("#" + idpreview).html(
        "<img id='target_wide' src='/attachments/tmp/" + url + "'>"
      );
      var select_default = MIN_WIDTH;
      if(w>=MIN_WIDTH && h>=MIN_HEIGHT)
      {
        if(w>=h) select_default = h;
        else select_default = w;
      }
      console.log("Voy con "+select_default+" porque w vale "+w);
      $("#target_wide").Jcrop({
        onChange: changeCoordsWide,
        trueSize: [w, h],
        bgOpacity: 0.1,
        allowSelect: false,
        minSize: [MIN_WIDTH, MIN_HEIGHT],
        aspectRatio: MIN_WIDTH / MIN_HEIGHT,
        setSelect: [0, 0, select_default, select_default]
      });

      $("#user_imagen").val(url);
      $("#path_subido").val(url); //For delete last upload
      $("#path_modificado").val(1);
      $("#icono_eliminar").show();

      return 1;
    }

    if (mensaje == "error_tam") {
      mostrar_alerta(
        "alerta_error",
        "al menos " + MIN_WIDTH + "x" + MIN_HEIGHT + " px",
        1500
      );
      return 1;
    }
    if (mensaje == "format") {
      mostrar_alerta("alerta_error", "Invalid format", 1500);
      return 1;
    }
    mostrar_alerta("alerta_error", "Error", 1500);
  }

  function del_objetc() {
    console.log("call funcion del_objectc()");
    $.ajax({
      type: "POST",
      url: base_url + "dashboard/delImgTemporal",
      data: { user_imagen: $("#user_imagen").val() },
      dataType: "html",
      success: function () {
        $("#icono_eliminar").hide();
        $("#preview_cartel").html(
          "<img id='target_wide' src='/attachments/web/imagenes/no_imagen.png'>"
        );
        $("#path_modificado").val(1);
        $("#user_imagen").val("");
      },
      error: function () {
        console.log("error de red");
      }
    });
  }

  pantalla_perfil();
});
