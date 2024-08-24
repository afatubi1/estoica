<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Eventos.php";

$eventos = new Eventos();

$evento = isset($_POST["evento"]) ? limpiarCadena($_POST["evento"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$hora = isset($_POST["hora"]) ? limpiarCadena($_POST["hora"]) : "";
$informacion = isset($_POST["informacion"]) ? limpiarCadena($_POST["informacion"]) : "";
$idevento = isset($_POST["idevento"]) ? limpiarCadena($_POST["idevento"]) : "";
$imagenes = [];
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_FILES["image$i"])) {
            $fileTmpPath = $_FILES["image$i"]['tmp_name'];
            $fileName = $_FILES["image$i"]['name'];
            $fileSize = $_FILES["image$i"]['size'];
            $fileType = $_FILES["image$i"]['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            
            $uploadFileDir = '../files/eventos/';
            $dest_path = $uploadFileDir . $fileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagenes[] = $dest_path; // Agregar la ruta al array de imágenes
            }
        }
    }

switch ($_GET["op"]) {
    case 'guardaryeditar':        
        if (empty($idevento)) {
            $rspta = $eventos->insertar($evento, $fecha, $hora, $informacion, $imagenes);
            echo $rspta ? "Evento registrado" : "No se pudieron registrar todos los datos del evento";
        } else {
            $rspta = $eventos->editar($idevento, $evento, $fecha, $hora, $informacion, $imagenes);
            echo $rspta ? "Evento actualizado" : "No se pudieron actualizar los datos del evento";
        }
        break;

    case 'listar':
        $rspta = $eventos->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "idevento" => $reg->idevento,
                "evento" => $reg->nombre,
                "fecha" => $reg->fecha,
                "hora" => $reg->hora,
                "informacion" => $reg->informacion
            );
        }

        echo json_encode($data);
        break;
    case 'getevento':
        $rspta = $eventos->getevento($idevento);
        echo json_encode($rspta);
        break;
}
?>