<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2021 <a href="https://adminlte.io">Desarrollado por Edwin Rojas</a>.</strong> Todos los derechos Reservados.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->




<!-- jQuery -->
<script src="<?=base_url()?>assets/back/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?=base_url()?>assets/back/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/back/dist/js/adminlte.min.js"></script>





<!-- jquery-validation -->
<script src="<?=base_url()?>assets/back/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="<?=base_url()?>assets/back/dist/js/demo.js"></script>-->
<!-- Page specific script -->

<!-- DataTables  & Plugins -->
<script src="<?=base_url()?>assets/back/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>assets/back/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- SweetAlert2 -->
<script src="<?=base_url()?>assets/back/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url()?>assets/back/plugins/toastr/toastr.min.js"></script>



<?php
//If JS Data exists, load files
	if(isset($js_data) and count($js_data)>0){
		foreach($js_data AS $js_file){
			echo '<script src="'.base_url().'assets/js/'.$js_file.'"></script>';
		}
	}
?>


<script>
$(function () {
  //bsCustomFileInput.init();
});



</script>

<?php
$this->load->view("modales");
?>
</body>
</html>
