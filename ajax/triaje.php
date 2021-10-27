<?php 
require_once "../modelos/Triaje.php";

$triaje=new Triaje();

$idtriaje=isset($_POST["idtriaje"])? limpiarCadena($_POST["idtriaje"]):"";
$idatencion=isset($_POST["idatencion"])? limpiarCadena($_POST["idatencion"]):"";
$presion_arterial=isset($_POST["presion_arterial"])? limpiarCadena($_POST["presion_arterial"]):"";
$temperatura=isset($_POST["temperatura"])? limpiarCadena($_POST["temperatura"]):"";
$frecuencia_respiratoria=isset($_POST["frecuencia_respiratoria"])? limpiarCadena($_POST["frecuencia_respiratoria"]):"";
$frecuencia_cardiaca=isset($_POST["frecuencia_cardiaca"])? limpiarCadena($_POST["frecuencia_cardiaca"]):"";
$saturacion=isset($_POST["saturacion"])? limpiarCadena($_POST["saturacion"]):"";
$peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
$talla=isset($_POST["talla"])? limpiarCadena($_POST["talla"]):"";
$imc=isset($_POST["imc"])? limpiarCadena($_POST["imc"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idtriaje)){
			//$rspta=$triaje->insertar($idatencion,$presion_arterial,$temperatura,$frecuencia_respiratoria,$frecuencia_cardiaca,$saturacion,$peso,$talla,$imc);
			$rspta=$triaje->insertar($idatencion,$presion_arterial,$temperatura,$frecuencia_respiratoria,$frecuencia_cardiaca,$saturacion,$peso,$talla,$imc);
			echo $rspta ? "Triaje registrado" : "Triaje no se pudo registrar";
		}
		else {
			
		}
	break;
	case 'mostrar':
		$rspta=$triaje->mostrar($idatencion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		require_once "../modelos/Atencion.php";

		$atencion=new Atencion();
		$rspta=$atencion->listarTriaje();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Pasar a Triaje" class="btn btn-info" onclick="mostrar('.$reg->idatencion.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->fecha.' - '.$reg->hora,
 				"2"=>$reg->registrador,
 				"3"=>$reg->servicio,
 				"4"=>$reg->especialista,
 				"5"=>$reg->paciente,
 				"6"=>$reg->costo,
 				"7"=>($reg->estado=='Anulado')?'<span class="label bg-red">Anulado</span>':'<span class="label bg-blue">'.$reg->estado.'</span>'
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"icostoRecords"=>count($data), //enviamos el costo registros al datatable
 			"icostoDisplayRecords"=>count($data), //enviamos el costo registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
}
?>