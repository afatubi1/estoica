<?php
// Iniciar la sesión si no está iniciada
if (strlen(session_id()) < 1)
    session_start();

// Incluir el modelo SaleCut
require_once "../modelos/SaleCut.php";

// Crear una instancia del modelo SaleCut
$venta = new SaleCut();

// Obtener y limpiar el parámetro ticketNum si está presente
$ticketNum = isset($_POST["ticketNum"]) ? limpiarCadena($_POST["ticketNum"]) : "";

// Verificar la operación solicitada
switch ($_GET["op"]) {
    case 'listForTicket':
        // Llamar al método listForTicket del modelo y pasar el parámetro ticketNum
        $rspta = $venta->listForTicket($ticketNum);
        $data = array();
        
        // Recorrer los resultados y construir el array de datos
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-primary" onclick="modalFactura(' . $reg->idventa . ',' . $reg->efectivo . ',' . $reg->idusuario . ')"><li class="fa fa-pencil"></li></button> <button class="btn btn-success" onclick="print(' . $reg->idventa . ')"><li class="fa fa-print"></li></button>',
                "1" => $reg->fecha,
                "2" => $reg->hora,
                "3" => 'uni-' . $reg->clave,
                "4" => $reg->placa,
                "5" => $reg->usuario,
                "6" => $reg->auto,
                "7" => $reg->ruta,
                "8" => $reg->kilometro,
                "9" => $reg->pasajero,
                "10" => $reg->tipo_pago,
                "11" => '$' . $reg->tarjeta . '.00',
                "12" => '$' . $reg->dolar,
                "13" => '$' . $reg->efectivo . '.00',
                "14" => '$' . $reg->cxc . '.00',
                "15" => $reg->ticket_num,
                "16" => 'ESTOI - 00' . $reg->idventa
            );
        }

        // Preparar los resultados para el DataTables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        // Enviar los resultados en formato JSON
        echo json_encode($results);
        break;

    case 'listar':
        // Llamar al método listar del modelo
        $rspta = $venta->listar();
        $data = array();

        // Recorrer los resultados y construir el array de datos
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-primary" onclick="modalFactura(' . $reg->idventa . ',' . $reg->efectivo . ',' . $reg->idusuario . ')"><li class="fa fa-pencil"></li></button> <button class="btn btn-success" onclick="print(' . $reg->idventa . ')"><li class="fa fa-print"></li></button>',
                "1" => $reg->fecha,
                "2" => $reg->hora,
                "3" => 'uni-' . $reg->clave,
                "4" => $reg->placa,
                "5" => $reg->usuario,
                "6" => $reg->auto,
                "7" => $reg->ruta,
                "8" => $reg->kilometro,
                "9" => $reg->pasajero,
                "10" => $reg->tipo_pago,
                "11" => '$' . $reg->tarjeta . '.00',
                "12" => '$' . $reg->dolar,
                "13" => '$' . $reg->efectivo . '.00',
                "14" => '$' . $reg->cxc . '.00',
                "15" => $reg->ticket_num,
                "16" => 'TAX - 00' . $reg->idventa
            );
        }

        // Preparar los resultados para el DataTables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        // Enviar los resultados en formato JSON
        echo json_encode($results);
        break;
}
?>
