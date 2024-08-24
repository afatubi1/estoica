<?php
    require '../config/conexion.php';

    Class Ruta
    {
        public function __construct()
        {

        }

        public function insertar($ruta_direccion,$ruta_precio)
        {
            $sql = "INSERT INTO ruta (
                    ruta_direccion,
                    ruta_precio,
                    status
                   )
                    VALUES (
                        '$ruta_direccion',
                        '$ruta_precio','1'
                        )";

            return ejecutarConsulta($sql);
        }

        public function editar($idruta,$ruta_direccion,$ruta_precio)
        {
            $sql = "UPDATE ruta SET
                    ruta_direccion='$ruta_direccion',
                    ruta_precio='$ruta_precio'
                    WHERE idruta='$idruta '";

            return ejecutarConsulta($sql);
        }


        public function eliminar($idruta)
        {
            $sql= "DELETE FROM ruta
                   WHERE idruta='$idruta'";

            return ejecutarConsulta($sql);
        }


        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idruta)
        {
            $sql = "SELECT * FROM ruta
                    WHERE idruta='$idruta'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listarp()
        {
            $sql = "SELECT * FROM ruta
                    WHERE status='1'";

            return ejecutarConsulta($sql);
        }

        public function listarc()
        {
            $sql = "SELECT * FROM ruta
                    WHERE status='1'";

            return ejecutarConsulta($sql);
        }

    }

?>
