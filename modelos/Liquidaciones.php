<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

Class Liquidaciones
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($fecha_hora, $clave, $concepto, $numeroCheque, $unidad, $importe, $descripcion, $hora,$movimiento)
	{
		$sql="INSERT INTO liquidaciones (
				fecha,
				clave,
				concepto_clave,
				numero_cheque,
				unidad,
				importe,
				descripcion,
				hora,
				movimiento)
				VALUES (
					'$fecha_hora',
					'$clave',
					'$concepto',
					'$numeroCheque',
					'$unidad',
					'$importe',
					'$descripcion',
					'$hora','$movimiento')";

		$idventanew=ejecutarConsulta_retornarID($sql);
		$num_elementos=0;
		$sw=true;

		return $sw;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT l.idliquidacion,l.fecha,
		l.clave,
			l.concepto_clave,
			l.numero_cheque,
			uni.clave,
			l.importe,
		  l.descripcion,
			l.hora,
			l.movimiento FROM liquidaciones l INNER JOIN unidad uni
		ON l.unidad = uni.idunidad";

		return ejecutarConsulta($sql);
	}
}
?>
