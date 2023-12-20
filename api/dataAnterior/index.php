<?php
header('Content-type: application/json; charset=utf-8');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
//$datosRecibidos = json_decode(file_get_contents('php://input'),true);
$datosRecibidos = file_get_contents('php://input');
//$contenedor = json_decode($datosRecibidos,true);
//$datosRecibidos = json_decode(file_get_contents('php://input'),true);
//$datosRecibidos = json_decode(file_get_contents('php://input'), true);
//$segundoFiltro = $contenedor->nombre_contenedor;

$claves = array_map('trim', preg_split('/\R/', $datosRecibidos));
$necesario = $claves[7];
if($claves[2] == "Accept-Encoding: gzip, deflate"){
    $Estructura =$claves[9];
}else if($claves[2] == "Connection:     Keep-Alive")
   $Estructura =$claves[8];
else{
    $Estructura =$claves[7];
}
//$Estructura =$claves[9];
echo "Hola JSON capturado- >  Este es el JSON :";
$contenedor = json_decode($Estructura);
echo $Estructura;
echo " Ahora vemos la estructura de nombre  : ";
$variable = $contenedor->nombre_contenedor;
$Filtro = $contenedor->tipo;
echo  $variable ;
?>

<?php
$er = $api->dataAnterior($variable,$datosRecibidos);

//echo $contenedor;

/*
POST /api/contenedores HTTP/1.1 -0
 Accept:           -1
 Accept-Encoding: gzip, deflate -2
 Connection:      keep-alive -3
 Content-Length:  471 -4 
 Content-Type:    applica ion/json -5
 Host:            162.248.55.24 -6 
 User-Agent:      python-requests/2.28.2-7
 8
 9-{"tipo": "Reefer", "nombre_contenedor": "LOSU6844452", "set_point": -25.0, "temp_supply_1": -29.4, "return_air": -24.9, "evaporation_coil": -6578.4, "ambient_air": 24.0, "cargo_1_temp": -3277.0, "cargo_2_temp": -3277.0, "cargo_3_temp": -3277.0, "cargo_4_temp": -3277.0, "relative_humidity": 62.0, "alarm_present": 0, "alarm_number": 0, "controlling_mode": "OPTIMIZED", "power_state": 1, "defrost_term_temp": 18.0, "defrost_interval": 6.0, "latitud": 0.0, "longitud": 0.0

    POST /api/contenedores HTTP/1.1
 Accept:         
 Accept-Encoding: gzip, deflate
 Connection:      keep-alive
 Content-Length:  471
 Content-Type:    application/json
 Host:            162.248.55.24
 User-Agent:      python-requests/2.28.2
 
 {"tipo": "Reefer", "nombre_contenedor": "LOSU6844452", "set_point": -25.0, "temp_supply_1": -29.4, "return_air": -24.9, "evaporation_coil": -6578.4, "ambient_air": 24.0, "cargo_1_temp": -3277.0, "cargo_2_temp": -3277.0, "cargo_3_temp": -3277.0, "cargo_4_temp": -3277.0, "relative_humidity": 62.0, "alarm_present": 0, "alarm_number": 0, "controlling_mode": "OPTIMIZED", "power_state": 1, "defrost_term_temp": 18.0, "defrost_interval": 6.0, "latitud": 0.0, "longitud": 0.0}

 


POST /api/contenedores HTTP/1.1 -0
 Accept:         application/json -1
 Connection:     close  -2
 Content-Length: 411 -3 
 Content-Type:   application/json -4
 Host:           162.248.55.24 -5 
 6
 7{"tipo":"Reefer","nombre_contenedor":"ZGRU6578922","set_point":8,"temp_supply_1":8,"return_air":9.6,"evaporation_coil":9.4,"ambient_air":24.6,"cargo_1_temp":0,"cargo_2_temp":0,"cargo_3_temp":0,"cargo_4_temp":0,"relative_humidity":65,"alarm_present":0,"alarm_number":0,"controlling_mode":"BULB MODE HIGH","power_state":3,"defrost_term_temp":18,"defrost_interval":6,"latitud":"-12.047778","longitud":"-76.952576"}


POST /api/contenedores HTTP/1.1 0
 Accept:         application/json 1
 Connection:     close 2
 Content-Length: 409 3
 Content-Type:   application/json 4
 Host:           162.248.55.24 5
 6
 7{"tipo":"Reefer","nombre_contenedor":"ZGRU7263904","set_point":6,"temp_supply_1":6,"return_air":13.6,"evaporation_coil":15.5,"ambient_air":25.4,"cargo_1_temp":0,"cargo_2_temp":0,"cargo_3_temp":0,"cargo_4_temp":0,"relative_humidity":82,"alarm_present":0,"alarm_number":0,"controlling_mode":"ECONOMIZER","power_state":3,"defrost_term_temp":18,"defrost_interval":6,"latitud":"-12.047778","longitud":"-76.952576"}

*/

 $contDirect = $api->verDirectos($variable);

if($Filtro=="Reefer"){

if($contDirect['count(*)'] == 0){ 


$primerFiltro = $contenedor->tipo ;
$segundoFiltro = $contenedor->nombre_contenedor;



//$set1 =  $contenedor->set_point;
//$ret1 = $contenedor->return_air;
//$eva1 = $contenedor->evaporation_coil;
//$amb1 = $contenedor->ambient_air;
//$rel1 = $contenedor->relative_humidity;
//$temp1= $contenedor->temp_supply_1;

    
 
    $existeContenedor = $api->comprobarContenedor($segundoFiltro);
    $contarResultado = $api->contarContenedor($segundoFiltro);
    //echo $contarResultado['count(*)'];
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
    $empresaAsignada =16;



    if($contarResultado['count(*)'] == 0){
        // al no haber contenedor registrado
        //se crea una telemetria por defecto con el nombre del contenedor       
        $numero_telefono =  $contenedor->nombre_contenedor;
        $imei =  $contenedor->nombre_contenedor;      
        $T = $api->saveTelemetria($numero_telefono, $imei);
    
        $existeTelemetria =$api->existeTelemetria($imei);
        $telemetria_id =$existeTelemetria['id'];
     
        $ultima_fecha =date("Y-m-d H:i:s");    

        $contError =0;
    
        $set1 =  $contenedor->set_point;
        $ret1 = $contenedor->return_air;
        $eva1 = $contenedor->evaporation_coil;
        $amb1 = $contenedor->ambient_air;
        $rel1 = $contenedor->relative_humidity;
        $temp1= $contenedor->temp_supply_1;
    
        if($set1 <-99 or $set1>99){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de set_point envia el 
           $set_point =0;
        }
        if($ret1 <-99 or $ret1>99){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de return_air envia el 
           $return_air =0;
        }
        if($eva1 <-99 or $eva1>99){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de set_point envia el 
           $evaporation_coil =0;
        }
        if($amb1 <-5 or $amb1>40){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de set_point envia el 
           $ambient_air =0;
        }
        if($rel1 <-99 or $rel1>99){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de set_point envia el 
           $relative_humidity =0;
        }
        if($temp1 <-99 or $temp1>99){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de set_point envia el 
           $temp_supply_1 =0;
        }
        if ($contError>0){
            $er = $api->error_trama($datosRecibidos);
        }
        
        $C = $api->crearContenedorR($nombrecontenedor, $tipo,$descripcion,$telemetria_id,$set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$ultima_fecha,$empresaAsignada);
     
        $created_at= date("Y-m-d H:i:s");   
        $R = $api->crearTramaReffer($set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id);
    }else{
        $telemetria_id =$existeContenedor['telemetria_id'];

        $ultima_fecha =date("Y-m-d H:i:s");
        $contError =0;
    
        $set1 =  $contenedor->set_point;
        $ret1 = $contenedor->return_air;
        $eva1 = $contenedor->evaporation_coil;
        $amb1 = $contenedor->ambient_air;
        $rel1 = $contenedor->relative_humidity;
        $temp1= $contenedor->temp_supply_1;
    
        if($set1 <-99 or $set1>99){
            $contError =$contError +1;
            // consulta al ultimo dato que este bien de set_point envia el 
            $respuesta = $api->verSet_point($telemetria_id);
           $set_point =$respuesta['set_point'];
        }
        if($ret1 <-99 or $ret1>99){
            $contError =$contError +1;
            $respuesta = $api->verReturn_air($telemetria_id);
           $return_air =$respuesta['return_air'];
        }
        if($eva1 <-99 or $eva1>99){
            $contError =$contError +1;
            $respuesta = $api->verEvaporation_coil($telemetria_id);
           $evaporation_coil =$respuesta['evaporation_coil'];
        }
        if($amb1 <-5 or $amb1>40){
            $contError =$contError +1;
            $respuesta = $api->verAmbient_air($telemetria_id);
            $ambient_air =$respuesta['ambient_air'];
        }
        if($temp1 <-99 or $temp1>99){
            $contError =$contError +1;
            $respuesta = $api->verTemp_supply($telemetria_id);
           $temp_supply_1 =$respuesta['temp_supply'];
        }
        if($rel1 <-99 or $rel1>99){
           $contError =$contError +1;
           $respuesta = $api->verRelative_humidity($telemetria_id);
           $relative_humidity =$respuesta['relative_humidity'];
        }
        if ($contError>0){
            $er = $api->error_trama($datosRecibidos);
        }

        $C = $api->updateContenedorR( $set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud, $ultima_fecha ,$segundoFiltro);
        
        $created_at= date("Y-m-d H:i:s");
        $R = $api->crearTramaReffer($set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id);


    }
    

}else{
 echo " genial !";
}

}

?>
