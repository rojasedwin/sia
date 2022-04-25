<script>
var vista = "<?=$this->vista?>";
</script>
<div class="content-wrap">
	<main id="content" class="content" role="main">
		<section class="widget">
			<header>
			<h4>Realizar Pedido</h4>
			</header>

			<div style='margin-top:20px;' class="widget-body">
				<div class="row"  name='pantalla_principal' style='margin:0px;' id='pantalla_principal'>

        <a type='button' onclick='importarPaso(1)' class='btn btn-xs btn-success' style='float:left;margin-top:-4px;'>Subir Excel Incrementales</a>

        <a type='button' onclick='importarPaso(2)' class='btn btn-xs btn-amarillosuave' style='float:left;margin-top:-4px;margin-left:5px;'>Subir Excel Almacén Externo</a>
		
        <a type='button' href='<?=base_url()?>adminsite/realizarpedido/confirmarpedido' class='btn btn-xs btn-primary' style='float:right;margin-top:-4px;margin-left:5px;'>Ir a Confirmar Pedido</a>
					

					<div class='<?=$bootstrap['col-12']?>'>
						<?php
							$this->load->view('themes/'.$this->config->item('app_theme_admin').'/realizarpedido/datosPasos');
						?>
					</div>
				</div>
			</div>
		</section>
	</main>
</div>

