
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Plataforma de monitoreo de disositivos con telemetria">
    <meta name="author" content="Luis Pablo Marcelo Perea, and Bootstrap contributors">
    <meta name="generator" content="lpmp 0.1">
    <title>ZTRACK | Monitoreo en vivo</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbars-offcanvas/">
    <link href="bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="leaflet.css" />
    <link rel="stylesheet" href="ac1.css" />
    <link rel="stylesheet" href="bc1.css" />
    <link rel="stylesheet" href="jquery.dataTables.min.css" />
    <link rel="stylesheet" href="leaflet.awesome-markers.css">
    <link rel="stylesheet" href="MarkerCluster.css">
    <link rel="stylesheet" href="MarkerCluster.Default.css">
    <link rel="stylesheet" href="total.css">
    <!-- Custom styles for this template -->
    <link href="navbars-offcanvas.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="../assets/js/hammer.min.js"></script>
    <script src="../assets/js/chartjs-plugin-zoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0 "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
    <link href="select2.css" rel="stylesheet" />
    <link href="snackbar.min.css" rel="stylesheet">
    <link href="context-menu.min.css" rel="stylesheet" type="text/css">      
  </head>
  <body></body>



<?php
require_once '../models/integral.php';
$api = new IntegralModel();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
echo" ola mundo ";

//$tipo_usuario = 2 ;
$tipo_usuario =$_SESSION['permiso'] ;
$usuario = $_SESSION['id'] ;
echo "ola mundo";
echo " este es el  TIPO usuario : ".$tipo_usuario ;
echo " este es el USUARIO : ".$usuario ;
if($tipo_usuario ==1){
    $empresa_general = 1;
}else {
echo " este es el usuario : ".$usuario ;
$datosUsuario = $api->UsuarioEmpresa($usuario);
echo var_dump($datosUsuario);
$empresa_general = $datosUsuario['empresa_id'] ;
}
echo " ala empresa es : ".$empresa_general ;





?>