<?php
require_once '../config.php';
require_once 'conexion.php';
class ContenedoresModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    // LLAMA A TODAS LOS DATOS DE CONTENEDORES con estado 1
    public function getContenedores()
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE estado =1 ");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
        //Llama a los datos de la empresa que se acaba de agregar  , para luego guardarlo en historial
    public function comprobarContenedor($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE nombre_contenedor = ? and estado =1");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se solicita los datos de la empresa que se acaba de guardar para el historial
    public function getContenedor_obtener($nombre_contenedor)
    {
            $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE nombre_contenedor = ?");
            $consult->execute([$nombre_contenedor]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }

    //GUARDA el contenedor
    public function saveContenedor($nombre_contenedor, $descripcion,$tipo)
    {
        $consult = $this->pdo->prepare("INSERT INTO contenedores (nombre_contenedor, descripcionC,tipo) VALUES (?,?,?)");
        return $consult->execute([$nombre_contenedor, $descripcion,$tipo]);
    }
    //ELIMINAR EMPRESA-CAMBIA DE ESTADO DE 1 A 0
    public function deleteContenedor($fecha_update,$id)
    {
        $consult = $this->pdo->prepare("UPDATE contenedores SET estado = ?  ,updated_at=? WHERE id = ?");
        return $consult->execute([0, $fecha_update , $id]);
    }
    //ACTUALIZAR CONTENEDOR
    public function updateContenedor($nombre_contenedor, $descripcion,$tipo ,$empresa_id, $generador_id,$telemetria_id, $fecha_update,$id)
    {       
        $consult = $this->pdo->prepare("UPDATE contenedores SET nombre_contenedor=? ,  descripcionC=? ,tipo=?,empresa_id=? ,generador_id=? ,telemetria_id=?  ,updated_at=?WHERE id=?");
        return $consult->execute([$nombre_contenedor, $descripcion,$tipo ,$empresa_id, $generador_id,$telemetria_id, $fecha_update,$id]);
    }

    // se busca la empresa por id para guardarlo en el historial como editado o eliminado
    public function getContenedor_id($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE id = ?");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    // se guarda en el historial las acciones de guardar , editar , eliminar
    public function savehistorialContenedor($id_r ,$nombre_contenedor, $descripcion ,$tipo,$fecha_cambio ,$usuario_cambio_id ,$accion)
    {
        $consult = $this->pdo->prepare("INSERT INTO historial_contenedores ( id_contenedor ,nombre_contenedor, descripcion,tipo, fecha_cambio,usuario_cambio_id ,evento) VALUES (?,?,?,?,?,?,?)");
        return $consult->execute([$id_r ,$nombre_contenedor, $descripcion ,$tipo,$fecha_cambio ,$usuario_cambio_id ,$accion]);
    }
    // se guarda en el historial las acciones de guardar , editar , eliminar
    public function edithistorialContenedor($id ,$nombre_contenedor, $descripcion,$tipo ,$empresa_id, $generador_id,$telemetria_id ,$fecha_cambio ,$usuario_cambio_id ,$accion)
    {
        $consult = $this->pdo->prepare("INSERT INTO historial_contenedores ( id_contenedor ,nombre_contenedor, descripcion,tipo,empresa_id, generador_id,telemetria_id, fecha_cambio,usuario_cambio_id ,evento) VALUES (?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$id ,$nombre_contenedor, $descripcion ,$tipo,$empresa_id, $generador_id,$telemetria_id,$fecha_cambio ,$usuario_cambio_id ,$accion]);
    }


}

?>