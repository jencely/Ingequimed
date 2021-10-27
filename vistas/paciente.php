<?php
error_reporting(0);
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['pacientes']==1)
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
                          <h1 class="box-title">Paciente <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>&nbsp;<button class="btn btn-danger" id="btncerrar" onclick="cancelarform()"><i class="fa fa-arrow-circle-left"></i> Cerrar</button></h1>
                          <div class="form-inline" id="dbuscar">
                            <br>
                            <label>Apellido o cedula:</label>
                            <input type="text" class="form-control" id="texto" name="texto" size="25">
                            <button class="btn btn-info" id="btnbuscar" onclick="listar()"><i class="fa fa-search"></i></button>
                          </div>
                        <div class="">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Nombre</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Sexo</th>
                            <th>Estado Civil</th>
                            <th>Numero de Documento</th>
                            <th>Direccion</th>
                            <th>Teléfono</th>
                          </thead>
                         
                        </table>
                    </div>
                    <div class="panel-body" style="height: 550px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Apellido Paterno:</label>
                            <input type="hidden" name="idpersona" id="idpersona">
                            <input type="text" class="form-control" name="apaterno" id="apaterno" maxlength="30" placeholder="apellido Paterno" required="">
                          </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Apellido Materno:</label>
                            <input type="text" class="form-control" name="amaterno" id="amaterno" maxlength="30" placeholder="Apellido Materno" required="">
                          </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="30" placeholder="nombre" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="fecha_nacimiento" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Sexo:</label>
                           <select class="form-control select-picker" name="sexo" id="sexo" required="">
                             <option value="M">Masculino</option>
                             <option value="F">Femenino</option>
                           </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Estado Civil:</label>
                           <select class="form-control select-picker" name="estado_civil" id="estado_civil" required="">
                             <option value="S">Soltero</option>
                             <option value="C">Casado</option>
                             <option value="V">Viudo</option>
                             <option value="D">Divorciado</option>
                           </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required=
                              <option value="DNI">PASAPORTE</option>
                              <option value="RUC">RUC</option>
                              <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Ocupacion:</label>
                            <input type="text" class="form-control" name="ocupacion" id="ocupacion" maxlength="30" placeholder="Ocupacion">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Persona Responsable:</label>
                            <input type="text" class="form-control" name="persona_responsable" id="persona_responsable" maxlength="30" placeholder="Persona responsable">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label>Alergias:</label>
                            <input type="text" class="form-control" name="alergia" id="alergia" maxlength="100" placeholder="Alergia">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label>Intervenciones quirúrgicas:</label>
                            <input type="text" class="form-control" name="intervenciones_quirurgicas" id="intervenciones_quirurgicas" maxlength="100" placeholder="Intervenciones quirúrgicas">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label>Vacunas completas:</label>
                            <select name="vacunas_completas" id="vacunas_completas" class="form-control selectpicker">
                              <option value="SI">SI</option>
                              <option value="NO">NO</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <div class="panel-body" style="height: 550px;" id="formulariohistoria">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="hisotoriac" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th style="font-size: 30px">#</th>
                                  <th style="font-size: 30px">Paciente</th>
                                </thead>
                                <tbody>
                                </tbody>

                              </table>

                          </div>
                        </div>
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
<script type="text/javascript" src="scripts/paciente.js"></script>
<?php
}
ob_end_flush();
?>
