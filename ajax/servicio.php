<?php 
require_once "../modelos/Servicio.php";

$servicio=new Servicio();

$idservicio=isset($_POST["idservicio"])? limpiarCadena($_POST["idservicio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$costo=isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idservicio)){
			$rspta=$servicio->insertar($nombre,$costo);
			echo $rspta ? "Servicio registrado" : "Servicio no se pudo registrar";
		}
		else {
			$rspta=$servicio->editar($idservicio,$nombre,$costo);
			echo $rspta ? "Servicio actualizado" : "Servicio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$servicio->desactivar($idservicio);
 		echo $rspta ? "Servicio Desactivada" : "Servicio no se puede desactivar";
	break;

	case 'activar':
		$rspta=$servicio->activar($idservicio);
 		echo $rspta ? "Servicio activada" : "Servicio no se puede activar";
	break;

	case 'mostrar':
		$rspta=$servicio->mostrar($idservicio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$servicio->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button tile="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idservicio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button tile="Desactivar" class="btn btn-danger" onclick="desactivar('.$reg->idservicio.')"><i class="fa fa-close"></i></button>':
 					'<button tile="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idservicio.')"><i class="fa fa-pencil"></i></button>'.
 					' <button tile="Activar" class="btn btn-primary" onclick="activar('.$reg->idservicio.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->costo,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>