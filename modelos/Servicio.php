<?php 
require "../config/Conexion.php";

Class Servicio
{
	public function __construct()
	{

	}

	public function insertar($nombre,$costo)
	{
		$sql="INSERT INTO servicio (nombre,costo,condicion)
		VALUES ('$nombre','$costo','1')";
		return ejecutarConsulta($sql);
	}

	
	public function editar($idservicio,$nombre,$costo)
	{
		$sql="UPDATE servicio SET nombre='$nombre',costo='$costo' WHERE idservicio='$idservicio'";
		return ejecutarConsulta($sql);
	}

	
	public function desactivar($idservicio)
	{
		$sql="UPDATE servicio SET condicion='0' WHERE idservicio='$idservicio'";
		return ejecutarConsulta($sql);
	}

	
	public function activar($idservicio)
	{
		$sql="UPDATE servicio SET condicion='1' WHERE idservicio='$idservicio'";
		return ejecutarConsulta($sql);
	}

	
	public function mostrar($idservicio)
	{
		$sql="SELECT * FROM servicio WHERE idservicio='$idservicio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function listar()
	{
		$sql="SELECT * FROM servicio";
		return ejecutarConsulta($sql);		
	}
	
	public function select()
	{
		$sql="SELECT * FROM servicio where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>