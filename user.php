<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';
require_once 'controllers/plantillaController.php';
$plantilla = new Plantilla();
##### PERMISOS #####

require_once 'models/permisos.php';
$id_user = $_SESSION['id'];
$permisos = new PermisosModel();
$configuracion = $permisos->getPermiso(1, $id_user);
$usuarios = $permisos->getPermiso(2, $id_user);
$clientes = $permisos->getPermiso(3, $id_user);
$productos = $permisos->getPermiso(4, $id_user);
$ventas = $permisos->getPermiso(5, $id_user);
$nueva_venta = $permisos->getPermiso(6, $id_user);
$compras = $permisos->getPermiso(7, $id_user);
$nueva_compra = $permisos->getPermiso(8, $id_user);
$proveedor = $permisos->getPermiso(9, $id_user);
$administracion =$permisos->getPermiso(10,$id_user);

##### FIN PERMISOS ####
require_once 'views/includes/header_user.php';
if (isset($_GET['pagina'])) {
    if (empty($_GET['pagina'])) {
        $plantilla->index();
    }else{
        try {
            $archivo = $_GET['pagina'];
            if ($archivo == 'usuarioss' && !empty($usuarios)) {
                $plantilla->usuarioss();
            } else if ($archivo == 'configuracion' && !empty($configuracion)) {
                $plantilla->configuracion();
            } else if ($archivo == 'tramas' && !empty($clientes)) {
                $plantilla->clientes();
            } else if ($archivo == 'empresas' && !empty($proveedor)) {
                $plantilla->empresas();
            }else if ($archivo == 'telemetrias' && !empty($productos)) {
                $plantilla->telemetrias();
            } else if ($archivo == 'generadores' && !empty($nueva_venta)) {
                $plantilla->generadores();
            } else if ($archivo == 'contenedores' && !empty($ventas)) {
                $plantilla->contenedores();
            } else if ($archivo == 'mapa' && !empty($ventas)) {
                $plantilla->mapa();
            } else if ($archivo == 'trama_madurador' && !empty($ventas)) {
                $plantilla->trama_madurador();
            } else if ($archivo == 'trama_reffer' && !empty($ventas)) {
                $plantilla->trama_reffer();
            } else if ($archivo == 'trama_genset' && !empty($ventas)) {
                $plantilla->trama_genset();
            } else if ($archivo == 'Administracion' && !empty($administracion)) {

            } else{
                $plantilla->notFound();
            }
        } catch (\Throwable $th) {
            $plantilla->notFound();
        }
    }
}else{
    $plantilla->index();
}
require_once 'views/includes/footer.php';
