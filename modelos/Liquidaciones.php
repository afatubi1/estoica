<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Liquidaciones
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($fecha_hora, $clave_l, $concepto, $numeroCheque, $unidad, $importe, $descripcion, $hora, $movimiento, $plaza, $imagen, $idusuario, $forma_pago, $imagen_dos)
	{
		$sql = "INSERT INTO liquidaciones (
				fecha,
				clave_l,
				concepto_clave,
				numero_cheque,
				unidad,
				importe,
				descripcion,
				hora,
				movimiento,
				plaza,
				imagen,
				idusuario,
				forma_pago,
				imagen_dos) 
				VALUES (
					'$fecha_hora',
					'$clave_l',
					'$concepto',
					'$numeroCheque',
					'$unidad',
					'$importe',
					'$descripcion',
					'$hora',
					'$movimiento',
					'$plaza',
					'$imagen', 
					'$idusuario',
					'$forma_pago',
					'$imagen_dos')";

		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;

		return $sw;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT l.idliquidacion,
       l.fecha,
       l.clave_l,
       l.concepto_clave,
       l.numero_cheque,
       uni.clave,
       l.importe,
       l.descripcion,
       l.hora,
       l.plaza,
       l.imagen,
       l.movimiento,
       l.forma_pago,
	   l.imagen_dos,
       us.nombre
FROM liquidaciones l
INNER JOIN unidad uni ON l.unidad = uni.idunidad
INNER JOIN usuario us ON us.idusuario = l.idusuario
ORDER BY l.idliquidacion DESC";

		return ejecutarConsulta($sql);
	}

	public function getLiquidacion($idliquidacion)
	{
		$sql = "SELECT 
    l.idliquidacion,
    l.fecha,
    l.clave_l,
    l.concepto_clave,
    l.numero_cheque,
    uni.clave,
    l.importe,
    l.descripcion,
    l.hora,
    l.plaza,
    l.imagen,
    l.movimiento,
    us.nombre
FROM 
    liquidaciones l 
INNER JOIN 
    unidad uni ON l.unidad = uni.idunidad
INNER JOIN 
    usuario us ON us.idusuario = l.idusuario
WHERE 
    l.idliquidacion = $idliquidacion";

		return ejecutarConsulta($sql);
	}
}
?>