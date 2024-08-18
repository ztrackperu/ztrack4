<?php
// necesarios del modelo 
require_once '../models/empresas.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$empresas = new EmpresasModel();
//opciones a trabajar
switch ($option) {
    //para listar en tabla la informacion obtenidos de la database
    case 'listar':
        //pide todo los datos de empresa
        $data = $empresas->getEmpresas();
        for ($i = 0; $i < count($data); $i++) {
            //le añadimos los botones a la lista de datosv con las opciones en js
            $data[$i]['accion'] = '<div class="d-flex">
                <a class="btn btn-danger btn-sm" onclick="deleteEmpresa(' . $data[$i]['id'] . ')"><i class="fas fa-eraser"></i>D</a>
                <a class="btn btn-primary btn-sm" onclick="editEmpresa(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i>E</a>
                <a class="btn btn-info btn-sm" onclick="EmpresaDispositivo(' . $data[$i]['id'] . ')"><i class="fas fa-lock"></i>A</a>
                </div>';
        }
        echo json_encode($data);
        break;
    
    case 'EmpresaDispositivo':
        $id = $_GET['id'];
        $data['empresa'] = $empresas->empresaDatos($id);
        //aqui solo solcitar id , nombre 
        $data['reeferDisponible'] = $empresas->reeferDisponible();
        $data['maduradorDisponible'] = $empresas->maduradorDisponible();
        $data['generadorDisponible'] = $empresas->generadorDisponible(); 
        // aqui solicitar id, nombre , tipo , descripcion
        $data['reeferAsignado'] = $empresas->reeferAsignado($id);
        $data['maduradorAsignado'] = $empresas->maduradorAsignado($id);
        $data['generadorAsignado'] = $empresas->generadorAsignado($id);


        echo json_encode($data);
        break;

    case 'ListaGeneradores':
        $id = $_GET['id'];

        //aqui solo solcitar id , nombre 
        $data['generadorDisponible'] = $empresas->generadorDisponible();
        // aqui solicitar id, nombre , tipo , descripcion
        echo json_encode($data);
        break;

    case 'ListaReefer':
        $id = $_GET['id'];

        //aqui solo solcitar id , nombre 
        $data['reeferDisponible'] = $empresas->reeferDisponible();
        // aqui solicitar id, nombre , tipo , descripcion
        echo json_encode($data);
        break;
    
    case 'ListaMaduradores':
        $id = $_GET['id'];
        //aqui solo solcitar id , nombre 
        $data['maduradorDisponible'] = $empresas->maduradorDisponible();
        // aqui solicitar id, nombre , tipo , descripcion
        echo json_encode($data);
        break;

    case 'ListaDispositivosComando':
        $tipo = $_GET['id'];
        $data['dispositivos'] = $empresas->listaDispositivosComando($tipo);
        echo json_encode($data);
        break;

    case 'ListaComando':
        $lista = $_GET['id'];
        $separador =".";
        $separada = explode($separador,$lista);
        $tipo = $separada[1];
        $dispositivo = $separada[0];
        $data['divece'] =$dispositivo; 

        $data['comandos'] = $empresas->listaComando($tipo);
        //buscar el nombre del dispositivo  por consulta de id en tabla contenedor para poder filtrar comando
        $filtro1 = $empresas->busquedaDispositivo($dispositivo);
        //contar dispositivos asignados
        $dispositivoF = $filtro1['nombre_contenedor'];
        $filtro2 = $empresas->existeComandoA($dispositivoF);
        $data['contarAsig'] = $filtro2['count(*)'];
        
        $data['comandosAsignados'] =$empresas->listaCasignados($dispositivoF);
        echo json_encode($data);
        break;


    case 'ComandoIntegrado':
        $lista = $_GET['id'];
        $separador =".";
        $separada = explode($separador,$lista);
        $tipo = $separada[2];
        $dispositivo = $separada[1];
        $comando = $separada[0];
        
        $data['datosComando'] =$empresas->datosComando($comando); 

        $data['datosDispositivo'] = $empresas->datosDispositivoComando($tipo,$dispositivo);
        echo json_encode($data);
        break;
    

    case 'GrabarComando':
        $nombre_dispositivo = $_POST['nombre_dispositivo'];
        $comando_id = $_POST['comando_id'];
        $telemetria_id = $_POST['telemetria_id'];
        $valor_actual = $_POST['valor_actual'];
        $valor_modificado = $_POST['valor_modificado'];
        
        $cadena = $nombre_dispositivo.",".$comando_id.",".$telemetria_id.",".$valor_actual.",".$valor_modificado ;
        
        $decision = $empresas->existeComando($nombre_dispositivo,$comando_id,$telemetria_id);
        if($decision['count(*)']==0){
        $res = $empresas->grabarCopmando($nombre_dispositivo,$comando_id, $telemetria_id,$valor_actual,$valor_modificado);
        if ($res) {
            $res = array('tipo' => 'success', 'mensaje' => 'COMANDO ASIGNADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ASIGNAR COMANDO');
        }
        }
        else{
             $res = array('tipo' => 'error', 'mensaje' => 'YA EXISTE UN COMANDO ASIGNADO PENDIENTE');
        }                  
        echo json_encode($res);

        break;


    case 'GrabarComandoTemp':
        $comando = $_GET['id'];
        $text ="viene de afuera".$comando;
        $cadena = array(
            'imei'=>"866782048942516",
            'estado' =>0,
            'comando'=>$comando      
        );
        $dataControl = $empresas->EnvioComando($cadena);
        //$resultadoMadurador = json_decode($dataMadurador);
        //$resultadoMadurador = $resultadoMadurador->data;
        echo json_encode($dataControl);
        //echo $text;
        break;



    case 'GrabarComando_cliente':
        $lista = $_GET['id'];
        //$lista = $lista."desde el backend";
        $matriz = explode(",", $lista);

        $nombre_dispositivo = $matriz[1];
        $comando_id = $matriz[2];
        $telemetria_id = $matriz[3];
        $valor_actual = $matriz[4];
        $valor_modificado =$matriz[0] ;
        //echo $lista;
        //$res = array('tipo' => 'okey', 'mensaje' => 'YA EXISTE UN COMANDO ASIGNADO PENDIENTE'.$lista);
        //return json_encode($res);
        //break;
        if($valor_actual=="DEFROST"){
            $valor_actual = 3;
            $valor_modificado =0 ;

        }
        if($valor_modificado=="TERRIBLE"){
            if($valor_actual==1){
                $valor_modificado =0 ;
            }else{
                $valor_modificado =1 ;
            }

        }
        $cadena = $nombre_dispositivo.",".$comando_id.",".$telemetria_id.",".$valor_actual.",".$valor_modificado ;    
        $decision = $empresas->existeComando($nombre_dispositivo,$comando_id,$telemetria_id);
        if($decision['count(*)']==0){
        $res = $empresas->grabarCopmando($nombre_dispositivo,$comando_id, $telemetria_id,$valor_actual,$valor_modificado);
        if ($res) {
            $res = array('tipo' => 'success', 'mensaje' => 'COMANDO ASIGNADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ASIGNAR COMANDO');
        }
        }
        else{
             $res = array('tipo' => 'error', 'mensaje' => 'YA EXISTE UN COMANDO ASIGNADO PENDIENTE');
        }                  
        echo json_encode($res);

        break;
        

    case 'bajarExcel':
        $telemetria_id = $_POST['telemetria_id'];
     
        $R = $empresas->bajarExcelM($telemetria_id);
        //$data['contenedor'] = $empresas->excelMadurador($telemetria_id); 
        $data = "ok";
        $salida="";
        $salida .="<table>";
        $salida .="<thead><th>ID</th><th>FECHA</th><th>ETHYLENO</th></thead>";
        foreach($R as $refer){
            $salida .= "<tr><td>".$refer['id']."</td><td>".$refer['created_at']."</td><td>".$refer['ethylene']."</td></tr>";

        }
        $salida .= "</table>";

        header("Content-Type: application/xls");
        header("Content-Disposition:attachment; filename=reporte.xls");
        header("Pragma:no-cache");
        header("Expires:0");

                    
        echo $data;

        break;

    case 'bajarExcelM':
        $telemetria_id = $_POST['telemetria_id'];    
        $data['data'] = $empresas->excelMadurador($telemetria_id);                   
        echo json_encode($data);
        break;
    
    case 'bajarExcelR':
        $telemetria_id = $_POST['telemetria_id'];    
        $data['data'] = $empresas->excelMadurador($telemetria_id);                   
        echo json_encode($data);
        break;

    case 'bajarExcelG':
        $telemetria_id = $_POST['telemetria_id'];    
        $data['data'] = $empresas->excelGenset($telemetria_id);                   
        echo json_encode($data);
        break;


    case 'AsignarDispositivo':
        $tipo_dispositivo =$_POST['tipo_dispositivo'];
        $id_empresa = $_POST['id_empresa'];
        //id del dispositivo seleccionado
        $listaDispositivos =$_POST['listaDispositivos'];
        $fecha_cambio = date("Y-m-d H:i:s");
        if($tipo_dispositivo =="Madurador" or $tipo_dispositivo =="Reefer")
        {
            // Actualizar la tabla de contenedores el campo empresa id donde sea igual a listaDispositivo      
            $res = $empresas->asignarDispositivo($id_empresa,$fecha_cambio, $listaDispositivos);
            
            if ($res) {
                $res = array('tipo' => 'success', 'mensaje' => 'DISPOSITIVO ASIGNADO');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ASIGNAR DISPOSITIVO');
            }                  
            echo json_encode($res);

        }else if($tipo_dispositivo =="Generador")
        {
            $res = $empresas->asignarDispositivoG($id_empresa,$fecha_cambio, $listaDispositivos);
            
            if ($res) {
                $res = array('tipo' => 'success', 'mensaje' => 'DISPOSITIVO ASIGNADO');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ASIGNAR DISPOSITIVO');
            }                  
            echo json_encode($res);

        }



        break;
        
    case 'save':
        //datos vienen del formulario
        $nombre_empresa = $_POST['nombre_empresa'];
        $descripcion = $_POST['descripcion'];
        $temp_contratada = $_POST['temp_contratada'];
        $id = $_POST['id_empresa'];
        // si id es vacio vamos a guardar los nuevos datos
        if ($id == '') { 
            $consult = $empresas->comprobarEmpresa($nombre_empresa);
            if (empty($consult)) {      
                $result = $empresas->saveEmpresa($nombre_empresa, $descripcion, $temp_contratada);
                if ($result) {
                //aqui solicitamos los datos del usuario que acabamos de guardar                
                $u_result = $empresas->getEmpresa_obtener($nombre_empresa);
                // aqui agregamos a las variables los campos de datos obtenidos
                $id_r = $u_result['id'];
                $nombre_empresa_r = $u_result['nombre_empresa'];
                $descripcion_r = $u_result['descripcion'];
                $temp_contratada_r = $u_result['temp_contratada'];
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "REGISTRADO";               
                //mandamos a guardar en el historial de empresas
                $historial_empresa_grabar = $empresas->savehistorialEmpresa($id_r ,$nombre_empresa_r, $descripcion_r ,$temp_contratada_r,$fecha_cambio ,$usuario_cambio_id ,$accion);
                $res = array('tipo' => 'success', 'mensaje' => 'EMPRESA REGISTRADA');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL REGISTRAR');
                }
            }else {
                $res = array('tipo' => 'error', 'mensaje' => 'LA EMPRESA YA EXISTE');
            }
          
        } 
        // en caso contrario se actualiza la informacion de la $id recibida
        else {
            $fecha_update = date("Y-m-d H:i:s");
            // aqui enviamos a actualizar la informacion
            $result = $empresas->updateEmpresa($nombre_empresa, $descripcion, $temp_contratada,$fecha_update,$id);
            if ($result) {
                // agregamos los datos grabados en update y le añadimos los datos para el historial
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "EDITADO";
                $historial_empresa_grabar = $empresas->savehistorialEmpresa($id ,$nombre_empresa , $descripcion ,$temp_contratada ,$fecha_cambio ,$usuario_cambio_id ,$accion);

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
        $data = $empresas->deleteEmpresa($fecha_update,$id);
        if ($data) {
            // solicito los datos de la id a eliminar para guardar los datos en el historial
            $u_result = $empresas->getEmpresa_id($id);                
            $id_r = $u_result['id'];
            $nombre_empresa_r = $u_result['nombre_empresa'];
            $descripcion_r = $u_result['descripcion'];
            $temp_contratada_r = $u_result['temp_contratada'];
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ELIMINADO";
            //guardo la accion en el historial
            $historial_empresa_grabar = $empresas->savehistorialEmpresa($id_r ,$nombre_empresa_r , $descripcion_r ,$temp_contratada_r ,$fecha_cambio ,$usuario_cambio_id ,$accion);
            $res = array('tipo' => 'success', 'mensaje' => 'EMPRESA ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res);
        break;
    case 'edit':
        $id = $_GET['id'];
        // le paso los datos a js para que cargue los datos en el formulario
        $data = $empresas->getEmpresa_id($id);
        echo json_encode($data);
        break;

    case 'eliminarEmpresa' :
        $id = $_GET['valor'];

        $data = $empresas->eliminarEmpresa($id);
        if($data){

        }

        break;
    
    case 'deleteAsignacionDispositivo' :

        
        $fecha_update = date("Y-m-d H:i:s");
        $id = $_GET['id'];

        $data = $empresas->deleteAsignacionEmpresa($fecha_update,$id);

        if ($data) {
            // solicito los datos de la id a eliminar para guardar los datos en el historial
            /*
            $u_result = $empresas->getEmpresa_id($id);                
            $id_r = $u_result['id'];
            $nombre_empresa_r = $u_result['nombre_empresa'];
            $descripcion_r = $u_result['descripcion'];
            $temp_contratada_r = $u_result['temp_contratada'];
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ELIMINADO";
            //guardo la accion en el historial
            $historial_empresa_grabar = $empresas->savehistorialEmpresa($id_r ,$nombre_empresa_r , $descripcion_r ,$temp_contratada_r ,$fecha_cambio ,$usuario_cambio_id ,$accion);
            */
            $res = array('tipo' => 'success', 'mensaje' => 'ASIGNACION ELIMINADA');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR ASIGNACION');
        }
        echo json_encode($res);
        break;
        
        break;

    case 'deteleComandoA' :

        $id = $_GET['id'];
        $data = $empresas->actualizarComandoM($id);

        if ($data) {

            $res = array('tipo' => 'success', 'mensaje' => 'COMANDO ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR COMANDO');
        }
        echo json_encode($res);
        break;
        
        break;
    default:
        # code...
        break;
}
