
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



function EstadoDispositivo($ultima_conexion){
    $captura30min = date('Y-m-d H:i:s',mktime(date('H'),date('i')-30,date('s'),date('n'),date('j'),date('Y')));
    $captura1dia= date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('n'),date('j')-1,date('Y')));
    if($captura30min>=$ultima_conexion){
      if($captura1dia>=$ultima_conexion){
        $estado =3;
      }else{
        $estado =2;
      }
    }else{
      $estado = 1;
    }
    return $estado;
  }
    $R = $api->TablaReefer($tipo_usuario,$empresa_general);
    $M = $api->TablaMadurador($tipo_usuario,$empresa_general);
    $G = $api->TablaGenset($tipo_usuario,$empresa_general);
    //contador de elementos generales ADMIN/EMPRESAS
    $cR = $api->ContarReffer($tipo_usuario,$empresa_general);
    $cM = $api->ContarMadurador($tipo_usuario,$empresa_general);
    $cG = $api->ContarGenset($tipo_usuario,$empresa_general);
    //Contar dispositivos en ON
    $cRon = $api->ContarRefferON($tipo_usuario,$empresa_general);
    $cMon = $api->ContarMaduradorON($tipo_usuario,$empresa_general);
    $cGon = $api->ContarGensetON($tipo_usuario,$empresa_general);
    $totalON =$cRon['count(*)'] +$cMon['count(*)'] + $cGon['count(*)'];
    //Contar dispositivos en WAIT
    $cRwait = $api->ContarRefferWAIT($tipo_usuario,$empresa_general);
    $cMwait = $api->ContarMaduradorWAIT($tipo_usuario,$empresa_general);
    $cGwait = $api->ContarGensetWAIT($tipo_usuario,$empresa_general);
    $totalWAIT =$cRwait['count(*)'] +$cMwait['count(*)'] + $cGwait['count(*)'];
      //Contar dispositivos en OFF
      $cRoff = $api->ContarRefferOFF($tipo_usuario,$empresa_general);
      $cMoff = $api->ContarMaduradorOFF($tipo_usuario,$empresa_general);
      $cGoff = $api->ContarGensetOFF($tipo_usuario,$empresa_general);
      $totalOFF =$cRoff['count(*)'] +$cMoff['count(*)'] + $cGoff['count(*)'];
  ?>



?>