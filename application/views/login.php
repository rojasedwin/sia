<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIA</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/back/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url()?>assets/back/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/back/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>SIA</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
	<header style='text-align: center;' >
	 <img style='max-height:100px;max-width:100%;margin:auto;margin-top:-5px;' src='<?php echo base_url();?>assets/back/dist/img/AdminLTELogo.png'>
	 </header>
      <p class="login-box-msg">Iniciar Sesión</p>

      <form action="<?php echo base_url();?>auth/authenticate" method='POST'>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" id="email" required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pass" id="pass" required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!--<div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>-->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!--<div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>-->
      <!-- /.social-auth-links -->

      <!--<p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>-->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<style>
body{

	background-image: url("<?=base_url()?>attachments/web/fondo2.png");
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
<!-- jQuery -->
<script src="<?=base_url()?>assets/back/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src=".<?=base_url()?>assets/back/dist/js/adminlte.min.js"></script>
</body>
</html>
