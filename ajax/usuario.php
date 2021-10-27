<?php
if (strlen(session_id()) < 1) 
  session_start();
require_once "../modelos/Usuario.php";

$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apaterno=isset($_POST["apaterno"])? limpiarCadena($_POST["apaterno"]):"";
$amaterno=isset($_POST["amaterno"])? limpiarCadena($_POST["amaterno"]):"";
$fecha_nacimiento=isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):"";
$sexo=isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$estado_civil=isset($_POST["estado_civil"])? limpiarCadena($_POST["estado_civil"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$ocupacion=isset($_POST["ocupacion"])? limpiarCadena($_POST["ocupacion"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$especialidad=isset($_POST["especialidad"])? limpiarCadena($_POST["especialidad"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		
		//Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clave);

		if (empty($idusuario)){
			$rspta=$usuario->insertar($apaterno,$amaterno,$nombre,$fecha_nacimiento,$sexo,$estado_civil,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ocupacion,$cargo,$especialidad,$login,$clavehash,$_POST['permiso']);
			echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
		}
		else {
			$rspta=$usuario->editar($idpersona,$apaterno,$amaterno,$nombre,$fecha_nacimiento,$sexo,$estado_civil,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ocupacion,$cargo,$especialidad,$login,$clavehash,$_POST['permiso']);
			echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button title="Desactivar" class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
 					'<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button title="Activar" class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>', 				
 				"1"=>$reg->apaterno . ' '.$reg->amaterno,
 				"2"=>$reg->nombre,
 				"3"=>$reg->fecha_nacimiento,
 				"4"=>$reg->sexo,
 				"5"=>$reg->estado_civil,
 				"6"=>$reg->tipo_documento,
 				"7"=>$reg->num_documento,
 				"8"=>$reg->cargo,
 				"9"=>$reg->especialidad,
 				"10"=>$reg->login,
 				"11"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

	case 'permisos':
		
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

	
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		
		$valores=array();

		
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idpermiso);
			}

		
		while ($reg = $rspta->fetch_object())
				{
					$sw=in_array($reg->idpermiso,$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
				}
	break;

	case 'verificar':
		$logina=$_POST['logina'];
	    $clavea=$_POST['clavea'];

	    
		$clavehash=hash("SHA256",$clavea);

		$rspta=$usuario->verificar($logina, $clavehash);

		$fetch=$rspta->fetch_object();

		if (isset($fetch))
	    {
	        
	        $_SESSION['idusuario']=$fetch->idusuario;
	        $_SESSION['nombre']=$fetch->nombre;
	        $_SESSION['login']=$fetch->login;

	        
	    	$marcados = $usuario->listarmarcados($fetch->idusuario);

	    	
			$valores=array();

			
			while ($per = $marcados->fetch_object())
				{
					array_push($valores, $per->idpermiso);
				}

			
			in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
			in_array(2,$valores)?$_SESSION['pacientes']=1:$_SESSION['pacientes']=0;
			in_array(3,$valores)?$_SESSION['clinica']=1:$_SESSION['clinica']=0;
			in_array(4,$valores)?$_SESSION['atencion']=1:$_SESSION['atencion']=0;
			in_array(5,$valores)?$_SESSION['triaje']=1:$_SESSION['triaje']=0;
			in_array(6,$valores)?$_SESSION['resultado']=1:$_SESSION['resultado']=0;
			in_array(7,$valores)?$_SESSION['consultas']=1:$_SESSION['consultas']=0;

	    }
	    echo json_encode($fetch);
	break;

	case 'salir':
		
        session_unset();
        
        session_destroy();
        
        header("Location: ../index.php");

	break;
}
?>