<?php

require_once '../modelos/Clientes.php';

$clientes = new Clientes();
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$rfc = isset($_POST["rfc"]) ? limpiarCadena($_POST["rfc"]) : "";
$razonSocial = isset($_POST["razonSocial"]) ? limpiarCadena($_POST["razonSocial"]) : "";
$codigoPostal = isset($_POST["codigoPostal"]) ? limpiarCadena($_POST["codigoPostal"]) : "";
$regimenFiscalRfc = isset($_POST["regimenFiscalRfc"]) ? limpiarCadena($_POST["regimenFiscalRfc"]) : "";

switch ($_GET["op"]) {
    case 'guardar':
        $rspta = $clientes->insertar($nombre, $telefono, "0", $correo, $rfc, $razonSocial, $codigoPostal,$regimenFiscalRfc);
        echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
        break;
    case 'listarClientes':
        $rspta = $clientes->listarClientes();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" =>'clte-00'.$reg->idcliente,
                "1" => $reg->nombre,
                "2" => $reg->telefono,
                "3" => $reg->correo,
                "4" => $reg->rfc,
                "5" => $reg->razonSocial,
                "6" => $reg->codigoPostal,
                "7" => $reg->regimenFiscalRfc,
            );
        }
        $results = array(
            "sEcho" => 1,
            //Informacion para el datable
            "iTotalRecords" => count($data),
            //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data),
            //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}

?>