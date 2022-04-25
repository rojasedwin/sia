<script>
var vista = "<?=$this->vista?>";
</script>
<div class="content-wrap">
	<main id="content" class="content" role="main">
		<section class="widget">
			<header>
			<h4>Confirmar Pedido</h4>
			</header>

			<div style='margin-top:20px;' class="widget-body">
				<div class="row"  name='pantalla_principal' style='margin:0px;' id='pantalla_principal'>

        <a type='button' onclick="fichaItem()" class='btn btn-xs btn-primary' style='float:right;margin-top:-4px;margin-left:5px;'>Añadir productos al pedido</a>
				<a type='button' onclick="confirmarPedido()" class='btn btn-xs btn-success' style='float:right;margin-top:-4px;margin-left:5px;'>Confirmar pedido</a>
				<div class='<?=$bootstrap['col-6']?>'>
					<label>Forma de calcular el pedido</label>
				<select class="selectpicker"
					data-style="btn-info btn-sm" onchange='recalcularPedido()'
					data-width="100%" data-live-search="true"
					tabindex="-1" name='tipo_algoritmo' id='tipo_algoritmo' title='Filtrar por laboratorio' >
					<option value='normal'>Priorizar a proveedores según orden</option>
					<option value='repartir'>Priorizar según orden pero repartir para intentar cumplir los mínimos</option>
				</select>
			</div>

					<div class='<?=$bootstrap['col-12']?>' id='resumen_pedido'>
						<?php
							$this->load->view('themes/'.$this->config->item('app_theme_admin').'/realizarpedido/confirmarpedido/getFormItem');
						?>
					</div>
				</div>
			</div>
		</section>
	</main>
</div>
