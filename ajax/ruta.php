<?php

    require_once '../modelos/Ruta.php';

    $ruta = new Ruta();

    $idruta=isset($_POST["idruta"])? limpiarCadena($_POST["idruta"]):"";
    $ruta_direccion=isset($_POST["ruta_direccion"])? limpiarCadena($_POST["ruta_direccion"]):"";
    $ruta_precio=isset($_POST["ruta_precio"])? limpiarCadena($_POST["ruta_precio"]):"";


    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idruta)){
                $rspta=$ruta->insertar($ruta_direccion,$ruta_precio);
                echo $rspta ? "Ruta registrada" : "Ruta no registrada";
            }
            else {
                $rspta=$ruta->editar($idruta,$ruta_direccion,$ruta_precio);
                echo $rspta ? "Ruta actualizada" : "Ruta no actualizada";
            }
        break;

        case 'eliminar':
                $rspta = $ruta->eliminar($idruta);
                echo $rspta ? "Ruta eliminada" : "Ruta no eliminada";
        break;

        case 'mostrar':
            $rspta = $ruta->mostrar($idruta);
            echo json_encode($rspta);
        break;

        case 'listarp':
            $rspta = $ruta->listarp();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idruta.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="eliminar('.$reg->idruta.')"><li class="fa fa-trash"></li></button>'
                        ,
                    "1"=>$reg->ruta_direccion,
                    "2"=>$reg->ruta_precio
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);
        break;

        case 'listarc':
            $rspta = $ruta->listarc();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idruta.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="eliminar('.$reg->idruta.')"><li class="fa fa-trash"></li></button>'
                        ,
                    "1"=>$reg->ruta_direccion,
                    "2"=>$reg->ruta_precio
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);
        break;
    }

?>
