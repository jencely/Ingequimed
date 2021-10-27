<?php 
$idatencion=$_GET['idatencion'];

require_once "../modelos/Persona.php";

$persona = new Persona();
$rspta=$persona->imprimirHistoria($idatencion);
$reg=$rspta->fetch_object();

$rspta2=$persona->imprimirDetalleHistoria($idatencion);

//Obtenemos valores de la base de datos
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
if ($_SESSION['pacientes']==1)
{
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Reporte de Historia Clínica</title>
	<link rel="stylesheet" href="../public/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div class="table-responsive">
				<table width="100%" border="1" cellpadding="5" cellspacing="5" style="font-size: 20px">
                                <tr>

                                  <td colspan="12"><center><img src="" width="300px" heigth="200px"></center></td>
                                </tr>
                                <tr>
                                  <td colspan="12"><center><h3><b>HISTORIA CLINICA</b></h3></center></td>
                                </tr>
                                <tr>
                                  <td colspan="12"><center><h3><b>APELLIDOS Y NOMBRES:</b> <?php echo $reg->paciente; ?></h3></center></td>
                                </tr>
                               <tr>
                                 <th style="background-color:#D8D8D8;">&nbsp;FECHA NACIMIENTO</th>
                                 <td colspan="2"><span id="fecha_nacimiento">&nbsp;<?php echo $reg->fecha_nacimiento; ?></span></td>
                                 <th style="background-color:#D8D8D8;">&nbsp;CEDULA</th>
                                 <td><span id="dni">&nbsp;<?php echo $reg->num_documento; ?></span></td>
                                 </tr>
                                <tr>
                                 <th style="background-color:#D8D8D8;">&nbsp;EDAD</th>
                                 <td colspan="2"><span id="edad">&nbsp;<?php echo $reg->edad; ?></span></td>
                                 <th style="background-color:#D8D8D8;">&nbsp;OCUPACIÓN</th>
                                 <td colspan="2"><span id="ocupacion">&nbsp;<?php echo $reg->ocupacion; ?></span></td>
                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;SEXO</th>
                                <td colspan="2"><span id="sexo">&nbsp;<?php echo $reg->sexo; ?></span></td>
                                <th style="background-color:#D8D8D8;">&nbsp;PERSONA RESPONSABLE</th>
                                <td colspan="2"><span id="persona_responsable">&nbsp;<?php echo $reg->persona_responsable; ?></span></td>
                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;ESTADO CIVIL</th>
                                <td colspan="2"><span id="estado_civil">&nbsp;<?php echo $reg->estado_civil; ?></span></td>
                                <th style="background-color:#D8D8D8;">&nbsp;FECHA ATENCIÓN</th>
                                <td colspan="2"><span id="estado_civil">&nbsp;<?php echo $reg->fecha; ?></span></td>
                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;DOMICILIO</th>
                                <td colspan="2"><span id="direccion">&nbsp;<?php echo $reg->direccion; ?></span></td>
                                <th style="background-color:#D8D8D8;">&nbsp;HORA ATENCIÓN</th>
                                <td colspan="2"><span id="Hora">&nbsp;<?php echo $reg->hora; ?></span></td>
                                </tr>
                                <tr>
                                  <td colspan="4" style="background-color:#D8D8D8;"><center><h4><b>MOTIVO DE LA CONSULTA</b></h4></center></td>
                                  <td colspan="2" style="background-color:#D8D8D8;"><center><h4><b>T.E</b></h4></center></td>
                                </tr>
                                <tr>

                                  <td colspan="4" >&nbsp;<?php echo str_replace("\n", "<br>", $reg->motivo_consulta); ?></td>
                                  <td colspan="2" style="vertical-align: top; text-align: center;">&nbsp;<?php echo $reg->tiempo_enfermedad; ?></td>
                                </tr>
                                <tr>
                                  <td colspan="12" style="background-color:#D8D8D8;"><center><h4><b>ANTECEDENTES</b></h4></center></td>
                                </tr>
                                <tr>
                                  <td colspan="12">&nbsp;<?php echo str_replace("\n", "<br>", $reg->antecedentes); ?></td>
                                </tr>
                                <tr>
                                  <td colspan="1" style="background-color:#D8D8D8;">&nbsp;<center><b>ALERGIAS</b></center></td>
                                  <td colspan="3" style="background-color:#D8D8D8;">&nbsp;<center><b>VACUNAS COMPLETAS</b></center></td>
                                  <td colspan="1" style="background-color:#D8D8D8;">&nbsp;<center><b>INTERVENCIONES QUIRÚRGICAS</b></center></td>
                                </tr>
                                <tr>
                                  <td colspan="1">&nbsp;<?php echo $reg->alergia; ?></td>
                                  <td colspan="3">&nbsp;<?php echo $reg->vacunas_completas; ?></td>
                                  <td colspan="1">&nbsp;<?php echo $reg->intervenciones_quirurgicas; ?></td>
                                </tr>                                
                                <tr>
                                  <td colspan="12" style="background-color:#D8D8D8;"><center><h4><b>SIGNOS VITALES</b></h4></center></td>
                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;PRESIÓN ARTERIAL (mmhg)</th>
                                <td colspan="2"><span id="direccion">&nbsp;<?php echo $reg->presion_arterial; ?></span></td>
                                 <th style="background-color:#D8D8D8;">&nbsp;SATURACIÓN (%)</th>
                                <td colspan="2"><span id="direccion">&nbsp;<?php echo $reg->saturacion; ?></span></td>

                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;TEMPERATURA (&deg;C)</th>
                                <td colspan="2">&nbsp;<span id="Hora"><?php echo $reg->temperatura; ?></span></td>
                                <th style="background-color:#D8D8D8;">&nbsp;PESO ACTUAL (Kg)</th>
                                <td colspan="2"><span id="Hora">&nbsp;<?php echo $reg->peso; ?></span></td>

                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;FRECUENCIA RESPIRATORIA (x')</th>
                                <td colspan="2"><span id="direccion">&nbsp;<?php echo $reg->frecuencia_respiratoria; ?></span></td>
                                <th style="background-color:#D8D8D8;">&nbsp;TALLA (cm)</th>
                                <td colspan="2"><span id="direccion">&nbsp;<?php echo $reg->talla; ?></span></td>
                                </tr>
                                <tr>
                                <th style="background-color:#D8D8D8;">&nbsp;FRECUENCIA CARDIACA (x')</th>
                                <td colspan="2"><span id="Hora">&nbsp;<?php echo $reg->frecuencia_cardiaca; ?></span></td>
                                <th style="background-color:#D8D8D8;">&nbsp;IMC</th>
                                <td colspan="2"><span id="Hora">&nbsp;<?php echo $reg->imc; ?></span></td>
                                </tr>
                                <tr>
                                  <td colspan="12" style="background-color:#D8D8D8;"><center><h4><b>EXAMEN FISICO</b></h4></center></td>
                                </tr>
                                <tr>
                                  <td colspan="12">&nbsp;<?php echo str_replace("\n", "<br>", $reg->examen_fisico); ?></td>
                                </tr>
                                <tr>
                                  <td colspan="4" style="background-color:#D8D8D8;"><center><b>DIAGNÓSTICO</b></center></td>
                                  <td colspan="4" style="background-color:#D8D8D8;"><center><b>PLAN</b></center></td>
                                </tr>
                                <tr>
                                  <td colspan="4">
                                  <table class="table" style="font-size: 20px">
                                  	<?php 
                                  	while ($reg2 = $rspta2->fetch_object()) {
                                  		echo '<tr><td>'.$reg2->enfermedad.'</td><td>TIPO: '.$reg2->tipo.'</td></tr>';
                                  	}
                                  	 ?>
                                  	</table>

                                  </td>
                                  <td colspan="4"><?php echo $reg->plan; ?></td>
                                </tr>
                                
                                <td colspan="12" style="background-color:#D8D8D8;"><center><h4><b>TRATAMIENTO</b></h4></center></td>
                                </tr>
                                <tr>
                                  <td colspan="12">&nbsp;<?php echo str_replace("\n", "<br>", $reg->tratamiento); ?></td>
                                </tr>
                             </table>
			</div>
		</div>
	</div>
</div>

</body>
</html>
<?php
}
else
{
  require '../vistas/noacceso.php';
}
?>
<?php 
}
ob_end_flush();
?>