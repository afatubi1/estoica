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
                <h1 class="box-title">Marca <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i
                      class="fa fa-plus-circle"></i> Agregar</button></h1>
                <div class="box-tools pull-right"></div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <tr>
                      <th>Marca</th>
                      <th>Local</th>
                      <th>Horario</th>
                      <th>Informacion</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Marca</th>
                      <th>Local</th>
                      <th>Horario</th>
                      <th>Informacion</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Marca:</label>
                    <input type="text" class="form-control" name="marca_nombre" id="marca_nombre" placeholder="Marca">

                    <label>Local:</label>
                    <input type="text" class="form-control" name="local" id="local" placeholder="Local">

                    <label>Horario:</label>
                    <input type="text" class="form-control" name="horario" id="horario" placeholder="Horarios">

                    <label>Información:</label>
                    <input type="text" class="form-control" name="informacion" id="informacion" placeholder="Información">
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar
                      Marca</button>
                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i
                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
  <script type="text/javascript" src="scripts/marcas.js"></script>
  <?php
}
ob_end_flush();
?>