<?php

if (strlen(session_id()) < 1)
	session_start();

require_once "../modelos/VentaDos.php";

$venta = new VentaDos();

$idventa = isset($_POST["idventa"]) ? limpiarCadena($_POST["idventa"]) : "";
$unidad = isset($_POST["idunidad"]) ? limpiarCadena($_POST["idunidad"]) : "";
$idusuario = $_SESSION["idusuario"];
$auto = isset($_POST["auto"]) ? limpiarCadena($_POST["auto"]) : "";
$serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
$num_comprobante = isset($_POST["total_mxn"]) ? limpiarCadena($_POST["total_mxn"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$hora = isset($_POST["hour_save"]) ? limpiarCadena($_POST["hour_save"]) : "";
$dolar = isset($_POST["Dolar"]) ? limpiarCadena($_POST["Dolar"]) : "";
$tarjeta = isset($_POST["Tarjeta"]) ? limpiarCadena($_POST["Tarjeta"]) : "";
$cxc = isset($_POST["CXC"]) ? limpiarCadena($_POST["CXC"]) : "";
$pasajero = isset($_POST["Pasajero"]) ? limpiarCadena($_POST["Pasajero"]) : "";

$total_venta = isset($_POST["total_venta"]) ? limpiarCadena($_POST["total_venta"]) : "";
$ruta = isset($_POST["idrutas"]) ? limpiarCadena($_POST["idrutas"]) : "";
$tipo_pago = isset($_POST["tipo_pago"]) ? limpiarCadena($_POST["tipo_pago"]) : "";
$ticket_num = isset($_POST["ticket_num"]) ? limpiarCadena($_POST["ticket_num"]) : "";
$unidad_save = isset($_POST["unidad_save"]) ? limpiarCadena($_POST["unidad_save"]) : "";
$destino_save = isset($_POST["idrutas"]) ? limpiarCadena($_POST["idrutas"]) : "";
$folio = isset($_POST["folioVentaEfectivo"]) ? limpiarCadena($_POST["folioVentaEfectivo"]) : "";
$folioDolar = isset($_POST["folioVentaDolar"]) ? limpiarCadena($_POST["folioVentaDolar"]) : "";
$folioCxc = isset($_POST["folioVentaCxc"]) ? limpiarCadena($_POST["folioVentaCxc"]) : "";

$efectivo = isset($_POST["Efectivo"]) ? limpiarCadena($_POST["Efectivo"]) : "";
$cambioEfectivo = isset($_POST["cambioEfectivo"]) ? limpiarCadena($_POST["cambioEfectivo"]) : "";
$kilometro = isset($_POST["kilometro"]) ? limpiarCadena($_POST["kilometro"]) : "";

// info for RFC 
$claveRfc = isset($_POST["claveRfc"]) ? limpiarCadena($_POST["claveRfc"]) : "";
$nameRfc = isset($_POST["nameRfc"]) ? limpiarCadena($_POST["nameRfc"]) : "";
$codePostalRfc = isset($_POST["codePostalRfc"]) ? limpiarCadena($_POST["codePostalRfc"]) : "";
$pymentTypeRfc = isset($_POST["pymentTypeRfc"]) ? limpiarCadena($_POST["pymentTypeRfc"]) : "";
$regimenFiscalRfc = isset($_POST["regimenFiscalRfc"]) ? limpiarCadena($_POST["regimenFiscalRfc"]) : "";
$idventarfc = isset($_POST["idventarfc"]) ? limpiarCadena($_POST["idventarfc"]) : "";
$dateRfc = isset($_POST["dateRfc"]) ? limpiarCadena($_POST["dateRfc"]) : "";
$folioRfc = isset($_POST["folioRfc"]) ? limpiarCadena($_POST["folioRfc"]) : "";
$amountRfc = isset($_POST["amountRfc"]) ? limpiarCadena($_POST["amountRfc"]) : "";
$referencesRfc = isset($_POST["referencesRfc"]) ? limpiarCadena($_POST["referencesRfc"]) : "";
$cfdi = isset($_POST["cfdi"]) ? limpiarCadena($_POST["cfdi"]) : "";
$facturaPdf = isset($_POST["facturaPdf"]) ? limpiarCadena($_POST["facturaPdf"]) : "";
$qr = isset($_POST["qrRfc"]) ? limpiarCadena($_POST["qrRfc"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idventa)) {
			$rspta = $venta->insertar($idusuario, $auto, $pasajero, $tarjeta, $fecha_hora, $hora, $dolar, $total_venta, $ruta, $unidad, $tipo_pago, $ticket_num, $efectivo, $cxc, $kilometro);
			$rspta = $venta->getIdVenta();
			while ($reg = $rspta->fetch_object()) {
				echo $reg->idventa;
			}
		} else {
		}
		break;

	case 'listar':
		$rspta = $venta->listar();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"0" => '<button class="btn btn-primary" onclick="modalFactura(' . $reg->idventa . ',' . $reg->total_venta . ',' . $reg->idusuario . ',' . $reg->tipo_pago . ')"><li class="fa fa-pencil"></li></button> <button class="btn btn-success" onclick="print(' . $reg->idventa . ')"><li class="fa fa-print"></li></button>',
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
			echo '<option value=' . $reg->idunidad . '>' . $reg->clave . ' - ' . $reg->placa . '</option>';
		}
		break;

	case 'getUsuario':
		require_once "../modelos/Usuario.php";
		$usuario = new Usuario();

		$rspta = $usuario->getNombreUser($idusuario);

		while ($reg = $rspta->fetch_object()) {
			echo $reg->nombre;
		}
		break;

	case 'getVenta':
		require_once "../modelos/VentaDos.php";

		$rspta = $venta->getVenta($idventa);
		while ($reg = $rspta->fetch_object()) {
			echo $json = json_encode($reg);
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

	case 'selectClientes':
		require_once "../modelos/Clientes.php";
		$cliente = new Clientes();

		$rspta = $cliente->listarClientes();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idcliente . '>' . $reg->nombre . '</option>';
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

	case 'getIdVentaDolar':
		require_once "../modelos/VentaEfectivo.php";
		$ruta = new VentaEfectivo();

		$rspta = $ruta->getLastDolar();

		while ($reg = $rspta->fetch_object()) {
			echo $reg->iddolar;
		}
		break;

	case 'getIdVentaCxc':
		require_once "../modelos/VentaEfectivo.php";
		$ruta = new VentaEfectivo();

		$rspta = $ruta->getLastCxc();

		while ($reg = $rspta->fetch_object()) {
			echo $reg->idcxc;
		}
		break;


	case 'guardarIdEfectivo':
		require_once "../modelos/VentaEfectivo.php";
		$venta = new VentaEfectivo();
		$rspta = $venta->insertar($folio);
		break;
	case 'guardarIdDolar':
		require_once "../modelos/VentaEfectivo.php";
		printf($folioDolar);
		$venta = new VentaEfectivo();
		$rspta = $venta->insertDolarSale($folioDolar);
		break;
	case 'guardarIdCxc':
		require_once "../modelos/VentaEfectivo.php";
		$venta = new VentaEfectivo();
		$rspta = $venta->insertCxcSale($folioCxc);
		break;

	case 'getFolioVenta':
		$rspta = $venta->getIdVenta();
		while ($reg = $rspta->fetch_object()) {
			echo $reg->idventa;
		}
		break;

	case 'guardarFactura':
		require_once "../modelos/Facturas.php";
		$ruta = new Facturas();
		$rspta = $ruta->insertar($idventarfc, $dateRfc, $folioRfc, $cfdi, $facturaPdf, $qr);
		break;

	case 'facturar':
		getFactura(
			array(
				"CFDi" => array(
					"modo" => "debug",
					"versionCFDi" => "4.0",
					"versionEF" => "6.5",
					"serie" => "STO",
					"folioInterno" => $folioRfc,
					"fechaEmision" => $dateRfc,
					"subTotal" => $amountRfc,
					"total" => $amountRfc,
					"rfc" => "EIN1801307W7",
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
		'User' => 'EIN1801307W7',
		'Pass' => '2cdfaab1e1a7017233a2431d845ef7d1'
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