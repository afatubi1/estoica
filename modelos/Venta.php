<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $hora, $impuesto, $total_venta, $ruta, $unidad, $tipo_pago, $ticket_num, $efectivo, $cambioEfectivo, $kilometro)
	{
		$sql = "INSERT INTO venta (
				idcliente,
				idusuario,
				tipo_comprobante,
				serie_comprobante,
				num_comprobante,
				fecha_hora,
				hora,
				impuesto,
				total_venta,
				estado,
				ruta,
				unidad,
				tipo_pago,
				ticket_num,
				efectivo,
				cambioEfectivo,
				kilometro
				)
				VALUES (
					'1',
					'$idusuario',
					'$tipo_comprobante',
					'$serie_comprobante',
					'$num_comprobante',
					'$fecha_hora',
					'$hora',
					'$impuesto',
					'$total_venta',
					'Aceptado',
					'$ruta',
					'$unidad',
					'$tipo_pago',
					'$ticket_num',
					'$efectivo',
					'$cambioEfectivo',
					'$kilometro')";

		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;

		return $sw;
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT v.idventa, DATE(v.fecha_hora) as fecha, uni.clave, uni.placa, p.nombre as cliente, u.idusuario, u.nombre as usuario, v.tipo_comprobante, v.ruta, v.serie_comprobante, v.num_comprobante, v.total_venta, v.hora, v.impuesto, v.tipo_pago, v.efectivo, v.cambioEfectivo, v.ticket_num, v.kilometro FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN unidad uni ON v.unidad=uni.idunidad ORDER BY v.idventa DESC LIMIT 100;";

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
		v.tipo_comprobante,
		v.ruta,
		v.serie_comprobante,
		v.num_comprobante,
		v.total_venta,
		v.hora,
		v.impuesto,
		v.tipo_pago,
		v.efectivo,
		v.cambioEfectivo,
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
   WHERE v.idventa = $idventa";

		return ejecutarConsulta($sql);
	}
}
?>