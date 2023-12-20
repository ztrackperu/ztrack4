<?php
require_once '../config.php';
require_once 'conexion.php';
class TelemetriasModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    // LLAMA A TODAS LOS DATOS DE EMPRESAS con estado 1
    public function getTelemetrias()
    {
        $consult = $this->pdo->prepare("SELECT * FROM telemetrias WHERE estado =1 ");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
        //Llama a los datos de la empresa que se acaba de agregar  , para luego guardarlo en historial
    public function comprobarTelemetria($imei)
    {
        $consult = $this->pdo->prepare("SELECT * FROM telemetrias WHERE imei = ? and estado =1");
        $consult->execute([$imei]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se solicita los datos de la empresa que se acaba de guardar para el historial
    public function getTelemetria_obtener($imei)
    {
            $consult = $this->pdo->prepare("SELECT * FROM telemetrias WHERE imei = ?");
            $consult->execute([$imei]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }

    //GUARDA LA EMPRESA
    public function saveTelemetria($numero_telefono, $imei)
    {
        $consult = $this->pdo->prepare("INSERT INTO telemetrias (numero_telefono, imei) VALUES (?,?)");
        return $consult->execute([$numero_telefono, $imei]);
    }
    //ELIMINAR EMPRESA-CAMBIA DE ESTADO DE 1 A 0
    public function deleteTelemetria($fecha_update,$id)
    {
        $consult = $this->pdo->prepare("UPDATE telemetrias SET estado = ?  ,updated_at=? WHERE id = ?");
        return $consult->execute([0, $fecha_update , $id]);
    }
    //ACTUALIZAR EMPRESA
    public function updateTelemetria($numero_telefono, $imei,$fecha_update,$id)
    {       
        $consult = $this->pdo->prepare("UPDATE telemetrias SET numero_telefono=? ,  imei=?  ,updated_at=? WHERE id=?");
        return $consult->execute([$numero_telefono, $imei,$fecha_update ,$id]);
    }

    // se busca la empresa por id para guardarlo en el historial como editado o eliminado
    public function getTelemetria_id($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM telemetrias WHERE id = ?");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se guarada en el historial ñas acciones de guardar , editar , eliminar
    public function savehistorialTelemetria($id_r ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion)
    {
        $consult = $this->pdo->prepare("INSERT INTO historial_telemetrias ( id_telemetria ,numero_telefono, imei, fecha_cambio,usuario_modifico_id ,evento) VALUES (?,?,?,?,?,?)");
        return $consult->execute([$id_r ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion]);
    }


}

?>