<?php 
require_once "../modelos/Atencion.php";

$atencion=new atencion();

$idatencion=isset($_POST["idatencion"])? limpiarCadena($_POST["idatencion"]):"";
$idpersona=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$idservicio=isset($_POST["idservicio"])? limpiarCadena($_POST["idservicio"]):"";
$idempleado=isset($_POST["idempleado"])? limpiarCadena($_POST["idempleado"]):"";
$costo=isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idatencion)){
			$rspta=$atencion->insertar($idpersona,$idusuario,$idservicio,$idempleado,$costo);
			echo $rspta ? "Atención registrada" : "Atención no se pudo registrar";
		}
		else {
			$rspta=$atencion->editar($idatencion,$idpersona,$idusuario,$idservicio,$idempleado,$costo);
			echo $rspta ? "Atención actualizada" : "Atención no se pudo actualizar";
		}
	break;

	case 'anular':
		$rspta=$atencion->anular($idatencion);
 		echo $rspta ? "Atención Anulada" : "Atención no se puede anular";
	break;

	case 'mostrar':
		$rspta=$atencion->mostrar($idatencion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$atencion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado<>'Atendido')?'<button title="Editar Atención" class="btn btn-warning" onclick="mostrar('.$reg->idatencion.')"><i class="fa fa-pencil"></i></button>'.
 				' <button title="Anular Atención" class="btn btn-danger" onclick="anular('.$reg->idatencion.')"><i class="fa fa-close"></i></button>':
 					' <button title="Modificar Plan de Atención" class="btn btn-info" onclick="modificar('.$reg->idatencion.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->fecha.' - '.$reg->hora,
 				"2"=>$reg->registrador,
 				"3"=>$reg->servicio,
 				"4"=>$reg->especialista,
 				"5"=>$reg->paciente,
 				"6"=>$reg->num_documento,
 				"7"=>$reg->edad,
 				"8"=>$reg->costo,
 				"9"=>($reg->estado=='Registrado')?'<span class="label bg-green">Registrado</span>':(($reg->estado=='Triaje')?'<span class="label bg-orange">Triaje</span>':'<span class="label bg-primary">Atendido</span>') 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"icostoRecords"=>count($data), //enviamos el costo registros al datatable
 			"icostoDisplayRecords"=>count($data), //enviamos el costo registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case "selectServicio":
		require_once "../modelos/Servicio.php";
		$servicio = new Servicio();

		$rspta = $servicio->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idservicio . '>' . $reg->nombre.' S/.'.$reg->costo. '</option>';
				}
	break;

	case "selectEspecialista":
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idpersona . '>' . $reg->especialista . '</option>';
				}
	break;

	case 'ListarAtenciones':
		$idp=$_GET['idp'];
		$rspta=$atencion->listarAtenciones($idp);
		echo '<thead>
                <tr>
                    <th>Fecha</th>
                    <th>Historia</th>
                    
                    
                </tr>
              </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr></td>
						<td>'.$reg->fecha.'</td><td><a target="_blank" href="../reportes/historia.php?idatencion='.$reg->idatencion.'">'.$reg->idatencion.'</a></td>
						<td><a target="_blank" href="../reportes/receta.php?idatencion='.$reg->idatencion.'">'.$reg->idatencion.'</a></td></tr>';
				}
	break;
}
?>