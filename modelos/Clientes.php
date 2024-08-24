<?php
require '../config/conexion.php';

class Clientes
{
    public function __construct()
    {

    }

    public function insertar($nombre, $telefono, $numeroviaje, $correo, $rfc, $razonSocial, $codigoPostal,$regimenFiscalRfc)
    {
        $sql = "INSERT INTO clientes(nombre,telefono,numeroviaje,correo,rfc,razonSocial,codigoPostal,regimenFiscalRfc) VALUES ('$nombre','$telefono','$numeroviaje','$correo','$rfc','$razonSocial','$codigoPostal','$regimenFiscalRfc')";
        return ejecutarConsulta($sql);
    }

    public function listarClientes()
    {
        $sql = "SELECT * FROM `clientes`";

        return ejecutarConsulta($sql);
    }

    public function getConsultaUnitaria($idcliente)
    {
        $sql = "SELECT * FROM `facturas` WHERE idfactura = $idcliente " ;

        return ejecutarConsulta($sql);
    }
}

?>