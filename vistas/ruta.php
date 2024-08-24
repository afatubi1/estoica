<?php
    //Activacion de almacenamiento en buffer
    ob_start();
    //iniciamos las variables de session
    session_start();

    if(!isset($_SESSION["nombre"]))
    {
      header("Location: login.html");
    }

    else  //Agrega toda la vista
    {
      require 'header.php';

      if($_SESSION['ventas'] == 1)
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
                          <h1 class="box-title">Rutas <button class="btn btn-success" id="btnagregarRuta" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Direccion</th>
                            <th>Precio</th>

                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Direccion</th>
                            <th>Precio</th>

                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Direccion</label>
                            <input type="hidden" name="idruta" id="idruta">
                            <input type="hidden" name="ruta_direccion" id="ruta_direccion" value="Ruta">
                            <input type="text" class="form-control" name="ruta_direccion" id="ruta_direccion" maxlength="100" placeholder="Direccion" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio</label>
                            <input type="text" class="form-control" name="ruta_precio" id="ruta_precio" maxlength="20" placeholder="Precio" required>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardarRuta"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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


<?php

  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>

<script src="./scripts/ruta.js"></script>


<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>
