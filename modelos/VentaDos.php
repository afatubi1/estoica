<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class VentaDos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario, $auto, $pasajero, $tarjeta, $fecha_hora, $hora, $dolar, $total_venta, $ruta, $unidad, $tipo_pago, $ticket_num, $efectivo, $cxc, $kilometro)
	{
		$sql = "INSERT INTO venta (
				idcliente,
				idusuario,
				auto,
				pasajero,
				tarjeta,
				fecha_hora,
				hora,
				dolar,
				total_venta,
				estado,
				ruta,
				unidad,
				tipo_pago,
				ticket_num,
				efectivo,
				cxc,
				kilometro
				)
				VALUES (
					'1',
					'$idusuario',
					'$auto',
					'$pasajero',
					'$tarjeta',
					'$fecha_hora',
					'$hora',
					'$dolar',
					'$total_venta',
					'Aceptado',
					'$ruta',
					'$unidad',
					'$tipo_pago',
					'$ticket_num',
					'$efectivo',
					'$cxc',
					'$kilometro')";

		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;

		return $sw;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT v.idventa,
	    DATE(v.fecha_hora) as fecha,
		uni.clave, uni.placa,
		p.nombre as cliente,
		u.idusuario,
		u.nombre as usuario,
		v.auto,
		v.ruta,
		v.pasajero,
		v.tarjeta,
		v.total_venta,
		v.hora,
		v.dolar,
		v.tipo_pago,
		v.cxc,
		v.ticket_num,
		v.efectivo,
		v.kilometro FROM venta v 
		INNER JOIN persona p 
		ON v.idcliente=p.idpersona
		INNER JOIN usuario u 
		ON v.idusuario=u.idusuario 
		INNER JOIN unidad uni 
		ON v.unidad=uni.idunidad 
		ORDER BY v.idventa DESC LIMIT 100;";

		return ejecutarConsulta($sql);
	}

	public function getIdVenta()
	{
		$sql = "SELECT * FROM `venta` ORDER BY idventa DESC LIMIT 1";

		return ejecutarConsulta($sql);
	}

	public function getVenta($idventa)
	{
		$sql = "SELECT
		v.idventa,
		DATE(v.fecha_hora) as fecha,
		uni.clave,
		p.nombre as cliente,
		u.idusuario,
		u.nombre as usuario,
		v.auto,
		v.ruta,
		v.pasajero,
		v.tarjeta,
		v.total_venta,
		v.hora,
		v.dolar,
		v.tipo_pago,
		v.efectivo,
		v.cxc,
		v.ticket_num,
		v.kilometro,
		v.ruta,
        uni.placa
		FROM venta v 
   INNER JOIN persona p
   ON v.idcliente=p.idpersona
   INNER JOIN usuario u
   ON v.idusuario=u.idusuario
   INNER JOIN unidad uni
   ON v.unidad=uni.idunidad
   WHERE v.idventa =$idventa";

		return ejecutarConsulta($sql);
	}
}
?>