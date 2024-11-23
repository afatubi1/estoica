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
                <h1 class="box-title">Egresos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i
                      class="fa fa-plus-circle"></i> Nuevo Egreso </button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Evidencia</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Usuario</th>
                    <th>Movimiento</th>
                    <th>Clave</th>
                    <th>Concepto clave</th>
                    <th>Folio del comprobante:</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Forma de pago</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Folio</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Evidencia</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Usuario</th>
                    <th>Movimiento</th>
                    <th>Clave</th>
                    <th>Concepto clave</th>
                    <th>Folio del comprobante:</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Forma de pago</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Folio</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 600px;" id="formularioregistros">
                <form name="formLiquidacion" id="formLiquidacion" method="POST" enctype="multipart/form-data">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Fecha(*):</label>
                    <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                    <input type="hidden" name="hour_save" id="hour_save">
                    <input type="hidden" name="idliquidacion" id="idliquidacion">

                    <br>
                    <label>Movimiento:</label>
                    <select name="movimiento" id="movimiento" class="form-control selectpicker" required="true">
                      <option value="Ingreso">Ingreso</option>
                      <option value="Egreso">Egreso</option>
                    </select>
                    <label>Forma de pago:</label>
                    <select name="forma_pago" id="forma_pago" class="form-control selectpicker" required="true">
                      <option value="Efectivo">Efectivo</option>
                      <option value="Tarjeta">Tarjeta</option>
                    </select>

                    <label>Concepto clave:</label>
                    <select name="concepto" id="concepto" class="form-control selectpicker" required="true">
                      <option value="Gasolina">Gasolina</option>
                      <option value="Peaje">Peaje</option>
                      <option value="Servicios">Servicios</option>
                      <option value="Prestamos personales">Prestamos personales</option>
                      <option value="Gastos Internos">Gastos Internos</option>
                    </select>

                    <label>Clave: </label>
                    <input type="text" class="form-control" name="clave_l" id="clave_l" maxlength="20" placeholder="Clave">
                    <br>


                    <label>Folio del comprobante:</label>
                    <input type="text" class="form-control" name="numeroCheque" id="numeroCheque" maxlength="20"
                      placeholder="Numero cheque" required="">
                    <br>
                  </div>

                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Unidad:</label>
                    <select id="idunidad" name="idunidad" class="form-control selectpicker" data-live-search="true"
                      required>
                    </select>
                    <br>
                    <br>
                    <label>Importe:</label>
                    <input type="text" class="form-control" name="importe" id="importe" required="">
                    <br>
                    <label>Descripción:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" required="">
                    <br>
                    <label>Plaza:</label>
                    <input type="text" class="form-control" name="plaza" id="plaza" required="">
                    <br>
                    <label>Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <button type="button" class="btn btn-primary" onclick="guardaryeditar()">Guardar Egreso</button>

                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Imagen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <div class="spinner-border" role="status" id="load" name="load"></div>
            <img id="modalImage" alt="Imagen desde URL" style="max-width: 570px; display: none;">
          </div>
          <div class="modal-footer">
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
  <?php
}
ob_end_flush();
?>