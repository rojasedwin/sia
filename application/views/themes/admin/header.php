<!DOCTYPE html>
<html>
  <head>
      <title><?php echo $this->config->item('app_name');?> - <?php echo $this->config->item('app_slogan');?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta name="description" content="">
      <meta name="author" content="Antonio Guerrero">
      <meta name="robots" content="noindex,nofollow">
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <link rel="icon" href="/assets/themes/front/css/img/favicon.png" type="image/png">

      <link href="/assets/themes/admin/css/personalizar.css?3.<?php echo $this->config->item('css_version');?>" rel="stylesheet">
      <link href="/assets/themes/admin/css/altaevento.css?3.<?php echo $this->config->item('css_version');?>" rel="stylesheet">
      <link href="/assets/themes/admin/css/font-awesome/css/font-awesome.css" rel="stylesheet">
      <link href="/assets/themes/admin/css/application.min.css" rel="stylesheet">
      <link href="/assets/themes/admin/css/flags/flags.css" rel="stylesheet">
      <link  href="/assets/themes/admin/js/vendor/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" rel="stylesheet" type="text/css" />
      <link href="/assets/themes/admin/js/vendor/datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
      <link href="/assets/themes/admin/css/summernote.css" rel="stylesheet">
      <link href="/assets/themes/admin/css/datetimepicker.css" rel="stylesheet">
      <link href="/assets/themes/admin/css/bootstrapxl.css" rel="stylesheet">
 
      <!-- <link rel="stylesheet" href="https://summernote.org/bower_components/summernote/dist/summernote.css"> -->

      <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
      <!--[if IE 9]>
          <link href="/assets/themes/admin/css/application-ie9-part2.css" rel="stylesheet">
      <![endif]-->


      <script>
      var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
      csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
          /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
           https://code.google.com/p/chromium/issues/detail?id=332189
           */

      var my_loader = "<div class='loader'></div>";
      var my_loader_auto = "<div class='loader_auto'></div>";
      var my_loader_auto_red = "<div class='loader_auto_red'></div>";
      var network_problems = "<div class='error'>Network problems...</div>";
      </script>
      <?php
        //If Assets CSS Data exists, load files
        if(isset($assets_css_data)){
            foreach($assets_css_data AS $css_file){
                echo '<link href="'.base_url().'assets/themes/admin/css/'.$css_file.'" rel="stylesheet">';
            }
        }
        //If CSS Data exists, load files
        if(isset($css_data)){
            foreach($css_data AS $css_file){
                echo '<link href="'.base_url().'assets/themes/'.$css_file.'" rel="stylesheet">';
            }
        }

        if(isset($external_js)){
            foreach($external_js AS $external_js_file){
                echo '<script src="'.$external_js_file.'"></script>';
            }
        }
       ?>
       <script language="javascript">
           var base_url = "<?php echo base_url()."adminsite/";?>";
       </script>
  </head>
