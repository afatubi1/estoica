<?php
if (strlen(session_id()) < 1)
	session_start();

require_once "../modelos/Reservaciones.php";
require '../config/conexion.php';

$reservaciones = new Reservaciones();
$idusuario = $_SESSION["idusuario"];
$idreservaciones = isset($_POST["idreservaciones"]) ? limpiarCadena($_POST["idreservaciones"]) : "";
$nombre_cliente = isset($_POST["nombre_cliente"]) ? limpiarCadena($_POST["nombre_cliente"]) : "";
$numero_celular = isset($_POST["numero_celular"]) ? limpiarCadena($_POST["numero_celular"]) : "";
$idConductor = isset($_POST["idConductor"]) ? limpiarCadena($_POST["idConductor"]) : "";
$tipo_viaje = isset($_POST["tipo_viaje"]) ? limpiarCadena($_POST["tipo_viaje"]) : "";
$idunidad = isset($_POST["idunidad"]) ? limpiarCadena($_POST["idunidad"]) : "";
$idruta = isset($_POST["ruta"]) ? limpiarCadena($_POST["ruta"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$hora = isset($_POST["hora"]) ? limpiarCadena($_POST["hora"]) : "";
$tipo_pago = isset($_POST["tipo_pago"]) ? limpiarCadena($_POST["tipo_pago"]) : "";
$automovil = isset($_POST["auto"]) ? limpiarCadena($_POST["auto"]) : "";
$numero_pasajero = isset($_POST["numero_pasajero"]) ? limpiarCadena($_POST["numero_pasajero"]) : "";
$kilometro = isset($_POST["kilometro"]) ? limpiarCadena($_POST["kilometro"]) : "";
$total_mxn = isset($_POST["total_mxn"]) ? limpiarCadena($_POST["total_mxn"]) : "";
$dolar = isset($_POST["dolar"]) ? limpiarCadena($_POST["dolar"]) : "";
$tarjeta = isset($_POST["tarjeta"]) ? limpiarCadena($_POST["tarjeta"]) : "";
$ticket_num = isset($_POST["ticket_num"]) ? limpiarCadena($_POST["ticket_num"]) : "";
$efectivo = isset($_POST["efectivo"]) ? limpiarCadena($_POST["efectivo"]) : "";
$cxc = isset($_POST["cxc"]) ? limpiarCadena($_POST["cxc"]) : "";
$chofer_save = isset($_POST["chofer_save"]) ? limpiarCadena($_POST["chofer_save"]) : "";

$cambioEfectivo = isset($_POST["dolar"]) ? limpiarCadena($_POST["dolar"]) : "";
$cambioEfectivo = isset($_POST["tarjeta"]) ? limpiarCadena($_POST["tarjeta"]) : "";
$cambioEfectivo = isset($_POST["cxc"]) ? limpiarCadena($_POST["cxc"]) : "";


// info for RFC reservaciones
$claveRfc = isset($_POST["claveRfc"]) ? limpiarCadena($_POST["claveRfc"]) : "";
$nameRfc = isset($_POST["nameRfc"]) ? limpiarCadena($_POST["nameRfc"]) : "";
$codePostalRfc = isset($_POST["codePostalRfc"]) ? limpiarCadena($_POST["codePostalRfc"]) : "";
$pymentTypeRfc = isset($_POST["pymentTypeRfc"]) ? limpiarCadena($_POST["pymentTypeRfc"]) : "";
$regimenFiscalRfc = isset($_POST["regimenFiscalRfc"]) ? limpiarCadena($_POST["regimenFiscalRfc"]) : "";
$idreservacionrfc = isset($_POST["idreservacionrfc"]) ? limpiarCadena($_POST["idreservacionrfc"]) : "";
$dateRfc = isset($_POST["dateRfc"]) ? limpiarCadena($_POST["dateRfc"]) : "";
$folioRfc = isset($_POST["folioRfc"]) ? limpiarCadena($_POST["folioRfc"]) : "";
$amountRfc = isset($_POST["amountRfc"]) ? limpiarCadena($_POST["amountRfc"]) : "";
$referencesRfc = isset($_POST["referencesRfc"]) ? limpiarCadena($_POST["referencesRfc"]) : "";
$cfdi = isset($_POST["cfdi"]) ? limpiarCadena($_POST["cfdi"]) : "";
$facturaPdf = isset($_POST["facturaPdf"]) ? limpiarCadena($_POST["facturaPdf"]) : "";
$cxc_edit = isset($_POST["cxc_edit"]) ? limpiarCadena($_POST["cxc_edit"]) : "";
// edit

$tarjeta_edit = isset($_POST["tarjeta_edit"]) ? limpiarCadena($_POST["tarjeta_edit"]) : "";
$efectivo_edit = isset($_POST["efectivo_edit"]) ? limpiarCadena($_POST["efectivo_edit"]) : "";
$dolar_edit = isset($_POST["dolar_edit"]) ? limpiarCadena($_POST["dolar_edit"]) : "";
$cxc_edit = isset($_POST["cxc_edit"]) ? limpiarCadena($_POST["cxc_edit"]) : "";
$idreservaciones_edit = isset($_POST["idreservaciones_edit"]) ? limpiarCadena($_POST["idreservaciones_edit"]) : "";

switch ($_GET["op"]) {
	case 'guardar':
		$sqlReserva = "INSERT INTO reservaciones (
				nombre_cliente,
				numero_celular,
				idConductor,
				tipo_viaje,
				idunidad,
				idruta,
				fecha,
				hora,
				tipo_pago,
				automovil,
				numero_pasajero,
				kilometro,
				total_mxn,
				dolar,
				tarjeta,
				ticket_num,
				efectivo,
				cxc,
				idusuario,
				facturado
				)
				VALUES (
					'$nombre_cliente',
					'$numero_celular',
					'$chofer_save',
					'$tipo_viaje',
					'$idunidad',
					'$idruta',
					'$fecha',
					'$hora',
					'$tipo_pago',
					'$automovil',
					'$numero_pasajero',
					'$kilometro',
					'$total_mxn',
					'$dolar',
					'$tarjeta',
					'$ticket_num',
					'$efectivo',
					'$cxc',
					'$idusuario',
					'1')";

		$idventanew = ejecutarConsulta_retornarID($sqlReserva);
		$num_elementos = 0;
		$sw = true;
		echo $sw ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";

		break;

	case 'listar':
		$rspta = $reservaciones->listar();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<button class="btn btn-primary" onclick="editarMontos(' . $reg->idreservaciones . ',' . $reg->facturado . ')"><li class="fa fa-pencil"></li></button> <button class="btn btn-success" onclick="print(' . $reg->idreservaciones . ')"><li class="fa fa-print"></li></button></button> <button class="btn btn-warning" onclick="abrirmodal(' . $reg->idreservaciones . ',' . $reg->facturado . ')"><li class="fa fa-times"></li></button>',
				"1" => cambiarColor($reg->facturado),
				"2" => $reg->fecha,
				"3" => $reg->hora,
				"4" => 'uni-' . $reg->clave,
				"5" => $reg->nombre,
				"6" => $reg->idConductor,
				"7" => $reg->tipo_viaje,
				"8" => $reg->idruta,
				"9" => $reg->kilometro,
				"10" => $reg->automovil,
				"11" => $reg->numero_pasajero,
				"12" => $reg->tipo_pago,
				"13" => '$' . $reg->efectivo . '.00',
				"14" => '$' . $reg->tarjeta . '.00',
				"15" => '$' . $reg->dolar . '.00',
				"16" => '$' . $reg->cxc . '.00',
				"17" => $reg->ticket_num,
				"18" => 'ESTOIRES - 00' . $reg->idreservaciones
			);
		}

		$results = array(
			"sEcho" => 1,
			//Información para el datatables
			"iTotalRecords" => count($data),
			//enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data),
			//enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;

	case 'selectUnidad':
		require_once "../modelos/Unidad.php";
		$unidad = new Unidad();

		$rspta = $unidad->listarC();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idunidad . '>' . $reg->clave . '</option>';
		}
		break;

	case 'selectRuta':
		require_once "../modelos/Ruta.php";
		$ruta = new Ruta();

		$rspta = $ruta->listarC();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idruta . '>' . $reg->ruta_direccion . '</option>';
		}
		break;

	case 'guardarIdEfectivo':
		require_once "../modelos/VentaEfectivo.php";
		$ruta = new VentaEfectivo();
		$rspta = $ruta->insertar($folio);
		break;

	case 'getFolioReserva':
		require_once "../modelos/VentaEfectivo.php";
		$reservaciones = new Reservaciones();

		$rspta = $reservaciones->getIdReservaciones();

		while ($reg = $rspta->fetch_object()) {
			echo $reg->idreservaciones;
		}
		break;

	case 'getIdVentaEfectivo':
		require_once "../modelos/VentaEfectivo.php";
		$ruta = new VentaEfectivo();

		$rspta = $ruta->getLast();

		while ($reg = $rspta->fetch_object()) {
			echo $reg->idefectivo;
		}
		break;

	case 'getReservaciones':
		require_once "../modelos/Reservaciones.php";
		$reservaciones = new Reservaciones();

		$rspta = $reservaciones->getReservaciones($idreservaciones);
		while ($reg = $rspta->fetch_object()) {
			echo $json = json_encode($reg);
		}

		break;

	case 'guardarFactura':
		require_once "../modelos/Facturas.php";
		$ruta = new Facturas();
		$rspta = $ruta->insertar($idreservacionrfc, $dateRfc, $folioRfc, $cfdi, $facturaPdf, $qr);
		break;


	// update reserva
	case 'updateReserva':
		$sql = "UPDATE reservaciones SET facturado = '0' WHERE idreservaciones='$idreservaciones '";
		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;
		echo $sw ? "Reserva cerrada" : "No se pudieron registrar todos los datos de la reserva";
		break;

	// update reserva
	case 'updateMontos':
		$sql = "UPDATE reservaciones SET efectivo = '$efectivo_edit', tarjeta ='$tarjeta_edit', dolar ='$dolar_edit', cxc ='$cxc_edit' WHERE idreservaciones='$idreservaciones_edit '";
		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;
		echo $sw ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		break;

	// update reserva
	case 'getMontos':
		require_once "../modelos/Reservaciones.php";
		$reservaciones = new Reservaciones();
	
		$rspta = $reservaciones->getMontos($idreservaciones);
		echo json_encode($rspta);
		
		break;
}

function cambiarColor($facturado) {
    if ($facturado == "1") {
        return '<span style="color: green; font-weight: bold;">Abierto</span>';
    } else {
        return '<span style="color: red; font-weight: bold;">Cerrado</span>';
    }
}


?>