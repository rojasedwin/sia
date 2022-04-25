	<script src="<?php echo base_url();?>assets/themes/admin/plugins/jquery/jquery-2.1.4.min.js"></script>
	<!--
		<script src="<?php echo base_url();?>assets/themes/admin/plugins/3d-bold-navigation/js/modernizr.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/pace-master/pace.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/jquery-blockui/jquery.blockui.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/bootstrap/js/bootstrap.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/switchery/switchery.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/uniform/jquery.uniform.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/classie/classie.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/waves/waves.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/3d-bold-navigation/js/main.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/plugins/chartsjs/Chart.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/admin/js/modern.min.js"></script>
	-->
    <!--
    	<script src="<?php echo base_url();?>assets/themes/admin/js/pages/charts-chartjs.js"></script>
	-->

<?php
	//Jquery
	$this->carabiner->js('assets/themes/admin/plugins/jquery/jquery.cookie.js');
	$this->carabiner->js('assets/themes/admin/plugins/3d-bold-navigation/js/modernizr.js');
	//$this->carabiner->js('assets/themes/admin/plugins/jquery/jquery-2.1.3.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/jquery-ui/jquery-ui.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/pace-master/pace.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/jquery-blockui/jquery.blockui.js');
	$this->carabiner->js('assets/themes/admin/plugins/bootstrap/js/bootstrap.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/switchery/switchery.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/uniform/jquery.uniform.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/classie/classie.js');
	$this->carabiner->js('assets/themes/admin/plugins/waves/waves.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/3d-bold-navigation/js/main.js');
	$this->carabiner->js('assets/themes/admin/plugins/chartsjs/Chart.min.js');
	$this->carabiner->js('assets/themes/admin/plugins/datatables/js/jquery.datatables.min.js');
	$this->carabiner->js('assets/themes/admin/js/modern.js');
	
	//$this->carabiner->js('assets/themes/admin/js/pages/charts-chartjs.js');

	//If Assets JS Data exists, load files
	if(isset($assets_js_data)){
		foreach($assets_js_data AS $js_file){
			$this->carabiner->js('assets/themes/admin/'.$js_file);
		}
	}

	//If JS Data exists, load files
	if(isset($js_data)){
		foreach($js_data AS $js_file){
			$this->carabiner->js('assets/themes/admin/js/'.$js_file);
		}
	}

	//GroceryCRUD JS
	if(isset($js_files)){
		foreach($js_files as $file){
		?>
			<script src="<?php echo $file; ?>"></script>
		<?php
		}
	}
	//Mostramos JS
	$this->carabiner->display('js');
?>
</html>
