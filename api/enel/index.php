<?php
header('Content-type: application/json; charset=utf-8');
date_default_timezone_set('America/Lima');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
$datosRecibidos = file_get_contents("php://input");
//$datosRecibidos ='{"nombre_contenedor": "ZGUU2240406", "tipo": "Generador", "battery_voltage": 35.0, "water_temp": 71.7, "running_frequency": 59.3, "fuel_level": 182.1, "voltage_measure": 464.0, "rotor_current": 0.0, "fiel_current": 0.0, "speed": 0, "eco_power": 0, "rpm": 1780.0, "unit_mode": "LOW", "horometro": 5, "alarma_id": 0.0, "evento_id": 0.0, "modelo": "SG+", "latitud": "W1193.5954000000002", "longitud": "S7713.257500000001", "engine_state": "LOW", "set_point": 0.0, "temp_supply_1": 0.0, "return_air": 0.0, "reefer_conected": "-"}';
$enel = json_decode($datosRecibidos);

$nombre_dispositivo =  $enel->dato1;
$dato1 = $enel->dato2;
$dato2 = $enel->dato3;

$fecha_ultima =date("Y-m-d H:i:s");
$latitud = -11.98003;
$longitud = -77.1226;

    if($contarResultadoEnel['count(*)'] == 0){

        
        $C = $api->crearEnel($segundoFiltro,$tipo , $descripcion,$telemetria_id,$battery_voltage,$water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current ,$speed, $eco_power,$rpm,$unit_mode,$horometro,$alarma_id,$evento_id,$modelo,$latitud,$longitud,$engine_state,$set_point,$temp_supply_1,$return_air,$reefer_conected,$fecha_ultima);
     
        $R = $api->crearTramaEnel($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $fecha_ultima ,$telemetria_id);

        
    }else{
        $telemetria_id =$existeGenerador['telemetria_id'];

        $fecha_ultima =date("Y-m-d H:i:s");

        $C = $api->actualizarEnel($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected ,$fecha_ultima ,$segundoFiltro);
        
        $R = $api->crearTramaEnel($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo ,$latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $fecha_ultima ,$telemetria_id);

    }


       
      $respuesta = [
          "mensaje" => "DESDE SERVIDOR PARA ENEL",
          "nombre" => $enel->dato1,
              "cadena" =>[
                      'dato1' =>  $enel->dato1,
                      'dato2' => $enel->dato2
              ],
              "fechaYHora" => date("Y-m-d H:i:s")
          ];
          
          $respuestaCodificada = json_encode($respuesta);
          echo $respuestaCodificada;
    
?>
