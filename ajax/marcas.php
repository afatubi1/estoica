<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Marcas.php";

$marcas = new Marcas();

$brand_name = isset($_POST["marca_nombre"]) ? limpiarCadena($_POST["marca_nombre"]) : "";
$local_number = isset($_POST["local"]) ? limpiarCadena($_POST["local"]) : "";
$horario = isset($_POST["horario"]) ? limpiarCadena($_POST["horario"]) : "";
$information = isset($_POST["informacion"]) ? limpiarCadena($_POST["informacion"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $marcas->insertar($brand_name, $local_number, $horario, $information);
            echo $rspta ? "Marca registrada" : "No se pudieron registrar todos los datos de la marca";
        } else {
            // En caso de que haya un método para editar, se incluiría aquí
            // Ejemplo: $rspta = $marcas->editar($id, $brand_name, $local_number, $horario, $information);
            echo $rspta ? "Marca actualizada" : "No se pudieron actualizar los datos de la marca";
        }
        break;

    case 'listar':
        $rspta = $marcas->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "brand_name" => $reg->brand_name,
                "local_number" => $reg->local_number,
                "horario" => $reg->horario,
                "information" => $reg->information
            );
        }

        echo json_encode($data);
        break;
}
?>