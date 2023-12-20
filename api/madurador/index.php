<?php
header('Content-type: application/json; charset=utf-8');
date_default_timezone_set('America/Lima');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
$datosRecibidos = file_get_contents("php://input");
//$datosRecibidos ='{"tipo": "Madurador", "nombre_contenedor": "COMANDO_MADURADOR", "set_point": 28.0, "temp_supply_1": 5.0, "temp_supply_2": 0.0, "return_air": 0.0, "evaporation_coil": 0.0, "condensation_coil": 0.0, "compress_coil_1": 0.0, "compress_coil_2": 0.0, "ambient_air": 0.0, "cargo_1_temp": 0.0, "cargo_2_temp": 0.0, "cargo_3_temp": 0.0, "cargo_4_temp": 0.0, "relative_humidity": 50.0, "avl": 0.0, "suction_pressure": 0.0,"discharge_pressure": 0.0, "line_voltage": 0.0, "line_frequency": 0.0, "consumption_ph_1": 0.0, "consumption_ph_2": 0.0, "consumption_ph_3": 0.0, "co2_reading": 0.0, "o2_reading": 20.7, "evaporator_speed": 0.0, "condenser_speed": 0.0, "battery_voltage": 0.0, "power_kwh": 0.0, "power_trip_reading": 0.0, "power_trip_duration": 0.0, "suction_temp": 0.0, "discharge_temp": 0.0, "supply_air_temp": 0.0, "return_air_temp": 0.0, "dl_battery_temp": 0.0, "dl_battery_charge": 0.0, "power_consumption": 0.0, "power_consumption_avg": 0.0, "alarm_present": 0.0, "capacity_load": 0.0, "power_state": 0.0, "controlling_mode": "NA", "humidity_control": 0.0, "humidity_set_point": 1011010.0, "fresh_air_ex_mode": 0.0, "fresh_air_ex_rate": 0.0, "fresh_air_ex_delay": 0.0, "set_point_o2": 20.7, "set_point_co2": 3.0, "defrost_term_temp": 0.0, "defrost_interval": 0.0, "water_cooled_conde": 0.0, "usda_trip": 0.0, "evaporator_exp_valve": 0.0, "suction_mod_valve": 0.0, "hot_gas_valve": 0.0, "economizer_valve": 0.0, "ethylene": 0.0, "stateProcess": "RESET", "stateInyection": "NO INJECTING", "timerOfProcess": 0, "modelo": "THERMOKING2", "latitud": 0.0, "longitud": 0.0,"defrost_prueba":3,"ripener_prueba":3}';
//$datosRecibidos ='{"1B": "1B02", "tipo": "Madurador", "nombre_contenedor": "ZGRU4701435", "set_point": 19.0, "temp_supply_1": 21.3, "temp_supply_2": -3277.0, "return_air": 20.3, "evaporation_coil": 20.2, "condensation_coil": 43.6, "compress_coil_1": 57.2, "compress_coil_2": -3276.9, "ambient_air": 26.2, "cargo_1_temp": 0.0, "cargo_2_temp": 0.0, "cargo_3_temp": 0.0, "cargo_4_temp": 0.0, "relative_humidity": 82.0, "avl": 0.0, "suction_pressure": 3276.6, "discharge_pressure": 3276.6, "line_voltage": 463.0, "line_frequency": 60.0, "consumption_ph_1": 6.2, "consumption_ph_2": 7.7, "consumption_ph_3": 7.6, "co2_reading": 25.3, "o2_reading": 3276.6, "evaporator_speed": 30.0, "condenser_speed": 28.0, "battery_voltage": 4563.3, "power_kwh": 160.6, "power_trip_reading": 3276.6, "power_trip_duration": 3276.6, "suction_temp": 21.3, "discharge_temp": 20.3, "supply_air_temp": 0.24, "return_air_temp": 0.0, "dl_battery_temp": 1.95, "dl_battery_charge": 5.3, "power_consumption": 5.28, "power_consumption_avg": 32.0, "alarm_present": 32.0, "capacity_load": 32.0, "power_state": 32.0, "controlling_mode": 32.0, "humidity_control": 32.0, "humidity_set_point": 32766.0, "fresh_air_ex_mode": 3276.6, "fresh_air_ex_rate": 3276.6, "fresh_air_ex_delay": 3276.6, "set_point_o2": 18.0, "set_point_co2": 6.0, "defrost_term_temp": 6.0, "defrost_interval": 6.0, "water_cooled_conde": 255.0, "usda_trip": 255.0, "evaporator_exp_valve": 255.0, "suction_mod_valve": 255.0, "hot_gas_valve": 7.3, "economizer_valve": 7.28, "ethylene": 7.28, "stateProcess": 7.28, "stateInyection": 0.0, "timerOfProcess": 0.0, "modelo": "THERMOKING", "latitud": 0.0, "longitud": 0.0, "defrost_prueba": 2, "ripener_prueba": 2}';
//$datosRecibidos ='{"1B": "1B02", "tipo": "Madurador", "nombre_contenedor": "COMANDO_MADURADOR", "set_point": 19, "temp_supply_1": 17.5, "temp_supply_2": -3277.0, "return_air": 17.9, "evaporation_coil": 18.2, "condensation_coil": 40.3, "compress_coil_1": 59.4, "compress_coil_2": -3276.9, "ambient_air": 25.3, "cargo_1_temp": 0.0, "cargo_2_temp": 0.0, "cargo_3_temp": 0.0, "cargo_4_temp": 0.0, "relative_humidity": 74.0, "avl": 0.0, "suction_pressure": 3264.06, "discharge_pressure": 0.0, "line_voltage": 459.0, "line_frequency": 60.0, "consumption_ph_1": 9.0, "consumption_ph_2": 15.3, "consumption_ph_3": 15.5, "co2_reading": 25.3, "o2_reading": 3276.6, "evaporator_speed": 60.0, "condenser_speed": 30.0, "battery_voltage": 4553.9, "power_kwh": 151.3, "power_trip_reading": 3264.06, "power_trip_duration": 0.0, "suction_temp": 0.0, "discharge_temp": 17.9, "supply_air_temp": 0.24, "return_air_temp": 0.0, "dl_battery_temp": 9.8, "dl_battery_charge": 5.2, "power_consumption": 5.19, "power_consumption_avg": 30.0, "alarm_present": 30.0, "capacity_load": 30.0, "power_state": 30.0, "controlling_mode": 30.0, "humidity_control": 30.0, "humidity_set_point": 32766.0, "fresh_air_ex_mode": 3276.6, "fresh_air_ex_rate": 3276.6, "fresh_air_ex_delay": 0.0, "set_point_o2": 18.0, "set_point_co2": 6.0, "defrost_term_temp": 6.0, "defrost_interval": 6.0, "water_cooled_conde": 255.0, "usda_trip": 255.0, "evaporator_exp_valve": 255.0, "suction_mod_valve": 255.0, "hot_gas_valve": 6.3, "economizer_valve": 6.28, "ethylene": 6.28, "stateProcess": 6.28, "stateInyection": 0.0, "timerOfProcess": 0.0, "modelo": "THERMOKING", "latitud": 0.0, "longitud": 0.0, "defrost_prueba": 2, "ripener_prueba": 2}';
$contenedor = json_decode($datosRecibidos);
$primerFiltro = $contenedor->tipo ;
$segundoFiltro = $contenedor->nombre_contenedor;

if($primerFiltro =="Madurador"){

    $B1 =  $contenedor->B1;
    $set_point =  $contenedor->set_point;
    $temp_supply_2 = $contenedor->temp_supply_2;
    $return_air = $contenedor->return_air;
    $evaporation_coil = $contenedor->evaporation_coil;
    $condensation_coil = $contenedor->condensation_coil;
    $compress_coil_1 = $contenedor->compress_coil_1;
    $compress_coil_2 = $contenedor->compress_coil_2;
    $ambient_air = $contenedor->ambient_air;
    $cargo_1_temp =  $contenedor->cargo_1_temp;

    $cargo_2_temp = $contenedor->cargo_2_temp;
    $cargo_3_temp = $contenedor->cargo_3_temp;
    $cargo_4_temp = $contenedor->cargo_4_temp;
    $relative_humidity = $contenedor->relative_humidity;
    $avl = $contenedor->avl;
    $suction_pressure = $contenedor->suction_pressure;
    $discharge_pressure = $contenedor->discharge_pressure;
    $line_voltage = $contenedor->line_voltage;
    $line_frequency = $contenedor->line_frequency;
    $consumption_ph_1 = $contenedor->consumption_ph_1;
     
    $consumption_ph_2 = $contenedor->consumption_ph_2;
    $consumption_ph_3 = $contenedor->consumption_ph_3;
    $co2_reading = $contenedor->co2_reading;
    $o2_reading = $contenedor->o2_reading;
    $evaporator_speed = $contenedor->evaporator_speed;
    $condenser_speed = $contenedor->condenser_speed;
    $battery_voltage = $contenedor->battery_voltage;
    $power_kwh = $contenedor->power_kwh;
    $power_trip_reading = $contenedor->power_trip_reading;
    $power_trip_duration = $contenedor->power_trip_duration;

    $suction_temp = $contenedor->suction_temp;
    $discharge_temp = $contenedor->discharge_temp;
    $supply_air_temp = $contenedor->supply_air_temp;
    $return_air_temp = $contenedor->return_air_temp;
    $dl_battery_temp = $contenedor->dl_battery_temp;
    $dl_battery_charge = $contenedor->dl_battery_charge;
    $power_consumption = $contenedor->power_consumption;
    $power_consumption_avg = $contenedor->power_consumption_avg;
    $alarm_present = $contenedor->alarm_present;
    $capacity_load = $contenedor->capacity_load;

    $power_state = $contenedor->power_state;
    $controlling_mode = $contenedor->controlling_mode;
    $humidity_control = $contenedor->humidity_control;
    $humidity_set_point = $contenedor->humidity_set_point;
    $fresh_air_ex_mode = $contenedor->fresh_air_ex_mode;
    $fresh_air_ex_rate = $contenedor->fresh_air_ex_rate;
    $fresh_air_ex_delay = $contenedor->fresh_air_ex_delay;
    $set_point_o2 = $contenedor->set_point_o2;
    $set_point_co2 = $contenedor->set_point_co2;
    $defrost_term_temp = $contenedor->defrost_term_temp;

    $defrost_interval = $contenedor->defrost_interval;
    $water_cooled_conde = $contenedor->water_cooled_conde;
    $usda_trip = $contenedor->usda_trip;
    $evaporator_exp_valve = $contenedor->evaporator_exp_valve;
    $suction_mod_valve = $contenedor->suction_mod_valve;
    $hot_gas_valve = $contenedor->hot_gas_valve;
    $economizer_valve = $contenedor->economizer_valve;
    $ethylene = $contenedor->ethylene;
    $stateProcess = $contenedor->stateProcess;
    $stateInyection = $contenedor->stateInyection;

    $timerOfProcess = $contenedor->timerOfProcess;
    $modelo = $contenedor->modelo; 

    $temp_supply_1 = $contenedor->temp_supply_1;
    $latitud = $contenedor->latitud;
    $longitud = $contenedor->longitud ;
    $nombrecontenedor = $contenedor->nombre_contenedor;

    $defrost_prueba = $contenedor->defrost_prueba;
    $ripener_prueba = $contenedor->ripener_prueba;
    //$sp_ethyleno =$contenedor->sp_ethyleno;
    if($B1 =="1B02"){
        $sp_ethyleno =0;
    }else{
        $sp_ethyleno =$contenedor->sp_ethyleno;
    }

    $empresaAsignada = 1;
    $tipo = "Madurador";
    $descripcion = "Sin Informacion";
    if($nombrecontenedor=='ZGRU7567785' ){
        $latitud = "-11.98016";
        $longitud = "-77.12271";
        $relative_humidity = 0;
    }
    if($nombrecontenedor=='ZGRU4701435'){
        $latitud = "-11.98016";
        $longitud = "-77.12271";
        //$relative_humidity = 0;
    }
    //Dispositivo de APEEL en Chiclayo
    if($nombrecontenedor=='ZGRU5100830'){
        $latitud = "-7.0684";
        $longitud = "-79.5591";
        //$relative_humidity = 0;
    }
    //Dispositvos en ESTADOS UNIDOS
    if($nombrecontenedor=='ZGRU2232647'){
        $latitud = "35.739611";
        $longitud = "-119.238378";
        //$relative_humidity = 0;
    }
    if($nombrecontenedor=='ZGRU2008220'){
        $latitud = "35.739411";
        $longitud = "-119.238278";
        //$relative_humidity = 0;
    }

    if($nombrecontenedor=='ZGRU2009227'){
        $latitud = "35.739511";
        $longitud = "-119.238278";
        //$relative_humidity = 0;
    }
    //BE FROST en Mexico
    if($nombrecontenedor=='ZGRU9802890'){
        $latitud = "21.85343";
        $longitud = "-100.89133";
    }
    if($nombrecontenedor=='ZGRU9803243'){
        $latitud = "21.85333";
        $longitud = "-100.89133";
    }


    //$alarm_number = $contenedor->alarm_number;
    $numero_telefono =  $contenedor->nombre_contenedor;
    $imei =  $contenedor->nombre_contenedor;

    $existeTelemetria =$api->existeTelemetria($imei);   
    $existeContenedor = $api->comprobarContenedor($segundoFiltro);
    $contarResultado = $api->contarContenedor($segundoFiltro);
    
    //evaluamos la existencia de comandos  
    $contarComandosPendientes = $api->contarComandos($segundoFiltro);
    if($contarComandosPendientes['count(*)'] == 0){
        if($contarResultado['count(*)'] == 0){     
            $T = $api->saveTelemetria($numero_telefono, $imei);
            $existeTelemetria1 =$api->existeTelemetria($imei);
            $telemetria_id =$existeTelemetria1['id'];    
            $ultima_fecha =date("Y-m-d H:i:s");    
            $contError =0;   
            $set1 =  $contenedor->set_point;
            $ret1 = $contenedor->return_air;
            $eva1 = $contenedor->evaporation_coil;
            $amb1 = $contenedor->ambient_air;
            $rel1 = $contenedor->relative_humidity;
            $temp1= $contenedor->temp_supply_1;
            $ethy1 = $contenedor->ethylene;
            $co21 = $contenedor->co2_reading;
        
            if($set1 <-99 or $set1>99){

                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
               $set_point =0;
            }
            if($ret1 <-0 or $ret1>99){
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
            if($ethy1 <0 or $ethy1>99){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
               $ethylene =0;
            }
            if($co21 <0 or $co21>99){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
               $co2_reading =0;
            }
            if ($contError>0){
                $er = $api->error_trama($datosRecibidos);
            }
            $direct = $api->directos($segundoFiltro);

            $C = $api->crearContenedorM($nombrecontenedor, $tipo,$descripcion,$telemetria_id,$set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$ultima_fecha,$empresaAsignada,$defrost_prueba,$ripener_prueba);
            $created_at= date("Y-m-d H:i:s");
            $R = $api->crearTramaMadurador($set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$telemetria_id,$defrost_prueba,$ripener_prueba,$sp_ethyleno);
    
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
            $co21 = $contenedor->co2_reading;

            $ethy1 = $contenedor->ethylene;
            if($ethy1 < 0 or $ethy1>300){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verEthyleneM($telemetria_id);
               $ethylene =$respuesta['ethylene'];
            }
            
            if($set1 <-99 or $set1>99){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verSet_pointM($telemetria_id);
               $set_point =$respuesta['set_point'];
            }
            if($ret1 <-99 or $ret1>99){
                $contError =$contError +1;
                $respuesta = $api->verReturn_airM($telemetria_id);
               $return_air =$respuesta['return_air'];
            }
            if($eva1 <-99 or $eva1>99){
                $contError =$contError +1;
                $respuesta = $api->verEvaporation_coilM($telemetria_id);
               $evaporation_coil =$respuesta['evaporation_coil'];
            }
            if($amb1 <-5 or $amb1>40){
                $contError =$contError +1;
                $respuesta = $api->verAmbient_airM($telemetria_id);
                $ambient_air =$respuesta['ambient_air'];
            }
            if($temp1 <-99 or $temp1>99){
                $contError =$contError +1;
                $respuesta = $api->verTemp_supplyM($telemetria_id);
               $temp_supply_1 =$respuesta['temp_supply_1'];
            }
            if($rel1 <-99 or $rel1>99){
               $contError =$contError +1;
               $respuesta = $api->verRelative_humidityM($telemetria_id);
               $relative_humidity =$respuesta['relative_humidity'];
            }
            if($co21 <0 or $co21>99){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verCo2M($telemetria_id);
                $co2_reading =$respuesta['co2_reading'];
            }

            // filtramos valores que salgan 0 y dañenm la grafica 
            if($set1==0){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verSet_pointM($telemetria_id);
               $set_point =$respuesta['set_point'];
            }
            if($ret1==0){
                $contError =$contError +1;
                $respuesta = $api->verReturn_airM($telemetria_id);
               $return_air =$respuesta['return_air'];
            }
            if($eva1==0){
                $contError =$contError +1;
                $respuesta = $api->verEvaporation_coilM($telemetria_id);
               $evaporation_coil =$respuesta['evaporation_coil'];
            }
            if($amb1==0){
                $contError =$contError +1;
                $respuesta = $api->verAmbient_airM($telemetria_id);
                $ambient_air =$respuesta['ambient_air'];
            }
            if($temp1==0){
                $contError =$contError +1;
                $respuesta = $api->verTemp_supplyM($telemetria_id);
               $temp_supply_1 =$respuesta['temp_supply_1'];
            }
            if($rel1==0){
               $contError =$contError +1;
               $respuesta = $api->verRelative_humidityM($telemetria_id);
               $relative_humidity =$respuesta['relative_humidity'];
            }
       
            if($ethy1==0){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verEthyleneM($telemetria_id);
               $ethylene =$respuesta['ethylene'];
            }
            if($co21==0){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verCo2M($telemetria_id);
                $co2_reading =$respuesta['co2_reading'];
             
            }

            if ($contError>0){
                $er = $api->error_trama($datosRecibidos);
            }
            $contDirect = $api->verDirectos($segundoFiltro);
    
            if($contDirect['count(*)'] == 0){
                $direct = $api->directos($segundoFiltro);
            }
            $C = $api->updateContenedorM($set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$ultima_fecha ,$defrost_prueba,$ripener_prueba,$segundoFiltro);
            $created_at= date("Y-m-d H:i:s");   
            $R = $api->crearTramaMadurador($set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$telemetria_id,$defrost_prueba,$ripener_prueba,$sp_ethyleno);
    
    
        }
        $alerta  = " GUARDADO CORRECTAMENTE";
        $mensaje ="No existen comandos pendientes";
    }else{
         //pedir trama anterior del dispositivo para comparar
       
         $telemetria_id1 =$existeContenedor['telemetria_id'];
         //echo $telemetria_id1;
         $tramaAnterior = $api->tramaAnteriorM($telemetria_id1);
        // print_r($tramaAnterior);
        // tratamos los comandos pendientes
        $comandosPendientes = $api->comandosPendientes($segundoFiltro);
        foreach($comandosPendientes as $data){
            $detalleComando = $api->detalleComando($data['comando_id']);
            //print_r($detalleComando) ;
            $campo_relacionado = $detalleComando['campo_relacionado'];
            //echo $campo_relacionado;
            $valor_buscado = $data['valor_modificado'] ;
            $valor_anterior = $tramaAnterior[$campo_relacionado];
            $valor_trama = $contenedor->$campo_relacionado;
           // echo " este es el valor buscado : ".$valor_buscado." y est es el valor anterior : ".$valor_anterior. " mas el valor en trama es : ".$valor_trama;
           //echo $valor_buscado.$valor_trama;
            if ($valor_buscado == $valor_trama ){
                
                //despues actualizar estado_comando a 0
                $actualizarComando = $api->actualizarComando($data['id']);
                /*
                if($actualizarComando==true){
                  echo "se actualizo el comando";
                  echo $segundoFiltro;
                }else{
                   echo "error en funcion";
                }
                */
  
            }           
        }
            $telemetria_id =$existeContenedor['telemetria_id'];
            $ultima_fecha =date("Y-m-d H:i:s");
            $contError =0;
            $set1 =  $contenedor->set_point;
            $ret1 = $contenedor->return_air;
            $eva1 = $contenedor->evaporation_coil;
            $amb1 = $contenedor->ambient_air;
            $rel1 = $contenedor->relative_humidity;
            $temp1= $contenedor->temp_supply_1;
            $ethy1 = $contenedor->ethylene;
            $co21 = $contenedor->co2_reading;
            if($ethy1 < 0 or $ethy1>300){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verEthyleneM($telemetria_id);
               $ethylene =$respuesta['ethylene'];
            }
            if($co21 < 0 or $co21>100){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verCo2M($telemetria_id);
               $co2_reading =$respuesta['co2_reading'];
            }
            if($set1 <-99 or $set1>99){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verSet_pointM($telemetria_id);
               $set_point =$respuesta['set_point'];
            }
            if($ret1 <-99 or $ret1>99){
                $contError =$contError +1;
                $respuesta = $api->verReturn_airM($telemetria_id);
               $return_air =$respuesta['return_air'];
            }
            if($eva1 <-99 or $eva1>99){
                $contError =$contError +1;
                $respuesta = $api->verEvaporation_coilM($telemetria_id);
               $evaporation_coil =$respuesta['evaporation_coil'];
            }
            if($amb1 <-5 or $amb1>40){
                $contError =$contError +1;
                $respuesta = $api->verAmbient_airM($telemetria_id);
                $ambient_air =$respuesta['ambient_air'];
            }
            if($temp1 <-99 or $temp1>99){
                $contError =$contError +1;
                $respuesta = $api->verTemp_supplyM($telemetria_id);
               $temp_supply_1 =$respuesta['temp_supply'];
            }
            if($rel1 <-0 or $rel1>99){
               $contError =$contError +1;
               $respuesta = $api->verRelative_humidityM($telemetria_id);
               $relative_humidity =$respuesta['relative_humidity'];
            }
            

            // filtramos valores que salgan 0 y dañenm la grafica 
            if($set1==0){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verSet_pointM($telemetria_id);
               $set_point =$respuesta['set_point'];
            }
            if($ret1==0){
                $contError =$contError +1;
                $respuesta = $api->verReturn_airM($telemetria_id);
               $return_air =$respuesta['return_air'];
            }
            if($eva1==0){
                $contError =$contError +1;
                $respuesta = $api->verEvaporation_coilM($telemetria_id);
               $evaporation_coil =$respuesta['evaporation_coil'];
            }
            if($amb1==0){
                $contError =$contError +1;
                $respuesta = $api->verAmbient_airM($telemetria_id);
                $ambient_air =$respuesta['ambient_air'];
            }
            if($temp1==0){
                $contError =$contError +1;
                $respuesta = $api->verTemp_supplyM($telemetria_id);
               $temp_supply_1 =$respuesta['temp_supply_1'];
            }
            if($rel1==0){
               $contError =$contError +1;
               $respuesta = $api->verRelative_humidityM($telemetria_id);
               $relative_humidity =$respuesta['relative_humidity'];
            }
            if($co21==0){
                $contError =$contError +1;
                // consulta al ultimo dato que este bien de set_point envia el 
                $respuesta = $api->verCo2M($telemetria_id);
               $co2_reading =$respuesta['co2_reading'];
            }



            if ($contError>0){
                $er = $api->error_trama($datosRecibidos);
            }
            $contDirect = $api->verDirectos($segundoFiltro);
    
            if($contDirect['count(*)'] == 0){
                $direct = $api->directos($segundoFiltro);
            }

            $C = $api->updateContenedorM($set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$ultima_fecha ,$defrost_prueba,$ripener_prueba,$segundoFiltro);
            $created_at= date("Y-m-d H:i:s");   
            $R = $api->crearTramaMadurador($set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$telemetria_id,$defrost_prueba,$ripener_prueba,$sp_ethyleno);
            $comandosPendientesPost = $api->comandosPendientes($segundoFiltro);
            $contarComandosPendientesPost = $api->contarComandos($segundoFiltro);
            if($contarComandosPendientesPost['count(*)'] == 0){
                $trama_respuesta ="los cambios fueron detectados" ;
            }else{
                $trama_respuesta = "2B59";
                $trama_respuesta .=",".$segundoFiltro ;
                foreach($comandosPendientesPost as $data1){
                    $detalleComandopost = $api->detalleComando($data1['comando_id']);
                    $trama_respuesta .=",#".$detalleComandopost['lista'].",".$data1['valor_modificado'];
    
                }
            
                $trama_respuesta .=",";
            }
                 
           $mensaje = $trama_respuesta;
    }
    echo $mensaje;  
 
}

?>
