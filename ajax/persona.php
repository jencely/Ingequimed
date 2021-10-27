<?php 
require_once "../modelos/Persona.php";

$persona=new Persona();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$apaterno=isset($_POST["apaterno"])? limpiarCadena($_POST["apaterno"]):"";
$amaterno=isset($_POST["amaterno"])? limpiarCadena($_POST["amaterno"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$fecha_nacimiento=isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):"";
$sexo=isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$estado_civil=isset($_POST["estado_civil"])? limpiarCadena($_POST["estado_civil"]):"";
$alergia=isset($_POST["alergia"])? limpiarCadena($_POST["alergia"]):"";
$intervenciones_quirurgicas=isset($_POST["intervenciones_quirurgicas"])? limpiarCadena($_POST["intervenciones_quirurgicas"]):"";
$vacunas_completas=isset($_POST["vacunas_completas"])? limpiarCadena($_POST["vacunas_completas"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$ocupacion=isset($_POST["ocupacion"])? limpiarCadena($_POST["ocupacion"]):"";
$persona_responsable=isset($_POST["persona_responsable"])? limpiarCadena($_POST["persona_responsable"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idpersona)){
			$rspta=$persona->insertar($apaterno,$amaterno,$nombre,$fecha_nacimiento,$sexo,$estado_civil,$alergia,$intervenciones_quirurgicas,$vacunas_completas,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ocupacion,$persona_responsable);
			echo $rspta ? "Paciente registrado" : "Paciente no se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$apaterno,$amaterno,$nombre,$fecha_nacimiento,$sexo,$estado_civil,$alergia,$intervenciones_quirurgicas,$vacunas_completas,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ocupacion,$persona_responsable);
			echo $rspta ? "Paciente actualizado" : "Paciente no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$persona->desactivar($idpersona);
 		echo $rspta ? "Paciente Desactivado" : "Paciente no se puede desactivar";
	break;

	case 'activar':
		$rspta=$persona->activar($idpersona);
 		echo $rspta ? "Paciente activado" : "Paciente no se puede activar";
	break;

	case 'mostrar':
		$rspta=$persona->mostrar($idpersona);
 		
 		echo json_encode($rspta);
	break;

	case 'listar':
		$texto=$_GET['texto'];
		$rspta=$persona->listar($texto);
 		
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button title="Historia Clínicas" class="btn btn-info" onclick="historia('.$reg->idpersona.')"><i class="fa fa-file"></i></button>',
 				"1"=>$reg->apaterno,
 				"2"=>$reg->amaterno,
 				"3"=>$reg->nombre,
 				"4"=>$reg->fecha_nacimiento,
 				"5"=>$reg->sexo,
 				"6"=>$reg->estado_civil,
 				"7"=>$reg->num_documento,
 				"8"=>$reg->direccion,
 				"9"=>$reg->telefono
 				);
 		}
 		$results = array(
 			"sEcho"=>1, 
 			"iTotalRecords"=>count($data), 
 			"iTotalDisplayRecords"=>count($data), 
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'buscar':
		$documento=$_POST["documento"];
		$rspta=$persona->buscar($documento);
 	 		echo json_encode($rspta);
	break;
}
?>