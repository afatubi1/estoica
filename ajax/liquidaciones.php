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
				$directorioDestino = "../files/documentos/";
				$nombreArchivo = basename($_FILES["imagen"]["name"]);
				$rutaArchivo = $directorioDestino . $nombreArchivo;

				$tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
				if (in_array($tipoArchivo, ["jpg", "jpeg", "png", "gif", "jfif"])) {
					if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
						echo "✅ La imagen principal se ha subido correctamente.<br>";
						$imagen = $rutaArchivo;

						// Imagen secundaria o PDF
						$imagen_dos = null;
						if (isset($_FILES["imagen_dos"]) && $_FILES["imagen_dos"]["error"] == 0) {
							$nombreArchivo2 = basename($_FILES["imagen_dos"]["name"]);
							$rutaArchivo2 = $directorioDestino . $nombreArchivo2;
							$tipoArchivo2 = strtolower(pathinfo($rutaArchivo2, PATHINFO_EXTENSION));

							// Aceptar imágenes y PDF
							if (in_array($tipoArchivo2, ["jpg", "jpeg", "png", "gif", "jfif", "pdf"])) {
								if (move_uploaded_file($_FILES["imagen_dos"]["tmp_name"], $rutaArchivo2)) {
									echo "✅ La imagen secundaria o documento PDF se ha subido correctamente.<br>";
									$imagen_dos = $rutaArchivo2;
								} else {
									echo "❌ Error al subir la imagen secundaria o PDF.<br>";
								}
							} else {
								echo "❌ El archivo secundario debe ser imagen o PDF. Tipo recibido: $tipoArchivo2<br>";
							}
						}

						// Guardar en base de datos
						$rspta = $liquidacion->insertar(
							$fecha_hora,
							$clave_l,
							$concepto,
							$numeroCheque,
							$unidad,
							$importe,
							$descripcion,
							$hora,
							$movimiento,
							$plaza,
							$imagen,
							$idusuario,
							$forma_pago,
							$imagen_dos
						);
						echo $rspta ? "✅ Egreso registrado." : "❌ No se pudieron registrar todos los datos del egreso.";

					} else {
						echo "❌ Hubo un error al guardar la imagen principal.";
					}
				} else {
					echo "❌ El archivo principal no es un tipo de imagen válido.";
				}
			} else {
				echo "❌ No se recibió la imagen principal.";
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
				"0" => '<button class="btn btn-info" onclick="mostrarImagen(\'' . $reg->imagen . '\')"><i class="fa fa-picture-o"></i></button><button class="btn btn-info" onclick="openDoc(\'' . $reg->imagen_dos . '\')"><i class="fa fa-picture-o"></i></button>' .
					'<button class="btn btn-info" onclick="print(\'' . $reg->idliquidacion . '\')"><i class="fa fa-print"></i></button>',
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
				"11" => esIngreso($reg->movimiento) ? '$ ' . $reg->importe : '$ 0.00',
				"12" => esGasto($reg->movimiento) ? '$ ' . $reg->importe : '$ 0.00',
				"13" => 'EGRE-00' . $reg->idliquidacion
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