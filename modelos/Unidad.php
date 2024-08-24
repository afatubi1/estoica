<?php
    require '../config/conexion.php';

    Class Unidad
    {
        public function __construct()
        {

        }

        public function insertar($clave,$propietario,$tipo_auto)
        {
            $sql = "INSERT INTO unidad (
                    clave,
                    propietario,
                    tipo_auto,
                    status
                   )
                    VALUES (
                        '$clave',
                        '$propietario',
                        '$tipo_auto',
                        '1'
                        )";

            return ejecutarConsulta($sql);
        }

        public function editar($idunidad,$clave,$propietario,$tipo_auto)
        {
            $sql = "UPDATE unidad SET
                    clave='$clave',
                    propietario='$propietario',
                    tipo_auto='$tipo_auto'
                    WHERE idunidad='$idunidad '";

            return ejecutarConsulta($sql);
        }


        public function eliminar($idunidad)
        {
            $sql= "DELETE FROM unidad
                   WHERE idunidad='$idunidad'";

            return ejecutarConsulta($sql);
        }


        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idunidad)
        {
            $sql = "SELECT * FROM unidad
                    WHERE idunidad='$idunidad'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listarp()
        {
            $sql = "SELECT * FROM unidad
                    WHERE status='1'";

            return ejecutarConsulta($sql);
        }

        public function listarc()
        {
            $sql = "SELECT * FROM unidad
                    WHERE status='1'";

            return ejecutarConsulta($sql);
        }

    }

?>
