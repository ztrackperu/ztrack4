<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pagina Principal</title>

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo RUTA . 'assets/'; ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo RUTA . 'assets/'; ?>css/snackbar.min.css" rel="stylesheet">
    <link href="<?php echo RUTA . 'assets/'; ?>css/iframe.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo RUTA . 'assets/'; ?>css/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RUTA . 'assets/'; ?>css/dataTables.dateTime.min.css" />
</head>
<?php $mini = false;
if (!empty($_GET['pagina'])) {
    if ($_GET['pagina'] == 'ventas' || $_GET['pagina'] == 'compras') {
        $mini = true;
    }
}
?>

<body id="page-top" class="<?php echo ($mini) ? 'sidebar-toggled' : ''; ?>">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion <?php echo ($mini) ? 'toggled' : ''; ?>" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="plantilla.php">
                <div class="sidebar-brand-icon ">
                    <img src="assets/img/logo.png" alt="LOGO-PNG" width="100">
                </div>
                
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo (empty($_GET['pagina'])) ? 'bg-gradient-info' : ''; ?>">
                <a class="nav-link" href="?pagina=mapa">
                    <i class="fas fa-chart-pie"></i>
                    <span>Administración</span></a>
            </li>



            <?php if (!empty($proveedor)) { ?>
                <hr class="sidebar-divider d-none d-md-block">
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item <?php echo (!empty($_GET['pagina'])  && $_GET['pagina'] == 'proveedor') ? 'bg-gradient-info' : ''; ?>">
                    <a class="nav-link" href="?pagina=telemetrias">
                        <i class="fas fa-store"></i>
                        <span>Telemetrias</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (!empty($proveedor)) { ?>
                <hr class="sidebar-divider d-none d-md-block">
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item <?php echo (!empty($_GET['pagina'])  && $_GET['pagina'] == 'reporte') ? 'bg-gradient-info' : ''; ?>">
                    <a class="nav-link" href="?pagina=contenedores">
                        <i class="fas fa-store"></i>
                        <span>Contenedores</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (!empty($proveedor)) { ?>
                <hr class="sidebar-divider d-none d-md-block">
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item <?php echo (!empty($_GET['pagina'])  && $_GET['pagina'] == 'compras') ? 'bg-gradient-info' : ''; ?>">
                    <a class="nav-link" href="?pagina=generadores">
                        <i class="fas fa-store"></i>
                        <span>Generadores</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (!empty($usuarios)) { ?>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <li class="nav-item <?php echo (!empty($_GET['pagina'])  && $_GET['pagina'] == 'proveedor') ? 'bg-gradient-info' : ''; ?>">
                    <a class="nav-link" href="?pagina=empresas">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Empresas</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (!empty($usuarios)) { ?>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <li class="nav-item <?php echo (!empty($_GET['pagina'])  && $_GET['pagina'] == 'usuarios') ? 'bg-gradient-info' : ''; ?>">
                    <a class="nav-link" href="?pagina=usuarios">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
            <?php } ?>



            <?php if (!empty($configuracion)) { ?>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <li class="nav-item <?php echo (!empty($_GET['pagina']) && $_GET['pagina'] == 'configuracion') ? 'bg-gradient-info' : ''; ?>">
                    <a class="nav-link" href="?pagina=configuracion">
                        <i class="fas fa-user-cog"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            <?php } ?>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-3">
                <button class="rounded-circle border-0" id="sidebarToggle"><i class="fas fa-chevron-circle-left text-gray-400"></i></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                    <li class="nav-item" >
                   <h3 style="color : red;"> <a  class="nav-link" href="../../ztrack1/test4/">
                        
                        VOLVER AL MAPA 
                    </a></h3>
                </li>
                        
                         

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nombres']; ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo RUTA .  'assets/img/avatar.png'; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerra Sesion
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
