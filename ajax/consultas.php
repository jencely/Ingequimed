<?php 
require_once "../modelos/Consultas.php";

$consultas=new Consultas();

switch ($_GET["op"]){
	case 'listar':
		$fechainicio=$_GET['fechainicio'];
		$fechafin=$_GET['fechafin'];
		$rspta=$consultas->listar($fechainicio,$fechafin);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha.' - '.$reg->hora,
 				"1"=>$reg->registrador,
 				"2"=>$reg->servicio,
 				"3"=>$reg->especialista,
 				"4"=>$reg->paciente,
 				"5"=>$reg->costo,
 				"6"=>($reg->estado=='Anulado')?'<span class="label bg-red">Anulado</span>':'<span class="label bg-green">'.$reg->estado.'</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, 
 			"iTotalRecords"=>count($data), 
 			"iTotalDisplayRecords"=>count($data),
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'listarHistorias':
		$fechainicio=$_GET['fechainicio'];
		$fechafin=$_GET['fechafin'];
		$rspta=$consultas->listarHistorias($fechainicio,$fechafin);
 		
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha.' - '.$reg->hora,
 				"1"=>$reg->registrador,
 				"2"=>$reg->servicio,
 				"3"=>$reg->especialista,
 				"4"=>$reg->paciente,
 				"5"=>$reg->costo,
 				"6"=>'<a target="_blank" href="../reportes/historia.php?idatencion='.$reg->idatencion.'" ><button title="Historia Clínicas" class="btn btn-info"><i class="fa fa-file"></i></button></a>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, 
 			"iTotalRecords"=>count($data),
 			"iTotalDisplayRecords"=>count($data), 
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
}
?>