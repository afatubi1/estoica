<?php
require '../config/conexion.php';
require_once '../modelos/ChoferModel.php';

class Persona
{
    public function __construct()
    {

    }

    public function insertar($choferModel)
    {
        $sql = "INSERT INTO persona (
                    tipo_persona,
                    nombre,
                    tipo_documento,
                    num_documento,
                    direccion,
                    telefono,
                    email,
                    ine,
                    licencia,
                    imgChofer,
                    tia,
                    telefonoReferencia,
                    Curp,
                    antecedentesPenales,
                    aptitudPsicofisica,
                    comprobanteDomicilio
                   ) 
                    VALUES (
                        '$choferModel->tipo_persona',
                        '$choferModel->nombre',
                        '$choferModel->tipo_documento',
                        '',
                        '$choferModel->direccion',
                        '$choferModel->telefono',
                        '$choferModel->email',
                        '$choferModel->ine',
                        '$choferModel->licencia',
                        '$choferModel->imgChofer',
                        '$choferModel->tia',
                        '$choferModel->telefonoReferencia',
                        '$choferModel->Curp',
                        '$choferModel->antecedentesPenales',
                        '$choferModel->aptitudPsicofisica',
                        '$choferModel->comprobanteDomicilio'
                        )";

        return ejecutarConsulta($sql);
    }

    public function editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email,$telefonoReferencia)
    {
        $sql = "UPDATE persona SET 
                    tipo_persona='$tipo_persona', 
                    nombre='$nombre',
                    tipo_documento='$tipo_documento',
                    num_documento='$num_documento',
                    direccion='$direccion',
                    telefono='$telefono',
                    email='$email'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }


    public function eliminar($idpersona)
    {
        $sql = "DELETE FROM persona 
                   WHERE idpersona='$idpersona'";

        return ejecutarConsulta($sql);
    }


    //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
    public function mostrar($idpersona)
    {
        $sql = "SELECT * FROM persona 
                    WHERE idpersona='$idpersona'";

        return ejecutarConsultaSimpleFila($sql);
    }

    //METODO PARA LISTAR LOS REGISTROS
    public function listarp()
    {
        $sql = "SELECT * FROM persona";

        return ejecutarConsulta($sql);
    }

    public function listarc()
    {
        $sql = "SELECT * FROM persona";

        return ejecutarConsulta($sql);
    }

    //  editar documentos !!
    public function editarImagen($idpersona, $imgChofer)
    {
        $sql = "UPDATE persona
                    SET imgChofer = '$imgChofer'
                    WHERE idpersona='$idpersona'";

        return ejecutarConsulta($sql);
    }

    public function editarIne($idpersona, $ine)
    {
        $sql = "UPDATE persona 
                    SET ine = '$ine'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }

    public function editarLicenia($idpersona, $licencia)
    {
        $sql = "UPDATE persona
                    SET licencia = '$licencia'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }

    public function editarTia($idpersona, $tia)
    {
        $sql = "UPDATE persona 
                    SET tia = '$tia'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }


    // new grup
    public function editarCurp($idpersona, $Curp)
    {
        $sql = "UPDATE persona 
                    SET Curp = '$Curp'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }

    public function editarComprobante($idpersona, $comprobanteDomicilio)
    {
        $sql = "UPDATE persona 
                    SET comprobanteDomicilio = '$comprobanteDomicilio'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }

    public function editarAptitud($idpersona, $aptitudPsicofisica)
    {
        $sql = "UPDATE persona 
                    SET aptitudPsicofisica = '$aptitudPsicofisica'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }

    public function editarAntecedentes($idpersona, $antecedentesPenales)
    {
        $sql = "UPDATE persona 
                    SET antecedentesPenales = '$antecedentesPenales'
                    WHERE idpersona='$idpersona '";

        return ejecutarConsulta($sql);
    }

}

?>