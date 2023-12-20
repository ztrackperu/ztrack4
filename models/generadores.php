<?php
require_once '../config.php';
require_once 'conexion.php';
class GeneradoresModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    // LLAMA A TODAS LOS DATOS DE EMPRESAS con estado 1
    public function getGeneradores()
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE estado =1 ");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
        //Llama a los datos de la empresa que se acaba de agregar  , para luego guardarlo en historial
    public function comprobarGenerador($nombre_generador)
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE nombre_generador = ? and estado =1");
        $consult->execute([$nombre_generador]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se solicita los datos de la empresa que se acaba de guardar para el historial
    public function getGenerador_obtener($nombre_generador)
    {
            $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE nombre_generador = ?");
            $consult->execute([$nombre_generador]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }

    //GUARDA LA EMPRESA
    public function saveGenerador($nombre_generador, $descripcion)
    {
        $consult = $this->pdo->prepare("INSERT INTO generadores (nombre_generador, descripcion) VALUES (?,?)");
        return $consult->execute([$nombre_generador, $descripcion]);
    }
    //ELIMINAR EMPRESA-CAMBIA DE ESTADO DE 1 A 0
    public function deleteGenerador($fecha_update,$id)
    {
        $consult = $this->pdo->prepare("UPDATE generadores SET estado = ?  ,updated_at=? WHERE id = ?");
        return $consult->execute([0, $fecha_update , $id]);
    }
    //ACTUALIZAR EMPRESA
    public function updateGenerador($nombre_generador, $descripcion,$fecha_update,$id)
    {       
        $consult = $this->pdo->prepare("UPDATE generadores SET nombre_generador=? ,  descripcion=?  ,updated_at=? WHERE id=?");
        return $consult->execute([$nombre_generador, $descripcion,$fecha_update ,$id]);
    }

    // se busca la empresa por id para guardarlo en el historial como editado o eliminado
    public function getGenerador_id($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE id = ?");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se guarada en el historial ñas acciones de guardar , editar , eliminar
    public function savehistorialGenerador($id_r ,$nombre_generador, $descripcion ,$fecha_cambio ,$usuario_cambio_id ,$accion)
    {
        $consult = $this->pdo->prepare("INSERT INTO historial_generadores ( id_generador ,nombre_generador, descripcion, fecha_cambio,usuario_cambio_id ,evento) VALUES (?,?,?,?,?,?)");
        return $consult->execute([$id_r ,$nombre_generador, $descripcion,$fecha_cambio ,$usuario_cambio_id ,$accion]);
    }
    public function edithistorialGenerador($id_r ,$nombre_generador, $descripcion , $empresa_id , $telemetria_id,$fecha_cambio ,$usuario_cambio_id ,$accion)
    {
        $consult = $this->pdo->prepare("INSERT INTO historial_generadores ( id_generador ,nombre_generador, descripcion, empresa_id , telemetria_id , fecha_cambio,usuario_cambio_id ,evento) VALUES (?,?,?,?,?,?,?,?)");
        return $consult->execute([$id_r ,$nombre_generador, $descripcion, $empresa_id , $telemetria_id ,$fecha_cambio ,$usuario_cambio_id ,$accion]);
    }


}

?>