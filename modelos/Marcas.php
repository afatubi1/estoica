<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Marcas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($brand_name, $local_number, $horario, $information)
	{
		$sql = "INSERT INTO brands (
				brand_name,
				local_number,
				horario,
				information
				)
				VALUES (
					'$brand_name',
					'$local_number',
					'$horario',
					'$information')";
		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;

		return $sw;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM `brands` ";

		return ejecutarConsulta($sql);
	}

	public function getIdVenta()
	{
		$sql = "SELECT * FROM `venta` ORDER BY idventa DESC LIMIT 1";

		return ejecutarConsulta($sql);
	}
}
?>