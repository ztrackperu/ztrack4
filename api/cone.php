<?php

class Conexion{
    public function conectar()
    {
       
        $servidor = "127.0.0.1:3307'";
        $password = "";
        $usuario ="root";
       
        try {
               $pdo  = new PDO("mysql:host=$servidor;dbname=zgroupztrack", $usuario, $password);      
              
              //echo "Conexión realizada Satisfactoriamente";
              return $pdo;
            }
       
        catch(PDOException $e)
            {
            echo "La conexión ha fallado: " . $e->getMessage();
            }
       
        $conexion = null;
    }
}


?>