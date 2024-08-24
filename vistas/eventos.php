<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
    require 'header.php';

    if ($_SESSION['ventas'] == 1) {
        ?>
        <!-- Contenido -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Eventos </br></br><button class="btn btn-success" id="btnagregar"
                                        onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Evento</button>
                                </h1>
                                <div class="box-tools pull-right"></div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th>Editar</th>
                                            <th>Evento</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Información</th>
                                            <th>Folio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Editar</th>
                                            <th>Evento</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Información</th>
                                            <th>Folio</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="panel-body" style="height: 1000px;" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <input type="hidden" name="idevento" id="idevento">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Evento:</label>
                                        <input type="text" class="form-control" name="evento" id="evento" placeholder="Evento">

                                        <label for="fecha">Fecha:</label>
                                        <input type="date" class="form-control" id="fecha" name="fecha">
                                        </br>
                                        <label>Hora(*):</label>
                                        <input type="time" id="hora" name="hora">
                                        </br> </br>
                                        <label>Información:</label>
                                        <input type="text" class="form-control" name="informacion" id="informacion"
                                            placeholder="Información">
                                        </br>
                                        <label for="image">Seleccionar imagen 1:</label>
                                        <input type="file" class="form-control" id="image1" name="image1">
                                        <label for="image">Seleccionar imagen 2:</label>
                                        <input type="file" class="form-control" id="image2" name="image2">
                                        <label for="image">Seleccionar imagen 3:</label>
                                        <input type="file" class="form-control" id="image3" name="image3">
                                        <label for="image">Seleccionar imagen 4:</label>
                                        <input type="file" class="form-control" id="image4" name="image4">
                                        <label for="image">Seleccionar imagen 5:</label>
                                        <input type="file" class="form-control" id="image5" name="image5">
                                        <label for="image">Seleccionar imagen 6:</label>
                                        <input type="file" class="form-control" id="image6" name="image6">
                                        <label for="image">Seleccionar imagen 7:</label>
                                        <input type="file" class="form-control" id="image7" name="image7">
                                        <label for="image">Seleccionar imagen 8:</label>
                                        <input type="file" class="form-control" id="image8" name="image8">
                                        <label for="image">Seleccionar imagen 9:</label>
                                        <input type="file" class="form-control" id="image9" name="image9">
                                        <label for="image">Seleccionar imagen 10:</label>
                                        <input type="file" class="form-control" id="image10" name="image10">

                                        </br> </br>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar">
                                                <i class="fa fa-save"></i>
                                                Guardar evento</button>
                                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                </form>
                            </div>
                            <!-- Fin centro -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <!-- Fin-Contenido -->

        <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/eventos.js"></script>
    <?php
}
ob_end_flush();
?>