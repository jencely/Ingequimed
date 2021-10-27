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

if ($_SESSION['triaje']==1)
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
                          <h1 class="box-title">Protocolo de intervencion</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" >
                          <thead>
                             <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Registrador</th>
                            <th>Servicio</th>
                            <th>Especialista</th>
                            <th>Paciente</th>
                             
                          </thead>
                          
                        </table>
                    </div>
                    <div class="panel-body" style="height: 550px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Paciente:</label>
                            <input type="hidden" id="idtriaje" name="idtriaje">
                            <input type="hidden" id="idatencion" name="idatencion">
                           <input type="text" class="form-control" name="paciente" id="paciente" maxlength="256" placeholder="Paciente" disabled="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>DNI:</label>
                           <input type="text" class="form-control" name="dni" id="dni" maxlength="256" placeholder="Paciente" disabled="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Edad:</label>
                           <input type="text" class="form-control" name="edad" id="edad" maxlength="256" placeholder="Paciente" disabled="">
                          </div>
                           <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Servicio:</label>
                            <input type="text" class="form-control" name="servicio" id="servicio" maxlength="256" placeholder="servicio" disabled="">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Especialista:</label>
                            <input type="text" class="form-control" name="especialista" id="especialista" maxlength="256" placeholder="Especialista" disabled="">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Presion Arterial (mmHg):</label>
                            <input type="text" class="form-control" name="presion_arterial" id="presion_arterial" maxlength="45" placeholder="Presion Arterial">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Temperatura (Cº):</label>
                            <input type="text" class="form-control" name="temperatura" id="temperatura" maxlength="45" placeholder="temperatura">
                          </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Frecuencia Respiratoria (x Minuto):</label>
                            <input type="text" class="form-control" name="frecuencia_respiratoria" id="frecuencia_respiratoria" maxlength="45" placeholder="Frecuencia Respiratoria">
                          </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Frecuencia Cardiaca (x Minuto):</label>
                            <input type="text" class="form-control" name="frecuencia_cardiaca" id="frecuencia_cardiaca" maxlength="45" placeholder="Frecuencia Cardiaca">
                          </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Saturacion O2:</label>
                            <input type="text" class="form-control" name="saturacion" id="saturacion" maxlength="45" placeholder="Saturacion">
                          </div>
                           <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Peso: (Kg) utilice punto para decimales</label>
                            <input type="text" class="form-control" name="peso" id="peso" maxlength="45" placeholder="Peso">
                          </div>
                           <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Talla: (cm)</label>
                            <input type="number" class="form-control" name="talla" id="talla" maxlength="45" placeholder="Talla">
                          </div>
                           <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Imc:</label>
                            <input type="text" class="form-control" name="imc" id="imc" placeholder="Imc">
                          </div>
                           <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Estado:</label>
                            <input type="text" class="form-control" name="estado" id="estado" maxlength="256" placeholder="estado" disabled="">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
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
<script type="text/javascript" src="scripts/triaje.js"></script>
<?php 
}
ob_end_flush();
?>


