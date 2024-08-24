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
$idruta = isset($_POST["idruta"]) ? limpiarCadena($_POST["idruta"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$hora = isset($_POST["hora"]) ? limpiarCadena($_POST["hora"]) : "";
$tipo_pago = isset($_POST["tipo_pago"]) ? limpiarCadena($_POST["tipo_pago"]) : "";
$automovil = isset($_POST["auto"]) ? limpiarCadena($_POST["auto"]) : "";
$numero_pasajero = isset($_POST["numero_pasajero"]) ? limpiarCadena($_POST["numero_pasajero"]) : "";
$kilometro = isset($_POST["kilometro"]) ? limpiarCadena($_POST["kilometro"]) : "";
$total_mxn = isset($_POST["total_mxn"]) ? limpiarCadena($_POST["total_mxn"]) : "";
$labelDolar = isset($_POST["labelDolar"]) ? limpiarCadena($_POST["labelDolar"]) : "";
$total_usd = isset($_POST["total_usd"]) ? limpiarCadena($_POST["total_usd"]) : "";
$ticket_num = isset($_POST["ticket_num"]) ? limpiarCadena($_POST["ticket_num"]) : "";
$efectivo = isset($_POST["efectivo"]) ? limpiarCadena($_POST["efectivo"]) : "";
$cambioEfectivo = isset($_POST["cambioEfectivo"]) ? limpiarCadena($_POST["cambioEfectivo"]) : "";
$chofer_save = isset($_POST["chofer_save"]) ? limpiarCadena($_POST["chofer_save"]) : "";

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
$qr = isset($_POST["qrRfc"]) ? limpiarCadena($_POST["qrRfc"]) : "";

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
				labelDolar,
				total_usd,
				ticket_num,
				efectivo,
				cambioEfectivo,
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
					'$labelDolar',
					'$total_usd',
					'$ticket_num',
					'$efectivo',
					'$cambioEfectivo',
					'$idusuario',
					'No')";

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
				"0" => '<button class="btn btn-primary" onclick="modalFactura(' . $reg->idreservaciones . ',' . $reg->total_mxn . ',' . $reg->idusuario . ')"><li class="fa fa-pencil"></li></button> <button class="btn btn-success" onclick="print(' . $reg->idreservaciones . ')"><li class="fa fa-print"></li></button>',
				"1" => 'Facturado - ' . $reg->facturado,
				"2" => $reg->fecha,
				"3" => $reg->hora,
				"4" => 'uni-' . $reg->clave,
				"5" => $reg->nombre,
				"6" => $reg->idConductor,
				"7" => $reg->tipo_viaje,
				"8" => $reg->ruta_direccion,
				"9" => $reg->kilometro,
				"10" => $reg->automovil,
				"11" => $reg->numero_pasajero,
				"12" => '$' . $reg->total_mxn . '.00',
				"13" => '$' . $reg->total_usd,
				"14" => $reg->tipo_pago,
				"15" => '$' . $reg->efectivo . '.00',
				"16" => '$' . $reg->cambioEfectivo . '.00',
				"17" => $reg->ticket_num,
				"18" => 'TAXRES - 00' . $reg->idreservaciones
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
		$sql = "UPDATE reservaciones SET facturado = 'Si' WHERE idreservaciones='$idreservacionrfc '";
		$idventanew = ejecutarConsulta_retornarID($sql);
		$num_elementos = 0;
		$sw = true;
		echo $sw ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		break;

	case 'facturar':
		getFactura(
			array(
				"CFDi" => array(
					"modo" => "debug",
					"versionCFDi" => "4.0",
					"versionEF" => "6.5",
					"serie" => "TSAIFA",
					"folioInterno" => $folioRfc,
					"fechaEmision" => $dateRfc,
					"subTotal" => $amountRfc,
					"total" => $amountRfc,
					"rfc" => "GTT220524A23",
					"exportacion" => "01",
					"DatosDePago" => array(
						"metodoDePago" => "PUE",
						"formaDePago" => $pymentTypeRfc,
						"condicionesDePago" => "Contado",
						"referenciaBancaria" => $referencesRfc
					),
					"Receptor" => array(
						"rfc" => $claveRfc,
						"nombre" => $nameRfc,
						"usoCfdi" => "G03",
						"regimenFiscal" => $regimenFiscalRfc,
						"DomicilioFiscal" => array(
							"cp" => $codePostalRfc
						)
					),
					"Partidas" => array(
						array(
							"cantidad" => "1",
							"objetoDeImpuesto" => "01",
							"claveUnidad" => "E48",
							"claveProdServ" => "78111804",
							"descripcion" => "1",
							"valorUnitario" => $amountRfc,
							"importe" => $amountRfc
						)
					)
				)
			)
		);
		break;
}


function getFactura($data)
{
	$aAuth = array(
		'User' => 'GTT220524A23',
		'Pass' => '5b190964819922e4417186960c895e02'
	);

	$sUrl = "https://api.enlacefiscal.com/v6/generarCfdi";

	$aData = array();

	$aData = $data;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $sUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

	$sDataJson = json_encode($aData);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $sDataJson);

	$nContentLenght = strlen($sDataJson);

	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'Content-Type: application/json',
			'x-api-key: e9aT1ajrRh1NyRkzOtDoN1ZEGmIsEKuJ6f3FYyLh',
			'Content-Length: ' . $nContentLenght
		)
	);

	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "{$aAuth['User']}:{$aAuth['Pass']}");

	$sOutput = curl_exec($ch);
	curl_close($ch);
	echo $sOutput;
}
?>