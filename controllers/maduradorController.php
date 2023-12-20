<?php
require_once '../models/api.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$api = new ApiModel();
switch ($option) {

    case 'madurador':
        $id = $_GET['id'];
        $data['tramaMadurador'] = $api->listaMadurador($id);
        //$consulta = $usuarios->getDetalle($id);
        $data['contenedor'] = $api->idEmpresa($id);


        echo json_encode($data);
        break;


    default:
        # code...
        break;
}
