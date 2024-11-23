<?php
//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Ingresosvs
{
    public function __construct()
    {

    }

    public function listar($fechaInicio, $fechaFin, $idunidad)
    {
        $sql = "SELECT 
    v.idventa,
    DATE(v.fecha_hora) AS fecha,
    uni.clave,
    uni.placa,
    u.idusuario,
    u.nombre AS usuario,
    v.total_venta,
    v.dolar,
    v.tipo_pago,
    v.cxc,
    v.ticket_num,
    v.efectivo,
    v.kilometro,
    v.tarjeta,
    v.hora
FROM 
    venta v 
INNER JOIN 
    usuario u ON v.idusuario = u.idusuario 
INNER JOIN 
    unidad uni ON v.unidad = uni.idunidad 
WHERE 
    DATE(v.fecha_hora) BETWEEN '$fechaInicio' AND '$fechaFin'  
    AND v.unidad = $idunidad
ORDER BY 
    v.idventa DESC 
LIMIT 100;";

        return ejecutarConsulta($sql);
    }

    public function listarEgresos($fechaInicio, $fechaFin, $idunidad)
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
        l.forma_pago,
        us.nombre
        FROM liquidaciones l
        INNER JOIN unidad uni ON l.unidad = uni.idunidad
        INNER JOIN usuario us ON us.idusuario = l.idusuario
        WHERE DATE(l.fecha) BETWEEN  '$fechaInicio' AND '$fechaFin'  
        AND uni.idunidad = $idunidad ORDER BY l.idliquidacion DESC LIMIT 100;";
        return ejecutarConsulta($sql);
    }
}
?>