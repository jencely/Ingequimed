<?php 

require "../config/Conexion.php";

Class Consultas
{
	
	public function __construct()
	{

	}

	public function listar($fechainicio,$fechafin)
	{
		$sql="SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio WHERE a.estado<>'Anulado' AND a.fecha>='$fechainicio' AND a.fecha<='$fechafin' order by a.idatencion desc";
		return ejecutarConsulta($sql);		
	}

	public function listarHistorias($fechainicio,$fechafin)
	{
		$sql="SELECT a.idatencion,a.idpersona,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio WHERE a.estado='Atendido' AND a.fecha>='$fechainicio' AND a.fecha<='$fechafin' order by a.idatencion desc";
		return ejecutarConsulta($sql);		
	}
}

?>