<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($apaterno,$amaterno,$nombre,$fecha_nacimiento,$sexo,$estado_civil,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ocupacion,$cargo,$especialidad,$login,$clave,$permisos)
	{
		
		$sql1="INSERT INTO persona (apaterno,amaterno,nombre,fecha_nacimiento,sexo,estado_civil,tipo_documento,num_documento,direccion,
		telefono,email,ocupacion)
		VALUES ('$apaterno','$amaterno','$nombre','$fecha_nacimiento','$sexo','$estado_civil','$tipo_documento','$num_documento','$direccion','$telefono','$email','$ocupacion')";
		$idpersonanew=ejecutarConsulta_retornarID($sql1);


		$sql2="INSERT INTO usuario (idusuario,cargo,especialidad,login,clave,condicion)
		VALUES ('$idpersonanew','$cargo','$especialidad','$login','$clave','1')";
		
		ejecutarConsulta_retornarID($sql2);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idpersonanew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	
	public function editar($idpersona,$apaterno,$amaterno,$nombre,$fecha_nacimiento,$sexo,$estado_civil,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ocupacion,$cargo,$especialidad,$login,$clave,$permisos)
	{
		$sql1="UPDATE persona SET apaterno='$apaterno',amaterno='$amaterno', nombre='$nombre',
		fecha_nacimiento='$fecha_nacimiento', sexo='$sexo',estado_civil='$estado_civil',tipo_documento='$tipo_documento',
		num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',ocupacion='$ocupacion' WHERE idpersona='$idpersona'";
		ejecutarConsulta($sql1);

		$sql2="UPDATE usuario SET cargo='$cargo',especialidad='$especialidad',login='$login', clave='$clave' WHERE idusuario='$idpersona'";
		ejecutarConsulta($sql2);


		
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idpersona'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idpersona', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM usuario u INNER JOIN persona p ON u.idusuario=p.idpersona WHERE u.idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function listar()
	{
		$sql="SELECT * FROM usuario u INNER JOIN persona p WHERE p.idpersona=u.idusuario";
		return ejecutarConsulta($sql);		
	}
	
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	
	public function verificar($login,$clave)
    {
    	$sql="SELECT u.idusuario,p.nombre,p.tipo_documento,p.num_documento,p.telefono,p.email,u.cargo,u.login FROM usuario u INNER JOIN persona p ON u.idusuario=p.idpersona WHERE u.login='$login' AND u.clave='$clave' AND u.condicion='1'"; 
    	return ejecutarConsulta($sql);  
    }
}

?>