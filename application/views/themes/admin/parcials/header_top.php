<div class="navbar">
	<div class="navbar-inner container">
	  <div class="sidebar-pusher">
	      <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
	          <i class="fa fa-bars"></i>
	      </a>
	  </div>
	  <div class="logo-box">
	      <a href="<?=base_url()?>" class="logo-text"><img height="55px" src="<?=base_url()?>assets/themes/admin/images/logoInstantPharmacy.png" alt="logo-InstantPharmacy"/></a>
	  </div><!-- Logo Box -->
	  <div class="search-button">
	      <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
	  </div>
	  <div class="topmenu-outer">
	      <div class="top-menu">
	          <ul class="nav navbar-nav navbar-right">
	              <li class="dropdown">
	                  <a href="#"  id="a_pedidos_no_procesados" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="icon-bag"></i><span id="badge_pedidos_no_procesados" class="badge badge-success pull-right"></span></a>
	                  <ul class="dropdown-menu title-caret dropdown-lg" role="menu" id="ul_pedidos_no_procesados"></ul>
	              </li>
	              <li class="dropdown">
	                  <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
	                      <span class="user-name">Hola, <strong><?php echo $this->user->getName();?></strong><i class="fa fa-angle-down"></i></span>
	                  </a>
	                  <ul class="dropdown-menu dropdown-list" role="menu">
	                      <li role="presentation"><a href="<?php echo base_url();?>auth/logoutExterno"><i class="fa fa-sign-out m-r-xs"></i>Cerrar Sesi&oacute;n</a></li>
	                  </ul>
	              </li>
	              <li>
	                  <a href="javascript:void(0);" class="waves-effect waves-button waves-classic" id="a-open_mensajes_no_leidos">
	                      <i class="fa fa-comments"></i>
	                      <span id="badge_mensajes_no_leidos" class="badge badge-danger pull-right"></span>
	                  </a>
	              </li>
	          </ul><!-- Nav -->
	      </div><!-- Top Menu -->
	  </div>
	</div>
	</div><!-- Navbar -->