<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->config->item('app_name');?></title>
    <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
    <!--[if IE 9]>
        <link href="/assets/themes/admin/css/application-ie9-part2.css" rel="stylesheet">
    <![endif]-->
    <link rel="shortcut icon" href="/adminerasmus/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="pedidoslab" />
    <meta name="author" content="HeyuApp" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="/assets/themes/admin/css/application.min.css" type="text/css" rel="stylesheet">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
</head>
<body class="login-page">

<div class="container">
    <main id="content" class="widget-login-container" role="main">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-10 col-lg-offset-4 col-sm-offset-3 col-xs-offset-1">
                <h4 style='color:#fff;' class="widget-login-logo animated fadeInUp">
                    <i class="fa fa-circle text-gray"></i>
                     <?php echo $this->config->item('app_name');?>
                    <i class="fa fa-circle text-warning"></i>
                </h4>
                <section style='background-color:#fff;color:#ff0000;' class="widget widget-login animated fadeInUp">
                    <header style='text-align: center;' >
                      <img style='max-height:100px;max-width:100%;margin:auto;margin-top:-5px;' src='<?php echo base_url();?>attachments/web/logo_1.png?1.2'>
                    </header>
                    <div class="widget-body">
                        <p class="widget-login-info">

							<?php
							if(isset($error))
							{
							?>
							<div class="alert alert-danger fade in">
								<strong>Upps!</strong>
								Usuario o contraseña incorrectos
								</div>
							<?php
							}
							?>
                </p>
                <form class="login-form mt-lg" id="admin" action='<?php echo base_url();?>auth/authenticate' method='POST'>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name='email' placeholder="Email" data-parsley-trigger="change"
                                           data-parsley-validation-threshold="1"
                                           required="required">
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="pass" name='pass' type="password" placeholder="Contraseña" required="required">
                        <input id="contra_securyti" type="hidden" value="<?php echo strtotime(date("Y-m-d s:i"));?>" name="contra_securyti" size="1">
                    </div>
                    <div class="form-group">
                      <label>  <input checked class="" value='1' id="rememberme" name='rememberme' type="checkbox" placeholder="Remember me">
                        Recordarme.</label>
                    </div>
                    <div class="clearfix">
                            <input type="submit" class="btn btn-info btn-block"  value="Log in" name='Entrar'>
                    </div>
                 <input name='acceder' type='hidden' value='102k3as3ll'>
                </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <footer class="page-footer">
        <?php echo date("Y");?> &copy; pedidoslab
    </footer>
</div>
<!-- The Loader. Is shown when pjax happens -->
<div class="loader-wrap hiding hide">
    <i class="fa fa-circle-o-notch fa-spin-fast"></i>
</div>
<style>
body{

	background-image: url("/attachments/web/fondo.jpg?1.2");
	background-position: center center;
	background-repeat: no-repeat;
	background-size: cover;
	bottom: 0;
	left: 0;
	position: fixed;
	right: 0;
	top: 0;

}
</style>
<!-- common libraries. required for every page-->
<script src="/assets/themes/admin/plugins/jquery/dist/jquery.min.js"></script>
<script src="/assets/themes/admin/plugins/jquery-pjax/jquery.pjax.js"></script>
<script src="/assets/themes/admin/plugins/bootstrap-sass/assets/javascripts/bootstrap/transition.js"></script>
<script src="/assets/themes/admin/plugins/bootstrap-sass/assets/javascripts/bootstrap/collapse.js"></script>
<script src="/assets/themes/admin/plugins/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js"></script>
<script src="/assets/themes/admin/plugins/bootstrap-sass/assets/javascripts/bootstrap/button.js"></script>
<script src="/assets/themes/admin/plugins/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js"></script>
<script src="/assets/themes/admin/plugins/bootstrap-sass/assets/javascripts/bootstrap/alert.js"></script>
<script src="/assets/themes/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/themes/admin/plugins/widgster/widgster.js"></script>

<!-- common app js -->
<script src="/assets/themes/admin/js/settings.js"></script>
<script src="/assets/themes/admin/js/app.js"></script>

<!-- page specific libs -->
<!-- page specific js -->
</body>
</html>
