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

if ($_SESSION['atencion']==1)
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
                          <h1 class="box-title">Atención <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Registrador</th>
                            <th>Servicio</th>
                            <th>Especialista</th>
                            <th>Paciente</th>
                            <th>Cedula</th>
                            <th>Edad</th>
                                                        
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                                              
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                         <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Número Documento (*):</label>
                            <input type="number" class="form-control" name="documento" id="documento" required="">
                            <button type="button" onclick="buscarPaciente()" class="btn btn-info">Consultar</button>
                          </div>
                         <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Paciente (*):</label>
                            <input type="hidden" name="idatencion" id="idatencion" required="">
                            <input type="hidden" class="form-control" name="idpaciente" id="idpaciente">
                            <input type="hidden" class="form-control" name="idusuario" id="idusuario" maxlength="256" value="<?php echo $_SESSION['idusuario']; ?>">
                            <input type="text" disabled="" class="form-control" name="paciente" id="paciente">
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <label>Servicio (*):</label>
                                <select id="idservicio" name="idservicio" class="form-control selectpicker" data-live-search="true" required="">
                                        
                                </select>
                              </div>
                              <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                  <label>Especialista (*):</label>
                                  <select id="idempleado" name="idempleado" class="form-control selectpicker" data-live-search="true" required="">
                                          
                                  </select>
                              </div>
                              <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                  <label>Costo (*):</label>
                                  <input type="number" name="costo" id="costo" class="form-control" required="">
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>

                    <div class="panel-body" id="formularioplan">
                        <form name="formulariop" id="formulariop" method="POST">
                           <div class="table-responsive">
                             <table class="table table-bordered">
                               <tr>
                                 <th style="background-color:#D8D8D8;">Paciente</th>
                                 <td><span id="paciente">Paciente</span></td>
                                  <th style="background-color:#D8D8D8;">Cedula</th>
                                 <td><span id="dni">Paciente</span></td>
                                  <th style="background-color:#D8D8D8;">Edad</th>
                                 <td><span id="edad">Paciente</span></td>
                                 <th style="background-color:#D8D8D8;">Servicio</th>
                                 <td><span id="servicio">Servicio</span></td>
                                 <th style="background-color:#D8D8D8;">Especialista</th>
                                 <td><span id="especialista">Especialista</span></td>
                               </tr>
                             </table>
                           </div>
                           <div class="table-responsive">
                             <table class="table table-bordered">
                               <tr>
                                 <th style="background-color:#D8D8D8;">Presión Arterial (mmhg)</th>
                                 <td><input type="text" class="form-control" name="presion_arterial" id="presion_arterial" size="5"></td>
                                 <th style="background-color:#D8D8D8;">Temperatura (&deg;C)</th>
                                 <td><input type="text" class="form-control" name="temperatura" id="temperatura" size="5"></td>
                                 <th style="background-color:#D8D8D8;">Frecuencia Respiratoria (x')</th>
                                 <td><input type="text" class="form-control" name="frecuencia_respiratoria" id="frecuencia_respiratoria" size="5"></td>
                                 <th style="background-color:#D8D8D8;">Frecuencia Cardiaca (x')</th>
                                 <td><input type="text" class="form-control" name="frecuencia_cardiaca" id="frecuencia_cardiaca" size="5"></td>
                               </tr>
                               <tr>
                                 <th style="background-color:#D8D8D8;">Saturación (%)</th>
                                 <td><input type="text" class="form-control" name="saturacion" id="saturacion" size="5"></td>
                                 <th style="background-color:#D8D8D8;">Peso (Kg)</th>
                                 <td><input type="text" class="form-control" name="peso" id="peso" size="5"></td>
                                 <th style="background-color:#D8D8D8;">Talla (Cm)</th>
                                 <td><input type="text" class="form-control" name="talla" id="talla" size="5"></td>
                                 <th style="background-color:#D8D8D8;">IMC</th>
                                 <td><input type="text" class="form-control" name="imc" id="imc" size="5"></td>
                               </tr>
                             </table>
                           </div>
                           <div class="col-row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="panel panel-primary">
                                 <div class="panel-body">
                                  <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                    <label>Motivo de la Consulta:</label>
                                    <input type="hidden" class="form-control" name="idresultado" id="idresultado">
                                    <input type="hidden" class="form-control" name="idatencionp" id="idatencionp">
                                    <textarea class="form-control" name="motivo_consulta" id="motivo_consulta" rows="5">
                                    </textarea>
                                  </div>
                                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>TE:</label>
                                    <input type="text" class="form-control" name="tiempo_enfermedad" id="tiempo_enfermedad" maxlength="30" required>
                                  </div>
                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Antecedentes:</label>
                                    <textarea class="form-control" name="antecedentes" id="antecedentes" rows="5">
                                    </textarea>
                                  </div>
                                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>Alergias:</label>
                                    <input type="hidden" name="idpersona" id="idpersona">
                                    <input type="text" class="form-control" name="alergia" id="alergia" maxlength="100">
                                  </div> 
                                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>Intervenciones Quirúrgicas:</label>
                                    <input type="text" class="form-control" name="intervenciones_quirurgicas" id="intervenciones_quirurgicas" maxlength="100">
                                  </div>
                                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>Vacunas completas:</label>
                                    <select class="form-control" name="vacunas_completas" id="vacunas_completas">
                                      <option value="SI">SI</option>
                                      <option value="NO">NO</option>
                                    </select>
                                  </div>   
                                 </div>
                               </div>
                             </div>
                           </div>
                           <div class="col-row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="panel panel-success">
                                 <div class="panel-body">
                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Examen Físico:</label>
                                    <textarea class="form-control" name="examen_fisico" id="examen_fisico" rows="5">
                                    </textarea>
                                  </div>
                                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Código (Nombre)</label>
                                    <input type="text" class="form-control" name="texto" id="texto">
                                    <button type="button" onclick="buscarDiagnostico()" class="btn btn-info">Consultar</button>
                                  </div>
                                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>Diagnósticos</label>
                                    <ul id="diagnosticos">
                                      
                                    </ul>
                                  </div> 
                                  <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <label>Aplicar</label>
                                      <table id="detalles" class="table">
                                        <thead style="background-color: #A9D0F5;">
                                          <tr>
                                            <th>Borrar</th>
                                            <th>Tipo</th>
                                            <th>Enfermedad</th>
                                          </tr>
                                          <tbody id="tablabody">                                            
                                          </tbody>
                                        </thead>
                                      </table>
                                  </div>
                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Tratamiento:</label>
                                    <textarea class="form-control" name="tratamiento" id="tratamiento" rows="5" required>
                                    </textarea>
                                  </div>
                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Plan:</label>
                                    <input type="text" class="form-control" name="plan" id="plan" maxlength="256" required>
                                  </div>
                                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Próxima Cita:</label>
                                    <input type="date" class="form-control" name="proxima_cita" id="proxima_cita">
                                  </div>
                                 </div>
                              </div>
                            </div>
                          </div>
                          
                          
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar">
                            <button class="btn btn-primary" type="submit" id="btnGuardarP"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" id="btnCancelarP" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            <p><strong></strong></p>
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
<script type="text/javascript" src="scripts/atencion.js"></script>
<?php 
}
ob_end_flush();
?>


