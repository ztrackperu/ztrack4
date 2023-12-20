<?php
require_once '../models/api.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$api = new ApiModel();
switch ($option) {

    case 'reefer':
        $id = $_GET['id'];
        $data['tramaReefer'] = $api->listareefer($id);
        //$consulta = $usuarios->getDetalle($id);
        $data['contenedor'] = $api->idEmpresa($id);
        $data['upunto'] = $api->rpunto($id);


        echo json_encode($data);
        break;

    case 'reeferAdmin':
      
        $data['reeferTotal'] = $api->TablaReefer();




        echo json_encode($data);
        break;
    case 'madurador':
        $id = $_GET['id'];
        $data['tramaReefer'] = $api->listaMaduradorTotal($id);
        //$consulta = $usuarios->getDetalle($id);
        $data['contenedor'] = $api->idEmpresa($id);
        $data['upunto'] = $api->mpunto($id);

        echo json_encode($data);
        break;
    case 'genset':
        $id = $_GET['id'];
        $data['tramaGenset'] = $api->listaGenset_r($id);
        //$consulta = $usuarios->getDetalle($id);
        $data['generador'] = $api->idGenerador($id);
        $data['upunto'] = $api->upunto($id);

        echo json_encode($data);
        break;

    case 'multilog':
            $id = $_GET['id'];
            $data['tramaReefer'] = $api->listaMultilog($id);
            //$consulta = $usuarios->getDetalle($id);
            $data['generador'] = $api->idGenerador($id);
    
    
            echo json_encode($data);
            break;
    


    default:
        # code...
        break;
}
