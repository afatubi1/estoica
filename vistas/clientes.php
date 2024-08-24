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

  if ($_SESSION['ventas'] == 1) {
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <div class="box-header with-border">
                  <h1 class="box-title">Clientes <button class="btn btn-success" id="btnagregar"
                      onclick="agregarCliente()"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Folio Cliente</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>RFC</th>
                    <th>Razon social</th>
                    <th>C.P</th>
                    <th>Regimen Fiscal</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Folio Cliente</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>RFC</th>
                    <th>Razon social</th>
                    <th>C.P</th>
                    <th>Regimen Fiscal</th>
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
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <div class="center">
              <img src="https://taxalaifa.com/taxal/taxal2.png" width="150" height="180" />
              <div class="modal-header">
              </div>
              <div class="modal-body">
                <form name="formCliente" id="formCliente" method="POST">
                <div class="col-sm-12 col-md-12">
                    <label>Regimen Fiscal</label>
                    <select id="regimenFiscalRfc" name="regimenFiscalRfc" class="form-control selectpicker"
                      data-live-search="true">
                      <option value="General de Ley Personas Morales">General de Ley Personas Morales</option>
                      <option value="Personas Morales con Fines no Lucrativos">Personas Morales con Fines no Lucrativos</option>
                      <option value="Sueldos y Salarios e Ingresos Asimilados a Salarios">Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                      <option value="Arrendamiento">Arrendamiento</option>
                      <option value="Régimen de Enajenación o Adquisición de Bienes">Régimen de Enajenación o Adquisición de Bienes</option>
                      <option value="Demás ingresos">Demás ingresos</option>
                      <option value="Residentes en el Extranjero sin Establecimiento Permanente en México">Residentes en el Extranjero sin Establecimiento Permanente en México</option>
                      <option value="Ingresos por Dividendos (socios y accionistas)">Ingresos por Dividendos (socios y accionistas)</option>
                      <option value="Personas Físicas con Actividades Empresariales y Profesionales">Personas Físicas con Actividades Empresariales y Profesionales</option>
                      <option value="Ingresos por intereses">Ingresos por intereses</option>
                      <option value="Régimen de los ingresos por obtención de premios">Régimen de los ingresos por obtención de premios</option>
                      <option value="Sin obligaciones fiscales">Sin obligaciones fiscales</option>
                      <option value="Sociedades Cooperativas de Producción que optan por diferir sus ingresos">Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
                      <option value="Incorporación Fiscal">Incorporación Fiscal</option>
                      <option value="Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras">Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
                      <option value="Opcional para Grupos de Sociedades">Opcional para Grupos de Sociedades</option>
                      <option value="Coordinados">Coordinados</option>
                      <option value="Régimen de las Actividades Empresariales con ingresos a través de Plataformas
                        Tecnológicas">Régimen de las Actividades Empresariales con ingresos a través de Plataformas
                        Tecnológicas</option>
                      <option value="626">Régimen Simplificado de Confianza</option>
                    </select>
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>Nombre completo del cliente</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required=""
                      placeholder="Nombre de cliente">
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>Telefono</label>
                    <input type="text" class="form-control" name="telefono" id="telefono" required=""
                      placeholder="Telefono">
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>Correo</label>
                    <input type="text" class="form-control" name="correo" id="correo" required="" placeholder="Correo">
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>RFC</label>
                    <input type="text" class="form-control" name="rfc" id="rfc" required="" placeholder="RFC">
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>Razon social</label>
                    <input type="text" class="form-control" name="razonSocial" id="razonSocial" required=""
                      placeholder="Razon Social">
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <label>C.P</label>
                    <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" required=""
                      placeholder="C.P">
                  </div>
                  
                  <div class="col-sm-12 col-md-12">
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="guardarCliente()">Guardar Cliente</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>


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
      <script src="./scripts/clientes.js"></script>

      <?php

}
ob_end_flush(); //liberar el espacio del buffer
?>