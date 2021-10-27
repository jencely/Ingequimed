<?php 

require "../config/Conexion.php";

Class Triaje
{
	
	public function __construct()
	{

	}

	
	public function insertar($idatencion,$presion_arterial,$temperatura,$frecuencia_respiratoria,$frecuencia_cardiaca,$saturacion,$peso,$talla,$imc)
	{
		$sql2="UPDATE atencion set estado='Triaje' WHERE idatencion='$idatencion'";
		ejecutarConsulta($sql2);

		$sql="INSERT INTO triaje (idatencion,presion_arterial,temperatura,frecuencia_respiratoria,frecuencia_cardiaca,saturacion,peso,talla,imc,estado)
		VALUES ('$idatencion','$presion_arterial','$temperatura','$frecuencia_respiratoria','$frecuencia_cardiaca','$saturacion','$peso','$talla','$imc','Triaje')";
		return ejecutarConsulta($sql);

		
	}

	
	public function mostrar($idatencion)
	{
		$sql="SELECT a.idatencion,a.idpersona,p.num_documento,concat(p.apaterno,' ',p.amaterno,' ',p.nombre) as paciente, p.fecha_nacimiento,CONCAT((YEAR( CURDATE( ) ) - YEAR( fecha_nacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fecha_nacimiento), 1, 
IF ( MONTH(CURDATE( )) = MONTH(fecha_nacimiento),IF (DAY( CURDATE( ) ) < DAY( fecha_nacimiento ),1,0 ),0))),' años, ',(MONTH(CURDATE()) - MONTH( fecha_nacimiento) + 12 * IF( MONTH(CURDATE())<MONTH(fecha_nacimiento), 1,IF(MONTH(CURDATE())=MONTH(fecha_nacimiento),IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0),0)) - IF(MONTH(CURDATE())<>MONTH(fecha_nacimiento),(DAY(CURDATE())<DAY(fecha_nacimiento)), IF (DAY(CURDATE())<DAY(fecha_nacimiento),1,0 ))),' meses, ',(DAY( CURDATE( ) ) - DAY( fecha_nacimiento ) +30 * ( DAY(CURDATE( )) < DAY(fecha_nacimiento) )),' días') as edad,a.fecha,a.hora,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idusuario) as registrador,(select concat(apaterno,' ',amaterno,' ',nombre) from persona where idpersona=a.idempleado) as especialista,s.nombre as servicio,a.costo,a.estado FROM atencion a INNER JOIN persona p ON a.idpersona=p.idpersona inner join servicio s on a.idservicio=s.idservicio WHERE a.idatencion='$idatencion'";
		return ejecutarConsultaSimpleFila($sql);
	}
}

?>