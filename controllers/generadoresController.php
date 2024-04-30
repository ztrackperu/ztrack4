<?php
// necesarios del modelo 
require_once '../models/generadores.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$generadores = new GeneradoresModel();
//opciones a trabajar
switch ($option) {
    //para listar en tabla la informacion obtenidos de la database
    case 'listar':
        //pide todo los datos de empresa
        $data = $generadores->getGeneradores();
        for ($i = 0; $i < count($data); $i++) {
            //le añadimos los botones a la lista de datosv con las opciones en js
            $data[$i]['accion'] = '<div class="d-flex">
                <a class="btn btn-danger btn-sm" onclick="deleteGenerador(' . $data[$i]['id'] . ')"><i class="fas fa-eraser"></i>D</a>
                <a class="btn btn-primary btn-sm" onclick="editGenerador(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i>E</a>
                <a class="btn btn-info btn-sm" onclick=""><i class="fas fa-lock"></i>P</a>
                </div>';
        }
        echo json_encode($data);
        break;
        
    case 'save':
        //datos vienen del formulario
        $nombre_generador = $_POST['nombre_generador'];
        $descripcion = $_POST['descripcion'];
        $id = $_POST['id_generador'];
        // si id es vacio vamos a guardar los nuevos datos
        if ($id == '') { 
            $consult = $generadores->comprobarGenerador($nombre_generador);
            if (empty($consult)) {      
                $result = $generadores->saveGenerador($nombre_generador, $descripcion);
                if ($result) {
                //aqui solicitamos los datos del generador que acabamos de guardar                
                $u_result = $generadores->getGenerador_obtener($nombre_generador);
                // aqui agregamos a las variables los campos de datos obtenidos
                $id_r = $u_result['id'];
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "REGISTRADO";               
                //mandamos a guardar en el historial de telemetrias
                $historial_generador_grabar = $generadores->savehistorialGenerador($id_r ,$nombre_generador, $descripcion ,$fecha_cambio ,$usuario_cambio_id ,$accion);
                $res = array('tipo' => 'success', 'mensaje' => 'GENERADOR REGISTRADA');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL REGISTRAR');
                }
            }else {
                $res = array('tipo' => 'error', 'mensaje' => 'EL NOMBRE DE GENERADOR YA EXISTE');
            }
          
        } 
        // en caso contrario se actualiza la informacion de la $id recibida
        else {
            $fecha_update = date("Y-m-d H:i:s");
            // aqui enviamos a actualizar la informacion
            $result = $generadores->updateGenerador($nombre_generador, $descripcion,$fecha_update,$id);
            if ($result) {
                // agregamos los datos grabados en update y le añadimos los datos para el historial
                $u_result = $generadores->getGenerador_id($id);                
                $id_r = $u_result['id'];
                $nombre_generador = $u_result['nombre_generador'];
                $descripcion = $u_result['descripcion'];
                $empresa_id = $u_result['empresa_id'];
                $telemetria_id = $u_result['telemetria_id'];
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "EDITADO";
                //guardo la accion en el historial
                $historial_generador_grabar =$generadores->edithistorialGenerador($id_r ,$nombre_generador, $descripcion , $empresa_id , $telemetria_id,$fecha_cambio ,$usuario_cambio_id ,$accion);   

                $res = array('tipo' => 'success', 'mensaje' => 'GENERADOR MODIFICADA');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR');
            }
        }
        echo json_encode($res);
        break;
    case 'delete':
        $fecha_update = date("Y-m-d H:i:s");
        $id = $_GET['id'];
        $data = $generadores->deleteGenerador($fecha_update,$id);
        if ($data) {
            // solicito los datos de la id a eliminar para guardar los datos en el historial
            $u_result = $generadores->getGenerador_id($id);                
            $id_r = $u_result['id'];
            $nombre_generador = $u_result['nombre_generador'];
            $descripcion = $u_result['descripcion'];
            $empresa_id = $u_result['empresa_id'];
            $telemetria_id = $u_result['telemetria_id'];
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ELIMINADO";
            //guardo la accion en el historial
            $historial_generador_grabar =$generadores->edithistorialGenerador($id_r ,$nombre_generador, $descripcion , $empresa_id , $telemetria_id,$fecha_cambio ,$usuario_cambio_id ,$accion);           
            $res = array('tipo' => 'success', 'mensaje' => 'GENERADOR ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res);
        break;
    case 'edit':
        $id = $_GET['id'];
        // le paso los datos a js para que cargue los datos en el formulario
        $data = $generadores->getGenerador_id($id);
        echo json_encode($data);
        break;
    default:
        # code...
        break;
}
