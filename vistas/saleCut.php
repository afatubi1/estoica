<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['ventas'] == 1) {
    ?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Corte de Venta
                </h1>
                <label>Numero Ticket</label>
                <input type="text" class="form-control" name="ticketNum" id="ticketNum" required="" placeholder="Ticket">
                </br>
                <button type="button" class="btn btn-success" onclick="listForTicket()" id="qr" name="qr">Obtener
                  Ventas</button>
                </br>

                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Facturacion</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Placa</th>
                    <th>Usuario</th>
                    <th>Vehiculo</th>
                    <th>Ruta</th>
                    <th>Km</th>
                    <th>Pasajeros</th>
                    <th>Forma de pago</th>
                    <th>Tarjeta</th>
                    <th>Dolar</th>
                    <th>Efectivo</th>
                    <th>CXC</th>
                    <th>Ticket numero</th>
                    <th>Folio</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Facturacion</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Placa</th>
                    <th>Usuario</th>
                    <th>Vehiculo</th>
                    <th>Ruta</th>
                    <th>Km</th>
                    <th>Pasajeros</th>
                    <th>Forma de pago</th>
                    <th>Tarjeta</th>
                    <th>Dolar</th>
                    <th>Efectivo</th>
                    <th>CXC</th>
                    <th>Ticket numero</th>
                    <th>Folio</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">

              </div>
              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/saleCut.js"></script>
  <?php
}
ob_end_flush();
?>