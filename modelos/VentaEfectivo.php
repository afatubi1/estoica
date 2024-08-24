<?php
require '../config/conexion.php';

class VentaEfectivo
{
    public function __construct()
    {

    }

    public function insertar($folio)
    {
        $sql = "INSERT INTO venta_efectivo ( folio) VALUES ('$folio')";

        return ejecutarConsulta($sql);
    }

    public function insertDolarSale($folio)
    {
        $sql = "INSERT INTO venta_dolar ( folio) VALUES ('$folio')";

        return ejecutarConsulta($sql);
    }

    public function insertCxcSale($folio)
    {
        $sql = "INSERT INTO venta_cxc ( folio) VALUES ('$folio')";

        return ejecutarConsulta($sql);
    }

    public function getLast()
    {
        $sql = "SELECT * FROM `venta_efectivo` ORDER BY idefectivo DESC LIMIT 1";

        return ejecutarConsulta($sql);
    }

    public function getLastDolar()
    {
        $sql = "SELECT * FROM `venta_dolar` ORDER BY iddolar DESC LIMIT 1";

        return ejecutarConsulta($sql);
    }

    public function getLastCxc()
    {
        $sql = "SELECT * FROM `venta_cxc` ORDER BY idcxc DESC LIMIT 1";

        return ejecutarConsulta($sql);
    }

}

?>