<?php

require_once '../modelos/Persona.php';
require_once '../modelos/ChoferModel.php';

$persona = new Persona();

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$tipo_persona = isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]) : "";
$nombre = isset($_POST["nombreChofer"]) ? limpiarCadena($_POST["nombreChofer"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$ine = isset($_POST["ine"]) ? limpiarCadena($_POST["ine"]) : "";
$licencia = isset($_POST["licencia"]) ? limpiarCadena($_POST["licencia"]) : "";
$imgChofer = isset($_POST["imgChofer"]) ? limpiarCadena($_POST["imgChofer"]) : "";
$telefonoReferencia = isset($_POST["telefonoR"]) ? limpiarCadena($_POST["telefonoR"]) : "";
$tia = isset($_POST["tia"]) ? limpiarCadena($_POST["tia"]) : "";

$Curp = isset($_POST["Curp"]) ? limpiarCadena($_POST["Curp"]) : "";
$antecedentesPenales = isset($_POST["antecedentesPenales"]) ? limpiarCadena($_POST["antecedentesPenales"]) : "";
$aptitudPsicofisica = isset($_POST["aptitudPsicofisica"]) ? limpiarCadena($_POST["aptitudPsicofisica"]) : "";
$comprobanteDomicilio = isset($_POST["comprobanteDomicilio"]) ? limpiarCadena($_POST["comprobanteDomicilio"]) : "";


switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idpersona)) {
            if ($_FILES['imgChofer']['type'] == "image/jpg" || $_FILES['imgChofer']['type'] == "image/jpeg" || $_FILES['imgChofer']['type'] == "image/png") {
                $directorioDestino = '../files/documentos/';

                $imgChofer = moverArchivo('imgChofer', $directorioDestino);
                $ine = moverArchivo('ine', $directorioDestino);
                $licencia = moverArchivo('licencia', $directorioDestino);
                $tia = moverArchivo('tia', $directorioDestino);

                $Curp = moverArchivo('Curp', $directorioDestino);
                $antecedentesPenales = moverArchivo('antecedentesPenales', $directorioDestino);
                $aptitudPsicofisica = moverArchivo('aptitudPsicofisica', $directorioDestino);
                $comprobanteDomicilio = moverArchivo('comprobanteDomicilio', $directorioDestino);

                $choferModel = new ChoferModel($tipo_persona, $nombre, $tipo_documento, $direccion, $telefono, $email, $ine, $licencia, $imgChofer, $tia, $telefonoReferencia, $Curp, $antecedentesPenales, $aptitudPsicofisica, $comprobanteDomicilio);

                $rspta = $persona->insertar($choferModel);
                echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
            } else {
                echo "Error al intentar agregar imagen";
            }

        } else {
            $rspta = $persona->editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $telefonoReferencia);
            echo $rspta ? "Persona editada" : "Persona no se pudo registrar";
        }
        break;

    case 'editarCurp':
        $directorioDestino = '../files/documentos/';
        $Curp = moverArchivo('Curp', $directorioDestino);

        $rspta = $persona->editarCurp($idpersona, $Curp);
        echo $rspta ? "Imagen editada" : "No se pudo editar Imagen";
        break;

    case 'editarComprobante':
        $directorioDestino = '../files/documentos/';
        $comprobanteDomicilio = moverArchivo('comprobanteDomicilio', $directorioDestino);

        $rspta = $persona->editarComprobante($idpersona, $comprobanteDomicilio);
        echo $rspta ? "Imagen editada" : "No se pudo editar Imagen";
        break;

    case 'editarAptitud':
        $directorioDestino = '../files/documentos/';
        $aptitudPsicofisica = moverArchivo('aptitudPsicofisica', $directorioDestino);

        $rspta = $persona->editarImagen($idpersona, $aptitudPsicofisica);
        echo $rspta ? "Imagen editada" : "No se pudo editar Imagen";
        break;

    case 'editarAntecedentes':
        $directorioDestino = '../files/documentos/';
        $antecedentesPenales = moverArchivo('antecedentesPenales', $directorioDestino);

        $rspta = $persona->editarImagen($idpersona, $antecedentesPenales);
        echo $rspta ? "Imagen editada" : "No se pudo editar Imagen";
        break;

    case 'editarImagen':
        $directorioDestino = '../files/documentos/';
        $imgChofer = moverArchivo('imgChofer', $directorioDestino);

        $rspta = $persona->editarImagen($idpersona, $imgChofer);
        echo $rspta ? "Imagen editada" : "No se pudo editar Imagen";
        break;

    case 'editarIne':
        $directorioDestino = '../files/documentos/';
        $ine = moverArchivo('ine', $directorioDestino);

        $rspta = $persona->editarIne($idpersona, $ine);
        echo $rspta ? "Ine editada" : "No se pudo editar INE";
        break;

    case 'editarLicencia':
        $directorioDestino = '../files/documentos/';
        $licencia = moverArchivo('licencia', $directorioDestino);

        $rspta = $persona->editarLicenia($idpersona, $licencia);
        echo $rspta ? "Licencia editada" : "No se pudo editar Licencia";
        break;

    case 'editarTia':
        $directorioDestino = '../files/documentos/';
        $tia = moverArchivo('tia', $directorioDestino);

        $rspta = $persona->editarTia($idpersona, $tia);
        echo $rspta ? "Tia editada" : "No se pudo editar Tia";
        break;

    case 'eliminar':
        $rspta = $persona->eliminar($idpersona);
        echo $rspta ? "Persona eliminada" : "Persona no se pudo eliminar";
        break;

    case 'mostrar':
        $rspta = $persona->mostrar($idpersona);
        echo json_encode($rspta);
        break;

    case 'listarp':
        $rspta = $persona->listarp();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" =>
                '<button class="btn btn-warning" onclick="mostrar(' . $reg->idpersona . ')"><li class="fa fa-pencil"></li></button>' .
                ' <button class="btn btn-danger" onclick="eliminar(' . $reg->idpersona . ')"><li class="fa fa-trash"></li></button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_documento,
                "3" => $reg->telefono,
                "4" => $reg->email
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

    case 'listarc':
        $rspta = $persona->listarc();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" =>
                '<button class="btn btn-warning" onclick="mostrar(' . $reg->idpersona . ')"><li class="fa fa-pencil"></li></button>' .
                '<button class="btn btn-primary" onclick="info(' . $reg->idpersona . ')"><li class="fa fa-eye"></li></button>' .
                '<button class="btn btn-danger" onclick="eliminar(' . $reg->idpersona . ')"><li class="fa fa-trash"></li></button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_documento,
                "3" => $reg->telefono,
                "4" => $reg->email
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

function moverArchivo($nombreCampo, $rutaDestino)
{
    if (isset($_FILES[$nombreCampo]) && $_FILES[$nombreCampo]['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES[$nombreCampo]['name'];
        $rutaArchivoTemporal = $_FILES[$nombreCampo]['tmp_name'];
        $rutaArchivoDestino = $rutaDestino . $nombreArchivo;

        if (move_uploaded_file($rutaArchivoTemporal, $rutaArchivoDestino)) {
            return $rutaArchivoDestino;
        } else {
            return "error";
        }
    }
}
?>