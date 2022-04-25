<li id='listado_noti' class="dropdown">
		<a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">

			<strong>
				<?php
				 echo ucwords($this->session->userdata('nombreUsuario'));
				?>
				&nbsp;&nbsp;
			</strong>
				<span id='nuevos_mensajes' class="circle bg-danger fw-bold" style='color:#FFF;'>
					<?php
					if(isset($mis_mensajes) and count($mis_mensajes)>0)
					{
						$nuevos=0;
						foreach($mis_mensajes as $m)
						{
							if($m['leido']==0) $nuevos++;
						}
						echo $nuevos;
					}
					else {
						echo "0";
					}
					 ?>
				</span>
				<b class="caret"></b></a>
		<!-- ready to use notifications dropdown.  inspired by smartadmin template.
				 consists of three components:
				 notifications, messages, progress. leave or add what's important for you.
				 uses Sing's ajax-load plugin for async content loading. See #load-notifications-btn -->
		<div class="dropdown-menu animated fadeInUp" id="notifications-dropdown-menu">
				<section class="panel notifications">

						<!-- notification list with .thin-scroll which styles scrollbar for webkit -->

						<div id="tab3" class="list-group thin-scroll" style='min-height:400px;'>
							<?php
							if(isset($mis_mensajes) and count($mis_mensajes)>0)
							{
								echo '<a class="list-group-item " href="#"><h5 style="text-align:center;" class="tarea_iniciada">Mensajes ('.count($mis_mensajes).')</h5></a>';
								foreach($mis_mensajes as $m)
								{
									$class= ""; if($m['leido']==0) $class="mensaje_nuevo";
									echo "<input type='hidden' id='leido_mensaje-".$m['id_mensaje']."' value='".$m['leido']."'>";
									echo "<input type='hidden' id='asunto_mensaje-".$m['id_mensaje']."' value='".$m['mensaje_asunto']."'>";
									echo "<input type='hidden' id='texto_mensaje-".$m['id_mensaje']."' value='".$m['mensaje_texto']."'>";
									echo '<a onclick="ver_mensaje('.$m['id_mensaje'].')" id="link_mensaje-'.$m['id_mensaje'].'" class="list-group-item '.$class.'" href="#"><p class="text-ellipsis no-margin">';
									echo $m['mensaje_asunto'];
									echo '<div style="float:right;" class="btn btn-xs btn-primary">Leer</div></p>';
									echo '<time class="help-block no-margin">'.fecha_red($m['mensajes_create_time']);
									echo '</time></a>';
								}
							}
							else {
								echo "<h3 class='text-center'>	-- No hay noticaciones --</h3>";
							}
							 ?>


						</div>
						<footer class="panel-footer text-sm">

						</footer>
				</section>
		</div>
</li>
