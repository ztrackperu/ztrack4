<?php
header('Content-type: application/json; charset=utf-8');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
$datosRecibidos = file_get_contents("php://input");
//$datosRecibidos ='{"tipo": "Reefer", "nombre_contenedor": "OSO1", "set_point": 78.0, "temp_supply_1": -197.8, "return_air": -123.1, "evaporation_coil": -223.0, "ambient_air": 129.0, "cargo_1_temp": -3277.0, "cargo_2_temp": -3277.0, "cargo_3_temp": -3277.0, "cargo_4_temp": -3277.0, "relative_humidity": 181.0, "alarm_present": 0, "alarm_number": 0, "controlling_mode": "OPTIMIZED", "power_state": 1, "defrost_term_temp": 18.0,"defrost_interval": 6.0, "latitud": -12.6342, "longitud": -78.0567}';
$contenedor = json_decode($datosRecibidos);
$primerFiltro = $contenedor->tipo ;
$segundoFiltro = $contenedor->nombre_contenedor;

if($primerFiltro =="Reefer"){
    
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
    $empresaAsignada =  1;

    if($nombrecontenedor=='ZGRU2212229'){
        $latitud = "-12.0060";
        $longitud = "-77.0603";
    }
    if($nombrecontenedor=='ZGRU5346143'){
        $nombrecontenedor='LOSU5346143';
    }
    $numero_telefono =  $contenedor->nombre_contenedor;
    $imei =  $contenedor->nombre_contenedor;  
    if( $nombrecontenedor=='LOSU5346143'){
        $existeTelemetria =$api->existeTelemetria($nombrecontenedor);      
        $existeContenedor = $api->comprobarContenedor($nombrecontenedor);
        $contarResultado = $api->contarContenedor($nombrecontenedor);
        $segundoFiltro = $nombrecontenedor;

    }else{
        $existeTelemetria =$api->existeTelemetria($imei);   
        $existeContenedor = $api->comprobarContenedor($segundoFiltro);
        $contarResultado = $api->contarContenedor($segundoFiltro);
    }
    //estructura de analisisn para comandos 
    $ListaComamdosReefer = $api->ListaComandosGenericos($tipo);
    foreach($ListaComamdosReefer as $refer){
     // $comand = refer[]
    }
    if($contarResultado['count(*)'] == 0){
        // al no haber contenedor registrado
        //se crea una telemetria por defecto con el nombre del contenedor       

        $T = $api->saveTelemetria($numero_telefono, $imei);
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
        $direct = $api->directos($segundoFiltro);

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
        $contDirect = $api->verDirectos($segundoFiltro);

        if($contDirect['count(*)'] == 0){
            $direct = $api->directos($segundoFiltro);
        }

        $C = $api->updateContenedorR( $set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud, $ultima_fecha ,$segundoFiltro);
        
        $created_at= date("Y-m-d H:i:s");
        $R = $api->crearTramaReffer($set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id);

    }
    $alerta  = " GUARDADO CORRECTAMENTE";

    // CONSULTAR SI EXITE DATOS DISPOBIBLES EN COMANDO CON ESTADO 0
   // $dataComnado = $api->TablaComando();
    //$com = json_encode($dataComnado);
    //$idComando =array();
   // echo var_dump($dataComnado);
   //echo $dataComnado['id'] ;
    //foreach($dataComnado as $refer){
       // array_push($idComando ,$refer['id'] );
       // $idComando =  $refer['id'] ;
      // echo "hola" ;
    //} print "aspectos directos"
    //$setPoint = $com->id;
    //$setPoint = $com["id"];
    
    // SI EXITE IMPRIMIR CON CODIGO 1B01 
        //actaulizar estado de comanado a 1

    //SI NO EXISTE IMPRIMIR CON CODIGO 1B99

//Imprimir respuesta

$dataEstructuraComando = $alerta."Distribucion de comandos Ejecutada "; 
$configDirectComando = $dataEstructuraComando;

$dataComnado1 = $api->contarContenedorComando($segundoFiltro);

if($dataComnado1['count(*)'] == 0){
  $tramaComando ="1B99 ,NA,NA,NA,NA,NA,NA,NA,NA,NA,NA,NA,NA,NA,NA,NA";
}else {
$dataComnado = $api->TablaComando($segundoFiltro);
$idComando = $dataComnado['id'] ;
$onComando = $dataComnado['on1'] ;
$offComando = $dataComnado['off1'] ;
$defrostComando = $dataComnado['defrost'] ;
$controlComando = $dataComnado['control_mode'] ;
$spointComando = $dataComnado['spoint_temp'] ;
$ptiComando = $dataComnado['pti'] ;
$spHumedadComandov= $dataComnado['sp_humedad'] ;
$spCo2Comando = $dataComnado['sp_co2'] ;
$spDefrostComando = $dataComnado['sp_defrost'] ;
$tiempoDefrostComando = $dataComnado['tiempo_defrost'] ;
$humedadComando =  $dataComnado['humedad'] ;
$cambiarCodigo = $dataComnado['cambiar_codigo'] ;
$funcionTest = $dataComnado['funcion_test'] ;
$reinicioModuloComando = $dataComnado['reinicio_modulo'] ;
$nombreContenedorComando =  $dataComnado['nombre_contenedor'] ;
$telemetriaRelacionadaComando = $dataComnado['estado'] ;

$tramaComando = "1B01 ,".$onComando.",".$offComando.",".$defrostComando.",".$controlComando.",".$spointComando.",".$ptiComando.",".$spHumedadComandov.",".$spCo2Comando.",".$spDefrostComando.",".$tiempoDefrostComando.",".$humedadComando.",".$cambiarCodigo.",".$funcionTest.",".$reinicioModuloComando.",".$nombreContenedorComando;

}

echo $tramaComando;    
}
  /*
else {
    $alerta  = " ERROR DE TIPO";
    // guardar la trama en errores 
    $er = $api->error_trama($datosRecibidos);
}
     
      $respuesta = [
          "mensaje" => "DESDE SERVIDOR LOCAL",
          "nombre" => $contenedor->nombre_contenedor,
          "alerta" => $alerta,
              "cadena" =>[
                      'tipo' =>  $primerFiltro,
                      'nombre_contenedor' => $contenedor->nombre_contenedor
              ],
              "fechaYHora" => date("Y-m-d H:i:s")
          ];
          
          $respuestaCodificada = json_encode($respuesta);
          //echo $respuestaCodificada;
          //echo $idComando[0]  ;
          
       */
?>







