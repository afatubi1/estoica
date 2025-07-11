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
                <h1 class="box-title">Venta
                  <button type="button" class="btn btn-primary" onclick="habailablePrincipalForm()">
                    Agregar
                  </button>
                </h1>
                <div>
                  <p class="text-center">Reservaciones abiertas: Número total.</p>
                  <p id="n_reserva" name="n_reserva" class="text-center">0</p>
                </div>

                <div id="loader" style="display: none;">Cargando...</div>
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
                    <th>Transferencias</th>
                    <th>CXC</th>
                    <th>Total</th>
                    <th>Ticket numero</th>
                    <th>Punto de venta</th>
                    <th>Uber</th>
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
                    <th>Transferencias</th>
                    <th>CXC</th>
                    <th>Total</th>
                    <th>Ticket numero</th>
                    <th>Punto de venta</th>
                    <th>Uber</th>
                    <th>Folio</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 1000px;" id="formularioregistros">
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <div class="panel-body" style="height: 400px;">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-8 col-md-4 col-sm-4 col-xs-12">
                            <input type="hidden" name="idventa" id="idventa">
                            <input type="hidden" name="unidad_save" id="unidad_save">
                            <input type="hidden" name="total_venta" id="total_venta">
                            <input type="hidden" name="usuario" id="usuario"
                              value="<?= htmlspecialchars($_SESSION['idusuario']); ?>">
                            <input type="hidden" class="form-control" name="fecha_hora" id="fecha_hora">
                            <input type="hidden" name="hour_save" id="hour_save">
                            <input type="hidden" name="idFolioVenta" id="idFolioVenta">

                            <!-- Guardar folios venta -->
                            <input type="hidden" name="idefectivo" id="idefectivo">
                            <input type="hidden" name="idDolar" id="idDolar">
                            <input type="hidden" name="idCxc" id="idCxc">
                            <input type="hidden" name="idTransferencia" id="idTransferencia">

                            <input type="hidden" name="folioVentaEfectivo" id="folioVentaEfectivo">
                            <input type="hidden" name="folioVentaDolar" id="folioVentaDolar">
                            <input type="hidden" name="folioVentaCxc" id="folioVentaCxc">
                            <input type="hidden" name="folioVentaTransferencias" id="folioVentaTransferencias">

                            <!-- fin folios venta -->

                            <!-- Unidad -->
                            <label>Unidad:</label>
                            <label id="shouldUnit">Debes elegir unidad</label>
                            <select id="idunidad" name="idunidad" class="form-control selectpicker"
                              data-live-search="true"></select>

                            <!-- Auto -->
                            <label>Auto:</label>
                            <select name="auto" id="auto" class="form-control selectpicker">
                              <option value="Sedan">Sedan</option>
                              <option value="Camioneta">Camioneta</option>
                            </select>

                            <!-- Forma de pago -->
                            <label>Forma de pago:</label>
                            <label id="shouldPayment">Debes elegir un tipo de pago</label>
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

                            <!-- Forma de pago -->
                            <label>Punto de venta:</label>
                            <select name="punto_venta" id="punto_venta" class="form-control selectpicker">
                              <option value="Internacional">Internacional</option>
                              <option value="Nacional">Nacional</option>
                            </select>

                            <!-- Ruta -->
                            <label>Ruta:</label>
                            <input type="hidden" name="ruta" id="ruta">
                            <input id="idrutas" name="idrutas" class="form-control selectpicker" data-live-search="true"
                              required>

                            <!-- Kilómetros -->
                            <label>Kilómetros:</label>
                            <input type="text" class="form-control" name="kilometro" id="kilometro" maxlength="10"
                              placeholder="Kilómetros" required>

                            <!-- Pasajeros -->
                            <label>Pasajeros:</label>
                            <input type="text" class="form-control" name="Pasajero" id="Pasajero" maxlength="7"
                              placeholder="Número de pasajeros" required>

                            <!-- Efectivo -->
                            <label>Efectivo:</label>
                            <input type="text" class="form-control" name="Efectivo" id="Efectivo" placeholder="Número"
                              required>

                            <!-- Dolar -->
                            <label>Dolar:</label>
                            <input type="text" class="form-control" name="Dolar" id="Dolar" required>

                            <!-- Tarjeta -->
                            <label>Tarjeta:</label>
                            <input type="text" class="form-control" name="Tarjeta" id="Tarjeta" required>

                            <!-- CXC -->
                            <label>CXC:</label>
                            <input type="text" class="form-control" name="CXC" id="CXC" required>

                            <!-- Transferencias -->
                            <label>Transferencias:</label>
                            <input type="text" class="form-control" name="Transferencia" id="Transferencia" required>

                            <!-- Ticket Numero -->
                            <label>Ticket Numero:</label>
                            <input type="text" class="form-control" name="ticket_num" id="ticket_num" required>
                            <br>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <input type="button" id="btnGuardar" class="btn btn-success" onclick="saveSales()"
                                value="Guardar Venta"></input>
                              <input type="button" id="btnCancelar" class="btn btn-danger" onclick="habailableTable()"
                                value="Cancelar"></input>
                            </div>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal"></a>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="col">
                      <!--
                      <body onload="initMap()">
                        <button class="btn btn-primary" onclick="searchLocation()">Buscar Dirección</button>
                        <input id="searchInput" name="searchInput" class="form-control selectpicker" type="text"
                          placeholder="Ingresa una dirección">
                        <br><br>
                        <div id="map" style="height: 500px; width: 100%;"></div>
                      </body> -->
                    </div>
                  </div>
                </div>
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
              <div class="center-image">
                <img src="https://www.estoicatravel.com/estoica.jpeg" width="150" height="140" />

              </div>

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

                  <div class="col-sm-12 col-md-12">
                    </br>
                    <label>Correo</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                  <input type="hidden" name="idventarfc" id="idventarfc">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Button trigger modal confirm uber -->
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
            <h1>¿Deseas agregar participación de Uber a esta venta?</h1>
            <br>
            <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="Advertencia" width="80" class="my-3">
            <div class="my-3">
              <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Cerrar Ventana</button>
              <button type="button" onclick="confirmUber()" class="btn btn-primary">Agregar participación</button>
            </div>
          </div>

          <div class="modal-footer">
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
  <script type="text/javascript" src="scripts/venta_dos.js"></script>

  <style>
    #shouldUnit {
      color: red;
    }

    #shouldPayment {
      color: red;
    }

    #map {
      height: 700px;
      width: 150%;
    }

    .center-image {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 10vh;
      /* Ajusta esta altura según tus necesidades */
    }

    #loader {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 20px;
      color: #333;
    }

    #directionsPanel {
      height: 700px;
      overflow: auto;
    }

    #load {
      width: 70px;
      height: 70px;
      border-color: red;
      /* Cambia el color del borde (el spinner) */
      border-right-color: transparent;
      /* Para que se vea como un spinner */
    }
  </style>
  <?php
}
ob_end_flush();
?>