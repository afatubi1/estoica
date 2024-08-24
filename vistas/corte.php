<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['ventas']==1)
{
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
                          <h1 class="box-title">Corte caja <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Usuario</th>
                            <th>Turno</th>
                            <th>.50c</th>
                            <th>1$</th>
                            <th>2$</th>
                            <th>5$</th>
                            <th>10$</th>
                            <th>20$</th>
                            <th>20$Billete</th>
                            <th>50$</th>
                            <th>100$</th>
                            <th>200$</th>
                            <th>500$</th>
                            <th>1000$</th>
                            <th>TotalMXN</th>
                            <th>1$Dolar</th>
                            <th>2$</th>
                            <th>5$</th>
                            <th>10$</th>
                            <th>20$</th>
                            <th>50$</th>
                            <th>100$</th>
                            <th>TotalUSD</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Usuario</th>
                            <th>Turno</th>
                            <th>.50c</th>
                            <th>1$</th>
                            <th>2$</th>
                            <th>5$</th>
                            <th>10$</th>
                            <th>20$</th>
                            <th>20$Billete</th>
                            <th>50$</th>
                            <th>100$</th>
                            <th>200$</th>
                            <th>500$</th>
                            <th>1000$</th>
                            <th>TotalMXN</th>
                            <th>1$Dolar</th>
                            <th>2$</th>
                            <th>5$</th>
                            <th>10$</th>
                            <th>20$</th>
                            <th>50$</th>
                            <th>100$</th>
                            <th>TotalUSD</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 600px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Turno:</label>
                            <select name="turno" id="turno" class="form-control selectpicker" required="">
                               <option value="Matutino">Matutino</option>
                               <option value="Vespertino">Vespertino</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="corte_fecha" id="corte_fecha" required="">
                          </div>
                            <div class="form-group col-lg-1 col-md-6 col-sm-6 col-xs-12">
                                <label>Modenas</label>
                                <br></br>
                                <label>.50c:</label>
                                <input type="text" class="form-control" name="cincuentaCentavos" id="cincuentaCentavos" maxlength="10" placeholder=".50c">
                                <label>1$:</label>
                                <input type="text" class="form-control" name="unPeso" id="unPeso" maxlength="7" placeholder="1$">
                                <label>2$:</label>
                                <input type="text" class="form-control" name="dosPesos" id="dosPesos" maxlength="7" placeholder="2$">
                                <label>5$:</label>
                                <input type="text" class="form-control" name="cincoPesos" id="cincoPesos" maxlength="7" placeholder="5$">
                                <label>10$:</label>
                                <input type="text" class="form-control" name="diezPesos" id="diezPesos" maxlength="7" placeholder="10$">
                                <label>20$:</label>
                                <input type="text" class="form-control" name="veintePesos" id="veintePesos" maxlength="7" placeholder="20$">
                            </div>
                            <div class="form-group col-lg-1 col-md-6 col-sm-6 col-xs-12">
                                <label>Billetes</label>
                                <br></br>
                                <label>20$:</label>
                                <input type="text" class="form-control" name="billeteVeinte" id="billeteVeinte" maxlength="10" placeholder="20$">
                                <label>50$:</label>
                                <input type="text" class="form-control" name="billeteCincuenta" id="billeteCincuenta" maxlength="7" placeholder="50$">
                                <label>100$:</label>
                                <input type="text" class="form-control" name="billeteCien" id="billeteCien" maxlength="7" placeholder="100$">
                                <label>200$:</label>
                                <input type="text" class="form-control" name="billeteDoscientos" id="billeteDoscientos" maxlength="7" placeholder="200$">
                                <label>500$:</label>
                                <input type="text" class="form-control" name="billeteQuinientos" id="billeteQuinientos" maxlength="7" placeholder="500$">
                                <label>1000$:</label>
                                <input type="text" class="form-control" name="billeteMil" id="billeteMil" maxlength="7" placeholder="1000$">
                            </div>
                            <div class="form-group col-lg-1 col-md-6 col-sm-6 col-xs-12">
                                <label>Dolares</label>
                                <br></br>
                                <label>1$:</label>
                                <input type="text" class="form-control" name="dolarUno" id="dolarUno" maxlength="10" placeholder="1$">
                                <label>2$:</label>
                                <input type="text" class="form-control" name="dolarDos" id="dolarDos" maxlength="7" placeholder="2$">
                                <label>5$:</label>
                                <input type="text" class="form-control" name="dolarCinco" id="dolarCinco" maxlength="7" placeholder="5$">
                                <label>10$:</label>
                                <input type="text" class="form-control" name="dolarDiez" id="dolarDiez" maxlength="7" placeholder="10$">
                                <label>20$:</label>
                                <input type="text" class="form-control" name="dolarVeinte" id="dolarVeinte" maxlength="7" placeholder="20$">
                                <label>50$:</label>
                                <input type="text" class="form-control" name="dolarCincuenta" id="dolarCincuenta" maxlength="7" placeholder="50$">
                                <label>100$:</label>
                                <input type="text" class="form-control" name="dolarCien" id="dolarCien" maxlength="7" placeholder="100$">
                            </div>
                            <div class="form-group col-lg-1 col-md-6 col-sm-6 col-xs-12">
                                <label>Total MXN:</label>
                                <input type="text" class="form-control" name="total_pesos" id="total_pesos" maxlength="10" placeholder="1$">
                                <label>Total USD:</label>
                                <input type="text" class="form-control" name="total_dolar" id="total_dolar" maxlength="7" placeholder="2$">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <a data-toggle="modal">
                                <button id="btnTotalImprimir" type="button" class="btn btn-primary"> <span class="fa fa-print"></span>Imprimir Corte</button>
                              </a>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <a data-toggle="modal">
                                <button id="btnTotalPesos" type="button" class="btn btn-warning"> <span class="fa fa-dollar"></span> TOTAL MXN</button>
                              </a>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <a data-toggle="modal">
                                <button id="btnTotalDolar" type="button" class="btn btn-success"> <span class="fa fa-dollar"></span> TOTAL USD</button>
                              </a>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a data-toggle="modal">
                                </a>
                            </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar Venta</button>

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
    <?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/corte.js"></script>

    <?php
}
ob_end_flush();
?>
