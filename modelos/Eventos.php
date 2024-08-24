<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Eventos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($evento, $fecha, $hora, $informacion, $imagenes)
	{
		 // Insert event details
		 $sql = "INSERT INTO eventos (nombre, fecha, hora, informacion) VALUES ('$evento', '$fecha', '$hora', '$informacion')";
		 $idevento = ejecutarConsulta_retornarID($sql);
		 
		 // Insert images into the image table
		 foreach ($imagenes as $imagen) {
			 $sql_img = "INSERT INTO image(image_path, idsection,	idbrand,idevento) VALUES ('$imagen','2','0','$idevento')";
			 ejecutarConsulta($sql_img);
		 }
		 
		 return true;
	}

	public function editar($idevento, $evento, $fecha, $hora, $informacion, $imagenes)
	{
		$sql = "UPDATE eventos set
				nombre = '$evento',
				fecha ='$fecha',
				hora ='$hora',
				informacion = '$informacion'
				where idevento = '$idevento'";
		$idventanew = ejecutarConsulta_retornarID($sql);

		foreach ($imagenes as $imagen) {
			$sql_img = "INSERT INTO image(image_path, idsection,	idbrand,idevento) VALUES ('$imagen','2','0','$idevento')";
			ejecutarConsulta($sql_img);
		}

		return true;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM `eventos` WHERE 1 ";

		return ejecutarConsulta($sql);
	}

	public function getevento($idevento)
	{
		$sql = "SELECT * FROM eventos WHERE idevento = $idevento";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function getIdVenta()
	{
		$sql = "SELECT * FROM `venta` ORDER BY idventa DESC LIMIT 1";

		return ejecutarConsulta($sql);
	}
}
?>