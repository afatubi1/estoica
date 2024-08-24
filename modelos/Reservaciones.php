<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Reservaciones
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
		$sql = "SELECT
		reserva.idreservaciones,
		DATE(reserva.fecha) as fecha,
		u.nombre,
		uni.clave,
		rut.ruta_direccion,
		reserva.idConductor,
		reserva.tipo_viaje,
		reserva.hora,
		reserva.tipo_pago,
		reserva.automovil,
		reserva.numero_pasajero,
		reserva.kilometro,
		reserva.labelDolar,
		reserva.total_mxn,
		reserva.idusuario,
		reserva.total_usd,
		reserva.ticket_num,
		reserva.efectivo,
		reserva.cambioEfectivo,
		reserva.ticket_num,
		reserva.facturado
		FROM reservaciones reserva
   INNER JOIN usuario u
   ON reserva.idusuario=u.idusuario
   INNER JOIN unidad uni
   ON reserva.idunidad =uni.idunidad
   INNER JOIN ruta rut
   ON reserva.idruta=rut.idruta
   ORDER by reserva.idreservaciones desc";

		return ejecutarConsulta($sql);
	}

	public function getIdReservaciones()
	{
		$sql = "SELECT * FROM `reservaciones` ORDER BY idreservaciones DESC LIMIT 1";

		return ejecutarConsulta($sql);
	}

	public function getReservaciones($idreservaciones)
	{
		$sql = "SELECT
		reserva.idreservaciones,
		DATE(reserva.fecha) as fecha,
		u.nombre,
		uni.clave,
		rut.ruta_direccion,
		reserva.idConductor,
		reserva.tipo_viaje,
		reserva.hora,
		reserva.tipo_pago,
		reserva.automovil,
		reserva.numero_pasajero,
		reserva.kilometro,
		reserva.labelDolar,
		reserva.total_mxn,
		reserva.idusuario,
		reserva.total_usd,
		reserva.ticket_num,
		reserva.efectivo,
		reserva.cambioEfectivo,
		reserva.ticket_num
		FROM reservaciones reserva
   INNER JOIN usuario u
   ON reserva.idusuario=u.idusuario
   INNER JOIN unidad uni
   ON reserva.idunidad =uni.idunidad
   INNER JOIN ruta rut
   ON reserva.idruta=rut.idruta
   WHERE idreservaciones =  $idreservaciones";

		return ejecutarConsulta($sql);
	}
}
?>