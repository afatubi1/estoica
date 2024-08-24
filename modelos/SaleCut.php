<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class SaleCut
{
	//Implementamos nuestro constructor
	public function __construct()
	{

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

	public function listForTicket($idTicket)
	{
		$sql = "SELECT 
                    v.idventa,
                    DATE(v.fecha_hora) AS fecha,
                    uni.clave,
                    uni.placa,
                    p.nombre AS cliente,
                    u.idusuario,
                    u.nombre AS usuario,
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
                    v.kilometro 
                FROM 
                    venta v 
                INNER JOIN 
                    persona p ON v.idcliente = p.idpersona
                INNER JOIN 
                    usuario u ON v.idusuario = u.idusuario 
                INNER JOIN 
                    unidad uni ON v.unidad = uni.idunidad 
                WHERE 
                    v.idventa >= $idTicket
                ORDER BY 
                    v.idventa DESC 
                LIMIT 100";

        return ejecutarConsulta($sql);

	}
}
?>