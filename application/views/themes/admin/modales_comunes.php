
<div class="modal fade" id="modal_descargar_dosc" tabindex="-1" role="dialog" data-backdrop='static' backdrop='static' aria-labelledby="modal_descargar_dosc" aria-hidden="true">
	<div class="modal-dialog" style='min-width:60%;'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" onclick='cerrarModalPrincipal()' class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-align-center fw-bold mt" style='margin-top:0px;' id="myModalLabel18">Descargar Documento</h4>
			</div>
			<div id='contenido_descargar_docs' style='' class="modal-body bg-gray-lighter">
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_exportar_datos" tabindex="-1" role="dialog" data-backdrop='static' backdrop='static' aria-labelledby="modal_opciones_cita" aria-hidden="true">
	<div class="modal-dialog" style='min-width:60%;'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick='cerrarModalPrincipal()' data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-align-center fw-bold mt" style='margin-top:0px;' id="myModalLabel18">Exportar Datos</h4>
			</div>
			<div id='contenido_exportar_datos' style='' class="modal-body bg-gray-lighter">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_descargar_dosc" tabindex="-1" role="dialog" data-backdrop='static' backdrop='static' aria-labelledby="modal_descargar_dosc" aria-hidden="true">
	<div class="modal-dialog" style='min-width:60%;'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" onclick='cerrarModalPrincipal()' class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-align-center fw-bold mt" style='margin-top:0px;' id="myModalLabel18">Descargar Documento</h4>
			</div>
			<div id='contenido_descargar_docs' style='' class="modal-body bg-gray-lighter">
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_delete_all" tabindex="-1" role="dialog" data-backdrop='static' backdrop='static' aria-labelledby="modal_aviso_urgente" aria-hidden="true">
	<div class="modal-dialog" style='min-width:200px;'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" onclick='cerrarModalPrincipal()' class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-align-center fw-bold mt" style='margin-top:0px;' id="titleMensaje"></h4>
			</div>
			<div id='contenido_form' style='' class="modal-body bg-gray-lighter">

			</div>
			<input type="hidden" name="item_id" id="item_id">
			<input type="hidden" name="item_id_accion" id="item_id_accion">
			<div class="modal-footer">
				<button type="button" onclick='cerrarModalPrincipal()' class="btn btn-gray" data-dismiss="modal">Cancelar</button>
				<button id="btnDelete" type="button" class="btn btn-danger" onclick='confirmar_delete_all()'></button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="modal_citas" tabindex="-1" role="dialog" data-backdrop='static' backdrop='static' aria-labelledby="modal_citas" aria-hidden="true">
	<div class="modal-dialog" style='min-width:80%;'>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" onclick='cerrarModalPrincipal()' class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-align-center fw-bold mt" style='margin-top:0px;' id="myModalLabel18">Gestion de Citas</h4>
			</div>
			
			<div id='contenido_cita' style='' class="modal-body bg-gray-lighter">

			</div>

			<div class="modal-footer">
				<button type="button" onclick='cerrarModalPrincipal()' class="btn btn-gray" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" onclick='guardarItem()'>Guardar</button>
				<button type="button" class="btn btn-warning" onclick='guardarItemEnviar()'>Guardar y Enviar</button>
			</div>
		</div>
	</div>
</div>