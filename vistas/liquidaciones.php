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
                <h1 class="box-title">Liquidaciones <button class="btn btn-success" id="btnagregar"
                    onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nueva liquidacion </button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>movimiento</th>
                    <th>clave</th>
                    <th>concepto clave</th>
                    <th>numero cheque</th>
                    <th>unidad</th>
                    <th>descripcion</th>
                    <th>Ingreso</th>
                    <th>Gasto</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                  <th>Folio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>movimiento</th>
                    <th>clave</th>
                    <th>concepto clave</th>
                    <th>numero cheque</th>
                    <th>unidad</th>
                    <th>descripcion</th>
                    <th>Ingreso</th>
                    <th>Gasto</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form name="formLiquidacion" id="formLiquidacion" method="POST">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Fecha(*):</label>
                    <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                    <input type="hidden" name="hour_save" id="hour_save">
                    </br>
                    <label>Clave: </label>
                    <input type="text" class="form-control" name="clave" id="clave" maxlength="7" placeholder="Clave">
                    </br>
                    <label>Concepto clave:</label>
                    <input type="text" class="form-control" name="concepto" id="concepto" maxlength="10"
                      placeholder="Concepto clave:" required="">
                    </br>
                    <label>Numero cheque:</label>
                    <input type="text" class="form-control" name="numeroCheque" id="numeroCheque" maxlength="10"
                      placeholder="Numero cheque" required="">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Detalle: </label>
                    </br></br>
                    <label>Unidad:</label>
                    <select id="idunidad" name="idunidad" class="form-control selectpicker" data-live-search="true"
                      required>
                    </select>
                    </br>
                    <label>Importe:</label>
                    <input type="text" class="form-control" name="importe" id="importe" required="">
                    </br>
                    <label>Descripción:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" required="">
                    </br>
                    <label>Movimiento:</label>
                    <select name="movimiento" id="movimiento" class="form-control selectpicker" required="">
                      <option value="Ingreso">Ingreso</option>
                      <option value="Gasto">Gasto</option>
                    </select>
                  </div>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar
                  liquidacion</button>
                <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i
                    class="fa fa-arrow-circle-left"></i> Cancelar</button>
              </div>
              </form>
            </div>
            <!--Fin centro -->
          </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <div class="center">
              <img src="https://taxalaifa.com/taxal/taxal2.png" width="150" height="180" />
              <div class="text-center">
                <div class="spinner-border" role="status" id="load" name="load">
                </div>
              </div>
              <div class="modal-header">
              </div>
              <div class="modal-body">
                <form name="formRfc" id="formRfc" method="POST">
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="getFactura()">Facturar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
      <script type="text/javascript" src="scripts/liquidaciones.js"></script>
      <script src="plugin_impresora_termica"></script>

      <?php
}
ob_end_flush();
?>