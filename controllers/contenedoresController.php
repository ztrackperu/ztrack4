<?php
// necesarios del modelo 
require_once '../models/contenedores.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$contenedores = new ContenedoresModel();
//opciones a trabajar
switch ($option) {
    //para listar en tabla la informacion obtenidos de la database
    case 'listar':
        //pide todo los datos de los contenedores
        $data = $contenedores->getContenedores();
        for ($i = 0; $i < count($data); $i++) {
            //le añadimos los botones a la lista de datosv con las opciones en js
            $data[$i]['accion'] = '<div class="d-flex">
                <a class="btn btn-danger btn-sm" onclick="deleteContenedor(' . $data[$i]['id'] . ')"><i class="fas fa-eraser"></i>D</a>
                <a class="btn btn-primary btn-sm" onclick="editContenedor(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i>E</a>
                <a class="btn btn-info btn-sm" onclick=""><i class="fas fa-lock"></i>P</a>
                </div>';
        }
        echo json_encode($data);
        break;
        
    case 'save':
        //datos vienen del formulario
        $nombre_contenedor = $_POST['nombre_contenedor'];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipo'];
        $id = $_POST['id_contenedor'];
        // si id es vacio vamos a guardar los nuevos datos
        if ($id == '') { 
            $consult = $contenedores->comprobarContenedor($nombre_contenedor);
            if (empty($consult)) {      
                $result = $contenedores->saveContenedor($nombre_contenedor, $descripcion,$tipo);
                if ($result) {
                //aqui solicitamos los datos del generador que acabamos de guardar                
                $u_result = $contenedores->getContenedor_obtener($nombre_contenedor);
                // aqui agregamos a las variables los campos de datos obtenidos
                $id_r = $u_result['id'];
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "REGISTRADO";               
                //mandamos a guardar en el historial de telemetrias
                $historial_contenedor_grabar = $contenedores->savehistorialContenedor($id_r ,$nombre_contenedor, $descripcion ,$tipo,$fecha_cambio ,$usuario_cambio_id ,$accion);
                $res = array('tipo' => 'success', 'mensaje' => 'CONTENEDOR REGISTRADA');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL REGISTRAR');
                }
            }else {
                $res = array('tipo' => 'error', 'mensaje' => 'EL NOMBRE DE CONTENEDOR YA EXISTE');
            }
          
        } 
        // en caso contrario se actualiza la informacion de la $id recibida
        else {
            $fecha_update = date("Y-m-d H:i:s");
            //aqui solcitamos la info del contenedor para actualizarla
            $result_1 = $contenedores->getContenedor_id($id);
            $empresa_id = $result_1['empresa_id'];
            $generador_id = $result_1['generador_id'];
            $telemetria_id = $result_1['telemetria_id'];
            // aqui enviamos a actualizar la informacion
            $result = $contenedores->updateContenedor($nombre_contenedor, $descripcion,$tipo ,$empresa_id, $generador_id,$telemetria_id, $fecha_update,$id);
            if ($result) {
                // agregamos los datos grabados en update y le añadimos los datos para el historial
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "EDITADO";
                $historial_contenedor_grabar = $contenedores->edithistorialContenedor($id ,$nombre_contenedor, $descripcion,$tipo ,$empresa_id, $generador_id,$telemetria_id ,$fecha_cambio ,$usuario_cambio_id ,$accion);

                $res = array('tipo' => 'success', 'mensaje' => 'CONTENEDOR MODIFICADO');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR');
            }
        }
        echo json_encode($res);
        break;
    case 'delete':
        $fecha_update = date("Y-m-d H:i:s");
        $id = $_GET['id'];
        $data = $contenedores->deleteContenedor($fecha_update,$id);
        if ($data) {
            // solicito los datos de la id a eliminar para guardar los datos en el historial
            $u_result = $contenedores->getContenedor_id($id);                
            $nombre_contenedor = $u_result['nombre_contenedor'];
            $descripcion = $u_result['descripcionC'];
            $tipo = $u_result['tipo'];
            $empresa_id = $u_result['empresa_id'];
            $generador_id = $u_result['generador_id'];
            $telemetria_id = $u_result['telemetria_id'];
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ELIMINADO";
            //guardo la accion en el historial
            $historial_contenedor_grabar = $contenedores->edithistorialContenedor($id ,$nombre_contenedor, $descripcion,$tipo ,$empresa_id, $generador_id,$telemetria_id ,$fecha_cambio ,$usuario_cambio_id ,$accion);
            $res = array('tipo' => 'success', 'mensaje' => 'CONTENEDOR ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res);
        break;
    case 'edit':
        $id = $_GET['id'];
        // le paso los datos a js para que cargue los datos en el formulario
        $data = $contenedores->getContenedor_id($id);
        echo json_encode($data);
        break;
    default:
        # code...
        break;
}
