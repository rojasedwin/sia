

<script type="text/javascript" src="/assets/themes/admin/js/comun/jquery3.1.1.min.js" language="javascript"></script>

<!-- <script type="text/javascript" src="/assets/themes/admin/js/comun/jquery-1.11.1.min.js" language="javascript"></script> -->

<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/transition.js"></script>
<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/collapse.js"></script>
<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js"></script>

<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js"></script>
<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/alert.js"></script>
<script src="/assets/themes/admin/js/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>


<script src="/assets/themes/admin/js/vendor/jquery-autosize/jquery.autosize.min.js"></script>
<!-- <script src="/assets/themes/admin/js/vendor/select2/select2.min.js"></script> -->
<script src="/assets/themes/admin/js/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/themes/admin/js/vendor/widgster/widgster.js"></script>
<script src="/assets/themes/admin/js/vendor/jquery-touchswipe/jquery.touchSwipe.js"></script>
<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/modal.js"></script>
<script type="text/javascript" src="/assets/themes/admin/js/comun/jquery.marquee.js?v=1" language="javascript"></script>

<script type="text/javascript" src="/assets/themes/admin/js/comun/jquery-ui.1.12.min.js" language="javascript"></script>
<!-- <script type="text/javascript" src="/assets/themes/admin/js/comun/jquery-ui.min.js" language="javascript"></script> -->

<script src="/assets/themes/admin/js/vendor/bootstrap-sass/assets/javascripts/bootstrap/button.js"></script> 

<script src="/assets/themes/admin/js/vendor/datepicker/bootstrap-datepicker.min.js"></script>
<script src="/assets/themes/admin/js/vendor/datepicker/bootstrap-datepicker.es.js"></script>
<script  src="/assets/themes/admin/js/vendor/fancybox/jquery.fancybox.js?v=2.1.4" type="text/javascript"></script>
<!--  <script type="text/javascript" src="/assets/themes/admin/js/comun/jquery-ui-1.10.4.custom.min.js" language="javascript"></script> -->
<script src="/assets/themes/admin/js/vendor/switchery/dist/switchery.min.js"></script>


<!-- <script src="/assets/themes/admin/js/comun/datatables.min.js"></script> -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="/assets/themes/admin/js/comun/mis_tablas.js?6.<?php echo $this->config->item('js_version');?>"></script>
<script src="/assets/themes/admin/js/comun/mis_tablas_json.js?6.<?php echo $this->config->item('js_version');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.3.0/firebase-app.js"></script>

<!-- Add additional services that you want to use -->
<script src="https://www.gstatic.com/firebasejs/5.3.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.3.0/firebase-database.js"></script>
<!-- <script src="/assets/themes/admin/js/vendor/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script> -->




<!-- Funciones especificas -->
<script type="text/javascript" src="/assets/themes/admin/js/comun/funciones_genericas.js?1<?php echo $this->config->item('js_version');?>" language="javascript"></script>
<script type="text/javascript" src="/assets/themes/admin/js/comun/engine.js?1.0.1" language="javascript"></script>
<script type="text/javascript" src="/assets/themes/admin/js/comun/fvalidar.js?v=13" language="javascript"></script>



<!-- common app js -->
<script src="/assets/themes/admin/js/comun/settings.js"></script>
<script src="/assets/themes/admin/js/comun/app.js?1.3"></script>

<script src="/assets/themes/admin/js/comun/ajax-select/ajax-bootstrap-select.js"></script>
<script src="/assets/themes/admin/js/comun/ajax-select/locale/ajax-bootstrap-select.es-ES.js"></script>


<?php

	//If Assets JS Data exists, load files
	if(isset($assets_js_data) and count($assets_js_data)>0){
		foreach($assets_js_data AS $js_file){
			  echo '<script src="/assets/themes/'.$js_file.'"></script>';
		}
	}

	//If JS Data exists, load files
	if(isset($js_data) and count($js_data)>0){
		foreach($js_data AS $js_file){
			echo '<script src="/assets/themes/admin/js/'.$js_file.'"></script>';
		}
	}
	if(isset($external_footer_js)){
			foreach($external_footer_js AS $external_js_file){
					echo '<script src="'.$external_js_file.'"></script>';
			}
	}
	/*
	//GroceryCRUD JS
	if(isset($js_files)){
		foreach($js_files as $file){
		?>
			<script src="<?php echo $file; ?>"></script>
		<?php
		}
		}
*/
?>
<script>
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
var buscar_nueva_venta_ajax = null;
$( document ).ready(function() {

		$('body').on('click','.launch_preview_image',function(){
			$("#imagepreview").prop('src', $(this).prop('src'));
			$("#imagemodal").modal("show");
		});

		$('#nav-collapse-toggle2').on('click tap',function(){
			//alert("Pulso");
			$('body').toggleClass('nav-collapsed');
		});
		$('#modal_buscar_nueva_venta #dni_nueva_venta').keyup(function() {
			delay(
			buscar_cliente_nuevaventa
		, 900 );});
		$('#modal_buscar_nueva_venta #telefono_nueva_venta').keyup(function() {
			delay(
			buscar_cliente_nuevaventa
		, 900 );});
		$('#modal_buscar_nueva_venta #apellidos_nueva_venta').keyup(function() {
			delay(
			buscar_cliente_nuevaventa
		, 900 );});
		/*
		$('#modal_citas_pdtes #dni_cita_pdte').keyup(function() {
			delay(
			buscar_cliente_citas_pdtes
		, 900 );});
		$('#modal_citas_pdtes #telefono_cita_pdte').keyup(function() {
			delay(
			buscar_cliente_citas_pdtes
		, 900 );});
		$('#modal_citas_pdtes #apellidos_cita_pdte').keyup(function() {
			delay(
			buscar_cliente_citas_pdtes
		, 900 );});
		*/


				$('#modal_buscar_recomendador #buscar_recomendador_telefono').keyup(function() {
					delay(
					buscar_recomendador
				, 900 );});
				$('#modal_buscar_recomendador #buscar_recomendador_matricula').keyup(function() {
					delay(
					buscar_recomendador
				, 900 );});

		$( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
			 if (jqxhr.status === 401) {
				alert("La sesión ha expirado. Inicie sesión de nuevo");
				location.reload();
			}
			if (jqxhr.status === 403) { //We have to regenerate CSRF TOKEN
			 alert("La sesión ha expirado. Inicie sesión de nuevo");
			 location.reload();
		 	}

		});
		var data = {};
		data[csrfName] = csrfHash;
		$.ajaxSetup({
       data: data
    });
		/*$.ajaxPrefilter(function(options, originalData, xhr){
		  if (options.data)
		    options.data += "&"+csrfName+"="+csrfHash;
		});*/
	   window.SingApp.hideLoader();
		 $('.selectpicker').selectpicker();
		 $('[data-toggle=tooltip]').tooltip();
		 $('.mifecha').datepicker({
			 autoclose: true,
			 format:"dd-mm-yyyy",
			 language: 'es'
		 });

		 $('#dialog_chat').draggable();
		 $('#dialog_pago').draggable();
		 
		 
		 /*
	     SELECTPICKER POR AJAX
	   */
	   $('.selectpicker_ajax').each(function(){

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
	 		    var i,l = data.length, array = [];
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
	 		    return array;
	 		  }
	 		};
	 		$(this).selectpicker()
	 	 .ajaxSelectPicker(options);
	 	});
		
		
		$('body').on('keyup','.is_number',function(){
				if($(this).val().indexOf(',')!=-1)
				{
						$(this).val($(this).val().replace(",","."));
				}
		});

});
</script>
</html>
