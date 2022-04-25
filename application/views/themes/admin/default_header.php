<body class='nav-collapsed'> <!-- nav-static  -->
<!--
  Main sidebar seen on the left. may be static or collapsing depending on selected state.

    * Collapsing - navigation automatically collapse when mouse leaves it and expand when enters.
    * Static - stays always open.
-->
<nav id="sidebar" class="sidebar" role="navigation">
    <!-- need this .js class to initiate slimscroll -->
    <div class="js-sidebar-content">
        <header class="logo hidden-xs" style='margin-top:10px;'>

			<img style='max-height:80px;max-width:100%;margin:auto;margin-top:-5px;' src='<?php echo base_url();?>attachments/web/logo_1.png?1.2'>


        </header>
        <!-- seems like lots of recent admin template have this feature of user info in the sidebar.
             looks good, so adding it and enhancing with notifications -->
        <div class="sidebar-status visible-xs">
                <!-- .circle is a pretty cool way to add a bit of beauty to raw data.
                     should be used with bg-* and text-* classes for colors -->

                <strong><?=ucwords($this->session->user_name)?></strong>


            <!-- #notifications-dropdown-menu goes here when screen collapsed to xs or sm -->
        </div>
        <?php
          if($this->session->logged_inAdmin)
				    $this->load->view('themes/'.$this->config->item('app_theme_admin').'/parcials/menu');
		 if($this->session->logged_inExterno)
				    $this->load->view('themes/'.$this->config->item('app_theme_admin').'/parcials/menu_externo');
		      ?>
    </div>
</nav>
<!-- This is the white navigation bar seen on the top. A bit enhanced BS navbar. See .page-controls in _base.scss. -->
<nav class="page-controls navbar navbar-default">
    <div class="container-fluid">
        <!-- .navbar-header contains links seen on xs & sm screens -->
        <div class="navbar-header" style='width:100%;'>
          <ul class="nav navbar-nav news-list">
            <li style='padding:0px;' id="nav-collapse-toggle2" class='visible-xs'><a style='padding:0px;' class=""  href="#">
                <span class="icon bg-black text-white"><i class="fa fa-bars"></i></span>
            </a>
          </li>
          </ul>
            <!-- xs & sm screen logo -->
            <div class='hidden-xs' style='font-weight:bold;float:left;font-size:17px;margin-top:10px;margin-left:40px;'>
              <?php
              /*
              if($this->session->userdata['user_imagen']!=""){
                $srcImg  = '<img style="border-radius:50%; width:40px; margin-top:-5px; height:auto;" src="/attachments/perfil_usuario/'.$this->session->userdata['user_imagen'].'">';
              }else{
                $srcImg  =  '<img style="border-radius:50%; width:40px; margin-top:-5px; height:auto;" src="/attachments/web/user_image_default.png?1.1">';
              }
              if($this->session->logged_inAdmin)
                echo '<a href="'.base_url().'/dashboard/my_profile">'.$srcImg.'</a>';
                */
            /*  elseif($this->session->logged_inInterfaz)
                echo '<a href="'.base_url().'/interfaz/my_profile">'.$srcImg.'</a>';
                */
              ?>
              <?=ucwords($this->session->user_name)?></div>
            <a class="navbar-brand hidden" href="/index.html">
                <i class="fa fa-circle text-gray mr-n-sm"></i>
                <i class="fa fa-circle text-warning"></i>
                &nbsp;
                <?php echo $this->config->item('app_name');?>
                &nbsp;
                <i class="fa fa-circle text-warning mr-n-sm"></i>
                <i class="fa fa-circle text-gray"></i>
            </a>
            <ul id='menu_notificaciones_header' class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="/#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog fa-lg"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <?php
                      if($this->session->logged_inAdmin){
                        //echo '<li><a href="'.base_url().'adminsite/dashboard/my_profile"><i class="glyphicon glyphicon-user"></i> &nbsp; Mi Perfil</a></li>';
                      }
                      /*elseif($this->session->logged_inInterfaz){
                        echo '<li><a href="'.base_url().'adminsite/interfaz/my_profile"><i class="glyphicon glyphicon-user"></i> &nbsp; Mi Perfil</a></li>';
                      }
                      */

                       ?>
                    <li class="divider"></li>
					<?php
					  if($this->session->logged_inAdmin){
					?>
                    <li><a href='<?php echo base_url()."auth/logout"; ?>'><i class="fa fa-sign-out"></i> &nbsp; Cerrar sesión</a></li>
					<?php

					?>

					<?php
					  }elseif($this->session->logged_inExterno){
					?>
                    <li><a href='<?php echo base_url()."auth/logoutExterno"; ?>'><i class="fa fa-sign-out"></i> &nbsp; Cerrar sesión</a></li>
					<?php
					  }
					?>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- this part is hidden for xs screens -->
        <div class="collapse navbar-collapse">
			  <ul class="nav navbar-nav navbar-left">
                <li>
    					<a href="#">

    				   </a>
				 </li>
			    </ul>

        </div>

    </div>
</nav>
<div id='alerta' style='display:none;'>
<div name='contenido_alerta' style='margin-top:5px;'  class=" col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">

</div>
</div>
<div id="modal-background"></div>
<div id="modal-content"></div>
<div id="modal-background2"></div>
<div id="modal-content2"></div>
<a id='link_exportar_excel' href='#exportar_excel' class='fancybox'></a>
<div style='display:none' class='content_fancy' id='exportar_excel'>

	<h1>Exportar Datos</h1>
	<div id='contenedor_exportar_excel' style='text-align:center;margin-top:20px;'>

	</div>
</div>
