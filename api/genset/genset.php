<?php
header('Content-type: application/json; charset=utf-8');
date_default_timezone_set('America/Lima');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
$datosRecibidos = file_get_contents("php://input");
//$datosRecibidos ='{"nombre_contenedor": "ZGUU2240406", "tipo": "Generador", "battery_voltage": 35.0, "water_temp": 71.7, "running_frequency": 59.3, "fuel_level": 182.1, "voltage_measure": 464.0, "rotor_current": 0.0, "fiel_current": 0.0, "speed": 0, "eco_power": 0, "rpm": 1780.0, "unit_mode": "LOW", "horometro": 5, "alarma_id": 0.0, "evento_id": 0.0, "modelo": "SG+", "latitud": "W1193.5954000000002", "longitud": "S7713.257500000001", "engine_state": "LOW", "set_point": 0.0, "temp_supply_1": 0.0, "return_air": 0.0, "reefer_conected": "-"}';
$generador = json_decode($datosRecibidos);
$primerFiltro = $generador->tipo ;
$segundoFiltro = $generador->nombre_contenedor;

$battery_voltage =  $generador->battery_voltage;
$water_temp = $generador->water_temp;
$running_frequency = $generador->running_frequency;
$fuel_level = $generador->fuel_level;
$voltage_measure =  $generador->voltage_measure;
$rotor_current = $generador->rotor_current;
$fiel_current = $generador->fiel_current;
$speed = $generador->speed;
$eco_power = $generador->eco_power;
$rpm = $generador->rpm;
$unit_mode = $generador->unit_mode;
$horometro =  $generador->horometro;
$alarma_id = $generador->alarma_id;
$evento_id = $generador->evento_id;
$modelo = $generador->modelo;
$fraseLatitud = $generador->latitud;
$fraseLongitud = $generador->longitud;
$engine_state = $generador->engine_state;
$set_point = $generador->set_point;
$temp_supply_1 = $generador->temp_supply_1;
$return_air = $generador->return_air;
$reefer_conected = $generador->reefer_conected;
$tipo = $primerFiltro;
$descripcion = "Sin Informacion";
$empresaAsignada =1;


//tratamiento de Latitud
$letraLatitud = substr($fraseLatitud,0,1);
$sinLetra = substr($fraseLatitud,1);
$cadenaLatitud = floatval($sinLetra);
//$enteroLatitud =substr($sinLetra, 0, strpos($sinLetra, '.'));
//$decimalLatitud = substr($sinLetra, strpos($sinLetra,'.')+strlen('.'));
//$decimalLatitudAjustado = substr($decimalLatitud,0,4);
//$cadenaLatitud = $enteroLatitud.$decimalLatitudAjustado;
$convertirDecimal =$cadenaLatitud/100;
if($letraLatitud=="W" or $letraLatitud=="S"){
    $nuevaLatitud = '-'.$convertirDecimal;
}else{
    $nuevaLatitud = '+'.$convertirDecimal;
}
//$latitudTratada = tratamiento($letraLatitud ,$sinletra1);
echo $nuevaLatitud ;
$latitud =$nuevaLatitud;

//tratamiento de Longitud
$letraLongitud = substr($fraseLongitud,0,1);
$sinLetra1 = substr($fraseLongitud,1);
$cadenaLongitud =floatval($sinLetra1);
//$enteroLongitud =substr($sinLetra1, 0, strpos($sinLetra1, '.'));
//$decimalLongitud = substr($sinLetra1, strpos($sinLetra1,'.')+strlen('.'));
//$decimalLongitudAjustado = substr($decimalLongitud,0,4);
//$cadenaLongitud = $enteroLongitud.$decimalLongitudAjustado;
$convertirDecimal1 =$cadenaLongitud/100;
if($letraLongitud=="W" or $letraLongitud=="S"){
    $nuevaLongitud = '-'.$convertirDecimal1;
}else{
    $nuevaLongitud = '+'.$convertirDecimal1;
}
//$latitudTratada = tratamiento($letraLatitud ,$sinletra1);
echo $nuevaLongitud ;
$longitud =$nuevaLongitud;


if($primerFiltro =="Generador"){
    if($segundoFiltro =="ZGGU1806109"){
        $speed = 0;
        $eco_power = 0 ;
    }
    
    $existeGenerador = $api->comprobarGenerador($segundoFiltro);
    $contarResultado = $api->contarGenerador($segundoFiltro);

    if($contarResultado['count(*)'] == 0){
        // al no haber contenedor registrado
        //se crea una telemetria por defecto con el nombre del contenedor       
        $numero_telefono =  $generador->nombre_contenedor;
        $imei =  $generador->nombre_contenedor;  
        $T = $api->saveTelemetria($numero_telefono, $imei);

        $existeTelemetria =$api->existeTelemetria($imei);
        //aqui se capturaq el id de la telemetria que se acaba de guardar
        $telemetria_id =$existeTelemetria['id'];
        //datos a guardar en tabla generadores  
   
        $fecha_ultima =date("Y-m-d H:i:s");
        
        $direct = $api->directos($segundoFiltro);

        $C = $api->crearGeneradorM($segundoFiltro,$tipo , $descripcion,$telemetria_id,$battery_voltage,$water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current ,$speed, $eco_power,$rpm,$unit_mode,$horometro,$alarma_id,$evento_id,$modelo,$latitud,$longitud,$engine_state,$set_point,$temp_supply_1,$return_air,$reefer_conected,$fecha_ultima,$empresaAsignada);
     
        $R = $api->crearTramaGenerador($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $fecha_ultima ,$telemetria_id);

        
    }else{
        $telemetria_id =$existeGenerador['telemetria_id'];

        $fecha_ultima =date("Y-m-d H:i:s");
        $contDirect = $api->verDirectos($segundoFiltro);

        if($contDirect['count(*)'] == 0){
            $direct = $api->directos($segundoFiltro);
        }

        $C = $api->updateGeneradorM($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected ,$fecha_ultima ,$segundoFiltro);
        
        $R = $api->crearTramaGenerador($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo ,$latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $fecha_ultima ,$telemetria_id);

    }

}
       
      $respuesta = [
          "mensaje" => "DESDE SERVIDOR DE ZGROUP",
          "nombre" => $generador->nombre_contenedor,
              "cadena" =>[
                      'tipo' =>  $generador->tipo,
                      'nombre_contenedor' => $generador->nombre_contenedor
              ],
              "fechaYHora" => date("Y-m-d H:i:s")
          ];
          
          $respuestaCodificada = json_encode($respuesta);
          echo $respuestaCodificada;
          

?>

