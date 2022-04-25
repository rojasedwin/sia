<ul class="sidebar-nav">
	<?php
		if(isset($menu_externo_app))
		foreach($menu_externo_app as $key=>$submenu)
		{
				if($this->uri->segment(3)=="" and $key=="provexterno") echo "<li class='active'>";
				elseif($this->uri->segment(3)=="mistrabajos" and $key=="provexterno/mistrabajos") echo "<li class='active'>";
				else echo "<li>";
				if(isset($menu_externo_app[$key]['submenu']))
				{
					echo "<a class='collapsed' href='#".$key."' data-toggle='collapse' data-parent='#sidebar'>";
					echo "<span class='icon'><i class='fa fa-".$menu_externo_app[$key]['icon']."'></i></span>";
					echo ucwords($menu_externo_app[$key]['content'])."<i class='toggle fa fa-angle-down'></i>";
					//if($key=="registros" and $registros_nuevos>0) echo '<span class="label label-danger">'.$registros_nuevos.'</span>';
					//if($key=="alertas" and $alertas_nuevas>0) echo '<span class="label label-danger">'.$alertas_nuevas.'</span>';
					echo "</a>";
					echo "<ul id='".$key."' class='collapse'>";
					foreach($menu_externo_app[$key]['submenu'] as $subkey=>$subcontent)
					{
						if($this->uri->segment(3)==$subkey) echo "<li class='active'>";
						else echo "<li>";
						echo "<a href='".base_url()."adminsite/".$key."/".$subkey."'>".ucwords($subcontent);
						//if($subkey=="registros" and $registros_nuevos>0) echo '<span style="margin-top:0px !important;" class="label label-danger">'.$registros_nuevos.'</span>';
						//if($subkey=="alertas" and $alertas_nuevas>0) echo '<span style="margin-top:0px !important;" class="label label-danger">'.$alertas_nuevas.'</span>';
						echo "</a></li>";

					}
					echo "</ul>";
				}
				else //isset($this->session['mis_rutas'][$key])
				{
					echo "<a href='".base_url()."adminsite/".$key."'>";
					echo "<span class='icon'><i class='fa fa-".$menu_externo_app[$key]['icon']."'></i></span>";
					echo ucwords($menu_externo_app[$key]['content']);
					//if($key=="contactos" and $contactos_nuevos>0) echo '<span class="label label-danger">'.$contactos_nuevos.'</span>';
					echo "</a>";
				}
				echo "</li>";

		}

	?>
</ul>
