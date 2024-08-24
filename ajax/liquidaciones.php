<?php
if (strlen(session_id()) < 1)
	session_start();

require_once "../modelos/Liquidaciones.php";

$liquidacion = new Liquidaciones();


$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$concepto = isset($_POST["concepto"]) ? limpiarCadena($_POST["concepto"]) : "";
$numeroCheque = isset($_POST["numeroCheque"]) ? limpiarCadena($_POST["numeroCheque"]) : "";
$unidad = isset($_POST["idunidad"]) ? limpiarCadena($_POST["idunidad"]) : "";
$importe = isset($_POST["importe"]) ? limpiarCadena($_POST["importe"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$hora = isset($_POST["hour_save"]) ? limpiarCadena($_POST["hour_save"]) : "";
$movimiento = isset($_POST["movimiento"]) ? limpiarCadena($_POST["movimiento"]) : "";

switch ($_GET["op"]) {
	case 'guardar':
		if (empty($idventa)) {
			$rspta = $liquidacion->insertar($fecha_hora, $clave, $concepto, $numeroCheque, $unidad, $importe, $descripcion, $hora, $movimiento);
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		} else {
		}
		break;

	case 'listar':
		$rspta = $liquidacion->listar();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => 'lq-00' . $reg->idliquidacion,
				"1" => $reg->fecha,
				"2" => $reg->hora,
				"3" => $reg->movimiento,
				"4" => $reg->clave,
				"5" => $reg->concepto_clave,
				"6" => $reg->numero_cheque,
				"7" => $reg->clave,
				"8" => $reg->descripcion,
				"9" => esIngreso($reg->movimiento) ? $reg->importe : '0',
                "10" => esGasto($reg->movimiento) ? $reg->importe : '0' 
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
}
function esIngreso($movimiento)
{
    if ($movimiento == "Ingreso") {
        return true;
    } else {
        return false;
    }
}

function esGasto($movimiento)
{
    if ($movimiento == "Gasto") {
        return true;
    } else {
        return false;
    }
}
?>