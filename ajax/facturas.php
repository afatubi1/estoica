<?php

require_once '../modelos/Facturas.php';

$facturas = new Facturas();
$idfactura=isset($_POST["idfactura"])? limpiarCadena($_POST["idfactura"]):"";

switch ($_GET["op"]) {
    case 'listarFacturas':
        $rspta = $facturas->listarFacturas();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" =>$reg->dateRfc,             
                "1" => '<button class="btn btn-success" onclick="getInfoXml(' . $reg->idfactura . ')"><li class="fa fa-file"></li>      XML </button>',
                "2" => '<button class="btn btn-success" onclick="getInfoFactura(' . $reg->idfactura . ')"><li class="fa fa-file"></li>      Factura</button>',
                "3" => '<button class="btn btn-success" onclick="getInfoQr(' . $reg->idfactura . ')"><li class="fa fa-file"></li>      QR</button>',
                "4" => 'ESTOI - '.$reg->folioRfc
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

        case 'getXML':
            $rspta = $facturas->getConsultaUnitaria($idfactura);
            while ($reg = $rspta->fetch_object()) {
            echo $reg->cfdi;
        }
        break;

        case 'getFactura':
            $rspta = $facturas->getConsultaUnitaria($idfactura);
            while ($reg = $rspta->fetch_object()) {
            echo $reg->facturaPdf;
        }
        break;

        case 'getQr':
            $rspta = $facturas->getConsultaUnitaria($idfactura);
            while ($reg = $rspta->fetch_object()) {
            echo $reg->qr;
        }
        break;
}

?>