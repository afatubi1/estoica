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

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Chofer <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i
                      class="fa fa-plus-circle"></i> Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Email</th>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Email</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre:</label>
                    <input type="hidden" name="idpersona" id="idpersona">
                    <input type="hidden" name="chofer" id="chofer" value="chofer">
                    <input type="text" class="form-control" name="nombreChofer" id="nombreChofer" maxlength="100"
                      placeholder="Nombre Chofer">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Tipo Documento :</label>
                    <select name="tipo_documento" id="tipo_documento" class="form-control select-picker" required>
                      <option value="INE">INE</option>
                      <option value="PASAPORTE">PASAPORTE</option>
                      <option value="LICENCIA DE MANEJO">LICENCIA DE MANEJO</option>
                      <option value="CARTILLA">CARTILLA</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Direccion:</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70"
                      placeholder="Direccion">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Telefono:</label>
                    <input type="text" class="form-control" name="telefono" id="telefono" maxlength="70"
                      placeholder="Telefono">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Telefono de Referencia:</label>
                    <input type="text" class="form-control" name="telefonoR" id="telefonoR" maxlength="70"
                      placeholder="Telefono de Referencia">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" id="email" maxlength="70" placeholder="Email">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Imagen de chofer</label>
                    <input class="form-control" type="file" id="imgChofer" name="imgChofer">
                    </br>
                    <button class="btn btn-secondary" name="editarImagen" id="editarImagen"><i class="fa fa-pencil">EDITAR
                        IMAGEN</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Curp</label>
                    <input class="form-control" type="file" id="Curp" name="Curp">
                    </br>
                    <button class="btn btn-secondary" name="editarCurp" id="editarCurp"><i class="fa fa-pencil">EDITAR
                        CURP</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">INE</label>
                    <input class="form-control" type="file" id="ine" name="ine">
                    </br>
                    <button class="btn btn-secondary" name="editarIne" id="editarIne"><i class="fa fa-pencil">EDITAR INE</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Licencia</label>
                    <input class="form-control" type="file" id="licencia" name="licencia">
                    </br>
                    <button class="btn btn-secondary" name="editarLicencia" id="editarLicencia"><i
                        class="fa fa-pencil">EDITAR LICENCIA</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Tia</label>
                    <input class="form-control" type="file" id="tia" name="tia">
                    </br>
                    <button class="btn btn-secondary" name="editarTia" id="editarTia"><i class="fa fa-pencil">EDITAR TIA</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Antecedentes no penales</label>
                    <input class="form-control" type="file" id="antecedentesPenales" name="antecedentesPenales">
                    </br>
                    <button class="btn btn-secondary" name="editarAntecedentesPenales" id="editarAntecedentesPenales"><i
                        class="fa fa-pencil">EDITAR
                        Antecedentes no penales</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Aptitud psicofisica</label>
                    <input class="form-control" type="file" id="aptitudPsicofisica" name="aptitudPsicofisica">
                    </br>
                    <button class="btn btn-secondary" name="editarAptitudPsicofisica" id="editarAptitudPsicofisica"><i
                        class="fa fa-pencil">EDITAR
                        Aptitud psicofisica</i>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="formFile" class="form-label">Comprobante de domicilio</label>
                    <input class="form-control" type="file" id="comprobanteDomicilio" name="comprobanteDomicilio">
                    </br>
                    <button class="btn btn-secondary" name="editarComprobanteDomicilio" id="editarComprobanteDomicilio"><i
                        class="fa fa-pencil">EDITAR
                        Comprobante de domicilio</i>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
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


    <!-- large modal -->

    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Informacion del chofer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <img width="420" height="350" id="imgChoferPerfil" name="imgChoferPerfil" />
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
              </br>
              <label id="nombreChofermodal" name="nombreChofermodal"></label>
              <label id="documentoChofer" name="documentoChofer"></label>


              <label id="direccionChofer" name="doreccionChofer"></label>
              <label id="telefonoChofer" name="telefonoChofer"></label>
              <label id="telefonoRef" name="telefonoRef"></label>
              <label id="emailChofer" name="emailChofer"></label>
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button type="button" class="btn btn-primary" id="btnLicencia" name="btnLicencia">Ver licencia</button>
              <button type="button" class="btn btn-primary" id="btnTia" name="btnTia">Ver tia</button>
              <button type="button" class="btn btn-primary" id="btnIne" name="btnIne">Ver ine</button>

            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button type="button" class="btn btn-primary" id="btnComprobante" name="btnIne">Ver Comprobante</button>
              <button type="button" class="btn btn-primary" id="btnAptitud" name="btnIne">Ver Aptitud</button>
              <button type="button" class="btn btn-primary" id="btnCurp" name="btnIne">Ver Curp</button>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button type="button" class="btn btn-primary" id="btnAntecedentes" name="btnIne">Ver Antecedentes</button>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!--  end large modal -->
    <?php

  } //Llave de la condicion if de la variable de session
  else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>

  <script src="./scripts/choferes.js"></script>


  <?php

}
ob_end_flush(); //liberar el espacio del buffer
?>