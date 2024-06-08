<?php
// necesarios del modelo

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);


function faren($celcius){


$conver = ($celcius*9)/5 +32;
return $conver ;

}

ini_set('memory_limit', '-1'); 
require_once '../models/principal.php';

require '../../../test/ztotal/vendor/autoload.php';
//use Exception;
use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use MongoDB\BSON\UTCDateTime ;



$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$principal = new PrincipalModel();
//opciones a trabajar
switch ($option) {
    //para listar en tabla la informacion obtenidos de la database
    case 'listarReefer':
        $data['listaReefer'] = $principal->listaReefer();
        echo json_encode($data);


        break;

    case 'consultaFechaMadurador3':

            $idf = $_GET['id'];
            $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
            $fechaaInicio = substr($idf, 0, strpos($idf, ','));
            $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
            $telemetria1 = substr($parte2, strpos($parte2,';')+strlen(';'));
            $telemetria = substr($telemetria1,0,strpos($telemetria1,"|"));
            $GMT = substr($telemetria1,strpos($telemetria1,'|')+strlen('|'));
//echo $GMT;

$signoGMT =  substr($GMT,0,1);          
$horaGTM =  substr($GMT,1,2);
$minutoGTM = substr($GMT ,3,2);

//echo  "el signo : ".$signoGMT." LA HORA ES : ".$horaGTM." Los minutos son : " . $minutoGTM;

//echo $horaGTM+1;
// evaluar zona horaria 
$horaG = $horaGTM+0;

//echo "VA". var_dump($horaG);

if($minutoGTM=="30"){
//RESOLVER PROBLEMA DE DESCONTRA MINUTOS

//$horaG = $horaG+0.5;
$horaG = $horaG;
}
	
if($signoGMT=="-"){
 $horaG = $horaG*(-1);
}

//echo "la condicion es :  " .$horaG;
  
          /*
            $data1 = $principal->listaMaduradorFecha($telemetria , $fechaaInicio ,$fechaFin);
            if(empty($data1)){$data['tramaMadurador'] = $principal->listaMaduradorAprox();
            }else{ $data['tramaMadurador'] =$data1; }  
            $data['madurador'] = $principal->madurador($telemetria);
    */
    //$data['madurador'] = $principal->madurador($telemetria);
            // Replace the placeholder with your Atlas connection string
            
            $uri = 'mongodb://localhost:27017';
    // Specify Stable API version 1
    $apiVersion = new ServerApi(ServerApi::V1);
    // Create a new client and connect to the server
    $client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);
    try {
        // Send a ping to confirm a successful connection
        $client->selectDatabase('ZTRACK_P')->command(['ping' => 1]);
        //echo "Pinged your deployment. You successfully connected to MongoDB!\n";
    } catch (Exception $e) {
        printf($e->getMessage());
    }
          //$coleccion = $client->selectDatabase('ztrack')->madurador ;
    
         //$data['bacan'] = $client->ztrack->madurador2->find(['telemetria_id' => 33]);
         /*
         $data['madurador'] = $principal->maduradorT($telemetria);
         echo json_encode($data);
         break;
         */
        //array( "created_at"=>array('$gt'=>new MongoDate(strtotime($fechaaInicio)), '$gte'=>new MongoDate(strtotime($fechaFin))))
         $fechaaInicio1 =$fechaaInicio.":00";
         $fechaFin1 =$fechaFin.":00";
         //problemas con fecha 5 horas menos debe ser UTC-5
        $nivelMundial = -5-5-($horaG);
 //$nivelMundial = -13;
        $puntoA = strtotime($fechaaInicio);

         $puntoA1 = strtotime($nivelMundial." hours",$puntoA)*1000;
         $puntoB = strtotime($fechaFin)  ;
         $puntoB1 = strtotime($nivelMundial." hours" ,$puntoB)*1000;

//nivelador GTM 
//$nivelMundial = -5-($horaG);



         //$puntoA2 = strtotime($fech);
         //$puntoA1 = strtotime($nivelMundial." hours",$puntoA2)*1000;
         //$puntoB2 = strtotime($fechaFin)  ;
         //$puntoB1 = strtotime($nivelMundial." hours" ,$puntoB2)*1000  ;



         // se selcciona los campos y las fechas 
         $cursor  = $client->ztrack_ja->madurador->find(array('$and' =>array( ['created_at'=>array('$gte'=>new MongoDB\BSON\UTCDateTime($puntoA1),'$lte'=>new MongoDB\BSON\UTCDateTime($puntoB1)),'telemetria_id'=>intval($telemetria)] )),
         array('projection' => array('_id' => 0,'trama'=> 1, 'created_at' => 1,'stateProcess' => 1,'set_point' => 1,'temp_supply_1' => 1,'return_air' => 1,'evaporation_coil' => 1,'ambient_air' => 1,'relative_humidity' => 1,'controlling_mode' => 1,'sp_ethyleno' => 1,
         'ethylene' => 1,'avl' => 1,'power_state' => 1,'compress_coil_1' => 1,'consumption_ph_1' => 1,'consumption_ph_2' => 1,'consumption_ph_3' => 1,'co2_reading' => 1,'o2_reading' => 1,'set_point_o2' => 1,'set_point_co2' => 1,'line_voltage' => 1,
         'defrost_term_temp' => 1,'defrost_interval' => 1,'inyeccion_pwm' => 1,'inyeccion_hora' => 1,'latitud' => 1,'longitud' => 1,'fresh_air_ex_mode' => 1,'telemetria_id'=>1,'cargo_1_temp' =>1,'cargo_2_temp' =>1,'cargo_3_temp' =>1,'cargo_4_temp' =>1,'id'=>1 ,'power_kwh' =>1),'sort'=>array('id'=>1)));
         //$cursor1 =$cursor->sort(array('trama' => 1));
         //array('sort'=>array('trama' => -1))
         $total['fecha']= [];
         $total['setPoint'] =[];
         $total['returnAir'] =[];
         $total['tempSupply'] =[];
         $total['ambienteAir'] =[];
         $total['relativeHumidity'] =[];
         $total['evaporationCoil'] =[];
         $total['D_ethylene'] =[];
         $total['co2'] =[];
         $total['sp_ethylene'] =[];
         $total['inyeccionEtileno'] =[];
         $total['telemetria_id'] =[];
         $total['objetivo'] =[];
         $total['cargo_1_temp'] =[];
         $total['cargo_2_temp'] =[];
         $total['cargo_3_temp'] =[];
         $total['cargo_4_temp'] =[];

         //array('$gt'=>new MongoDB\BSON\UTCDateTime(strtotime($fechaaInicio)*1000), '$gte'=>new MongoDB\BSON\UTCDateTime(strtotime($fechaFin)*1000))
         //     $cursor  = $client->ztrack->madurador2->find(array('$and' =>array( ['created_at'=>array('$gt'=>new MongoDB\BSON\UTCDateTime($puntoA)),'created_at'=>array('$gte'=>new MongoDB\BSON\UTCDateTime($puntoB)),'telemetria_id'=>intval($telemetria)] )));
         $total['madurador2'] = [];
         $total['inyeccion_pwm'] =[];
         $cont=0;
         foreach ($cursor as $document) {
            $cont++;
            if($cont%1==0)
            {

            //array_push($total['fecha'],$document['created_at']);
            $fechaJa = json_decode($document['created_at'])/1000;
            // $fechaJa1 = $fechaJa['$date'];
            $fechaD = date('d-m-Y H:i:s', $fechaJa);
    
            $puntoA = strtotime($fechaD);
$baseHoraGTM = +5 +5+($horaG);
            $puntoA1 = strtotime($baseHoraGTM." hours",$puntoA);
            $fechaD1 = date('d-m-Y H:i:s', $puntoA1);
           // array_push($total,$fechaD);
           array_push($total['fecha'],$fechaD1);
            //array_push($total['tramaMadurador'],$document);  



            if($document['relative_humidity']<=100.00){
                array_push($total['relativeHumidity'],$document['relative_humidity']);

            }else{
                array_push($total['relativeHumidity'],null);

          }

 array_push($total['objetivo'],2.00);



if($document['telemetria_id']==4584 ||$document['telemetria_id']==4586 ||$document['telemetria_id']==4587  || $document['telemetria_id']==4588 ||$document['telemetria_id']==4589 ||$document['telemetria_id']==33 || $document['telemetria_id']==258 ||$document['telemetria_id']==259 ||$document['telemetria_id']==260  || $document['telemetria_id']==4500 ||$document['telemetria_id']==4487 ) {
            array_push($total['setPoint'],round(faren($document['set_point'])));
            array_push($total['returnAir'],round(faren($document['return_air']),1));
            array_push($total['tempSupply'],round(faren($document['temp_supply_1']),1));
            array_push($total['ambienteAir'],round(faren($document['ambient_air']),1));
            if($document['evaporation_coil']>=50.00){
                array_push($total['evaporationCoil'],null);
            }else{
                array_push($total['evaporationCoil'],round(faren($document['evaporation_coil']),1));
            }
            if($document['cargo_1_temp']>=40.00 || $document['cargo_1_temp']==25.60  ){
                array_push($total['cargo_1_temp'],null);
            }else{
                array_push($total['cargo_1_temp'],round(faren($document['cargo_1_temp']),1));
            }

            if($document['cargo_2_temp']>=40.00){
                array_push($total['cargo_2_temp'],null);
            }else{
                array_push($total['cargo_2_temp'],round(faren($document['cargo_2_temp'])));
            }
            if($document['cargo_3_temp']>=40.00){
                array_push($total['cargo_3_temp'],null);
            }else{
                array_push($total['cargo_3_temp'],round(faren($document['cargo_3_temp'])));
            }
            if($document['cargo_4_temp']>=40.00){
                array_push($total['cargo_4_temp'],null);
            }else{
                array_push($total['cargo_4_temp'],faren($document['cargo_4_temp']));
            }
}else{
            array_push($total['setPoint'],$document['set_point']);
            array_push($total['returnAir'],$document['return_air']);
            array_push($total['tempSupply'],$document['temp_supply_1']);
            array_push($total['ambienteAir'],$document['ambient_air']);
            if($document['evaporation_coil']>=50.00){
                array_push($total['evaporationCoil'],null);
            }else{
                array_push($total['evaporationCoil'],$document['evaporation_coil']);
            }
            if($document['cargo_1_temp']>=40.00 || $document['cargo_1_temp']==25.60  ){
                array_push($total['cargo_1_temp'],null);
            }else{
                array_push($total['cargo_1_temp'],$document['cargo_1_temp']);
            }

            if($document['cargo_2_temp']>=40.00){
                array_push($total['cargo_2_temp'],null);
            }else{
                array_push($total['cargo_2_temp'],$document['cargo_2_temp']);
            }
            if($document['cargo_3_temp']>=40.00){
                array_push($total['cargo_3_temp'],null);
            }else{
                array_push($total['cargo_3_temp'],$document['cargo_3_temp']);
            }
            if($document['cargo_4_temp']>=40.00){
                array_push($total['cargo_4_temp'],null);
            }else{
                array_push($total['cargo_4_temp'],$document['cargo_4_temp']);
            }
}            



            if($document['co2_reading']>25.3){
                array_push($total['co2'],null);
            }
            //else if($document['co2_reading']>25){
              //  array_push($total['co2'],0.1);
            //}
            else{
                array_push($total['co2'],$document['co2_reading']);
            }
            //array_push($total['co2'],$document['co2_reading']);
            if($document['sp_ethyleno']==-1.00){
                array_push($total['sp_ethylene'],null);
            }else{
                array_push($total['sp_ethylene'],$document['sp_ethyleno']);
            }
           
            //array_push($total['fecha'],$document['created_at']);
            //array_push($total['inyeccionEtileno'],$document['stateProcess']);
            if($document['stateProcess']==5.00 ){
                array_push($total['inyeccionEtileno'],100); 
if($document['ethylene']>230){
               array_push($total['D_ethylene'],null);

}else{
                array_push($total['D_ethylene'],$document['ethylene']);

}


               // array_push($total['D_ethylene'],$document['ethylene']);  
            }else{
                array_push($total['inyeccionEtileno'],0);
                //if($document['stateProcess']==-1.00){

                //}
                if($document['telemetria_id']==260 || $document['telemetria_id']==259 || $document['telemetria_id']==258 || $document['telemetria_id']==33 ){
                    //se hace la regulacion  de datos por encima de 20 ppm
                    $nuevoEthyleno = (intval(($document['ethylene']-0.9)*10))/10;
                    if($nuevoEthyleno>0 && $nuevoEthyleno<20){
                        array_push($total['D_ethylene'],$nuevoEthyleno);
                    }elseif($nuevoEthyleno>20){
                        array_push($total['D_ethylene'],null);
                    }
                    else{
                        array_push($total['D_ethylene'],0);
                    }

                }
                else if($document['telemetria_id']==378){
                    if($document['ethylene']>89){
                        array_push($total['D_ethylene'],null);

                    }else{
                        array_push($total['D_ethylene'],$document['ethylene']);

                    }
                }

                
                
                else{
                   
if($document['ethylene']>230){
               array_push($total['D_ethylene'],null);

}else{
                array_push($total['D_ethylene'],$document['ethylene']);

}

// array_push($total['D_ethylene'],$document['ethylene']);
                }
                /*
                if($document['ethylene']>=80.00){
                    array_push($total['D_ethylene'],null);
                }else{
                    array_push($total['D_ethylene'],$document['ethylene']);
                }
                */

            }
            array_push($total['telemetria_id'],$document['telemetria_id']);
            if($document['inyeccion_pwm']==-1.00){
                array_push($total['inyeccion_pwm'],null);
            }else{
                array_push($total['inyeccion_pwm'],$document['inyeccion_pwm']);
            }
            //array_push($total['inyeccion_pwm'],$document['inyeccion_pwm']);
            array_unshift($total['madurador2'],$document);
            //array_push($total['madurador'],$document);
        } 
        }
        //$total['madurador'] = $principal->madurador($telemetria);
        echo json_encode($total);
        break;
        


    case 'circulos':
        $idf = $_GET['id'];
        $empresa =  substr($idf, strpos($idf,',')+strlen(','));
        $tipoUsuario = substr($idf, 0, strpos($idf, ','));

        $data['contenedores'] = $principal->circuloContenedores($tipoUsuario,$empresa);
        $data['generadores'] = $principal->circuloGeneradores($tipoUsuario ,$empresa);
        echo json_encode($data);
    
    
        break;
     case 'circulosMultilog':
            $data['generadores'] = $principal->circuloGeneradoresMultilog();
            echo json_encode($data);
    
        break;
    case 'circulosBrokmar':
            $data['generadores'] = $principal->circuloGeneradoresBrokmar();
            echo json_encode($data);
     
        break;
    case 'circulos1':
        $id = $_GET['id'];
        $data['nombre'] = $principal->nombre_de_contenedor($id);
        echo json_encode($data);    
        break;
    case 'listarTabla':
        $id = $_GET['id'];
        $data['tipoReefer'] = $principal->tramas($id);
        echo json_encode($data);      
        break;

    case 'consultaFechaReefer':
        $idf = $_GET['id'];
        $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
        $fechaaInicio = substr($idf, 0, strpos($idf, ','));
        $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
        $telemetria = substr($parte2, strpos($parte2,';')+strlen(';'));
        $data1 = $principal->listaReeferFecha($telemetria , $fechaaInicio ,$fechaFin);
        if(empty($data1)){
            $data['tramaReefer'] = $principal->listaReeferAprox($telemetria);
        }else{
            $data['tramaReefer'] =$data1;
        }      
        $data['reefer'] = $principal->reefer($telemetria);
        echo json_encode($data);   
        break;
    case 'consultaFechaGenset':
        $idf = $_GET['id'];
        $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
        $fechaaInicio = substr($idf, 0, strpos($idf, ','));
        $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
        $telemetria = substr($parte2, strpos($parte2,';')+strlen(';'));
        $data1 = $principal->listaGensetFiltroFecha($telemetria , $fechaaInicio ,$fechaFin);
        if(empty($data1)){
            $data['tramaGenset'] = $principal->listaGensetAprox($telemetria);
        }else{
            $data['tramaGenset'] =$data1;
        }   
        $data['genset'] = $principal->genset($telemetria);
        echo json_encode($data);   
        break;

    case 'consultaTelemetriaMadurador':
        $telemetria = $_GET['id'];
        $data= $principal->consultaTelemetriaMadurador($telemetria);
        echo json_encode($data);   
        break;

    case 'consultaFechaMadurador':
        $idf = $_GET['id'];
        $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
        $fechaaInicio = substr($idf, 0, strpos($idf, ','));
        $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
        $telemetria = substr($parte2, strpos($parte2,';')+strlen(';'));
        $data1 = $principal->listaMaduradorFecha($telemetria , $fechaaInicio ,$fechaFin);
        if(empty($data1)){$data['tramaMadurador'] = $principal->listaMaduradorAprox($telemetria);
        }else{ $data['tramaMadurador'] =$data1; }  
        $data['madurador'] = $principal->madurador($telemetria);
        echo json_encode($data);   
        break;

    case 'consultaFechaMadurador1':

            $idf = $_GET['id'];
            $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
            $fechaaInicio = substr($idf, 0, strpos($idf, ','));
            $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
            $telemetria = substr($parte2, strpos($parte2,';')+strlen(';'));
            /*
            $data1 = $principal->listaMaduradorFecha($telemetria , $fechaaInicio ,$fechaFin);
            if(empty($data1)){$data['tramaMadurador'] = $principal->listaMaduradorAprox();
            }else{ $data['tramaMadurador'] =$data1; }  
            $data['madurador'] = $principal->madurador($telemetria);
    */
    //$data['madurador'] = $principal->madurador($telemetria);
            // Replace the placeholder with your Atlas connection string
            
            $uri = 'mongodb://localhost:27017';
    // Specify Stable API version 1
    $apiVersion = new ServerApi(ServerApi::V1);
    // Create a new client and connect to the server
    $client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);
    try {
        // Send a ping to confirm a successful connection
        $client->selectDatabase('ZTRACK_P')->command(['ping' => 1]);
        //echo "Pinged your deployment. You successfully connected to MongoDB!\n";
    } catch (Exception $e) {
        printf($e->getMessage());
    }
          //$coleccion = $client->selectDatabase('ztrack')->madurador2 ;
    
         //$data['bacan'] = $client->ztrack->madurador2->find(['telemetria_id' => 33]);
         /*
         $data['madurador'] = $principal->maduradorT($telemetria);
         echo json_encode($data);
         break;
         */
        //array( "created_at"=>array('$gt'=>new MongoDate(strtotime($fechaaInicio)), '$gte'=>new MongoDate(strtotime($fechaFin))))
         $fechaaInicio1 =$fechaaInicio.":00";
         $fechaFin1 =$fechaFin.":00";
         //problemas con fecha 5 horas menos debe ser UTC-5
         $puntoA = strtotime($fechaaInicio);
         $puntoA1 = strtotime("-5 hours",$puntoA)*1000;
         $puntoB = strtotime($fechaFin)  ;
         $puntoB1 = strtotime("-5 hours" ,$puntoB)*1000  ;
         // se selcciona los campos y las fechas 
         $cursor  = $client->ztrack_ja->madurador->find(array('$and' =>array( ['created_at'=>array('$gte'=>new MongoDB\BSON\UTCDateTime($puntoA1),'$lte'=>new MongoDB\BSON\UTCDateTime($puntoB1)),'telemetria_id'=>intval($telemetria)] )),
         array('projection' => array('_id' => 0,'trama'=> 1, 'created_at' => 1,'stateProcess' => 1,'set_point' => 1,'temp_supply_1' => 1,'return_air' => 1,'evaporation_coil' => 1,'ambient_air' => 1,'relative_humidity' => 1,'controlling_mode' => 1,'sp_ethyleno' => 1,
         'ethylene' => 1,'avl' => 1,'power_state' => 1,'compress_coil_1' => 1,'consumption_ph_1' => 1,'consumption_ph_2' => 1,'consumption_ph_3' => 1,'co2_reading' => 1,'o2_reading' => 1,'set_point_o2' => 1,'set_point_co2' => 1,'line_voltage' => 1,
         'defrost_term_temp' => 1,'defrost_interval' => 1,'inyeccion_pwm' => 1,'inyeccion_hora' => 1,'latitud' => 1,'longitud' => 1,'fresh_air_ex_mode' => 1,'telemetria_id'=>1,'cargo_1_temp' =>1,'cargo_2_temp' =>1,'cargo_3_temp' =>1,'cargo_4_temp' =>1,'id'=>1 ,'power_kwh' =>1),'sort'=>array('id'=>1)));
         //$cursor1 =$cursor->sort(array('trama' => 1));
         //array('sort'=>array('trama' => -1))
         $total['fecha']= [];
         $total['setPoint'] =[];
         $total['returnAir'] =[];
         $total['tempSupply'] =[];
         $total['ambienteAir'] =[];
         $total['relativeHumidity'] =[];
         $total['evaporationCoil'] =[];
         $total['D_ethylene'] =[];
         $total['co2'] =[];
         $total['sp_ethylene'] =[];
         $total['inyeccionEtileno'] =[];
         $total['telemetria_id'] =[];
         $total['objetivo'] =[];
         $total['cargo_1_temp'] =[];
         $total['cargo_2_temp'] =[];
         $total['cargo_3_temp'] =[];
         $total['cargo_4_temp'] =[];

         //array('$gt'=>new MongoDB\BSON\UTCDateTime(strtotime($fechaaInicio)*1000), '$gte'=>new MongoDB\BSON\UTCDateTime(strtotime($fechaFin)*1000))
         //     $cursor  = $client->ztrack->madurador2->find(array('$and' =>array( ['created_at'=>array('$gt'=>new MongoDB\BSON\UTCDateTime($puntoA)),'created_at'=>array('$gte'=>new MongoDB\BSON\UTCDateTime($puntoB)),'telemetria_id'=>intval($telemetria)] )));
         $total['madurador'] = [];
         $total['inyeccion_pwm'] =[];
         foreach ($cursor as $document) {
            //array_push($total['fecha'],$document['created_at']);
            $fechaJa = json_decode($document['created_at'])/1000;
            // $fechaJa1 = $fechaJa['$date'];
            $fechaD = date('d-m-Y H:i:s', $fechaJa);
    
            $puntoA = strtotime($fechaD);
            $puntoA1 = strtotime("+5 hours",$puntoA);
            $fechaD1 = date('d-m-Y H:i:s', $puntoA1);
           // array_push($total,$fechaD);
           array_push($total['fecha'],$fechaD1);
            //array_push($total['tramaMadurador'],$document);  
            
            array_push($total['setPoint'],$document['set_point']);
            array_push($total['returnAir'],$document['return_air']);
            array_push($total['tempSupply'],$document['temp_supply_1']);
            array_push($total['ambienteAir'],$document['ambient_air']);
            array_push($total['relativeHumidity'],$document['relative_humidity']);
            array_push($total['objetivo'],2.00);

            if($document['evaporation_coil']>=50.00){
                array_push($total['evaporationCoil'],null);
            }else{
                array_push($total['evaporationCoil'],$document['evaporation_coil']);
            }

            //array_push($total['evaporationCoil'],$document['evaporation_coil']);

          

            if($document['cargo_1_temp']>=40.00 || $document['cargo_1_temp']==25.60  ){
                array_push($total['cargo_1_temp'],null);
            }else{
                array_push($total['cargo_1_temp'],$document['cargo_1_temp']);
            }

            if($document['cargo_2_temp']>=40.00){
                array_push($total['cargo_2_temp'],null);
            }else{
                array_push($total['cargo_2_temp'],$document['cargo_2_temp']);
            }
            if($document['cargo_3_temp']>=40.00){
                array_push($total['cargo_3_temp'],null);
            }else{
                array_push($total['cargo_3_temp'],$document['cargo_3_temp']);
            }
            if($document['cargo_4_temp']>=40.00){
                array_push($total['cargo_4_temp'],null);
            }else{
                array_push($total['cargo_4_temp'],$document['cargo_4_temp']);
            }


            

            if($document['co2_reading']==25.4 || $document['co2_reading']==25.5 ){
                array_push($total['co2'],null);
            }
            //else if($document['co2_reading']>25){
              //  array_push($total['co2'],0.1);
            //}
            else{
                array_push($total['co2'],$document['co2_reading']);
            }
            //array_push($total['co2'],$document['co2_reading']);
            if($document['sp_ethyleno']==-1.00){
                array_push($total['sp_ethylene'],null);
            }else{
                array_push($total['sp_ethylene'],$document['sp_ethyleno']);
            }
           
            //array_push($total['fecha'],$document['created_at']);
            //array_push($total['inyeccionEtileno'],$document['stateProcess']);
            if($document['stateProcess']==5.00 ){
                array_push($total['inyeccionEtileno'],100); 
                array_push($total['D_ethylene'],$document['ethylene']);  
            }else{
                array_push($total['inyeccionEtileno'],0);
                //if($document['stateProcess']==-1.00){

                //}
                if($document['telemetria_id']==260 || $document['telemetria_id']==259 || $document['telemetria_id']==258 || $document['telemetria_id']==33 ){
                    //se hace la regulacion  de datos por encima de 20 ppm
                    $nuevoEthyleno = (intval(($document['ethylene']-0.9)*10))/10;
                    if($nuevoEthyleno>0 && $nuevoEthyleno<20){
                        array_push($total['D_ethylene'],$nuevoEthyleno);
                    }elseif($nuevoEthyleno>20){
                        array_push($total['D_ethylene'],null);
                    }
                    else{
                        array_push($total['D_ethylene'],0);
                    }

                }
                else{
                    if($document['ethylene']>250){
                        array_push($total['D_ethylene'],null);

                    }else{
                        array_push($total['D_ethylene'],$document['ethylene']);

                    }

                }
                /*
                else if($document['telemetria_id']==378){
                    if($document['ethylene']>89){
                        array_push($total['D_ethylene'],null);

                    }else{
                        array_push($total['D_ethylene'],$document['ethylene']);

                    }
                }
                */

                //else{
                  //  array_push($total['D_ethylene'],$document['ethylene']);
                //}
                /*
                if($document['ethylene']>=80.00){
                    array_push($total['D_ethylene'],null);
                }else{
                    array_push($total['D_ethylene'],$document['ethylene']);
                }
                */

            }
            array_push($total['telemetria_id'],$document['telemetria_id']);
            if($document['inyeccion_pwm']==-1.00){
                array_push($total['inyeccion_pwm'],null);
            }else{
                array_push($total['inyeccion_pwm'],$document['inyeccion_pwm']);
            }
            //array_push($total['inyeccion_pwm'],$document['inyeccion_pwm']);
            array_unshift($total['madurador'],$document);
            //array_push($total['madurador'],$document);
            
        }
        //$total['madurador'] = $principal->madurador($telemetria);
        echo json_encode($total);
        break;
        
    
    case 'consultaFechaM':
        $idf = $_GET['id'];

        $parte2 =  substr($idf, strpos($idf,',')+strlen(','));

        $fechaaInicio = substr($idf, 0, strpos($idf, ','));

        $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
        $telemetria = substr($parte2, strpos($parte2,';')+strlen(';'));

        $data['tramaReefer'] = $principal->listaMaduradorFecha($telemetria , $fechaaInicio ,$fechaFin);
        $data['contenedor'] = $principal->idEmpresa($telemetria);


        echo json_encode($data);   
        break;
    
    
    case 'verAlias':
        $id = $_GET['id'];
        $data['alias'] = $principal->puntoEnMapaAlias($id);
        echo json_encode($data);      
        break;

    case 'verGrafica':
        $id = $_GET['id'];
        $data['reefer'] = $principal->puntoEnMapa($id);
        $data['datos'] = $principal->datosGrafica($id);
        echo json_encode($data);      
        break;
    
    case 'puntoEnMapa':
        $id = $_GET['id'];
        $data['punto'] = $principal->puntoEnMapa($id);
        $data['ultimaTrama'] = $principal->ultimaTrama($id);
        $contenedor = $principal->puntoEnMapa($id);
        $empresa =$contenedor['empresa_id'];
        $data['empresa'] = $principal->empresaAsociada($empresa);
        echo json_encode($data);      
        break;

    case 'puntoEnMapaM':
        $id = $_GET['id'];
        $data['punto'] = $principal->puntoEnMapaM($id);
        $contenedor = $principal->puntoEnMapaM($id);
        $empresa =$contenedor['empresa_id'];
        $data['empresa'] = $principal->empresaAsociada($empresa);
        echo json_encode($data);      
        break;
    case 'puntoEnMapaG':
        $id = $_GET['id'];
        $data['punto'] = $principal->puntoEnMapaM($id);
        $contenedor = $principal->puntoEnMapaM($id);
        $empresa =$contenedor['empresa_id'];
        $data['empresa'] = $principal->empresaAsociada($empresa);

        echo json_encode($data['punto']);      
        break;


    case 'verLocation':
        $id = $_GET['id'];
        $data['location'] = $principal->verLocation($id);
        echo json_encode($data);      
        break;

    case 'listar':
        //pide todo los datos de empresa
        $data = $telemetrias->getTelemetrias();
        for ($i = 0; $i < count($data); $i++) {
            //le añadimos los botones a la lista de datosv con las opciones en js
            $data[$i]['accion'] = '<div class="d-flex">
                <a class="btn btn-danger btn-sm" onclick="deleteTelemetria(' . $data[$i]['id'] . ')"><i class="fas fa-eraser"></i>D</a>
                <a class="btn btn-primary btn-sm" onclick="editTelemetria(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i>E</a>
                <a class="btn btn-info btn-sm" onclick=""><i class="fas fa-lock"></i>P</a>
                </div>';
        }
        echo json_encode($data);
        break;
        
    case 'save':
        //datos vienen del formulario
        $numero_telefono = $_POST['numero_telefono'];
        $imei = $_POST['imei'];
        $id = $_POST['id_telemetria'];
        // si id es vacio vamos a guardar los nuevos datos
        if ($id == '') { 
            $consult = $telemetrias->comprobarTelemetria($imei);
            if (empty($consult)) {      
                $result = $telemetrias->saveTelemetria($numero_telefono, $imei);
                if ($result) {
                //aqui solicitamos los datos de la telemetria que acabamos de guardar                
                $u_result = $telemetrias->getTelemetria_obtener($imei);
                // aqui agregamos a las variables los campos de datos obtenidos
                $id_r = $u_result['id'];
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "REGISTRADO";               
                //mandamos a guardar en el historial de telemetrias
                $historial_telemetria_grabar = $telemetrias->savehistorialTelemetria($id_r ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion);
                //$historial_telemetria_grabar = $telemetrias->savehistorialTelemetria(2 ,"41", "terr" ,$fecha_cambio ,$usuario_cambio_id ,$accion);
                $res = array('tipo' => 'success', 'mensaje' => 'TELEMETRIA REGISTRADA');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL REGISTRAR');
                }
            }else {
                $res = array('tipo' => 'error', 'mensaje' => 'EL IMEI YA EXISTE');
            }
          
        } 
        // en caso contrario se actualiza la informacion de la $id recibida
        else {
            $fecha_update = date("Y-m-d H:i:s");
            // aqui enviamos a actualizar la informacion
            $result = $telemetrias->updateTelemetria($numero_telefono, $imei,$fecha_update,$id);
            if ($result) {
                // agregamos los datos grabados en update y le añadimos los datos para el historial
                $fecha_cambio = date("Y-m-d H:i:s");
                $usuario_cambio_id =$_SESSION['id'];
                $accion = "EDITADO";
                $historial_telemetria_grabar = $telemetrias->savehistorialTelemetria($id ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion);

                $res = array('tipo' => 'success', 'mensaje' => 'EMPRESA MODIFICADA');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR');
            }
        }
        echo json_encode($res);
        break;
    case 'delete':
        $fecha_update = date("Y-m-d H:i:s");
        $id = $_GET['id'];
        $data = $telemetrias->deleteTelemetria($fecha_update,$id);
        if ($data) {
            // solicito los datos de la id a eliminar para guardar los datos en el historial
            $u_result = $telemetrias->getTelemetria_id($id);                
            $id_r = $u_result['id'];
            $numero_telefono = $u_result['numero_telefono'];
            $imei = $u_result['imei'];
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ELIMINADO";
            //guardo la accion en el historial
            $historial_telemetria_grabar = $telemetrias->savehistorialTelemetria($id_r ,$numero_telefono, $imei ,$fecha_cambio ,$usuario_cambio_id ,$accion);
            $res = array('tipo' => 'success', 'mensaje' => 'TELEMETRIA ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res);
        break;
    case 'edit':
        $id = $_GET['id'];
        // le paso los datos a js para que cargue los datos en el formulario
        $data = $telemetrias->getTelemetria_id($id);
        echo json_encode($data);
        break;

    case 'saveAlias':
        $id_contenedor = $_POST['id_contenedor'];
        $alias =$_POST['aliasalias'];
        $res = $principal->asignarAlias($id_contenedor, $alias);
        if ($res) {
            /*
            $fecha_cambio = date("Y-m-d H:i:s");
            $usuario_cambio_id =$_SESSION['id'];
            $accion = "ALIAS ASIGNADO";
            $res2 = $principal->saveHistorialContenedores($id_contenedor , $alias, $id_user , $fecha_cambio, $usuario_cambio_id , $accion);
            */
            $res = array('tipo' => 'success', 'mensaje' => 'ALIAS ASIGNADA');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ASIGNAR ALIAS');
        }                  
        echo json_encode($res);
        break;

    case 'consultaFechaMadurador2':

/*
        $idf = $_GET['id'];
        $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
        $fechaaInicio = substr($idf,0, strpos($idf, ','));
        $fechaFin = substr($parte2,0, strpos($parte2, ';'));
        $telemetria = substr($parte2, strpos($parte2,';')+strlen(';'));

*/


            $idf = $_GET['id'];
            $parte2 =  substr($idf, strpos($idf,',')+strlen(','));
            $fechaaInicio = substr($idf, 0, strpos($idf, ','));
            $fechaFin = substr($parte2, 0, strpos($parte2, ';'));
            $telemetria1 = substr($parte2, strpos($parte2,';')+strlen(';'));
            $telemetria = substr($telemetria1,0,strpos($telemetria1,"|"));
            $GMT = substr($telemetria1,strpos($telemetria1,'|')+strlen('|'));
//echo $GMT;

$signoGMT =  substr($GMT,0,1);
$horaGTM =  substr($GMT,1,2);
$minutoGTM = substr($GMT ,3,2);
          
        $uri = 'mongodb://localhost:27017';

        $apiVersion = new ServerApi(ServerApi::V1);

        $client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);
         $fechaaInicio1 =rtrim($fechaaInicio).":00";
         $fechaFin1 =rtrim($fechaFin).":00";
         //problemas con fecha 5 horas menos debe ser UTC-5
         $puntoA = strtotime($fechaaInicio);
         $puntoA1 = strtotime("-5 hours",$puntoA)*1000;
         $puntoB = strtotime($fechaFin)  ;
         $puntoB1 = strtotime("-5 hours" ,$puntoB)*1000  ;
         // se selcciona los campos y las fechas 
         $cursor  = $client->ztrack_ja->madurador->find(array('$and' =>array( ['created_at'=>array('$gte'=>new MongoDB\BSON\UTCDateTime($puntoA1),'$lte'=>new MongoDB\BSON\UTCDateTime($puntoB1)),'telemetria_id'=>intval($telemetria)] )),
         array('projection' => array('_id' => 0,'trama'=> 1, 'created_at' => 1,'stateProcess' => 1,'set_point' => 1,'temp_supply_1' => 1,'return_air' => 1,'evaporation_coil' => 1,'ambient_air' => 1,'relative_humidity' => 1,'controlling_mode' => 1,'sp_ethyleno' => 1,
         'ethylene' => 1,'avl' => 1,'power_state' => 1,'compress_coil_1' => 1,'consumption_ph_1' => 1,'consumption_ph_2' => 1,'consumption_ph_3' => 1,'co2_reading' => 1,'o2_reading' => 1,'set_point_o2' => 1,'set_point_co2' => 1,'line_voltage' => 1,
         'defrost_term_temp' => 1,'defrost_interval' => 1,'inyeccion_pwm' => 1,'inyeccion_hora' => 1,'latitud' => 1,'longitud' => 1,'fresh_air_ex_mode' => 1,'telemetria_id'=>1,'cargo_1_temp' =>1,'cargo_2_temp' =>1,'cargo_3_temp' =>1,'cargo_4_temp' =>1,'id'=>1 ,'power_kwh' =>1),'sort'=>array('id'=>1)));
        //analizar el tiempo
        $date1 = new DateTime($fechaaInicio1);
        $date2 = new DateTime($fechaFin1);
        $diff = $date1->diff($date2);
        $total['diferencia_fecha']= [];
        array_push($total['diferencia_fecha'],$diff->days);
        array_push($total['diferencia_fecha'],$diff->h);
        $dif_dia=$diff->days;
         $total1['fecha']= [];
         $total1['setPoint'] =[];
         $total1['returnAir'] =[];
         $total1['tempSupply'] =[];
         $total1['ambienteAir'] =[];
         $total1['relativeHumidity'] =[];
         $total1['evaporationCoil'] =[];
         $total1['D_ethylene'] =[];
         $total1['co2'] =[];
         $total1['sp_ethylene'] =[];
         $total1['inyeccionEtileno'] =[];
         $total1['telemetria_id'] =[];
         $total1['objetivo'] =[];
         $total1['cargo_1_temp'] =[];
         $total1['cargo_2_temp'] =[];
         $total1['cargo_3_temp'] =[];
         $total1['cargo_4_temp'] =[];

         //array('$gt'=>new MongoDB\BSON\UTCDateTime(strtotime($fechaaInicio)*1000), '$gte'=>new MongoDB\BSON\UTCDateTime(strtotime($fechaFin)*1000))
         //     $cursor  = $client->ztrack->madurador2->find(array('$and' =>array( ['created_at'=>array('$gt'=>new MongoDB\BSON\UTCDateTime($puntoA)),'created_at'=>array('$gte'=>new MongoDB\BSON\UTCDateTime($puntoB)),'telemetria_id'=>intval($telemetria)] )));
         $total['madurador'] = [];
         $total1['madurador2'] = [];
         $total1['inyeccion_pwm'] =[];
         $cont=0;
         foreach ($cursor as $document) {
        //$returnInicial =$document['return_air'];
        array_push( $total['madurador'] ,$document);
         }

        //for(i=1;i<count()){

        //}
        if($dif_dia<1){
            $segundos =360;
            $porcentaje =6;
            $array_optimo =[];
            array_push($array_optimo,$total['madurador'][0]);
            array_push($total['diferencia_fecha'],$total['madurador']);
            //array_push($total['diferencia_fecha'],optimo($total['madurador'][0],$segundos));
            //optimo($total['madurador'],$segundos);
            //variables iniciales 
            //$return_air_inical=$total['madurador'][0]->return_air;
            $return_air_inicial=$total['madurador'][0]['return_air'];
            array_push($total['diferencia_fecha'],$return_air_inicial);
            $tiempo_inicial=json_decode($total['madurador'][0]['created_at'])/1000;
            //$tiempo_inicial =json_decode($xd)/1000;
            array_push($total['diferencia_fecha'],$tiempo_inicial);
            $cadenae ="";
            for($i=1;$i<count($total['madurador']);$i++){
                $tiempo_a =json_decode($total['madurador'][$i]['created_at'])/1000;
                $comparador =$total['madurador'][$i]['return_air'];
                if(($tiempo_a-$tiempo_inicial) <= $segundos){
                    //if( ($salario >= 0) && ($salario <= 500000) )
                    if($comparador<0){
                        if(( $comparador <= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador >= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
     
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }else{
                        if(( $comparador >= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador <= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
     
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }



                }
                
                else{
                    array_push($array_optimo,$total['madurador'][$i]);
                    $return_air_inicial=$total['madurador'][$i]['return_air'];
                    //$xd=$total['madurador'][$i]['created_at'];
                    //$tiempo_inicial =json_decode($xd)/1000;
                    $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;


                }
                
                $cadenae =$cadenae." a : ".$i;
            }
            array_push($total['diferencia_fecha'],$cadenae);
            array_push($total['diferencia_fecha'],$array_optimo);




        }elseif($dif_dia<7){
            $segundos =720;
            $porcentaje =8;
            $array_optimo =[];
            array_push($array_optimo,$total['madurador'][0]);
            array_push($total['diferencia_fecha'],$total['madurador']);
            //array_push($total['diferencia_fecha'],optimo($total['madurador'][0],$segundos));
            //optimo($total['madurador'],$segundos);
            //variables iniciales 
            //$return_air_inical=$total['madurador'][0]->return_air;
            $return_air_inicial=$total['madurador'][0]['return_air'];
            array_push($total['diferencia_fecha'],$return_air_inicial);
            $tiempo_inicial=json_decode($total['madurador'][0]['created_at'])/1000;
            //$tiempo_inicial =json_decode($xd)/1000;
            array_push($total['diferencia_fecha'],$tiempo_inicial);
            $cadenae ="";
            for($i=1;$i<count($total['madurador']);$i++){
                $tiempo_a =json_decode($total['madurador'][$i]['created_at'])/1000;
                $comparador =$total['madurador'][$i]['return_air'];
                if(($tiempo_a-$tiempo_inicial) <= $segundos){
                    //if( ($salario >= 0) && ($salario <= 500000) )
                    if($comparador<0){
                        if(( $comparador <= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador >= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }else{
                        if(( $comparador >= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador <= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }
                    


                }
                
                else{
                    array_push($array_optimo,$total['madurador'][$i]);
                    $return_air_inicial=$total['madurador'][$i]['return_air'];
                    //$xd=$total['madurador'][$i]['created_at'];
                    //$tiempo_inicial =json_decode($xd)/1000;
                    $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;


                }
                
                $cadenae =$cadenae." a : ".$i;
            }
            array_push($total['diferencia_fecha'],$cadenae);
            array_push($total['diferencia_fecha'],$array_optimo);


        }elseif($dif_dia<16){
            $segundos =1440;
            $porcentaje =10;
            $array_optimo =[];
            array_push($array_optimo,$total['madurador'][0]);
            array_push($total['diferencia_fecha'],$total['madurador']);
            //array_push($total['diferencia_fecha'],optimo($total['madurador'][0],$segundos));
            //optimo($total['madurador'],$segundos);
            //variables iniciales 
            //$return_air_inical=$total['madurador'][0]->return_air;
            $return_air_inicial=$total['madurador'][0]['return_air'];
            array_push($total['diferencia_fecha'],$return_air_inicial);
            $tiempo_inicial=json_decode($total['madurador'][0]['created_at'])/1000;
            //$tiempo_inicial =json_decode($xd)/1000;
            array_push($total['diferencia_fecha'],$tiempo_inicial);
            $cadenae ="";
            for($i=1;$i<count($total['madurador']);$i++){
                $tiempo_a =json_decode($total['madurador'][$i]['created_at'])/1000;
                $comparador =$total['madurador'][$i]['return_air'];
                if(($tiempo_a-$tiempo_inicial) <= $segundos){
                    //if( ($salario >= 0) && ($salario <= 500000) )
                    if($comparador<0){
                        if(( $comparador <= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador >= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }else{
                        if(( $comparador >= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador <= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }
                    


                }
                
                else{
                    array_push($array_optimo,$total['madurador'][$i]);
                    $return_air_inicial=$total['madurador'][$i]['return_air'];
                    //$xd=$total['madurador'][$i]['created_at'];
                    //$tiempo_inicial =json_decode($xd)/1000;
                    $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;


                }
                
                $cadenae =$cadenae." a : ".$i;
            }
            array_push($total['diferencia_fecha'],$cadenae);
            array_push($total['diferencia_fecha'],$array_optimo);



            
        }elseif($dif_dia<45){
            $segundos =2880;
            $porcentaje =14;
            $array_optimo =[];
            array_push($array_optimo,$total['madurador'][0]);
            array_push($total['diferencia_fecha'],$total['madurador']);
           // array_push($total['diferencia_fecha'],optimo($total['madurador'][0],$segundos));
            //optimo($total['madurador'],$segundos);
            //variables iniciales 
            //$return_air_inical=$total['madurador'][0]->return_air;
            $return_air_inicial=$total['madurador'][0]['return_air'];
            array_push($total['diferencia_fecha'],$return_air_inicial);
            $tiempo_inicial=json_decode($total['madurador'][0]['created_at'])/1000;
            //$tiempo_inicial =json_decode($xd)/1000;
            array_push($total['diferencia_fecha'],$tiempo_inicial);
            $cadenae ="";
            for($i=1;$i<count($total['madurador']);$i++){
                $tiempo_a =json_decode($total['madurador'][$i]['created_at'])/1000;
                $comparador =$total['madurador'][$i]['return_air'];
                if(($tiempo_a-$tiempo_inicial) <= $segundos){
                    //if( ($salario >= 0) && ($salario <= 500000) )
                    if($comparador<0){
                        if(( $comparador <= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador >= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }else{
                        if(( $comparador >= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador <= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }
                    


                }
                
                else{
                    array_push($array_optimo,$total['madurador'][$i]);
                    $return_air_inicial=$total['madurador'][$i]['return_air'];
                    //$xd=$total['madurador'][$i]['created_at'];
                    //$tiempo_inicial =json_decode($xd)/1000;
                    $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;


                }
                
                $cadenae =$cadenae." a : ".$i;
            }
            array_push($total['diferencia_fecha'],$cadenae);
            array_push($total['diferencia_fecha'],$array_optimo);

            
        }else{
            $segundos =5760;
            $porcentaje =18;
            $array_optimo =[];
            array_push($array_optimo,$total['madurador'][0]);
            array_push($total['diferencia_fecha'],$total['madurador']);
            //array_push($total['diferencia_fecha'],optimo($total['madurador'][0],$segundos));
            //optimo($total['madurador'],$segundos);
            //variables iniciales 
            //$return_air_inical=$total['madurador'][0]->return_air;
            $return_air_inicial=$total['madurador'][0]['return_air'];
            array_push($total['diferencia_fecha'],$return_air_inicial);
            $tiempo_inicial=json_decode($total['madurador'][0]['created_at'])/1000;
            //$tiempo_inicial =json_decode($xd)/1000;
            array_push($total['diferencia_fecha'],$tiempo_inicial);
            $cadenae ="";
            for($i=1;$i<count($total['madurador']);$i++){
                $tiempo_a =json_decode($total['madurador'][$i]['created_at'])/1000;
                $comparador =$total['madurador'][$i]['return_air'];
                if(($tiempo_a-$tiempo_inicial) <= $segundos){
                    //if( ($salario >= 0) && ($salario <= 500000) )
                    if($comparador<0){
                        if(( $comparador <= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador >= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }else{
                        if(( $comparador >= (($return_air_inicial)*(100-$porcentaje)/100)) && ($comparador <= (($return_air_inicial)*(100+$porcentaje)/100))){
                            //array_push($array_optimo,$comparador);
    
    
                        }else{
                            array_push($array_optimo,$total['madurador'][$i]);
                            $return_air_inicial=$total['madurador'][$i]['return_air'];
                            $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;
                            //$tiempo_inicial =json_decode($xd)/1000;
                        }

                    }
                    


                }
                
                else{
                    array_push($array_optimo,$total['madurador'][$i]);
                    $return_air_inicial=$total['madurador'][$i]['return_air'];
                    //$xd=$total['madurador'][$i]['created_at'];
                    //$tiempo_inicial =json_decode($xd)/1000;
                    $tiempo_inicial=json_decode($total['madurador'][$i]['created_at'])/1000;


                }
                
                $cadenae =$cadenae." a : ".$i;
            }
            array_push($total['diferencia_fecha'],$cadenae);
            array_push($total['diferencia_fecha'],$array_optimo);


        }
        array_push($total['diferencia_fecha'],$segundos);

	//echo var_dump($array_optimo);
        foreach ($array_optimo as $document) {
            $cont++;
            if($cont%1==0)
            {

            //array_push($total['fecha'],$document['created_at']);
            $fechaJa = json_decode($document['created_at'])/1000;
            // $fechaJa1 = $fechaJa['$date'];
            $fechaD = date('d-m-Y H:i:s', $fechaJa);
    
            $puntoA = strtotime($fechaD);
            $puntoA1 = strtotime("+5 hours",$puntoA);
            $fechaD1 = date('d-m-Y H:i:s', $puntoA1);
           // array_push($total,$fechaD);
           array_push($total1['fecha'],$fechaD1);
            //array_push($total['tramaMadurador'],$document);  
            
            if($document['relative_humidity']<=100.00){
                array_push($total1['relativeHumidity'],$document['relative_humidity']);

            }else{
                array_push($total1['relativeHumidity'],null);

            }
		array_push($total1['objetivo'],2.00);


if($document['telemetria_id']==4584 ||$document['telemetria_id']==4586 ||$document['telemetria_id']==4587  || $document['telemetria_id']==4588 ||$document['telemetria_id']==4589 ||$document['telemetria_id']==33 || $document['telemetria_id']==258 ||$document['telemetria_id']==259 ||$document['telemetria_id']==260  || $document['telemetria_id']==4500 ||$document['telemetria_id']==4487 ) {


            array_push($total1['setPoint'],round(faren($document['set_point'])));
            array_push($total1['returnAir'],round(faren($document['return_air']),1));
            array_push($total1['tempSupply'],round(faren($document['temp_supply_1']),1));
            array_push($total1['ambienteAir'],round(faren($document['ambient_air']),1));
            if($document['evaporation_coil']>=50.00){
                array_push($total1['evaporationCoil'],null);
            }else{
                array_push($total1['evaporationCoil'],round(faren($document['evaporation_coil']),1));
            }
            if($document['cargo_1_temp']>=40.00 || $document['cargo_1_temp']==25.60  ){
                array_push($total1['cargo_1_temp'],null);
            }else{
                array_push($total1['cargo_1_temp'],round(faren($document['cargo_1_temp']),1));
            }

            if($document['cargo_2_temp']>=40.00){
                array_push($total1['cargo_2_temp'],null);
            }else{
                array_push($total1['cargo_2_temp'],round(faren($document['cargo_2_temp'])));
            }
            if($document['cargo_3_temp']>=40.00){
                array_push($total1['cargo_3_temp'],null);
            }else{
                array_push($total1['cargo_3_temp'],round(faren($document['cargo_3_temp'])));
            }
            if($document['cargo_4_temp']>=40.00){
                array_push($total1['cargo_4_temp'],null);
            }else{
                array_push($total1['cargo_4_temp'],faren($document['cargo_4_temp']));
            }
}else{
            array_push($total1['setPoint'],$document['set_point']);
            array_push($total1['returnAir'],$document['return_air']);
            array_push($total1['tempSupply'],$document['temp_supply_1']);
            array_push($total1['ambienteAir'],$document['ambient_air']);
            if($document['evaporation_coil']>=50.00){
                array_push($total1['evaporationCoil'],null);
            }else{
                array_push($total1['evaporationCoil'],$document['evaporation_coil']);
            }
            if($document['cargo_1_temp']>=40.00 || $document['cargo_1_temp']==25.60  ){
                array_push($total1['cargo_1_temp'],null);
            }else{
                array_push($total1['cargo_1_temp'],$document['cargo_1_temp']);
            }

            if($document['cargo_2_temp']>=40.00){
                array_push($total1['cargo_2_temp'],null);
            }else{
                array_push($total1['cargo_2_temp'],$document['cargo_2_temp']);
            }
            if($document['cargo_3_temp']>=40.00){
                array_push($total1['cargo_3_temp'],null);
            }else{
                array_push($total1['cargo_3_temp'],$document['cargo_3_temp']);
            }
            if($document['cargo_4_temp']>=40.00){
                array_push($total1['cargo_4_temp'],null);
            }else{
                array_push($total1['cargo_4_temp'],$document['cargo_4_temp']);
            }
}

            

            if($document['co2_reading']>=25.4  ){
                array_push($total1['co2'],null);
            }
            //else if($document['co2_reading']>25){
              //  array_push($total['co2'],0.1);
            //}
            else{
                array_push($total1['co2'],$document['co2_reading']);
            }
            //array_push($total['co2'],$document['co2_reading']);
            if($document['sp_ethyleno']==-1.00){
                array_push($total1['sp_ethylene'],null);
            }else{
                array_push($total1['sp_ethylene'],$document['sp_ethyleno']);
            }
           
            //array_push($total['fecha'],$document['created_at']);
            //array_push($total['inyeccionEtileno'],$document['stateProcess']);
            if($document['stateProcess']==5.00 ){
                array_push($total1['inyeccionEtileno'],100); 
                if($document['ethylene']>250){
                    array_push($total1['D_ethylene'],null);
                }else{
                    array_push($total1['D_ethylene'],$document['ethylene']);
                }
                //array_push($total1['D_ethylene'],$document['ethylene']);  
            }else{
                array_push($total1['inyeccionEtileno'],0);
                //if($document['stateProcess']==-1.00){

                //}
                if($document['telemetria_id']==260 || $document['telemetria_id']==259 || $document['telemetria_id']==258 || $document['telemetria_id']==33 ){
                    //se hace la regulacion  de datos por encima de 20 ppm
                    $nuevoEthyleno = (intval(($document['ethylene']-0.9)*10))/10;
                    if($nuevoEthyleno>0 && $nuevoEthyleno<20){
                        array_push($total1['D_ethylene'],$nuevoEthyleno);
                    }elseif($nuevoEthyleno>20){
                        array_push($total1['D_ethylene'],null);
                    }
                    else{
                        array_push($total1['D_ethylene'],0);
                    }

                }
                /*
                else if($document['telemetria_id']==378){
                    if($document['ethylene']>89){
                        array_push($total1['D_ethylene'],null);

                    }else{
                        array_push($total1['D_ethylene'],$document['ethylene']);

                    }
                }
                */
    
                else{
                    if($document['ethylene']>250){
                        array_push($total1['D_ethylene'],null);
                    }else{
                        array_push($total1['D_ethylene'],$document['ethylene']);
                    }
                }
                /*
                if($document['ethylene']>=80.00){
                    array_push($total['D_ethylene'],null);
                }else{
                    array_push($total['D_ethylene'],$document['ethylene']);
                }
                */

            }
            array_push($total1['telemetria_id'],$document['telemetria_id']);
            if($document['inyeccion_pwm']==-1.00){
                array_push($total1['inyeccion_pwm'],null);
            }else{
                array_push($total1['inyeccion_pwm'],$document['inyeccion_pwm']);
            }
            //array_push($total['inyeccion_pwm'],$document['inyeccion_pwm']);
            array_unshift($total1['madurador2'],$document);
            //array_push($total['madurador'],$document);
        } 
        }

        



        echo json_encode($total1);

        break;



    


    default:
        # code...
        break;
}
