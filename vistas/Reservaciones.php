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
                <h1 class="box-title">Reservación <button class="btn btn-success" id="btnagregar"
                    onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Facturacion</th>
                    <th>estatus</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Usuario</th>
                    <th>Conductor</th>
                    <th>Tipo de viaje</th>
                    <th>Ruta</th>
                    <th>Km</th>
                    <th>Auto</th>
                    <th>Pasajeros</th>
                    <th>Forma de pago</th>
                    <th>Efectivo</th>
                    <th>Tarjeta</th>
                    <th>Dolar</th>
                    <th>CXC</th>
                    <th>Transferencia</th>
                    <th>Ticket numero</th>
                    <th>Folio</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Facturacion</th>
                    <th>estatus</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Usuario</th>
                    <th>Conductor</th>
                    <th>Tipo de viaje</th>
                    <th>Ruta</th>
                    <th>Km</th>
                    <th>Auto</th>
                    <th>Pasajeros</th>
                    <th>Forma de pago</th>
                    <th>Efectivo</th>
                    <th>Tarjeta</th>
                    <th>Dolar</th>
                    <th>CXC</th>
                    <th>Transferencia</th>
                    <th>Ticket numero</th>
                    <th>Folio</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 1000px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="col-md-6">
                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Conductor:</label>
                      <select id="idConductor" name="idConductor" class="form-control selectpicker" data-live-search="true">
                        <option value="JOVANY GOMEZ">JOVANY GOMEZ</option>
                        <option value="RICARDO GOMEZ">RICARDO GOMEZ</option>
                        <option value="JORGE LUIS MARTINEZ">JORGE LUIS MARTINEZ</option>
                        <option value="OMAR RAMIREZ">OMAR RAMIREZ</option>
                        <option value="JAIR RAMIREZ ">JAIR RAMIREZ</option>
                        <option value="JOSE MANUEL">JOSE MANUEL</option>
                        <option value="CLEMENTE TORRES">CLEMENTE TORRES</option>
                        <option value="MIGUEL CEJA">MIGUEL CEJA</option>
                        <option value="FILIBERTO MENDEZ">FILIBERTO MENDEZ</option>
                        <option value="JOSE SANTIAGO">JOSE SANTIAGO</option>
                        <option value="GERARDO VALDEZ">GERARDO VALDEZ</option>
                        <option value="FRANCISCO MORALES">FRANCISCO MORALES</option>
                        <option value="PABLO ISLAS">PABLO ISLAS</option>
                        <option value="ANTIAGO MARQUEZ">ANTIAGO MARQUEZ</option>
                        <option value="SALVADOR SANCHEZ">SALVADOR SANCHEZ</option>
                      </select>
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Forma de pago:</label>
                      <select name="tipo_pago" id="tipo_pago" class="form-control selectpicker">
                        <option value="SN">Sin tipo de pago</option>
                        <option value="Dolar">Dolar</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="CxC AereoMexico">CxC AereoMexico</option>
                        <option value="CxC Volaris">CxC Volaris</option>
                        <option value="CxC VivaAeroBus">CxC VivaAeroBus</option>
                        <option value="CxC Global">CxC Global</option>
                        <option value="Deudores Diversos">Deudores Diversos</option>
                      </select>
                    </div>
                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Unidad:</label>
                      <input type="hidden" name="idreservaciones" id="idreservaciones">
                      <input type="hidden" name="unidad_save" id="unidad_save">
                      <input type="hidden" name="chofer_save" id="chofer_save">
                      <input type="hidden" name="idefectivo" id="idefectivo">
                      <input type="hidden" name="hour_save" id="hour_save">
                      <input type="hidden" name="getFolioReserva" id="getFolioReserva">
                      <input type="hidden" name="folioVentaEfectivo" id="folioVentaEfectivo">
                      <select id="idunidad" name="idunidad" class="form-control selectpicker" data-live-search="true"
                        required>
                      </select>
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Tipo de viaje:</label>
                      <select id="tipo_viaje" name="tipo_viaje" class="form-control selectpicker" data-live-search="true">
                        <option value="Recolección">Recolección</option>
                        <option value="Reservación">Reservación</option>
                      </select>
                    </div>
                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Auto:</label>
                      <input type="hidden" name="auto_save" id="auto_save">
                      <select name="auto" id="auto" class="form-control selectpicker">
                        <option value="Sedan">Sedan</option>
                        <option value="Camioneta">Camioneta</option>
                      </select>
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Ruta:</label>
                      <input type="hidden" name="destino_save" id="destino_save">
                      <input type="text" class="form-control" name="ruta" id="ruta" placeholder="Ruta:">
                      </select>
                    </div>
                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Nombre del cliente:</label>
                      <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente"
                        placeholder="Nombre del cliente:">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Numero de celular:</label>
                      <input type="text" class="form-control" name="numero_celular" id="numero_celular"
                        placeholder="Numero de celular:">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Fecha inicio:</label>
                      <input type="date" class="form-control" name="fecha" id="fecha">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Fecha fin:</label>
                      <input type="date" class="form-control" name="fecha_recoleccion" id="fecha_recoleccion">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Hora(*):</label>
                      <input type="time" id="hora" name="hora">
                    </div>
                  </div>

                  <div class="col-md-6">


                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Pasajero:</label>
                      <input type="text" class="form-control" name="numero_pasajero" id="numero_pasajero" maxlength="20"
                        placeholder="Numero de pasajeros">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Kilometros:</label>
                      <input type="text" class="form-control" name="kilometro" id="kilometro" maxlength="10"
                        placeholder="Kilometros">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Efectivo:</label>
                      <input type="text" class="form-control" name="efectivo" id="efectivo" maxlength="10"
                        placeholder="Número">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Dolar:</label>
                      <input type="text" class="form-control" name="dolar" id="dolar">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Tarjeta:</label>
                      <input type="text" class="form-control" name="tarjeta" id="tarjeta">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Transferencia:</label>
                      <input type="text" class="form-control" name="Transferencia" id="Transferencia">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>CxC:</label>
                      <input type="text" class="form-control" name="cxc" id="cxc">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Ticket Numero:</label>
                      <input type="text" class="form-control" name="ticket_num" id="ticket_num">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <label>Evidencia:</label>
                      <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      <a data-toggle="modal">
                      </a>
                    </div>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar
                      Venta</button>

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

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
            <h1> Editar montos</h1>
            <div class="modal-body">
              <input type="hidden" name="idreservaciones_edit" id="idreservaciones_edit">
              <label>Tarjeta:</label>
              <input type="text" class="form-control" name="tarjeta_edit" id="tarjeta_edit">
              <label>Efectivo:</label>
              <input type="text" class="form-control" name="efectivo_edit" id="efectivo_edit">
              <label>Dolar:</label>
              <input type="text" class="form-control" name="dolar_edit" id="dolar_edit">
              <label>CXC:</label>
              <input type="text" class="form-control" name="cxc_edit" id="cxc_edit">
              <label>Transferencia:</label>
              <input type="text" class="form-control" name="Transferencia_edit" id="Transferencia_edit">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="updateMontos()" class="btn btn-primary">Actualizar montos</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!--// modal confiramar cerrar  -->

    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body text-center">
            <h1>¿Cerrar reservación?</h1>
            <br>
            <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="Advertencia" width="80" class="my-3">
            <div class="my-3">
              <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Cerrar Ventana</button>
              <button type="button" onclick="cerrarReserva()" class="btn btn-primary">Cerrar reservación</button>
            </div>
          </div>

          <div class="modal-footer">
            <!-- Puedes agregar contenido aquí si quieres -->
          </div>

        </div>
      </div>
    </div>

    <!-- Modal imagen-->
    <div class="modal fade" id="myModalImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
  <script type="text/javascript" src="scripts/reservaciones.js"></script>
  <script src="plugin_impresora_termica"></script>

  <?php
}
ob_end_flush();
?>