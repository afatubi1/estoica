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
                    <th>Facturado</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Usuario</th>
                    <th>Conductor</th>
                    <th>Tipo de viaje</th>
                    <th>Ruta</th>
                    <th>Km</th>
                    <th>Auto</th>
                    <th>Pasajeros</th>
                    <th>Total MXN</th>
                    <th>Total USD</th>
                    <th>Forma de pago</th>
                    <th>Efectivo</th>
                    <th>Cambio</th>
                    <th>Ticket numero</th>
                    <th>Folio</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Facturacion</th>
                    <th>Facturado</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Unidad</th>
                    <th>Usuario</th>
                    <th>Conductor</th>
                    <th>Tipo de viaje</th>
                    <th>Ruta</th>
                    <th>Km</th>
                    <th>Auto</th>
                    <th>Pasajeros</th>
                    <th>Total MXN</th>
                    <th>Total USD</th>
                    <th>Forma de pago</th>
                    <th>Efectivo</th>
                    <th>Cambio</th>
                    <th>Ticket numero</th>
                    <th>Folio</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <label>Ruta:</label>
                    <input type="hidden" name="ruta" id="ruta">
                    <input type="hidden" name="destino_save" id="destino_save">
                    <select id="idruta" name="idruta" class="form-control selectpicker" data-live-search="true">
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
                    <label>Conductor:</label>
                    <select id="idConductor" name="idConductor" class="form-control selectpicker" data-live-search="true">
                       <option value="Américo Arceo Flores">Américo Arceo Flores</option>
                      <option value="Jovany Uzziel Gómez Dominguez">Jovany Uzziel Gómez Dominguez</option>
                      <option value="Omar Ramirez González">Omar Ramirez González</option>
                      <option value="Roberto Jhonatan Olvera Díaz">Roberto Jhonatan Olvera Díaz</option>
                      <option value="Gustavo Rodolfo Rivera Perez">Gustavo Rodolfo Rivera Perez</option>
                      <option value="Gerardo Valadez Cruz">Gerardo Valadez Cruz</option>
                      <option value="José Manuel Méndez Téllez">José Manuel Méndez Téllez</option>
                      <option value="Brandon Jesus Arellano Rodriguez">Brandon Jesus Arellano Rodriguez</option>
                      <option value="Victor Alan Arellano Lopez">Victor Alan Arellano Lopez</option>
                      <option value="Ruben Jaramillo Perez">Ruben Jaramillo Perez</option>
                      <option value="Ricardo Gomez Hernandez">Ricardo Gomez Hernandez</option>
                      <option value="Jose Adrian Montiel Carrasco">Jose Adrian Montiel Carrasco</option>
                      <option value="José Santiago Sanchez">José Santiago Sanchez</option>
                      <option value="Sin asignar">Sin asignar</option>

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
                    <label>Fecha(*):</label>
                    <input type="date" class="form-control" name="fecha" id="fecha">
                  </div>

                  <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <label>Hora(*):</label>
                    <input type="time" id="hora" name="hora">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Forma de pago:</label>
                    <select name="tipo_pago" id="tipo_pago" class="form-control selectpicker">
                      <option value="Dolar">Dolar</option>
                      <option value="Efectivo">Efectivo</option>
                      <option value="Tarjeta">Tarjeta</option>
                      <option value="Transferencia">Transferencia</option>
                      <option value="CxC AereoMexico">CxC AereoMexico</option>
                      <option value="CxC Volaris">CxC Volaris</option>
                      <option value="CxC VivaAeroBus">CxC VivaAeroBus</option>
                      <option value="CxC NADGlobal">CxC NADGlobal</option>
                      <option value="Deudores Diversos">Deudores Diversos</option>

                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Auto:</label>
                    <input type="hidden" name="auto_save" id="auto_save">
                    <select name="auto" id="auto" class="form-control selectpicker">
                      <option value="Sedan">Sedan</option>
                      <option value="Camioneta">Camioneta</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Pasajero:</label>
                    <input type="text" class="form-control" name="numero_pasajero" id="numero_pasajero" maxlength="7"
                      placeholder="Numero de pasajeros">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Kilometros:</label>
                    <input type="text" class="form-control" name="kilometro" id="kilometro" maxlength="10"
                      placeholder="Kilometros">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Total MXN:</label>
                    <input type="text" class="form-control" name="total_mxn" id="total_mxn" maxlength="10"
                      placeholder="Número">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Precio Dolar:</label>
                    <input type="text" class="form-control" name="labelDolar" id="labelDolar">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Total Dolar:</label>
                    <input type="text" class="form-control" name="total_usd" id="total_usd">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Ticket Numero:</label>
                    <input type="text" class="form-control" name="ticket_num" id="ticket_num">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Efectivo:</label>
                    <input type="text" class="form-control" name="efectivo" id="efectivo">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <input type="hidden" class="form-control" name="cambioEfectivo" id="cambioEfectivo">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a data-toggle="modal">
                      <button id="btnKilometro" type="button" class="btn btn-success"> <span class="fa fa-car"></span>
                        Kilometros a pesos </button>
                    </a>
                  </div>

                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a data-toggle="modal">
                      <button id="btnCalculaDolar" type="button" class="btn btn-warning"> <span class="fa fa-dollar"></span>
                        Calcular Total Dolar </button>
                    </a>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a data-toggle="modal">
                    </a>
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

                  <div class="col-sm-12 col-md-12">
                    <label>Regimen Fiscal</label>
                    <select id="regimenFiscalRfc" name="regimenFiscalRfc" class="form-control selectpicker"
                      data-live-search="true">
                      <option value="601">General de Ley Personas Morales</option>
                      <option value="603">Personas Morales con Fines no Lucrativos </option>
                      <option value="605">Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                      <option value="606">Arrendamiento</option>
                      <option value="607">Régimen de Enajenación o Adquisición de Bienes</option>
                      <option value="608">Demás ingresos</option>
                      <option value="610">Residentes en el Extranjero sin Establecimiento Permanente en México</option>
                      <option value="611">Ingresos por Dividendos (socios y accionistas)</option>
                      <option value="612">Personas Físicas con Actividades Empresariales y Profesionales</option>
                      <option value="614">Ingresos por intereses</option>
                      <option value="615">Régimen de los ingresos por obtención de premios</option>
                      <option value="616">Sin obligaciones fiscales</option>
                      <option value="620">Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
                      <option value="621">Incorporación Fiscal</option>
                      <option value="622">Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
                      <option value="623">Opcional para Grupos de Sociedades</option>
                      <option value="624">Coordinados</option>
                      <option value="625">Régimen de las Actividades Empresariales con ingresos a través de Plataformas
                        Tecnológicas</option>
                      <option value="626">Régimen Simplificado de Confianza</option>
                    </select>

                    <label>RFC beneficiario</label>
                    <input type="text" class="form-control" name="claveRfc" id="claveRfc" required=""
                      placeholder="RFC cliente">
                    </br>

                    <label>Razon social</label>
                    <input type="text" class="form-control" name="nameRfc" id="nameRfc" required=""
                      placeholder="beneficiario">
                    </br>

                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>Codigo Postal del beneficiario</label>
                    <input type="text" class="form-control" name="codePostalRfc" id="codePostalRfc" required=""
                      placeholder="C.P">
                    </br>
                    <label>Forma de pago</label>

                    <select id="pymentTypeRfc" name="pymentTypeRfc" class="form-control selectpicker"
                      data-live-search="true">
                      <option value="01">Efectivo</option>
                      <option value="04">Tarjeta de Credito</option>
                      <option value="28">Tarjeta de debito</option>
                      <option value="03">Transferencia</option>
                    </select>
                    </br>

                  </div>

                  <div class="col-sm-12 col-md-12">

                    </br>
                    <label>Referencia bancaria</label>(en caso de transferecnia)
                    <input type="text" class="form-control" name="referencesRfc" id="referencesRfc" required=""
                      placeholder="Referencia bancaria">
                  </div>
                  <input type="hidden" name="idreservacionrfc" id="idreservacionrfc">
                  <input type="hidden" name="dateRfc" id="dateRfc">
                  <input type="hidden" name="folioRfc" id="folioRfc">
                  <input type="hidden" name="amountRfc" id="amountRfc">
                  <input type="hidden" name="cfdi" id="cfdi">
                  <input type="hidden" name="facturaPdf" id="facturaPdf">
                  <input type="hidden" name="qrRfc" id="qrRfc">

                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="descarQr()" id="qr" name="qr"> QR</button>
                <button type="button" class="btn btn-success" onclick="descarFactura()" id="factura" name="factura">
                  factura</button>
                <button type="button" class="btn btn-success" onclick="descarCfdi()" id="xml" name="xml"> XML</button>
                <button type="button" class="btn btn-primary" onclick="getFactura()">Facturar</button>
                <button type="button" class="btn btn-danger" onclick="listar()" data-dismiss="modal">Cerrar</button>

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