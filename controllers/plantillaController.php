<?php
class Plantilla{
    //pagina principal
    public function index()
    {
        include_once 'views/mapa/index.php';
    }
    //pagina mapa
    public function mapa(){
        include_once 'views/mapa/index.php';
    }
    //pagina usuarios
    public function usuarios()
    {
        include_once 'views/usuarios/index.php';
    }
    public function usuarioss()
    {
        include_once 'views/usuarioss/index.php';
    }

    //pagina empresas
    public function empresas()
    {
        include_once 'views/empresas/index.php';
    }
    //pagina telemetrias
    public function telemetrias()
    {
        include_once 'views/telemetrias/index.php';
    }

    //pagina generadores
    public function generadores()
    {
        include_once 'views/generadores/index.php';
    }
    //pagina contenedores
    public function contenedores()
    {
        include_once 'views/contenedores/index.php';
    }

    //pagina trama_maduradores
    public function trama_madurador()
    {
        include_once 'views/trama_madurador/index.php';
    }
    //pagina trama_genset
    public function trama_genset()
    {
        include_once 'views/trama_genset/index.php';
    }
    //pagina trama_reffer
    public function trama_reffer()
    {
        include_once 'views/trama_reffer/index.php';
    }

    //pagina configuracion
    public function configuracion()
    {
        include_once 'views/usuarios/configuracion.php';
    }
    //pagina error
    public function notFound()
    {
        include_once 'views/errors.php';
    }


}
?>