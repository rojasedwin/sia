<!-- MODAL PARA EDITAR Y GUARDAR ITEM -->
<div class="modal fade" id="modal_guardar_item">
  <div class="modal-dialog" style=''>
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id='titulo_guardar_item' class="modal-title text-align-center fw-bold">-</h4>
      </div>
      <div class="modal-body bg-gray-lighter modal-body-form" id='contenedor_guardar_item'>

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-gray boton_cancelar" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success boton_guardar">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL PARA EDITAR Y GUARDAR ITEM -->

<!-- MODAL PARA ELIMINAR ITEM -->
<div class="modal fade" id="modal_eliminar_item">
  <div class="modal-dialog" style=''>
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id='titulo_eliminar_item' class="modal-title text-align-center fw-bold">-</h4>
          <input type='hidden' id='id_item_eliminar' value=''>
          <input type='hidden' id='callback_function_eliminar' value=''>
      </div>
      <div class="modal-body bg-gray-lighter">
          <div class="row">
              <div class="col-md-12" id='mensaje_eliminar_item'>
                  -
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-gray" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" onclick='confirmarEliminarItem()'>Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL PARA ELIMINAR ITEM -->


<!-- MODAL PARA ACTIVAR ITEM -->
<div class="modal fade" id="modal_activar_item">
  <div class="modal-dialog" style=''>
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id='titulo_activar_item' class="modal-title text-align-center fw-bold">-</h4>
          <input type='hidden' id='id_item_activar' value=''>
          <input type='hidden' id='callback_function_activar' value=''>
      </div>
      <div class="modal-body bg-gray-lighter">
          <div class="row">
              <div class="col-md-12" id='mensaje_activar_item'>
                  -
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-gray" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" onclick='confirmarActivarItem()'>Activar</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL PARA ACTIVAR ITEM -->


<!-- MODAL PARA DESACTIVAR ITEM -->
<div class="modal fade" id="modal_desactivar_item">
  <div class="modal-dialog" style=''>
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id='titulo_desactivar_item' class="modal-title text-align-center fw-bold">-</h4>
          <input type='hidden' id='id_item_desactivar' value=''>
          <input type='hidden' id='callback_function_desactivar' value=''>
      </div>
      <div class="modal-body bg-gray-lighter">
          <div class="row">
              <div class="col-md-12" id='mensaje_desactivar_item'>
                  -
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-gray" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-warning" onclick='confirmarDesactivarItem()'>Desactivar</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL PARA DESACTIVAR ITEM -->

<!-- MODAL PARA ACTIVAR DESACTIVAR ELIMINAR ITEM -->
<div class="modal fade" id="modal_ade_item">
  <div class="modal-dialog" style=''>
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id='titulo_ade_item' class="modal-title text-align-center fw-bold">-</h4>
          <input type='hidden' id='id_item_ade' value=''>
          <input type='hidden' id='id_item_accion' value=''>
          <input type='hidden' id='callback_function_ade' value=''>
          <input type='hidden' id='ctrlFuncion_function_ade' value=''>
      </div>
      <div class="modal-body bg-gray-lighter">
          <div class="row">
              <div class="col-md-12" id='mensaje_ade_item'>
                  -
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-gray" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-warning" id="boton_ade_item" onclick='confirmarAdeItem()'></button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL PARA DESACTIVAR ITEM -->
