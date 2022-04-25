<div class="page-title">
  <div class="container">
      <h3>
        <?php
          if(isset($crud_title)){
            echo($crud_title);
          }
          else{
            echo("Panel de Gesti&oacute;n");
          }
        ?>
        <small>
          <?php
            if(isset($crud_subtitle)){
              echo(" - ".$crud_subtitle);
            }
            else{
              echo(" - Panel de Gesti&oacute;n");
            }
          ?>
        </small>
      </h3>
  </div>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <?php echo $output; ?>
    </div>
  </div>
</div><!-- Main Wrapper -->
