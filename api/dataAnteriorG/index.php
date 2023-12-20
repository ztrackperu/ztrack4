<?php
header('Content-type: application/json; charset=utf-8');
// necesarios del modelo 
require_once '../../models/api.php';
$api = new ApiModel();
//$datosRecibidos = json_decode(file_get_contents('php://input'),true);
$datosRecibidos = file_get_contents('php://input');

echo "Hola - >  JSON capturado : ";
$claves = array_map('trim', preg_split('/\R/', $datosRecibidos));
$necesario = $claves[7];
if($claves[2] == "Accept-Encoding: gzip, deflate"){
    $Estructura =$claves[9];
}else{
    $Estructura =$claves[8];
}
//$Estructura =$claves[9];

$generador = json_decode($Estructura);
echo $Estructura;
echo " Ahora vemos la estructura de nombre  : ";
$variable = $generador->nombre_contenedor;
echo  $variable ;

$er = $api->dataAnteriorG($variable,$datosRecibidos);

//echo $contenedor;

/*

POST /api/contenedores HTTP/1.1 -0 
 Accept:          -1
 Connection:     Keep-Alive -2
 Content-Length: 425 -3 
 Content-Type:   application/json -4
 Host:           162.248.55.24  -5 
 User-Agent:     SIMCOM_MODULE -6
7 
 8{"nombre_contenedor":"ZGUU2049067","tipo":"Generador","battery_voltage":14.29,"water_temp":0,"running_frequency":0,"fuel_level":33,"voltage_measure":0,"rotor_current":0,"fiel_current":0,"speed":0,"eco_power":0,"rpm":0,"unit_mode":"SHUTDOWN","horometro":0,"alarma_id":0,"evento_id":0,"modelo":"SG+","latitud":"SS","longitud":"WW","engine_state":"POWER OFF","set_point":0,"temp_supply_1":0,"return_air":0,"reefer_conected":"-"}


*/

$contDirect = $api->verDirectos($variable);

if($contDirect['count(*)'] == 0){

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
    $empresaAsignada =16;
    
    
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
    $latitud =0;
    
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
    $longitud = 0;
    
    
    if($primerFiltro =="Generador"){
        
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
            
    
            $C = $api->crearGeneradorM($segundoFiltro,$tipo , $descripcion,$telemetria_id,$battery_voltage,$water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current ,$speed, $eco_power,$rpm,$unit_mode,$horometro,$alarma_id,$evento_id,$modelo,$latitud,$longitud,$engine_state,$set_point,$temp_supply_1,$return_air,$reefer_conected,$fecha_ultima,$empresaAsignada);
         
            $R = $api->crearTramaGenerador($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $fecha_ultima ,$telemetria_id);
    
            
        }else{
            $telemetria_id =$existeGenerador['telemetria_id'];
    
            $fecha_ultima =date("Y-m-d H:i:s");

    
            $C = $api->updateGeneradorM($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected ,$fecha_ultima ,$segundoFiltro);
            
            $R = $api->crearTramaGenerador($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo ,$latitud ,$longitud,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $fecha_ultima ,$telemetria_id);
    
        }
    
    }
   


}





?>