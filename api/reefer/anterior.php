<?php
header('Content-type: application/json; charset=utf-8');
date_default_timezone_set('America/Lima');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
$datosRecibidos = file_get_contents("php://input");
//$datosRecibidos ='{"tipo": "Reefer2", "nombre_contenedor": "paTT4020550", "set_point": -85.0, "temp_supply_1": -37.8, "return_air": -23.1, "evaporation_coil": -23.0, "ambient_air": 29.0, "cargo_1_temp": -3277.0, "cargo_2_temp": -3277.0, "cargo_3_temp": -3277.0, "cargo_4_temp": -3277.0, "relative_humidity": 81.0, "alarm_present": 0, "alarm_number": 0, "controlling_mode": "OPTIMIZED", "power_state": 1, "defrost_term_temp": 18.0,"defrost_interval": 6.0, "latitud": -12.6342, "longitud": -78.0567}';
$contenedor = json_decode($datosRecibidos);
$primerFiltro = $contenedor->tipo ;
$segundoFiltro = $contenedor->nombre_contenedor;


if($primerFiltro =="Reefer"){
    
    $existeContenedor = $api->comprobarContenedor($segundoFiltro);
    $contarResultado = $api->contarContenedor($segundoFiltro);
    echo $contarResultado['count(*)'];
    //echo print_r($contarResultado);
    //$contador_fila =$existeContenedor->num_rows;

    $temp_supply_1 = $contenedor->temp_supply_1;
    $latitud = $contenedor->latitud;
    $longitud = $contenedor->longitud ;
    $set_point =  $contenedor->set_point;
    $return_air = $contenedor->return_air;
    $evaporation_coil = $contenedor->evaporation_coil;
    $ambient_air = $contenedor->ambient_air;
    $cargo_1_temp =  $contenedor->cargo_1_temp;
    $cargo_2_temp = $contenedor->cargo_2_temp;
    $cargo_3_temp = $contenedor->cargo_3_temp;
    $cargo_4_temp = $contenedor->cargo_4_temp;
    $relative_humidity = $contenedor->relative_humidity;
    $alarm_present = $contenedor->alarm_present;
    $alarm_number = $contenedor->alarm_number;
    $controlling_mode =  $contenedor->controlling_mode;
    $power_state = $contenedor->power_state;
    $defrost_term_temp = $contenedor->defrost_term_temp;
    $defrost_interval = $contenedor->defrost_interval;
    $nombrecontenedor = $contenedor->nombre_contenedor;
    $tipo = "Reefer";
    $descripcion = "Sin Informacion";



    if($contarResultado['count(*)'] == 0){
        // al no haber contenedor registrado
        //se crea una telemetria por defecto con el nombre del contenedor       
        $numero_telefono =  $contenedor->nombre_contenedor;
        $imei =  $contenedor->nombre_contenedor;      
        $T = $api->saveTelemetria($numero_telefono, $imei);

        $existeTelemetria =$api->existeTelemetria($imei);
        $telemetria_id =$existeTelemetria['id'];
     
        $ultima_fecha =date("Y-m-d H:i:s");    
        $C = $api->crearContenedorR($nombrecontenedor, $tipo,$descripcion,$telemetria_id,$set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$ultima_fecha);
     
        $created_at= date("Y-m-d H:i:s");   
        $R = $api->crearTramaReffer($set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id);
    }else{
        $telemetria_id =$existeContenedor['telemetria_id'];

        $ultima_fecha =date("Y-m-d H:i:s");
        $C = $api->updateContenedorR( $set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud, $ultima_fecha ,$segundoFiltro);
        
        $created_at= date("Y-m-d H:i:s");
        $R = $api->crearTramaReffer($set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id);


    }
    $alerta  = " GUARDADO CORRECTAMENTE";
}else {
    $alerta  = " ERROR DE TIPO";
}
       
      $respuesta = [
          "mensaje" => "DESDE SERVIDOR ZGROUP",
          "nombre" => $contenedor->nombre_contenedor,
          "alerta" => $alerta,
              "cadena" =>[
                      'tipo' =>  $primerFiltro,
                      'nombre_contenedor' => $contenedor->nombre_contenedor
              ],
              "fechaYHora" => date("Y-m-d H:i:s")
          ];
          
          $respuestaCodificada = json_encode($respuesta);
          echo $respuestaCodificada;
          

?>







