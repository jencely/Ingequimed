<?php 
require_once "../modelos/Resultado.php";

$resultado=new Resultado();

$idresultado=isset($_POST["idresultado"])? limpiarCadena($_POST["idresultado"]):"";
$idatencion=isset($_POST["idatencion"])? limpiarCadena($_POST["idatencion"]):"";
$idatencionp=isset($_POST["idatencionp"])? limpiarCadena($_POST["idatencionp"]):"";

$presion_arterial=isset($_POST["presion_arterial"])? limpiarCadena($_POST["presion_arterial"]):"";
$temperatura=isset($_POST["temperatura"])? limpiarCadena($_POST["temperatura"]):"";
$frecuencia_respiratoria=isset($_POST["frecuencia_respiratoria"])? limpiarCadena($_POST["frecuencia_respiratoria"]):"";
$frecuencia_cardiaca=isset($_POST["frecuencia_cardiaca"])? limpiarCadena($_POST["frecuencia_cardiaca"]):"";
$saturacion=isset($_POST["saturacion"])? limpiarCadena($_POST["saturacion"]):"";
$peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
$talla=isset($_POST["talla"])? limpiarCadena($_POST["talla"]):"";
$imc=isset($_POST["imc"])? limpiarCadena($_POST["imc"]):"";


$motivo_consulta=isset($_POST["motivo_consulta"])? limpiarCadena($_POST["motivo_consulta"]):"";
$tiempo_enfermedad=isset($_POST["tiempo_enfermedad"])? limpiarCadena($_POST["tiempo_enfermedad"]):"";
$antecedentes=isset($_POST["antecedentes"])? limpiarCadena($_POST["antecedentes"]):"";
$examen_fisico=isset($_POST["examen_fisico"])? limpiarCadena($_POST["examen_fisico"]):"";
$tratamiento=isset($_POST["tratamiento"])? limpiarCadena($_POST["tratamiento"]):"";
$proxima_cita=isset($_POST["proxima_cita"])? limpiarCadena($_POST["proxima_cita"]):"";



$alergia=isset($_POST["alergia"])? limpiarCadena($_POST["alergia"]):"";
$intervenciones_quirurgicas=isset($_POST["intervenciones_quirurgicas"])? limpiarCadena($_POST["intervenciones_quirurgicas"]):"";
$vacunas_completas=isset($_POST["vacunas_completas"])? limpiarCadena($_POST["vacunas_completas"]):"";

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idresultado)){
			$rspta=$resultado->insertar($idatencion,$motivo_consulta,$tiempo_enfermedad,$antecedentes,$examen_fisico,$tratamiento,$proxima_cita,$_POST["iddiagnostico"],$_POST["tipo"],$plan,$alergia,$intervenciones_quirurgicas,$vacunas_completas,$idpersona,$_POST["medicamento"],$_POST["presentacion"],$_POST["dosis"],$_POST["duracion"],$_POST["cantidad"],$presion_arterial,$temperatura,$frecuencia_respiratoria,$frecuencia_cardiaca,$saturacion,$peso,$talla,$imc);
			echo $rspta ? "Plan de Atención registrado" : "Plan de Atención no se pudo registrar";
			
		}
		else {	
			$rspta=$resultado->editar($idatencionp,$idresultado,$motivo_consulta,$tiempo_enfermedad,$antecedentes,$examen_fisico,$tratamiento,$proxima_cita,$_POST["iddiagnostico"],$_POST["tipo"],$plan,$alergia,$intervenciones_quirurgicas,$vacunas_completas,$idpersona,$_POST["medicamento"],$_POST["presentacion"],$_POST["dosis"],$_POST["duracion"],$_POST["cantidad"],$presion_arterial,$temperatura,$frecuencia_respiratoria,$frecuencia_cardiaca,$saturacion,$peso,$talla,$imc);
			echo $rspta ? "Plan de Atención Actualizado" : "Plan de Atención no se puede actualizar";		
		}
	break;



	case 'mostrar':
		$rspta=$resultado->mostrar($idatencion);
 		
 		echo json_encode($rspta);
	break;

	case 'modificar':
		$rspta=$resultado->modificar($idatencion);
 		
 		echo json_encode($rspta);
	break;

	case 'listar':
		require_once "../modelos/Atencion.php";

		$atencion=new Atencion();
		$rspta=$atencion->listarPlan();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Atender especialista" class="btn btn-info" onclick="mostrar('.$reg->idatencion.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->fecha.' - '.$reg->hora,
 				"2"=>$reg->registrador,
 				"3"=>$reg->servicio,
 				"4"=>$reg->especialista,
 				"5"=>$reg->paciente,
 				"6"=>$reg->costo,
 				"7"=>($reg->estado=='Anulado')?'<span class="label bg-red">Anulado</span>':'<span class="label bg-orange">'.$reg->estado.'</span>'
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, 
 			"icostoRecords"=>count($data), 
 			"icostoDisplayRecords"=>count($data), 
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
	
	break;


}
?>