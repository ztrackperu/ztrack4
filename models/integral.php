<?php
require_once 'config.php';
require_once 'conexion.php';
class IntegralModel{ 
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    public function listaReeferFecha1($id ,$fechaInicio , $fechaFin)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id = ? and created_at >= ? and created_at <= ? ORDER BY id desc");
        $consult->execute([$valor,$fechaInicio , $fechaFin]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function UsuarioEmpresa($usuario)
    {
        $consult = $this->pdo->prepare("SELECT * FROM usuario_empresa WHERE usuario_id =?");
        $consult->execute([$usuario]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    //para administradores
    public function TablaReefer($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1");
            $consult->execute();
        }else{
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ?");
            $consult->execute([$empresa]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaMadurador($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1 ");
            $consult->execute();
        }else{
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ? ");
            $consult->execute([$empresa]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaGenset($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 ");
            $consult->execute();
        }else{
            $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.empresa_id =? ");
            $consult->execute([$empresa]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
    //para clientes

    public function TablaReeferCliente($empresa)
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.empresa_id = ?");
        $consult->execute([$empresa]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaMaduradorCliente($empresa)
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.empresa_id = ? ");
        $consult->execute([$empresa]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaGensetCliente($empresa)
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =?");
        $consult->execute([$empresa]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    */
    public function ContarReffer($tipoUsuario , $empresa){
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1");
            $consult->execute();
        }else{
            $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ?");
            $consult->execute([$empresa]);
        }

        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function ContarMadurador($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT  count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1 ");
            $consult->execute();
        }else{
            $consult = $this->pdo->prepare("SELECT count(*)  FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ? ");
            $consult->execute([$empresa]);
        }
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function ContarGenset($tipoUsuario , $empresa)
    {
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 ");
            $consult->execute();
        }else{
            $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =? and c.estado=1 ");
            $consult->execute([$empresa]);
        }
        return $consult->fetch(PDO::FETCH_ASSOC);
    }


    // para los que estan en estado ENCENDIDO 

    public function TablaReeferON($tipoUsuario , $empresa)
    {
        $date = date('Y-m-j H:i:s');
        $newdate = strtotime('-30 minute' ,strtotime($date));
        $newdate = date('Y-m-j H:i:s' ,$newdate);
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1 and c.ultima_fecha > ?");
            $consult->execute([$newdate]);
        }else{
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ? and c.ultima_fecha > ?");
            $consult->execute([$empresa , $newdate]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaMaduradorON($tipoUsuario , $empresa)
    {
        $date = date('Y-m-j H:i:s');
        $newdate = strtotime('-30 minute' ,strtotime($date));
        $newdate = date('Y-m-j H:i:s' ,$newdate);
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.ultima_fecha > ?");
            $consult->execute([$newdate]);
        }else{
            $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ? and c.ultima_fecha > ? ");
            $consult->execute([$empresa , $newdate]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaGensetON($tipoUsuario , $empresa)
    {
        $date = date('Y-m-j H:i:s');
        $newdate = strtotime('-30 minute' ,strtotime($date));
        $newdate = date('Y-m-j H:i:s' ,$newdate);
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.ultima_fecha > ? ");
            $consult->execute([$newdate]);
        }else{
            $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.empresa_id =? and c.ultima_fecha > ? ");
            $consult->execute([$empresa , $newdate]);
        }
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    //contador en ON

    public function ContarRefferON($tipoUsuario , $empresa){
        $date = date('Y-m-j H:i:s');
        $newdate = strtotime('-30 minute' ,strtotime($date));
        $newdate = date('Y-m-j H:i:s' ,$newdate);
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1 and c.ultima_fecha > ? ");
            $consult->execute([$newdate]);

        }else{
            $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ? and c.ultima_fecha > ?");
            $consult->execute([$empresa , $newdate]);
        }

        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function ContarMaduradorON($tipoUsuario , $empresa)
    {
        $date = date('Y-m-j H:i:s');
        $newdate = strtotime('-30 minute' ,strtotime($date));
        $newdate = date('Y-m-j H:i:s' ,$newdate);
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT  count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1 and c.ultima_fecha > ? ");
            $consult->execute([$newdate]);
        }else{
            $consult = $this->pdo->prepare("SELECT count(*)  FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ? and c.ultima_fecha > ? ");
            $consult->execute([$empresa , $newdate]);
        }
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function ContarGensetON($tipoUsuario , $empresa)
    {
        $date = date('Y-m-j H:i:s');
        $newdate = strtotime('-30 minute' ,strtotime($date));
        $newdate = date('Y-m-j H:i:s' ,$newdate);
        if($tipoUsuario==1){
            $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.ultima_fecha > ?  ");
            $consult->execute([$newdate]);
        }else{
            $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =? and c.estado=1 and c.ultima_fecha > ? ");
            $consult->execute([$empresa , $newdate]);
        }
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    
        // para los que estan en estado WAIT

        public function TablaReeferWAIT($tipoUsuario , $empresa)
        {
            $date = date('Y-m-j H:i:s');
            $newdate = strtotime('-30 minute' ,strtotime($date));
            $newdate = date('Y-m-j H:i:s' ,$newdate);
            $newdate1 = strtotime('-24 hour' ,strtotime($date));
            $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
            if($tipoUsuario==1){
                $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1 and c.ultima_fecha <? and c.ultima_fecha>?");
                $consult->execute([$newdate,$newdate1]);
            }else{
                $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ? and c.ultima_fecha < ? and c.ultima_fecha>?");
                $consult->execute([$empresa , $newdate,$newdate1]);
            }
            return $consult->fetchAll(PDO::FETCH_ASSOC);
        }
        public function TablaMaduradorWAIT($tipoUsuario , $empresa)
        {
            $date = date('Y-m-j H:i:s');
            $newdate = strtotime('-30 minute' ,strtotime($date));
            $newdate = date('Y-m-j H:i:s' ,$newdate);
            $newdate1 = strtotime('-24 hour' ,strtotime($date));
            $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
            if($tipoUsuario==1){
                $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.ultima_fecha <? and c.ultima_fecha>?");
                $consult->execute([$newdate,$newdate1]);
            }else{
                $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ? and c.ultima_fecha <? and c.ultima_fecha>? ");
                $consult->execute([$empresa , $newdate,$newdate1]);
            }
            return $consult->fetchAll(PDO::FETCH_ASSOC);
        }
        public function TablaGensetWAIT($tipoUsuario , $empresa)
        {
            $date = date('Y-m-j H:i:s');
            $newdate = strtotime('-30 minute' ,strtotime($date));
            $newdate = date('Y-m-j H:i:s' ,$newdate);
            $newdate1 = strtotime('-24 hour' ,strtotime($date));
            $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
            if($tipoUsuario==1){
                $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.ultima_fecha <? and c.ultima_fecha>? ");
                $consult->execute([$newdate,$newdate1]);
            }else{
                $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.empresa_id =? and c.ultima_fecha <? and c.ultima_fecha>? ");
                $consult->execute([$empresa , $newdate,$newdate1]);
            }
            return $consult->fetchAll(PDO::FETCH_ASSOC);
        }
    
        //contador en WAIT
    
        public function ContarRefferWAIT($tipoUsuario , $empresa){
            $date = date('Y-m-j H:i:s');
            $newdate = strtotime('-30 minute' ,strtotime($date));
            $newdate1 = strtotime('-24 hour' ,strtotime($date));
            $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
            $newdate = date('Y-m-j H:i:s' ,$newdate);
            if($tipoUsuario==1){
                $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1 and c.ultima_fecha <? and c.ultima_fecha>? ");
                $consult->execute([$newdate,$newdate1]);
    
            }else{
                $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ? and c.ultima_fecha <? and c.ultima_fecha>?");
                $consult->execute([$empresa , $newdate,$newdate1]);
            }
    
            return $consult->fetch(PDO::FETCH_ASSOC);
        }
        public function ContarMaduradorWAIT($tipoUsuario , $empresa)
        {
            $date = date('Y-m-j H:i:s');
            $newdate = strtotime('-30 minute' ,strtotime($date));
            $newdate = date('Y-m-j H:i:s' ,$newdate);
            $newdate1 = strtotime('-24 hour' ,strtotime($date));
            $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
            if($tipoUsuario==1){
                $consult = $this->pdo->prepare("SELECT  count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1 and c.ultima_fecha <? and c.ultima_fecha>?");
                $consult->execute([$newdate,$newdate1]);
            }else{
                $consult = $this->pdo->prepare("SELECT count(*)  FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ? and c.ultima_fecha <? and c.ultima_fecha>? ");
                $consult->execute([$empresa , $newdate,$newdate1]);
            }
            return $consult->fetch(PDO::FETCH_ASSOC);
        }
        public function ContarGensetWAIT($tipoUsuario , $empresa)
        {
            $date = date('Y-m-j H:i:s');
            $newdate = strtotime('-30 minute' ,strtotime($date));
            $newdate = date('Y-m-j H:i:s' ,$newdate);
            $newdate1 = strtotime('-24 hour' ,strtotime($date));
            $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
            if($tipoUsuario==1){
                $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.ultima_fecha <? and c.ultima_fecha>? ");
                $consult->execute([$newdate,$newdate1]);
            }else{
                $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =? and c.estado=1 and c.ultima_fecha <? and c.ultima_fecha>?");
                $consult->execute([$empresa , $newdate,$newdate1]);
            }
            return $consult->fetch(PDO::FETCH_ASSOC);
        }


                // para los que estan en estado OFF

                public function TablaReeferOFF($tipoUsuario , $empresa)
                {
                    $date = date('Y-m-j H:i:s');
                    $newdate1 = strtotime('-24 hour' ,strtotime($date));
                    $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
                    if($tipoUsuario==1){
                        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1  and c.ultima_fecha<?");
                        $consult->execute([$newdate1]);
                    }else{
                        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ?  and c.ultima_fecha<?");
                        $consult->execute([$empresa ,$newdate1]);
                    }
                    return $consult->fetchAll(PDO::FETCH_ASSOC);
                }
                public function TablaMaduradorOFF($tipoUsuario , $empresa)
                {
                    $date = date('Y-m-j H:i:s');
                    $newdate1 = strtotime('-24 hour' ,strtotime($date));
                    $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
                    if($tipoUsuario==1){
                        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1   and c.ultima_fecha<?");
                        $consult->execute([$newdate1]);
                    }else{
                        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ?  and c.ultima_fecha<? ");
                        $consult->execute([$empresa ,$newdate1]);
                    }
                    return $consult->fetchAll(PDO::FETCH_ASSOC);
                }
                public function TablaGensetOFF($tipoUsuario , $empresa)
                {
                    $date = date('Y-m-j H:i:s');
                    $newdate1 = strtotime('-24 hour' ,strtotime($date));
                    $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
                    if($tipoUsuario==1){
                        $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1  and c.ultima_fecha<? ");
                        $consult->execute([$newdate1]);
                    }else{
                        $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1 and c.empresa_id =?  and c.ultima_fecha<? ");
                        $consult->execute([$empresa ,$newdate1]);
                    }
                    return $consult->fetchAll(PDO::FETCH_ASSOC);
                }
            
                //contador en OFF
            
                public function ContarRefferOFF($tipoUsuario , $empresa){
                    $date = date('Y-m-j H:i:s');
                    $newdate1 = strtotime('-24 hour' ,strtotime($date));
                    $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
                    if($tipoUsuario==1){
                        $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado =1  and c.ultima_fecha<? ");
                        $consult->execute([$newdate1]);
            
                    }else{
                        $consult = $this->pdo->prepare("SELECT count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.estado=1 and c.empresa_id = ?  and c.ultima_fecha<?");
                        $consult->execute([$empresa ,$newdate1]);
                    }
            
                    return $consult->fetch(PDO::FETCH_ASSOC);
                }
                public function ContarMaduradorOFF($tipoUsuario , $empresa)
                {
                    $date = date('Y-m-j H:i:s');
                    $newdate1 = strtotime('-24 hour' ,strtotime($date));
                    $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
                    if($tipoUsuario==1){
                        $consult = $this->pdo->prepare("SELECT  count(*) FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.ultima_fecha<?");
                        $consult->execute([$newdate1]);
                    }else{
                        $consult = $this->pdo->prepare("SELECT count(*)  FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.estado=1  and c.empresa_id = ?  and c.ultima_fecha<? ");
                        $consult->execute([$empresa ,$newdate1]);
                    }
                    return $consult->fetch(PDO::FETCH_ASSOC);
                }
                public function ContarGensetOFF($tipoUsuario , $empresa)
                {
                    $date = date('Y-m-j H:i:s');
                    $newdate1 = strtotime('-24 hour' ,strtotime($date));
                    $newdate1 = date('Y-m-j H:i:s' ,$newdate1);
                    if($tipoUsuario==1){
                        $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.estado=1  and c.ultima_fecha<? ");
                        $consult->execute([$newdate1]);
                    }else{
                        $consult = $this->pdo->prepare("SELECT count(*) FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =? and c.estado=1  and c.ultima_fecha<?");
                        $consult->execute([$empresa ,$newdate1]);
                    }
                    return $consult->fetch(PDO::FETCH_ASSOC);
                }
    
}

?>