<?php
if (strlen(session_id()) < 1) //Si la variable de session no esta iniciada
{
  session_start();
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ventas Estoica</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="chrome://print-preview/print_preview.js"></script>
  <script src="https://parzibyte.github.io/ejemplos-javascript-plugin-v3/ConectorJavaScript.js"
    type="text/javascript"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/img/favicon.ico">

  <!--DATATABLES-->
  <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">

  <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">


</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a class="logo" id="idVenta">
        <img src="estoica.jpeg" class="user-image" alt="User Image" width="210" height="80">
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation" id="navBar">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <p>
                    Desarrollando Software
                    <small>www.google.com</small>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">

                  <div class="pull-right">
                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                  </div>
                </li>
              </ul>
            </li>

          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header"></li>
          <?php
          if ($_SESSION['escritorio'] == 1) {
            echo
              '<li>
                  <a href="escritorio.php">
                    <i class="fa fa-tasks"></i> <span>Escritorio</span>
                  </a>
                </li>';
          }

          if ($_SESSION['almacen'] == 1) {
            echo
              '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-laptop"></i>
                      <span>Contabilidad</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="facturas.php"><i class="fa fa-circle-o"></i> Facturas</a></li>
                      <li><a href="liquidaciones.php"><i class="fa fa-circle-o"></i> liquidaciones</a></li>
                    </ul>
                  </li>'
            ;
          }

          if ($_SESSION['compras'] == 1) {
            echo
              '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i>
                      <span>Corte </span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="corte.php"><i class="fa fa-circle-o"></i> Corte Efectivo</a></li>
                      <li><a href="saleCut.php"><i class="fa fa-circle-o"></i> Corte ventas</a></li>
                    </ul>
                  </li>'
            ;
          }
          if ($_SESSION['ventas'] == 1) {
            echo
              '<li class="treeview">
                  <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Clientes</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="clientes.php"><i class="fa fa-circle-o"></i> Cliente</a></li>
                  </ul>
                </li>'
            ;
            echo
              '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      <span>Ventas</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                     <!-- <li><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>-->
                      <li><a href="venta2.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                      <li><a href="Reservaciones.php"><i class="fa fa-circle-o"></i> Reservaciones</a></li>
                      <li><a href="choferes.php"><i class="fa fa-circle-o"></i> Choferes</a></li>
                      <li><a href="unidad.php"><i class="fa fa-circle-o"></i> Unidad</a></li>
                      <li><a href="ruta.php"><i class="fa fa-circle-o"></i> Rutas</a></li>
                    </ul>
                  </li>'
            ;
            echo
              '<li class="treeview">
                     <a href="#">
                       <i class="fa fa-car"></i>
                       <span>Traking Unidad</span>
                       <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                      <li> <a href="https://www.protrack365.com/" target="_blank"><i class="fa fa-circle-o"></i>Seguimiento de Unidades</a></li>
                     </ul>
                   </li>'
            ;
          }
          if ($_SESSION['acceso'] == 1) {
            echo
              '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-folder"></i> <span>Acceso</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                      <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>

                    </ul>
                  </li>'
            ;
          }
          if ($_SESSION['consultac'] == 1) {
            echo
              '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Compras</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Compras</a></li>
                    </ul>
                  </li>'
            ;
          }

          if ($_SESSION['consultav'] == 1) {
            echo
              '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>
                    </ul>
                  </li>'
            ;
          }
          ?>

          <li>
            <a href="#">
              <i class="fa fa-plus-square"></i> <span>Ayuda</span>
              <small class="label pull-right bg-red">PDF</small>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
              <small class="label pull-right bg-yellow">IT</small>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>


    <style>
      #navBar {
        background-color: #289ba0;
        height: 60%;
        width: 80%;
      }

      #idVenta {
        background-color: #289ba0;
        text-align: left;
        height: 50%;
        width: 20%;
        display: flex;
        align-items: center;
      }
    </style>