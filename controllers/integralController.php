<?php
require_once '../models/integral.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$integral = new IntegralModel();
switch ($option) {

    case 'analizarTablas':
        $idf = $_GET['id'];

        
        $empresa =  substr($idf, strpos($idf,',')+strlen(','));

        $tipoUsuario = substr($idf, 0, strpos($idf, ','));

        $data['contarReefer'] = $integral->ContarReffer($tipoUsuario , $empresa);
        $data['contarMadurador'] = $integral->ContarMadurador($tipoUsuario , $empresa); 
        $data['contarGenset'] = $integral->ContarGenset($tipoUsuario , $empresa);




        echo json_encode($data);
        break;


    default:
        # code...
        break;
}
