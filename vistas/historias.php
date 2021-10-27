<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['consultas']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Historias del día</h1> 
                          <div class="form-inline" id="dbuscar">
                            <label>Desde:</label>
                            <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="fechainicio" size="25">
                            <label>Hasta:</label>
                            <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="fechafin" size="25">
                          </div>                      
                    </div>
                    
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Fecha</th>
                            <th>Registrador</th>
                            <th>Servicio</th>
                            <th>Especialista</th>
                            <th>Paciente</th>
                            <th>Costo</th>
                            <th>Imprimir</th>                            
                          </thead>
                          <tbody>                            
                          </tbody>
                         
                        </table>
                    </div>                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/historias.js"></script>
<?php 
}
ob_end_flush();
?>


