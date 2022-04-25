<ul class="sidebar-nav">
	<?php

		foreach($menu_admin_app as $key=>$submenu)
		{
				if($this->uri->segment(2)==$key) echo "<li class='active'>";
				else echo "<li>";
				if(isset($menu_admin_app[$key]['submenu']))
				{
					echo "<a class='collapsed' href='#".$key."' data-toggle='collapse' data-parent='#sidebar'>";
					echo "<span class='icon'><i class='fa fa-".$menu_admin_app[$key]['icon']."'></i></span>";
					echo ucwords($menu_admin_app[$key]['content'])."<i class='toggle fa fa-angle-down'></i>";
					//if($key=="citas" and $citasNoCompletadas>0) echo '<span id="citasnocompletadas" class="label label-danger">'.$citasNoCompletadas.'</span>';
					//if($key=="alertas" and $alertas_nuevas>0) echo '<span class="label label-danger">'.$alertas_nuevas.'</span>';
					echo "</a>";
					echo "<ul id='".$key."' class='collapse'>";
					foreach($menu_admin_app[$key]['submenu'] as $subkey=>$subcontent)
					{
						if($this->uri->segment(3)==$subkey) echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='".base_url()."adminsite/".$key."/".$subkey."'>".ucwords($subcontent);
						//if($subkey=="citas" and $citasNoCompletadas>0) echo '<span id="subcitasnocompletadas" style="margin-top:0px !important;" class="label label-danger">'.$citasNoCompletadas.'</span>';
						//if($subkey=="alertas" and $alertas_nuevas>0) echo '<span style="margin-top:0px !important;" class="label label-danger">'.$alertas_nuevas.'</span>';
						echo "</a></li>";

					}
					echo "</ul>";
				}
				else //isset($this->session['mis_rutas'][$key])
				{
					echo "<a href='".base_url()."adminsite/".$key."'>";
					echo "<span class='icon'><i class='fa fa-".$menu_admin_app[$key]['icon']."'></i></span>";
					echo ucwords($menu_admin_app[$key]['content']);
					//if($key=="contactosweb" and $contactos_NoLeidos>0) echo '<span id="contactosNoLeidos" class="label label-danger">'.$contactos_NoLeidos.'</span>';

					/*if($key=="pedidos" and $pedidos_pagados>0){
						echo '<span id="sub_pedidos_nuevos" class="label label-warning">'.$pedidos_pagados.'</span>';
					}*/

					/*if($key=="suscripciones" and $suscripciones_NoAtendidas>0){
						echo '<span id="suscripciones_nuevos" class="label label-warning">'.$suscripciones_NoAtendidas.'</span>';
					}*/

					echo "</a>";
				}
				echo "</li>";

		}




	?>
</ul>
