<?php

require_once '../modelos/Unidad.php';

$unidad = new Unidad();

$idunidad = isset($_POST["idunidad"]) ? limpiarCadena($_POST["idunidad"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$propietario = isset($_POST["propietario"]) ? limpiarCadena($_POST["propietario"]) : "";
$tipo_auto = isset($_POST["tipo_auto"]) ? limpiarCadena($_POST["tipo_auto"]) : "";

switch ($_GET["op"]) {
    case 'guardarEditar':
        if (empty($idunidad)) {
            $rspta = $unidad->insertar($clave, $propietario, $tipo_auto);
            echo $rspta ? "Unidad registrada" : "Unidad no se pudo registrar";
            
        } else {
            $rspta = $unidad->editar($idunidad, $clave, $propietario, $tipo_auto);
            echo $rspta ? "Unidad actualizada" : "Unidad no se pudo actualizar";
        }

        break;

    case 'eliminar':
        $rspta = $unidad->eliminar($idunidad);
        echo $rspta ? "Persona eliminada" : "Persona no se pudo eliminar";
        break;

    case 'mostrar':
        $rspta = $unidad->mostrar($idunidad);
        echo json_encode($rspta);
        break;

    case 'listarp':
        $rspta = $unidad->listarp();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" =>
                '<button class="btn btn-warning" onclick="mostrar(' . $reg->idunidad . ')"><li class="fa fa-pencil"></li></button>' .
                ' <button class="btn btn-danger" onclick="eliminar(' . $reg->idunidad . ')"><li class="fa fa-trash"></li></button>'
                ,
                "1" => $reg->clave,
                "2" => $reg->propietario,
                "3" => $reg->tipo_auto
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
        $rspta = $unidad->listarc();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" =>
                '<button class="btn btn-warning" onclick="mostrar(' . $reg->idunidad . ')"><li class="fa fa-pencil"></li></button>' .
                ' <button class="btn btn-danger" onclick="eliminar(' . $reg->idunidad . ')"><li class="fa fa-trash"></li></button>'
                ,
                "1" => $reg->clave,
                "2" => $reg->propietario,
                "3" => $reg->tipo_auto
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

?>