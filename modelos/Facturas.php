<?php
require '../config/conexion.php';

class Facturas
{
    public function __construct()
    {

    }

    public function insertar($idventarfc, $dateRfc, $folioRfc, $cfdi, $facturaPdf, $qr)
    {
        $sql = "INSERT INTO facturas(idventarfc,dateRfc,folioRfc,cfdi,facturaPdf,qr) VALUES ('$idventarfc','$dateRfc','$folioRfc','$cfdi','$facturaPdf','$qr')";

        return ejecutarConsulta($sql);
    }

    public function listarFacturas()
    {
        $sql = "SELECT * FROM `facturas`";

        return ejecutarConsulta($sql);
    }

    public function getConsultaUnitaria($idfactura)
    {
        $sql = "SELECT * FROM `facturas` WHERE idfactura = $idfactura " ;

        return ejecutarConsulta($sql);
    }
}

?>