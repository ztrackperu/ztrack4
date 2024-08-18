<?php
require_once '../config.php';
require_once 'conexion.php';
class EmpresasModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    //envio de comandos a NUEVA API 

    public function EnvioComando($data)
    {
        $ch = curl_init();
        $data =json_encode($data);
        curl_setopt($ch, CURLOPT_URL, "http://161.132.206.104:9050/Comandos/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }
    //EnvioComando_libre
    public function EnvioComando_libre($data)
    {
        $ch = curl_init();
        $data =json_encode($data);
        curl_setopt($ch, CURLOPT_URL, "http://161.132.206.104:9050/Comandos/libre/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }



    // LLAMA A TODAS LOS DATOS DE EMPRESAS con estado 1
    public function getEmpresas()
    {
        $consult = $this->pdo->prepare("SELECT * FROM empresas WHERE estado =1 ");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
        //Llama a los datos de la empresa que se acaba de agregar  , para luego guardarlo en historial
    public function comprobarEmpresa($nombre_empresa)
    {
        $consult = $this->pdo->prepare("SELECT * FROM empresas WHERE nombre_empresa = ? and estado =1"); 
        $consult->execute([$nombre_empresa]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se solicita los datos de la empresa que se acaba de guardar para el historial
    public function getEmpresa_obtener($nombre_empresa)
    {
            $consult = $this->pdo->prepare("SELECT * FROM empresas WHERE nombre_empresa = ?");
            $consult->execute([$nombre_empresa]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }

    //GUARDA LA EMPRESA
    public function saveEmpresa($nombre_empresa, $descripcion, $temp_contratada)
    {
        $consult = $this->pdo->prepare("INSERT INTO empresas (nombre_empresa, descripcion, temp_contratada) VALUES (?,?,?)");
        return $consult->execute([$nombre_empresa, $descripcion, $temp_contratada]);
    }
    //ELIMINAR EMPRESA-CAMBIA DE ESTADO DE 1 A 0
    public function deleteEmpresa($fecha_update,$id)
    {
        $consult = $this->pdo->prepare("UPDATE empresas SET estado = ?  ,updated_at=? WHERE id = ?");
        return $consult->execute([0, $fecha_update , $id]);
    }
    //ACTUALIZAR EMPRESA
    public function updateEmpresa($nombre_empresa, $descripcion, $temp_contratada,$fecha_update ,$id)
    {       
        $consult = $this->pdo->prepare("UPDATE empresas SET nombre_empresa=? ,  descripcion=? ,temp_contratada=? ,updated_at=? WHERE id=?");
        return $consult->execute([$nombre_empresa, $descripcion, $temp_contratada,$fecha_update ,$id]);
    }

    // se busca la empresa por id para guardarlo en el historial como editado o eliminado
    public function getEmpresa_id($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se guarada en el historial ñas acciones de guardar , editar , eliminar
    public function savehistorialEmpresa($id_r ,$nombre_empresa_r , $descripcion_r ,$temp_contratada_r ,$fecha_cambio ,$usuario_cambio_id ,$accion)
    {
        $consult = $this->pdo->prepare("INSERT INTO historial_empresas ( id_empresa ,nombre_empresa, descripcion, temp_contratada, fecha_cambio,usuario_cambio_id ,evento) VALUES (?,?,?,?,?,?,?)");
        return $consult->execute([$id_r ,$nombre_empresa_r , $descripcion_r ,$temp_contratada_r ,$fecha_cambio ,$usuario_cambio_id ,$accion]);
    }
   // aqui viene la rutina de datos necesarios para asignar dispositivos 
    public function empresaDatos($id)
    {
        $consult = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");
        $consult->execute([$id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function generadorDisponible()
    {
        $consult = $this->pdo->prepare("SELECT id,nombre_generador FROM generadores WHERE empresa_id =1 and  estado =1"); 
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function maduradorDisponible()
    {
        $consult = $this->pdo->prepare("SELECT id , nombre_contenedor FROM contenedores WHERE empresa_id =1 AND tipo ='Madurador'  AND estado = 1");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function reeferDisponible()
    {
        $consult = $this->pdo->prepare("SELECT id , nombre_contenedor FROM contenedores WHERE empresa_id =1 AND tipo ='Reefer' AND estado = 1");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    //Lista desplegable para Control de Dispositivo 
    public function listaDispositivosComando($tipo)
    {
        if($tipo=="Reefer"){ 
            $consult = $this->pdo->prepare("SELECT id,nombre_contenedor FROM contenedores WHERE estado=1 AND tipo='Reefer' ");
            $consult->execute();
        }else if($tipo=="Madurador"){
            $consult = $this->pdo->prepare("SELECT id,nombre_contenedor  FROM contenedores WHERE estado=1 AND tipo='Madurador' ");
            $consult->execute();
        }else if($tipo=="Generador"){
            $consult = $this->pdo->prepare("SELECT id,nombre_generador  FROM generadores WHERE estado=1");
            $consult->execute();
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listaComando($tipo)
    {
        $consult = $this->pdo->prepare("SELECT * FROM lista_comando WHERE tipo_dispositivo = ?");
        $consult->execute([$tipo]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaCasignados($dispositivo)
    {
        $consult = $this->pdo->prepare("SELECT * FROM tabla_comandos WHERE nombre_dispositivo = ? and estado_comando =1");
        $consult->execute([$dispositivo]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function busquedaDispositivo($dispositivo)
    {
        $consult = $this->pdo->prepare("SELECT id ,nombre_contenedor FROM contenedores WHERE id = ?");
        $consult->execute([$dispositivo]);
        return $consult->fetch(PDO::FETCH_ASSOC);

    }

    public function datosComando($comando)
    {
        $consult = $this->pdo->prepare("SELECT * FROM lista_comando WHERE id = ?");
        $consult->execute([$comando]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function datosDispositivoComando($tipo,$dispositivo)
    {
        if($tipo =="Generador"){
            $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE id = ?");
            $consult->execute([$dispositivo]);

        }else{
            $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE id = ?");
            $consult->execute([$dispositivo]);

        }

        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function existeComando($nombre_dispositivo,$comando_id,$telemetria_id)
    {
        $consult = $this->pdo->prepare("SELECT count(*)  FROM tabla_comandos WHERE nombre_dispositivo = ? AND comando_id = ? AND telemetria_id = ? AND estado_comando = 1");
        $consult->execute([$nombre_dispositivo,$comando_id,$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function existeComandoA($nombre_dispositivo)
    {
        $consult = $this->pdo->prepare("SELECT count(*)  FROM tabla_comandos WHERE nombre_dispositivo = ? AND estado_comando = 1");
        $consult->execute([$nombre_dispositivo]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
//GRABAR COMANDO
    public function grabarCopmando($nombre_dispositivo,$comando_id, $telemetria_id,$valor_actual,$valor_modificado)
    {
        $consult = $this->pdo->prepare("INSERT INTO tabla_comandos (nombre_dispositivo,comando_id, telemetria_id,valor_actual,valor_modificado) VALUES (?,?,?,?,?)");
        return $consult->execute([$nombre_dispositivo,$comando_id, $telemetria_id,$valor_actual,$valor_modificado]);
    }

    // dispositivos Asignados 
    public function generadorAsignado($id)
    {
        $consult = $this->pdo->prepare("SELECT id,nombre_generador , descripcion FROM generadores WHERE empresa_id =? ");
        $consult->execute([$id]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function maduradorAsignado($id)
    {
        $consult = $this->pdo->prepare("SELECT id , nombre_contenedor, tipo , descripcionC FROM contenedores WHERE empresa_id =? AND tipo ='Madurador'");
        $consult->execute([$id]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function reeferAsignado($id)
    {
        $consult = $this->pdo->prepare("SELECT id , nombre_contenedor,tipo , descripcionC FROM contenedores WHERE empresa_id =? AND tipo ='Reefer'");
        $consult->execute([$id]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    //ASIGNAR DISPOSITIVO
    public function asignarDispositivo($id_empresa,$fecha_cambio, $listaDispositivos)
    {       
        $consult = $this->pdo->prepare("UPDATE contenedores SET empresa_id=? ,updated_at=? WHERE id=?");
        return $consult->execute([$id_empresa,$fecha_cambio, $listaDispositivos]);
    }
    public function asignarDispositivoG($id_empresa,$fecha_cambio, $listaDispositivos)
    {       
        $consult = $this->pdo->prepare("UPDATE generadores SET empresa_id=? ,updated_at=? WHERE id=?");
        return $consult->execute([$id_empresa,$fecha_cambio, $listaDispositivos]);
    }

    public function deleteAsignacionEmpresa($fecha_update,$id)
    {
        $tipo =  substr($id, strpos($id,',')+strlen(','));

        $empresa_id = substr($id, 0, strpos($id, ','));

        if($tipo=='G'){
            $consult = $this->pdo->prepare("UPDATE generadores SET empresa_id=1 ,updated_at=? WHERE id=?");
        }else {
            $consult = $this->pdo->prepare("UPDATE contenedores SET empresa_id=1 ,updated_at=? WHERE id=?");
        }
        
        return $consult->execute([$fecha_update, $empresa_id]);

    }
    public function bajarExcelM($telemetria_id)
    {
        $consult = $this->pdo->prepare("SELECT * FROM registro_madurador where telemetria_id=? order by id desc limit 1000");
        $consult->execute([$telemetria_id]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function excelMadurador($telemetria_id)
    {
        $consult = $this->pdo->prepare("SELECT *  FROM contenedores WHERE telemetria_id = ? AND estado = 1 limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function excelGenset($telemetria_id)
    {
        $consult = $this->pdo->prepare("SELECT *  FROM generadores WHERE telemetria_id = ? AND estado = 1 limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function actualizarComandoM($nombre_dispositivo){
        $ultima_fecha =date("Y-m-d H:i:s");  
        $consult = $this->pdo->prepare("UPDATE tabla_comandos SET estado_comando=0 ,  fecha_ejecucion=?   WHERE id=?");
        //$consult = $this->pdo->prepare("UPDATE generadores SET water_temp=? ,  latitud=?  ,longitud=? ,fecha_ultima=? WHERE nombre_generador=?");
        return $consult->execute([ $ultima_fecha ,$nombre_dispositivo]);
    }

}

?>