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
                <h1 class="box-title">Ingresos vs Egresos</h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <form id="ingresosForm">
                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">

                  <label for="fechaInicio">Fecha de Inicio:</label>
                  <input type="date" id="fechaInicio" name="fechaInicio" required>
                  <br><br>

                  <label for="fechaFin">Fecha de Fin:</label>
                  <input type="date" id="fechaFin" name="fechaFin" required>
                  <br><br>

                  <label for="idunidad">ID Unidad:</label>
                  <select id="idunidad" name="idunidad" class="form-control selectpicker" data-live-search="true" required>
                  </select>
                  <br><br>
                  <button type="button" onclick="fillIngresos()" class="btn btn-primary">Obtener Ingresos</button>
                  <button type="button" onclick="fillEgresos()" class="btn btn-secondary">Obtener Egresos</button>

                  <h2>Resultados Ingresos</h2>
                </div>
              </form>

              <table id="resultadosTable" class="table table-striped table-bordered table-condensed table-hover" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Nombre</th>
                    <th>Tipo Pago</th>
                    <th>Efectivo</th>
                    <th>Tarjeta</th>
                    <th>Dólar</th>
                    <th>CxC</th>
                    <th>ID Venta</th>
                  </tr>
                </thead>
                <tbody>
                <tfoot>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Unidad</th>
                  <th>Nombre</th>
                  <th>Tipo Pago</th>
                  <th>Efectivo</th>
                  <th>Tarjeta</th>
                  <th>Dólar</th>
                  <th>CxC</th>
                  <th>ID Venta</th>
                </tfoot>
                </tbody>
              </table>
              <div class="panel-body table-responsive" id="listadoregistros">
                <h2>Resultados Egresos</h2>
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Usuario</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Movimiento</th>
                    <th>Clave</th>
                    <th>Concepto clave</th>
                    <th>Folio externo</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Forma de pago</th>
                    <th>Ingreso</th>
                    <th>Egresos</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Usuario</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Movimiento</th>
                    <th>Clave</th>
                    <th>Concepto clave</th>
                    <th>Folio externo</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Forma de pago</th>
                    <th>Ingreso</th>
                    <th>Egresos</th>
                  </tfoot>
                </table>
              </div>
              <div id="contenedor">
                <div class="container-fluid cew-9">
                  <div class="row">
                    <div class="col col-lg-2">
                      <label>Ingresos:</label>
                      </br>
                      <label>Efectivo</label>
                      <input type="text" class="form-control" name="textEfectivo" id="textEfectivo" placeholder="0">
                      </br>
                      <label>Tarjeta</label>
                      <input type="text" class="form-control" name="textTarjeta" id="textTarjeta" placeholder="0">
                      </br>
                      <label>Dolar</label>
                      <input type="text" class="form-control" name="textDolar" id="textDolar" placeholder="0">
                      </br>
                      <label>Cxc</label>
                      <input type="text" class="form-control" name="textCxc" id="textCxc" placeholder="0">
                      </br>
                    </div>
                    <div class="col col-lg-2">
                      <label>Egresos:</label>
                      </br>
                      <label>Ingreso</label>
                      <input type="text" class="form-control" name="textIngreso" id="textIngreso" placeholder="0">
                      </br>
                      <label>Egresos</label>
                      <input type="text" class="form-control" name="textGastos" id="textGastos" placeholder="0">
                    </div>
                    <div class="col col-lg-2">
                      <label>Total Egresos:</label>                                        
                      <input type="text" class="form-control" name="totalgasto" id="totalgasto" placeholder="0">
                      </br>
                      <label>Total Ingreso:</label>                     
                      <input type="text" class="form-control" name="totalIngreso" id="totalIngreso" placeholder="0">
                    </div>
                    <div class="col col-lg-2">
                      <label>Total (Total Ingresos - Total Egresos):</label>
                      <input type="text" class="form-control" name="total" id="total" placeholder="0">
                    </div>
                  </div>
                </div>
                <div>
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
  <script type="text/javascript" src="scripts/ingresosvs.js"></script>
  <style>
    #totalgasto {
        color: red;
        font-weight: bold;
    }
</style>
  <?php
}
ob_end_flush();
?>