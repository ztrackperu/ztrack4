<?php
// necesarios del modelo 
require_once '../models/telemetrias.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$telemetrias = new TelemetriasModel();
//opciones a trabajar
switch ($option) {
    //para listar en tabla la informacion obtenidos de la database
    case 'listar':
        //pide todo los datos de empresa
        $data = $telemetrias->getTelemetrias();
        for ($i = 0; $i < count($data); $i++) {
            //le añadimos los botones a la lista de datosv con las opciones en js
            $data[$i]['accion'] = '<div class="d-flex">
                <a class="btn btn-danger btn-sm" onclick="deleteTelemetria(' . $data[$i]['id'] . ')"><i class="fas fa-eraser"></i>D</a>
                <a class="btn btn-primary btn-sm" onclick="editTelemetria(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i>E</a>
                <a class="btn btn-info btn-sm" onclick=""><i class="fas fa-lock"></i>P</a>
                </div>';
        }
        echo json_encode($data);
        break;
        
    case 'save':
        //datos vienen del formulario
        $numero_telefono = $_POST['numero_telefono'];
        $imei = $_POST['imei'];
        $id = $_POST['id_telemetria'];
        // si id es vacio vamos a guardar los nuevos datos
        if ($id == '') { 
            $consult = $telemetrias->comprobarTelemetria($imei);
            if (empty($consult)) {      
                $result = $telemetrias->saveTelemetria($numero_telefono, $imei);
                if ($result) {
                //aqui solicitamos los datos de la telemetria que acabamos de guardar                
                $u_result = $telemetrias->getTelemetria_obtener($imei);
                // aqui agregamos a las variables los campos de datos obtenidos
                $id_r = $u_result['id'];
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "REGISTRADO";               
                //mandamos a guardar en el historial de telemetrias
                $historial_telemetria_grabar = $telemetrias->savehistorialTelemetria($id_r ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion);
                //$historial_telemetria_grabar = $telemetrias->savehistorialTelemetria(2 ,"41", "terr" ,$fecha_cambio ,$usuario_cambio_id ,$accion);
                $res = array('tipo' => 'success', 'mensaje' => 'TELEMETRIA REGISTRADA');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL REGISTRAR');
                }
            }else {
                $res = array('tipo' => 'error', 'mensaje' => 'EL IMEI YA EXISTE');
            }
          
        } 
        // en caso contrario se actualiza la informacion de la $id recibida
        else {
            $fecha_update = date("Y-m-d H:i:s");
            // aqui enviamos a actualizar la informacion
            $result = $telemetrias->updateTelemetria($numero_telefono, $imei,$fecha_update,$id);
            if ($result) {
                // agregamos los datos grabados en update y le añadimos los datos para el historial
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "EDITADO";
                $historial_telemetria_grabar = $telemetrias->savehistorialTelemetria($id ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion);

                $res = array('tipo' => 'success', 'mensaje' => 'EMPRESA MODIFICADA');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR');
            }
        }
        echo json_encode($res);
        break;
    case 'delete':
        $fecha_update = date("Y-m-d H:i:s");
        $id = $_GET['id'];
        $data = $telemetrias->deleteTelemetria($fecha_update,$id);
        if ($data) {
            // solicito los datos de la id a eliminar para guardar los datos en el historial
            $u_result = $telemetrias->getTelemetria_id($id);                
            $id_r = $u_result['id'];
            $numero_telefono = $u_result['numero_telefono'];
            $imei = $u_result['imei'];
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ELIMINADO";
            //guardo la accion en el historial
            $historial_telemetria_grabar = $telemetrias->savehistorialTelemetria($id_r ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion);
            $res = array('tipo' => 'success', 'mensaje' => 'TELEMETRIA ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res);
        break;
    case 'edit':
        $id = $_GET['id'];
        // le paso los datos a js para que cargue los datos en el formulario
        $data = $telemetrias->getTelemetria_id($id);
        echo json_encode($data);
        break;
    default:
        # code...
        break;
}
