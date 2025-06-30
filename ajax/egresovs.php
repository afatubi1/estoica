<?php
if (strlen(session_id()) < 1) {
	session_start();
}

require_once "../modelos/Ingresosvs.php";

$ingresos = new Ingresosvs();

$fechaInicio = isset($_POST["fechaInicio"]) ? limpiarCadena($_POST["fechaInicio"]) : "";
$fechaFin = isset($_POST["fechaFin"]) ? limpiarCadena($_POST["fechaFin"]) : "";
$idunidad = isset($_POST["idunidad"]) ? limpiarCadena($_POST["idunidad"]) : "";

function validarFecha1($fecha)
{
	$d = DateTime::createFromFormat('Y-m-d', $fecha);
	return $d && $d->format('Y-m-d') === $fecha;
}

// Validación de parámetros
if (!validarFecha1($fechaInicio) || !validarFecha1($fechaFin)) {
	echo json_encode(["error" => "Formato de fecha inválido"]);
	exit();
}
if (!is_numeric($idunidad)) {
	echo json_encode(["error" => "ID de unidad inválido"]);
	exit();
}

	switch ($_GET["op"]) {
		case 'listar':
			// Llamada a la base de datos
			$rspta = $ingresos->listar($fechaInicio, $fechaFin, $idunidad);
			$data = array();

			if ($rspta) {
				while ($reg = $rspta->fetch_object()) {
					if ($reg) {  // Verificar que $reg sea válido
						$data[] = array(
							"0" => $reg->fecha,
							"1" => $reg->hora,
							"2" => $reg->nombre,
							"3" => 'Uni-00' . $reg->clave . ' - ' . $reg->placa,
							"4" => $reg->tipo_pago,
							"5" => $reg->efectivo,
							"6" => $reg->tarjeta,
							"7" => $reg->dolar,
							"8" => $reg->cxc,
							"9" => fillTranfer($reg->transferencias),
							"10" => 'ESTOI-00' . $reg->idventa,
						);
					}
				}
			}

			$results = array(
				"sEcho" => 1,
				"iTotalRecords" => count($data),
				"iTotalDisplayRecords" => count($data),
				"aaData" => $data
			);
			echo json_encode($results);
			break;

		default:
			echo json_encode(["error" => "Operación no válida"]);
			break;
		case 'listarEgresos':
			$rspta = $ingresos->listarEgresos($fechaInicio, $fechaFin, $idunidad);
			$data = array();

			if ($rspta) {
				while ($reg = $rspta->fetch_object()) {
					if ($reg) {  // Verificar que $reg sea válido
						$data[] = array(
							"0" => $reg->nombre,
							"1" => 'Eg-00' . $reg->idliquidacion,
							"2" => $reg->fecha,
							"3" => $reg->hora,
							"4" => $reg->movimiento,
							"5" => $reg->clave_l,
							"6" => $reg->concepto_clave,
							"7" => $reg->numero_cheque,
							"8" => $reg->clave,
							"9" => $reg->descripcion,
							"10" => $reg->forma_pago,
							"11" => esIngreso1($reg->movimiento) ? $reg->importe : '0',
							"12" => esGasto1($reg->movimiento) ? $reg->importe : '0',
						);
					}
				}
			}

			$results = array(
				"sEcho" => 1,
				"iTotalRecords" => count($data),
				"iTotalDisplayRecords" => count($data),
				"aaData" => $data
			);
			echo json_encode($results);
			break;
	}
	function esIngreso1($movimiento)
	{
		if ($movimiento == "Ingreso") {
			return true;
		} else {
			return false;
		}
	}
	
	function esGasto1($movimiento)
	{
		if ($movimiento == "Egreso") {
			return true;
		} else {
			return false;
		}
	}

	function fillTranfer($transfer)
	{
		if ($transfer == "") {
			return "0";
		} else {
			return $transfer;
		}
	}
?>