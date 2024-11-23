<?php
if (strlen(session_id()) < 1)
	session_start();

require_once "../modelos/Liquidaciones.php";

$liquidacion = new Liquidaciones();


$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$clave_l = isset($_POST["clave_l"]) ? limpiarCadena($_POST["clave_l"]) : "";
$concepto = isset($_POST["concepto"]) ? limpiarCadena($_POST["concepto"]) : "";
$numeroCheque = isset($_POST["numeroCheque"]) ? limpiarCadena($_POST["numeroCheque"]) : "";
$unidad = isset($_POST["idunidad"]) ? limpiarCadena($_POST["idunidad"]) : "";
$importe = isset($_POST["importe"]) ? limpiarCadena($_POST["importe"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$hora = isset($_POST["hour_save"]) ? limpiarCadena($_POST["hour_save"]) : "";
$movimiento = isset($_POST["movimiento"]) ? limpiarCadena($_POST["movimiento"]) : "";
$plaza = isset($_POST["plaza"]) ? limpiarCadena($_POST["plaza"]) : "";
$idusuario = $_SESSION["idusuario"];
$idliquidacion = isset($_POST["idliquidacion"]) ? limpiarCadena($_POST["idliquidacion"]) : "";
$forma_pago = isset($_POST["forma_pago"]) ? limpiarCadena($_POST["forma_pago"]) : "";

switch ($_GET["op"]) {
	case 'guardar':
		if (empty($idliquidacion)) {
			if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
				// Ruta y nombre del archivo a guardar
				$directorioDestino = "../files/documentos/"; // Carpeta donde guardarás las imágenes
				$nombreArchivo = basename($_FILES["imagen"]["name"]);
				$rutaArchivo = $directorioDestino . $nombreArchivo;

				// Asegúrate de que sea un tipo de archivo de imagen
				$tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
				if (in_array($tipoArchivo, ["jpg", "jpeg", "png", "gif", "jfif"])) {
					// Mueve el archivo a la carpeta de destino
					if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
						echo "La imagen se ha subido correctamente.";
						$imagen = $rutaArchivo; // Guarda la ruta en la variable
						$rspta = $liquidacion->insertar($fecha_hora, $clave_l, $concepto, $numeroCheque, $unidad, $importe, $descripcion, $hora, $movimiento, $plaza, $imagen, $idusuario,$forma_pago);
						echo $rspta ? "Egreso registrado" : "No se pudieron registrar todos los datos del egreso";
					} else {
						echo "Hubo un error al guardar la imagen.";
					}
				} else {
					echo "El archivo no es un tipo de imagen válido.";
				}
			} else {
				echo "No se ha subido ninguna imagen.";
			}

		} else {
		}
		break;

	case 'listar':
		$rspta = $liquidacion->listar();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<button class="btn btn-info" onclick="mostrarImagen(\'' . $reg->imagen . '\')"><li class="fa fa-picture-o"></li></button><button class="btn btn-info" onclick="print(\'' . $reg->idliquidacion . '\')"><li class="fa fa-print"></li></button>',
				"1" => $reg->fecha,
				"2" => $reg->hora,
				"3" => $reg->nombre,
				"4" => $reg->movimiento,
				"5" => $reg->clave_l,
				"6" => $reg->concepto_clave,
				"7" => $reg->numero_cheque,
				"8" => $reg->clave,
				"9" => $reg->descripcion,
				"10" => $reg->forma_pago,
				"11" => esIngreso($reg->movimiento) ? $reg->importe : '0',
				"12" => esGasto($reg->movimiento) ? $reg->importe : '0',
				"13" => 'lq-00' . $reg->idliquidacion
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
	case 'getLiquidacion':
		$rspta = $liquidacion->getLiquidacion($idliquidacion);
		while ($reg = $rspta->fetch_object()) {
			echo $json = json_encode($reg);
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
	if ($movimiento == "Egreso") {
		return true;
	} else {
		return false;
	}
}
?>