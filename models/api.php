<?php
require_once 'config.php';
require_once 'conexion.php';
class ApiModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    public function listaDeTablaComando()
    {
        $consult = $this->pdo->prepare("SELECT * FROM tabla_comandos WHERE estado_comando =  1 ");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    //listaComandos por tipo 
    public function ListaComandosGenericos($tipo)
    {
        $consult = $this->pdo->prepare("SELECT * FROM lista_comando WHERE tipo_dispositivo =  ? ");
        $consult->execute([$tipo]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function TablaReefer()
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer'");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaReeferCliente($empresa)
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Reefer' and c.empresa_id = ?");
        $consult->execute([$empresa]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaMadurador()
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador'");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaMaduradorCliente($empresa)
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.tipo ='Madurador' and c.empresa_id = ?");
        $consult->execute([$empresa]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaMultilog()
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =14");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function TablaBrokmar()
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores AS c INNER JOIN empresas e ON c.empresa_id =e.id WHERE c.empresa_id =15");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
 
    public function comprobarContenedor($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE nombre_contenedor = ? ");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function comprobarGenerador($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE nombre_generador = ? ");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function contarContenedor($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT count(*)  FROM contenedores WHERE nombre_contenedor = ? and estado=1 ");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function contarContenedorComando($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT count(*)  FROM comando WHERE nombre_contenedor = ? and estado=1 ");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }


    public function contarGenerador($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT count(*)  FROM generadores WHERE nombre_generador = ? ");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

        //GUARDA LA TELEMETRIA con datos de nombre de contenedor predeterminado
    public function saveTelemetria($numero_telefono, $imei)
    {
        $consult = $this->pdo->prepare("INSERT INTO telemetrias (numero_telefono, imei) VALUES (?,?)");
        return $consult->execute([$numero_telefono, $imei]);
    }

    public function error_trama($trama)
    {
        $consult = $this->pdo->prepare("INSERT INTO errores_trama (trama) VALUES (?)");
        return $consult->execute([$trama]);
    }

    public function directos($trama)
    {
        $consult = $this->pdo->prepare("INSERT INTO directos (nombre_empresa) VALUES (?)");
        return $consult->execute([$trama]);
    }

    public function verDirectos($nombre_contenedor)
    {
        $consult = $this->pdo->prepare("SELECT count(*)  FROM directos WHERE nombre_empresa = ? ");
        $consult->execute([$nombre_contenedor]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function dataAnterior($nombre ,$trama)
    {
        $consult = $this->pdo->prepare("INSERT INTO dataAnterior (nombre , trama) VALUES (?,?)");
        return $consult->execute([$nombre,$trama]);
    }
    public function dataAnteriorG($nombre ,$trama)
    {
        $consult = $this->pdo->prepare("INSERT INTO dataAnteriorG (nombre , trama) VALUES (?,?)");
        return $consult->execute([$nombre,$trama]);
    }
    public function dataAnteriorM($nombre ,$trama)
    {
        $consult = $this->pdo->prepare("INSERT INTO dataAnteriorM (nombre , trama) VALUES (?,?)");
        return $consult->execute([$nombre,$trama]);
    }
    
    //filtro de datos para reefer
    public function verSet_point($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,set_point from registro_reefers where telemetria_id =? and set_point > -100 and set_point <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function verReturn_air($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,return_air from registro_reefers where telemetria_id =? and return_air > -100 and return_air <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verEvaporation_coil($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,evaporation_coil from registro_reefers where telemetria_id =? and evaporation_coil > -100 and evaporation_coil <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verAmbient_air($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,ambient_air from registro_reefers where telemetria_id =? and ambient_air > -100 and ambient_air <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verRelative_humidity($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,relative_humidity from registro_reefers where telemetria_id =? and relative_humidity > -100 and relative_humidity <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verTemp_supply($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,temp_supply from registro_reefers where telemetria_id =? and temp_supply > -100 and temp_supply <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    //fin de filtro para reefer
    //FILTRO PARA MADURADOR
    public function verSet_pointM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,set_point from registro_madurador where telemetria_id =? and set_point > -100 and set_point <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function verReturn_airM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,return_air from registro_madurador where telemetria_id =? and return_air > -100 and return_air <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verEvaporation_coilM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,evaporation_coil from registro_madurador where telemetria_id =? and evaporation_coil > -100 and evaporation_coil <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verAmbient_airM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,ambient_air from registro_madurador where telemetria_id =? and ambient_air > -100 and ambient_air <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verRelative_humidityM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,relative_humidity from registro_madurador where telemetria_id =? and relative_humidity > -100 and relative_humidity <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verTemp_supplyM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,temp_supply_1 from registro_madurador where telemetria_id =? and temp_supply_1 > -100 and temp_supply_1 <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verEthyleneM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,ethylene from registro_madurador where telemetria_id =? and ethylene >= 0 and ethylene <300 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function verCo2M($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT id ,co2_reading from registro_madurador where telemetria_id =? and co2_reading > 0 and co2_reading <100 order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }




    // se solicita los datos de la empresa que se acaba de guardar para el historial
    public function existeTelemetria($imei)
    {
            $consult = $this->pdo->prepare("SELECT * FROM telemetrias WHERE imei = ?");
            $consult->execute([$imei]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
  
    public function crearContenedorM($nombrecontenedor, $tipo, $descripcion, $telemetria_id , $set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$empresaAsignada,$defrost_prueba,$ripener_prueba)
    {
        $consult = $this->pdo->prepare("INSERT INTO contenedores ( nombre_contenedor ,tipo, descripcionc, telemetria_id,set_point, temp_supply_1,temp_supply_2,return_air,evaporation_coil,condensation_coil, compress_coil_1,compress_coil_2,ambient_air , cargo_1_temp ,cargo_2_temp,cargo_3_temp,cargo_4_temp,relative_humidity,avl , suction_pressure ,discharge_pressure,line_voltage, line_frequency,consumption_ph_1,consumption_ph_2 , consumption_ph_3 ,co2_reading,o2_reading,evaporator_speed,condenser_speed,battery_voltage , power_kwh ,power_trip_reading,power_trip_duration, suction_temp,discharge_temp,supply_air_temp , return_air_temp ,dl_battery_temp,dl_battery_charge,power_consumption,power_consumption_avg,alarm_present , capacity_load ,power_state,controlling_mode,humidity_control,humidity_set_point,fresh_air_ex_mode , fresh_air_ex_rate ,fresh_air_ex_delay,set_point_o2, set_point_co2,defrost_term_temp,defrost_interval , water_cooled_conde ,usda_trip,evaporator_exp_valve,suction_mod_valve,hot_gas_valve,economizer_valve,ethylene , stateProcess,stateInyection, timerOfProcess,modelo,latitud , longitud ,ultima_fecha ,empresa_id,defrost_prueba,ripener_prueba ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$nombrecontenedor, $tipo, $descripcion, $telemetria_id, $set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$empresaAsignada,$defrost_prueba,$ripener_prueba]);
    }

    public function crearContenedorR($nombrecontenedor, $tipo,$descripcion,$telemetria_id,$set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$ultima_fecha,$empresaAsignada)
    {
        $consult = $this->pdo->prepare("INSERT INTO contenedores ( nombre_contenedor, tipo,descripcionc,telemetria_id,set_point, temp_supply_1,return_air,evaporation_coil,ambient_air,cargo_1_temp,cargo_2_temp,cargo_3_temp,cargo_4_temp,relative_humidity , alarm_present,alarm_number,controlling_mode,power_state,defrost_term_temp , defrost_interval ,latitud,longitud,ultima_fecha,empresa_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$nombrecontenedor, $tipo,$descripcion,$telemetria_id,$set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$ultima_fecha,$empresaAsignada]);
    }

    public function crearTramaReffer($set_point, $temp_supply,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id)
    {
        $consult = $this->pdo->prepare("INSERT INTO registro_reefers ( set_point, temp_supply,return_air,evaporation_coil,ambient_air,cargo_1_temp,cargo_2_temp,cargo_3_temp,cargo_4_temp,relative_humidity , alarm_present,alarm_number,controlling_mode,power_state,defrost_term_temp , defrost_interval ,latitud,longitud,created_at,telemetria_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$set_point, $temp_supply,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud,$created_at,$telemetria_id]);

    }
    //$set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$ultima_fecha ,$segundoFiltro
    public function updateContenedorM( $set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$ultima_fecha,$defrost_prueba,$ripener_prueba ,$segundoFiltro)
    {
        $consult = $this->pdo->prepare("UPDATE contenedores SET  set_point=?, temp_supply_1=?,temp_supply_2=?,return_air=?,evaporation_coil=?,condensation_coil=?, compress_coil_1=?,compress_coil_2=?,ambient_air =?, cargo_1_temp =?,cargo_2_temp=?,cargo_3_temp=?,cargo_4_temp=?,relative_humidity=?,avl =?, suction_pressure =?,discharge_pressure=?,line_voltage=?, line_frequency=?,consumption_ph_1=?,consumption_ph_2 =?, consumption_ph_3 =?,co2_reading=?,o2_reading=?,evaporator_speed=?,condenser_speed=?,battery_voltage =?, power_kwh =?,power_trip_reading=?,power_trip_duration=?, suction_temp=?,discharge_temp=?,supply_air_temp =?, return_air_temp =?,dl_battery_temp=?,dl_battery_charge=?,power_consumption=?,power_consumption_avg=?,alarm_present =?, capacity_load =?,power_state=?,controlling_mode=?,humidity_control=?,humidity_set_point=?,fresh_air_ex_mode =?, fresh_air_ex_rate =?,fresh_air_ex_delay=?,set_point_o2=?, set_point_co2=?,defrost_term_temp=?,defrost_interval =?, water_cooled_conde =?,usda_trip=?,evaporator_exp_valve=?,suction_mod_valve=?,hot_gas_valve=?,economizer_valve=?,ethylene =?, stateProcess=?,stateInyection=?, timerOfProcess=?,modelo=?,latitud =?, longitud =? ,ultima_fecha=? ,defrost_prueba=?,ripener_prueba=? WHERE nombre_contenedor=?");
        return $consult->execute([ $set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$ultima_fecha ,$defrost_prueba,$ripener_prueba,$segundoFiltro]);
    }
    public function updateContenedorR($set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud, $ultima_fecha  ,$segundoFiltro)
    {
        $consult = $this->pdo->prepare("UPDATE contenedores SET set_point=? , temp_supply_1=? ,return_air=? ,evaporation_coil=? ,ambient_air=? ,cargo_1_temp=? ,cargo_2_temp=? ,cargo_3_temp=? ,cargo_4_temp=? ,relative_humidity =? , alarm_present=? ,alarm_number=? ,controlling_mode=? ,power_state=? ,defrost_term_temp =? , defrost_interval =? ,latitud=? ,longitud=?  ,ultima_fecha=? WHERE nombre_contenedor=?");
        return $consult->execute([$set_point, $temp_supply_1,$return_air,$evaporation_coil,$ambient_air,$cargo_1_temp,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity , $alarm_present,$alarm_number,$controlling_mode,$power_state,$defrost_term_temp , $defrost_interval ,$latitud,$longitud, $ultima_fecha ,$segundoFiltro]);
    }
    public function ListaReffer()
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE estado =1 and tipo ='Reefer'");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function ListaMadurador()
    {
        $consult = $this->pdo->prepare("SELECT * FROM contenedores WHERE estado =1 and tipo ='Madurador'");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function nombreEmpresa($empresa_id)
    {
            $consult = $this->pdo->prepare("SELECT nombre_empresa FROM empresas WHERE id = ?");
            $consult->execute([$empresa_id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function imeiTelemetria($telemetria_id)
    {
            $consult = $this->pdo->prepare("SELECT imei FROM telemetrias WHERE id = ?");
            $consult->execute([$telemetria_id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function idGenerador($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM generadores WHERE telemetria_id = ?");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function listaReefer($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id = ? ORDER BY id DESC LIMIT 400");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function listaMaduradorTotal($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_madurador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 400");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function listaGenset($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_generador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 800");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function listaGenset_r($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_generador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 200");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function upunto($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM registro_generador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 1 ");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function rpunto($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id = ? ORDER BY id DESC LIMIT 1 ");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function mpunto($id)
    {
            $consult = $this->pdo->prepare("SELECT * FROM registro_madurador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 1 ");
            $consult->execute([$id]);
            return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function listareeferFecha($id ,$fechaInicio , $fechaFin)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_reefers WHERE telemetria_id = ? and created_at >= ? and created_at <= ? ORDER BY id ");
        $consult->execute([$valor,$fechaInicio , $fechaFin]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    public function listaMultilog($id)
    {
        $valor =intval($id);
        $consult = $this->pdo->prepare("SELECT * FROM registro_generador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 400");
        $consult->execute([$valor]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);

    }
    //public function listaMadurador($id)
    //{
        //$valor =intval($id);
        //$consult = $this->pdo->prepare("SELECT * FROM registro_madurador WHERE telemetria_id = ? ORDER BY id DESC LIMIT 100");
        //$consult->execute([$valor]);
        //return $consult->fetchAll(PDO::FETCH_ASSOC);

    //}


    public function idEmpresa($id)
    {
        $consult = $this->pdo->prepare("SELECT nombre_contenedor , descripcionC FROM contenedores WHERE telemetria_id = ?");
        $consult->execute([$id]);
        return $consult->fetch(PDO::FETCH_ASSOC);

    }
    
    public function TablaComando($id)
    {
        $consult = $this->pdo->prepare("SELECT * from comando where nombre_contenedor = ? and estado = 1 ");
        $consult->execute([$id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    //crear trama MADURADOR 
    public function crearTramaMadurador($set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$telemetria_id,$defrost_prueba,$ripener_prueba,$sp_ethyleno)
    {
        $consult = $this->pdo->prepare("INSERT INTO registro_madurador ( set_point, temp_supply_1,temp_supply_2,return_air,evaporation_coil,condensation_coil, compress_coil_1,compress_coil_2,ambient_air,cargo_1_temp ,cargo_2_temp,cargo_3_temp,cargo_4_temp,relative_humidity,avl , suction_pressure ,discharge_pressure,line_voltage, line_frequency,consumption_ph_1,consumption_ph_2 , consumption_ph_3 ,co2_reading,o2_reading,evaporator_speed,condenser_speed,battery_voltage , power_kwh ,power_trip_reading,power_trip_duration, suction_temp,discharge_temp,supply_air_temp , return_air_temp ,dl_battery_temp,dl_battery_charge,power_consumption,power_consumption_avg,alarm_present , capacity_load ,power_state,controlling_mode,humidity_control,humidity_set_point,fresh_air_ex_mode , fresh_air_ex_rate ,fresh_air_ex_delay,set_point_o2, set_point_co2,defrost_term_temp,defrost_interval , water_cooled_conde ,usda_trip,evaporator_exp_valve,suction_mod_valve,hot_gas_valve,economizer_valve,ethylene , stateProcess,stateInyection, timerOfProcess,modelo,latitud , longitud ,created_at,telemetria_id,defrost_prueba,ripener_prueba,sp_ethyleno) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$set_point, $temp_supply_1,$temp_supply_2,$return_air,$evaporation_coil,$condensation_coil, $compress_coil_1,$compress_coil_2,$ambient_air , $cargo_1_temp ,$cargo_2_temp,$cargo_3_temp,$cargo_4_temp,$relative_humidity,$avl , $suction_pressure ,$discharge_pressure,$line_voltage, $line_frequency,$consumption_ph_1,$consumption_ph_2 , $consumption_ph_3 ,$co2_reading,$o2_reading,$evaporator_speed,$condenser_speed,$battery_voltage , $power_kwh ,$power_trip_reading,$power_trip_duration, $suction_temp,$discharge_temp,$supply_air_temp , $return_air_temp ,$dl_battery_temp,$dl_battery_charge,$power_consumption,$power_consumption_avg,$alarm_present , $capacity_load ,$power_state,$controlling_mode,$humidity_control,$humidity_set_point,$fresh_air_ex_mode , $fresh_air_ex_rate ,$fresh_air_ex_delay,$set_point_o2, $set_point_co2,$defrost_term_temp,$defrost_interval , $water_cooled_conde ,$usda_trip,$evaporator_exp_valve,$suction_mod_valve,$hot_gas_valve,$economizer_valve,$ethylene , $stateProcess,$stateInyection, $timerOfProcess,$modelo,$latitud , $longitud ,$created_at,$telemetria_id,$defrost_prueba,$ripener_prueba,$sp_ethyleno]);

    }

    // api de GENERADORES

    public function crearGenerador($nombreGenerador,$descripcion,$telemetria_id,$water_temp,$latitud,$longitud,$ultima_fecha)
    {
        $consult = $this->pdo->prepare("INSERT INTO generadores ( nombre_generador , descripcion, telemetria_id,water_temp ,latitud ,longitud,fecha_ultima) VALUES (?,?,?,?,?,?,?)");
        return $consult->execute([$nombreGenerador,$descripcion,$telemetria_id,$water_temp,$latitud,$longitud,$ultima_fecha]);
    }
    //crearGeneradorM($segundoFiltro,$tipo , $descripcion,$telemetria_id,$battery_voltage,$water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current ,$speed, $eco_power,$rpm,$unit_mode,$horometro,$alarma_id,$evento_id,$modelo,$latitud,$longitud,$engine_state,$set_point,$temp_supply_1,$return_air,$reefer_conected,$fecha_ultima)
    public function crearGeneradorM($nombreGenerador,$ipo , $descripcion,$telemetria_id,$battery_voltage,$water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current ,$speed, $eco_power,$rpm,$unit_mode,$horometro,$alarma_id,$evento_id,$modelo,$latitud,$longitud,$engine_state,$set_point,$temp_supply_1,$return_air,$reefer_conected,$fecha_ultima)
    {
        $consult = $this->pdo->prepare("INSERT INTO generadores (nombre_generador,tipo , descripcion,telemetria_id,battery_voltage,water_temp,running_frequency,fuel_level,voltage_measure,rotor_current,fiel_current ,speed, eco_power,rpm,unit_mode,horometro,alarma_id,evento_id,modelo,latitud,longitud,engine_state,set_point,temp_supply,return_air,reefer_conected,ultima_fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$nombreGenerador,$ipo , $descripcion,$telemetria_id,$battery_voltage,$water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current ,$speed, $eco_power,$rpm,$unit_mode,$horometro,$alarma_id,$evento_id,$modelo,$latitud,$longitud,$engine_state,$set_point,$temp_supply_1,$return_air,$reefer_conected,$fecha_ultima]);
    }

    public function crearTramaGenerador($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud1 ,$longitud1,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $ultima_fecha ,$telemetria_id)
    {
        $consult = $this->pdo->prepare("INSERT INTO registro_generador ( battery_voltage, water_temp,running_frequency,fuel_level,voltage_measure,rotor_current,fiel_current,speed,eco_power,rpm , unit_mode,horometro,alarma_id,evento_id,modelo , latitud ,longitud,engine_state,set_point,temp_supply,return_air,reefer_conected,created_at,telemetria_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        return $consult->execute([$battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud1 ,$longitud1,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected, $ultima_fecha ,$telemetria_id]);

    }
    public function updateGenerador($water_temp,$latitud1,$longitud1 , $ultima_fecha ,$segundoFiltro)
    {
        $consult = $this->pdo->prepare("UPDATE generadores SET water_temp=? ,  latitud=?  ,longitud=? ,fecha_ultima=? WHERE nombre_generador=?");
        return $consult->execute([$water_temp,$latitud1,$longitud1 , $ultima_fecha ,$segundoFiltro]);
    }
    public function updateGeneradorM($battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud1 ,$longitud1,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected  , $ultima_fecha ,$segundoFiltro)
    {
        $consult = $this->pdo->prepare("UPDATE generadores SET    battery_voltage=?, water_temp=?,running_frequency=?,fuel_level=?,voltage_measure=?,rotor_current=?,fiel_current=?,speed=?,eco_power=?,rpm =?, unit_mode=?,horometro=?,alarma_id=?,evento_id=?,modelo =?, latitud =?,longitud=?,engine_state=?,set_point=?,temp_supply =?,return_air=?,reefer_conected =? ,ultima_fecha =? WHERE nombre_generador=?");
        return $consult->execute([$battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud1 ,$longitud1,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected , $ultima_fecha ,$segundoFiltro]);
    }
    //$battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,$rotor_current,$fiel_current,$speed,$eco_power,$rpm , $unit_mode,$horometro,$alarma_id,$evento_id,$modelo , $latitud1 ,$longitud1,$engine_state,$set_point,$temp_supply_1 ,$return_air,$reefer_conected ,$fecha_ultima 
    //$battery_voltage, $water_temp,$running_frequency,$fuel_level,$voltage_measure,
    //$rotor_current,$fiel_current,$speed,$eco_power,$rpm ,
    //$unit_mode,$horometro,$alarma_id,$evento_id,$modelo ,
    //$latitud1 ,$longitud1,$engine_state,$set_point,$temp_supply_1 ,
    //$return_air,$reefer_conected, $ultima_fecha ,$telemetria_id
    //24 datos
    // ESTRUCTURA DE INTERACCION CON COMANDOS 
    public function contarComandos($nombre_dispositivo){
        $consult = $this->pdo->prepare("SELECT count(*)  FROM tabla_comandos WHERE nombre_dispositivo = ? AND estado_comando = 1");
        $consult->execute([$nombre_dispositivo]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function comandosPendientes($nombre_dispositivo){
        $consult = $this->pdo->prepare("SELECT * from tabla_comandos where nombre_dispositivo = ? and estado_comando = 1 ");
        $consult->execute([$nombre_dispositivo]);
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }
    public function detalleComando($comando_id){
        $consult = $this->pdo->prepare("SELECT * FROM lista_comando WHERE id = ? ");
        $consult->execute([$comando_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function tramaAnterior($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT * from registro_reefers where telemetria_id =? order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function tramaAnteriorM($telemetria_id)
    { 
        $consult = $this->pdo->prepare("SELECT * from registro_madurador where telemetria_id =? order by id desc limit 1");
        $consult->execute([$telemetria_id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
    public function actualizarComando($nombre_dispositivo){
        $ultima_fecha =date("Y-m-d H:i:s");  
        $consult = $this->pdo->prepare("UPDATE tabla_comandos SET estado_comando=0 ,  fecha_ejecucion=?   WHERE id=?");
        //$consult = $this->pdo->prepare("UPDATE generadores SET water_temp=? ,  latitud=?  ,longitud=? ,fecha_ultima=? WHERE nombre_generador=?");
        return $consult->execute([ $ultima_fecha ,$nombre_dispositivo]);
    }


}