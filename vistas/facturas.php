<?php
//Activacion de almacenamiento en buffer
ob_start();
//iniciamos las variables de session
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else //Agrega toda la vista
{
  require 'header.php';

  if ($_SESSION['almacen'] == 1) {
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Facturas

                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Fecha</th>
                    <th>xml</th>
                    <th>factura</th>
                    <th>QR</th>
                    <th>Folio factura</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Fecha</th>
                    <th>xml</th>
                    <th>factura</th>
                    <th>QR</th>
                    <th>Folio factura</th>
                  </tfoot>
                </table>
              </div>
              <!--Fin centro -->
              <form name="formRfc" id="formRfc" method="POST">
                <input type="hidden" name="idfactura" id="idfactura">
              </form>

            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php

  } //Llave de la condicion if de la variable de session
  else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
  <script src="./scripts/facturas.js"></script>

  <?php

}
ob_end_flush(); //liberar el espacio del buffer
?>