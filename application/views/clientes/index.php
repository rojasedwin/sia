<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<div id='alerta' style='display:none'>
<div name='contenido_alerta' style='margin-top:5px;background:#84B1BC;border-bottom:1px solid #31B0D5;color:#fff;'  class=" col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">

</div>
</div>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión de Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
              <li class="breadcrumb-item active">Clientes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
				 <button type="button" onclick="fichaItem()" class="prueba btn btn-block bg-gradient-primary btn-sm">+ Nuevo Cliente</button>
				</h3>
              </div>
              <!-- /.card-header -->
              <div id="resultados_clientes" class="card-body">
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
  