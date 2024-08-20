<?php
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
?>