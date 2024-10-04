<?php 
if (strlen(session_id()) < 1) 
    session_start();

// Verificar si las variables de sesión están definidas y asignarles un valor por defecto si no lo están
$escritorio = isset($_SESSION['escritorio']) ? $_SESSION['escritorio'] : 0;
$comunidades = isset($_SESSION['comunidades']) ? $_SESSION['comunidades'] : 0;
$acceso = isset($_SESSION['acceso']) ? $_SESSION['acceso'] : 0;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Qachuu Aloom</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

    <!-- Estilos personalizados para el logo -->
    <style>
      .img-logo-mini {
          width: 100%;
          height: auto;
          display: block;
          max-height: 50px;
      }

      .img-logo-lg {
          max-width: 50px;
          height: auto;
          display: inline-block;
          margin-right: 10px;
      }

      .logo-lg span {
          font-size: 18px;
          font-weight: bold;
          display: inline-block;
          vertical-align: middle;
          color: #fff;
      }

      .logo-mini {
          width: 50px;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .logo-lg {
          display: flex;
          align-items: center;
          justify-content: flex-start;
          padding: 10px;
      }
    </style>
  </head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <a href="escritorio.php" class="logo">
        <span class="logo-mini">
          <img src="../public/img/logo-mini.png" alt="Mini Logo" class="img-logo-mini">
        </span>
        <span class="logo-lg">
          <img src="../public/img/logo.png" alt="Logo Completo" class="img-logo-lg">
          <span>Qachuu Aloom</span>
        </span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['nombre']; ?>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
          <br>
          <!-- Mostrar la opción de Escritorio si el usuario tiene permiso -->
          <?php 
          if ($escritorio == 1) {
            echo '<li><a href="escritorio.php"><i class="fa fa-dashboard"></i> <span>Escritorio</span></a></li>';
          }

          // Mostrar la opción de Comunidades si el usuario tiene permiso
          if ($comunidades == 1) {
            echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-sitemap"></i> <span>Comunidades</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="comunidades.php"><i class="fa fa-circle-o"></i> Comunidades</a></li>
                    </ul>
                  </li>';
          }

          // Mostrar la opción de Acceso si el usuario tiene permiso
          if ($acceso == 1) {
            echo '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-users"></i> <span>Acceso</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                      <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                    </ul>
                  </li>';
          }
          ?>   
          <li><a href="#"><i class="fa fa-question-circle"></i> <span>Ayuda</span><small class="label pull-right bg-yellow">PDF</small></a></li>
          <li><a href="https://www.qachuualoom.org" target="_blank"><i class="fa fa-exclamation-circle"></i> <span>Acerca de</span><small class="label pull-right bg-yellow">ComCod</small></a></li>   
        </ul>
      </section>
    </aside>
