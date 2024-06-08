<?php
require_once 'config.php';
require_once 'conexion.php';
class PrincipalModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    //consultaTelemetriaMadurador($telemetria)

    public function consultaTelemetriaMadurador($telemetria){
        $valor =intval($telemetria);
        $consult = $this->pdo->prepare("SELECT nombre_contenedor ,descripcionC ,extra_1  FROM contenedores WHERE telemetria_id = ?");
        $consult->execute([$valor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }


    public function genset($telemetria){
        $valor =intval($telemetria);
        $consult = $this->pdo->prepare("SELECT *  FROM generadores WHERE telemetria_id = ?");
        $consult->execute([$valor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function reefer($telemetria){
        $valor =intval($telemetria);
        $consult = $this->pdo->prepare("SELECT *  FROM contenedores WHERE telemetria_id = ? and tipo ='Reefer'");
        $consult->execute([$valor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function madurador($telemetria){
        $valor =intval($telemetria);
        $consult = $this->pdo->prepare("SELECT *  FROM contenedores WHERE telemetria_id = ? and tipo ='Madurador'");
        $consult->execute([$valor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function idEmpresa($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT nombre_contenedor , descripcionC FROM contenedores WHERE telemetria_id = ?");
        $consult->execute([$valor]);
        return $consult->fetch(PDO::FETCH_ASSOC);

    }
    public function idEmpresaG($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT nombre_generador , descripcion FROM generadores WHERE telemetria_id = ?");
        $consult->execute([$valor]);
        return $consult->fetch(PDO::FETCH_ASSOC);

    }
    public function listaReeferFecha($id ,$fechaInicio , $fechaFin)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id = ? and created_at >= ? and created_at <= ? ORDER BY id desc");
        $consult->execute([$valor,$fechaInicio , $fechaFin]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listaReeferAprox($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id = ?  ORDER BY id desc limit 200");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaMaduradorFecha($id ,$fechaInicio , $fechaFin)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT id,created_at,stateProcess,set_point,temp_supply_1, return_air,evaporation_coil,ambient_air,relative_humidity, controlling_mode, sp_ethyleno,ethylene,avl,power_state, compress_coil_1,consumption_ph_1,consumption_ph_2,consumption_ph_3, co2_reading, o2_reading , set_point_o2,set_point_co2,line_voltage,defrost_term_temp,defrost_interval,latitud,longitud ,inyeccion_hora,inyeccion_pwm FROM registro_madurador WHERE telemetria_id = ? and created_at >= ? and created_at <= ? ORDER BY id desc");
        $consult->execute([$valor,$fechaInicio , $fechaFin]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listaMaduradorAprox($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_madurador WHERE telemetria_id = ?  ORDER BY id desc limit 100");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function listaGensetFiltroFecha($id ,$fechaInicio , $fechaFin)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_generador WHERE telemetria_id = ? and created_at >= ? and created_at <= ? ORDER BY id  desc");
        $consult->execute([$valor,$fechaInicio , $fechaFin]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function listaGensetAprox($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_generador WHERE telemetria_id = ?  ORDER BY id desc limit 200");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listaReefer()
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE tipo ='Reefer' ");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function circuloContenedores($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE estado =1 ");
        $consult->execute();
        }else{
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE estado = 1 and empresa_id = ?");
        $consult->execute([$empresa]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function circuloGeneradores($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE estado =1 ");
        $consult->execute();
        }else {
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE estado =1 and empresa_id = ?");
        $consult->execute([$empresa]);

        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function circuloGeneradoresMultilog()
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE  empresa_id =14");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function circuloGeneradoresBrokmar()
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE  empresa_id =15");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function nombre_de_contenedor($id)
    {
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT nombre_contenedor FROM contenedores WHERE telemetria_id=?");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);

    }
    public function tramas($id){
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id=? ORDER BY id DESC LIMIT 500");
        $consult->execute([$tele]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function ultimaTrama($id){
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id=? ORDER BY id DESC LIMIT 1");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function puntoEnMapa($id)
    {
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE telemetria_id=?");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function puntoEnMapaAlias($id)
    {
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE id=?");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function puntoEnMapaM($id)
    {
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE telemetria_id=? ");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function empresaAsociada($id)
    {
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM empresas WHERE id=?");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }


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
    public function asignarAlias($id_contenedor, $alias)
    {       
        $fecha_update =date("Y-m-d H:i:s");
        $consult = $this->pdo->prepare("UPDATE contenedores SET descripcionC=? ,updated_at=?WHERE id=?");
        return $consult->execute([$alias, $fecha_update,$id_contenedor]);
    }
    public function verLocation($id)
    {
        $tele = intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE telemetria_id=?");
        $consult->execute([$tele]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    // data para las graficas 
    public function datosGrafica($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id=? ORDER BY id DESC LIMIT 500");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

        //SELECT * FROM registro_reefers WHERE telemetria_id=? ORDER BY id DESC LIMIT 200



    }



}

?>