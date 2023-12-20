CREATE DATABASE zgroup;
use zgroup;

use zgroupztrack;
CREATE TABLE `tabla_comandos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_dispositivo` varchar(255) DEFAULT NULL,
  `comando_id` int DEFAULT '1',
  `telemetria_id` int DEFAULT '1',
  `valor_actual` varchar(20) DEFAULT '0',
  `valor_modificado` varchar(20) DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_modifico` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `contenedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_contenedor` varchar(255) DEFAULT NULL,
7



  `tipo` varchar(50) DEFAULT NULL,
  `estado` int DEFAULT '1',
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `empresa_id` int DEFAULT '1',
  `generador_id` int DEFAULT '1',
  `telemetria_id` int DEFAULT '1',
  `set_point` float DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  `ultima_fecha` timestamp NULL DEFAULT NULL,
  `temp_supply_1` float DEFAULT NULL,
  `temp_supply_2` float DEFAULT NULL,
  `return_air` float DEFAULT NULL,
  `evaporation_coil` float DEFAULT NULL,
  `condensation_coil` float DEFAULT NULL,
  `compress_coil_1` float DEFAULT NULL,
  `compress_coil_2` float DEFAULT NULL,
  `ambient_air` float DEFAULT NULL,
  `cargo_1_temp` float DEFAULT NULL,
  `cargo_2_temp` float DEFAULT NULL,
  `cargo_3_temp` float DEFAULT NULL,
  `cargo_4_temp` float DEFAULT NULL,
  `relative_humidity` float DEFAULT NULL,
  `avl` float DEFAULT NULL,
  `suction_pressure` float DEFAULT NULL,
  `discharge_pressure` float DEFAULT NULL,
  `line_voltage` float DEFAULT NULL,
  `line_frequency` float DEFAULT NULL,
  `consumption_ph_1` float DEFAULT NULL,
  `consumption_ph_2` float DEFAULT NULL,
  `consumption_ph_3` float DEFAULT NULL,
  `co2_reading` float DEFAULT NULL,
  `o2_reading` float DEFAULT NULL,
  `evaporator_speed` float DEFAULT NULL,
  `condenser_speed` float DEFAULT NULL,
  `battery_voltage` float DEFAULT NULL,
  `power_kwh` float DEFAULT NULL,
  `power_trip_reading` float DEFAULT NULL,
  `power_trip_duration` float DEFAULT NULL,
  `suction_temp` float DEFAULT NULL,
  `discharge_temp` float DEFAULT NULL,
  `supply_air_temp` float DEFAULT NULL,
  `return_air_temp` float DEFAULT NULL,
  `dl_battery_temp` float DEFAULT NULL,
  `dl_battery_charge` float DEFAULT NULL,
  `power_consumption` float DEFAULT NULL,
  `power_consumption_avg` float DEFAULT NULL,
  `alarm_present` float DEFAULT NULL,
  `capacity_load` float DEFAULT NULL,
  `power_state` float DEFAULT NULL,
  `controlling_mode` varchar(30) DEFAULT NULL,
  `humidity_control` float DEFAULT NULL,
  `humidity_set_point` float DEFAULT NULL,
  `fresh_air_ex_mode` float DEFAULT NULL,
  `fresh_air_ex_rate` float DEFAULT NULL,
  `fresh_air_ex_delay` float DEFAULT NULL,
  `set_point_o2` float DEFAULT NULL,
  `set_point_co2` float DEFAULT NULL,
  `defrost_term_temp` float DEFAULT NULL,
  `defrost_interval` float DEFAULT NULL,
  `water_cooled_conde` float DEFAULT NULL,
  `usda_trip` float DEFAULT NULL,
  `evaporator_exp_valve` float DEFAULT NULL,
  `suction_mod_valve` float DEFAULT NULL,
  `hot_gas_valve` float DEFAULT NULL,
  `economizer_valve` float DEFAULT NULL,
  `ethylene` float DEFAULT NULL,
  `stateProcess` varchar(30) DEFAULT NULL,
  `stateInyection` varchar(30) DEFAULT NULL,
  `timerOfProcess` float DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `alarm_number` float DEFAULT NULL,
  PRIMARY KEY (`id`)

) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `detalle_permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_permiso` int NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_permiso` (`id_permiso`),
  KEY `id_usuario` (`id_usuario`)
 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 ;
INSERT INTO `detalle_permisos` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1);

CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int DEFAULT '1',
  `temp_contratada` varchar(20) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `empresas` VALUES (1,'ZGROUP+','Base Central',1,'18','2023-02-21 22:26:53','2023-02-24 21:37:49');

CREATE TABLE `generadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_generador` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int DEFAULT '1',
  `empresa_id` int DEFAULT '1',
  `telemetria_id` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `water_temp` float DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  `fecha_ultima` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)

) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `historial_contenedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_contenedor` int DEFAULT NULL,
  `nombre_contenedor` varchar(255) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `empresa_id` int DEFAULT '1',
  `generador_id` int DEFAULT '1',
  `telemetria_id` int DEFAULT '1',
  `fecha_cambio` timestamp NULL DEFAULT NULL,
  `usuario_cambio_id` int DEFAULT NULL,
  `evento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `historial_empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int DEFAULT NULL,
  `nombre_empresa` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `temp_contratada` varchar(20) DEFAULT '0',
  `fecha_cambio` timestamp NULL DEFAULT NULL,
  `usuario_cambio_id` int DEFAULT NULL,
  `evento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `historial_generadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_generador` int DEFAULT NULL,
  `nombre_generador` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `empresa_id` int DEFAULT '1',
  `telemetria_id` int DEFAULT '1',
  `fecha_cambio` timestamp NULL DEFAULT NULL,
  `usuario_cambio_id` int DEFAULT NULL,
  `evento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `historial_telemetrias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_telemetria` int DEFAULT NULL,
  `numero_telefono` varchar(25) DEFAULT NULL,
  `imei` varchar(25) DEFAULT NULL,
  `fecha_cambio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_modifico_id` int DEFAULT '1',
  `evento` varchar(255) DEFAULT 'CREADO',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `historial_usuario_empresa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario_empresa` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `empresa_id` int DEFAULT NULL,
  `fecha_cambio` timestamp NULL DEFAULT NULL,
  `usuario_cambio_id` int DEFAULT NULL,
  `evento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `historial_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `estado` int DEFAULT '1',
  `permiso` int DEFAULT '2',
  `correo` varchar(255) DEFAULT  NULL,
  `password` varchar(255) DEFAULT NULL,
  `ultimo_acceso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_cambio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_modifico_id` int DEFAULT '1',
  `evento` varchar(255) DEFAULT 'CREADO',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

CREATE TABLE `comandosDirectos`(
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL DEFAULT 'sin informacion',
  `dirext` varchar(80) NOT NULL DEFAULT 'codex TX',
  PRIMARY KEY ('id')
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

INSERT INTO `permisos` VALUES (1,'Configuracion'),(2,'Usuarios'),(3,'Clientes'),(4,'Productos'),(5,'Ventas'),(6,'Nueva venta'),(7,'Compras'),(8,'Nueva compra'),(9,'Proveedores');

CREATE TABLE `registro_generador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `battery_voltage` float DEFAULT NULL,
  `water_temp` float DEFAULT NULL,
  `running_frequency` float DEFAULT NULL,
  `fuel_level` float DEFAULT NULL,
  `voltage_measure` float DEFAULT NULL,
  `rotor_current` float DEFAULT NULL,
  `fiel_current` float DEFAULT NULL,
  `speed` float DEFAULT NULL,
  `eco_power` float DEFAULT NULL,
  `rpm` float DEFAULT NULL,
  `unit_mode` varchar(30) DEFAULT NULL,
  `horometro` float DEFAULT NULL,
  `alarma_id` float DEFAULT NULL,
  `evento_id` float DEFAULT NULL,
  `modelo` varchar(20) DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  `engine_state` varchar(20) DEFAULT NULL,
  `set_point` float DEFAULT NULL,
  `temp_supply` float DEFAULT NULL,
  `return_air` float DEFAULT NULL,
  `reefer_conected` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `telemetria_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `registro_madurador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `set_point` float DEFAULT NULL,
  `temp_supply_1` float DEFAULT NULL,
  `temp_supply_2` float DEFAULT NULL,
  `return_air` float DEFAULT NULL,
  `evaporation_coil` float DEFAULT NULL,
  `condensation_coil` float DEFAULT NULL,
  `compress_coil_1` float DEFAULT NULL,
  `compress_coil_2` float DEFAULT NULL,
  `ambient_air` float DEFAULT NULL,
  `cargo_1_temp` float DEFAULT NULL,
  `cargo_2_temp` float DEFAULT NULL,
  `cargo_3_temp` float DEFAULT NULL,
  `cargo_4_temp` float DEFAULT NULL,
  `relative_humidity` float DEFAULT NULL,
  `avl` float DEFAULT NULL,
  `suction_pressure` float DEFAULT NULL,
  `discharge_pressure` float DEFAULT NULL,
  `line_voltage` float DEFAULT NULL,
  `line_frequency` float DEFAULT NULL,
  `consumption_ph_1` float DEFAULT NULL,
  `consumption_ph_2` float DEFAULT NULL,
  `consumption_ph_3` float DEFAULT NULL,
  `co2_reading` float DEFAULT NULL,
  `o2_reading` float DEFAULT NULL,
  `evaporator_speed` float DEFAULT NULL,
  `condenser_speed` float DEFAULT NULL,
  `battery_voltage` float DEFAULT NULL,
  `power_kwh` float DEFAULT NULL,
  `power_trip_reading` float DEFAULT NULL,
  `power_trip_duration` float DEFAULT NULL,
  `suction_temp` float DEFAULT NULL,
  `discharge_temp` float DEFAULT NULL,
  `supply_air_temp` float DEFAULT NULL,
  `return_air_temp` float DEFAULT NULL,
  `dl_battery_temp` float DEFAULT NULL,
  `dl_battery_charge` float DEFAULT NULL,
  `power_consumption` float DEFAULT NULL,
  `power_consumption_avg` float DEFAULT NULL,
  `alarm_present` float DEFAULT NULL,
  `capacity_load` float DEFAULT NULL,
  `power_state` float DEFAULT NULL,
  `controlling_mode` varchar(30) DEFAULT NULL,
  `humidity_control` float DEFAULT NULL,
  `humidity_set_point` float DEFAULT NULL,
  `fresh_air_ex_mode` float DEFAULT NULL,
  `fresh_air_ex_rate` float DEFAULT NULL,
  `fresh_air_ex_delay` float DEFAULT NULL,
  `set_point_o2` float DEFAULT NULL,
  `set_point_co2` float DEFAULT NULL,
  `defrost_term_temp` float DEFAULT NULL,
  `defrost_interval` float DEFAULT NULL,
  `water_cooled_conde` float DEFAULT NULL,
  `usda_trip` float DEFAULT NULL,
  `evaporator_exp_valve` float DEFAULT NULL,
  `suction_mod_valve` float DEFAULT NULL,
  `hot_gas_valve` float DEFAULT NULL,
  `economizer_valve` float DEFAULT NULL,
  `ethylene` float DEFAULT NULL,
  `stateProcess` varchar(30) DEFAULT NULL,
  `stateInyection` varchar(30) DEFAULT NULL,
  `timerOfProcess` float DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `telemetria_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `registro_reefers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `set_point` float DEFAULT NULL,
  `temp_supply` float DEFAULT NULL,
  `return_air` float DEFAULT NULL,
  `evaporation_coil` float DEFAULT NULL,
  `ambient_air` float DEFAULT NULL,
  `cargo_1_temp` float DEFAULT NULL,
  `cargo_2_temp` float DEFAULT NULL,
  `cargo_3_temp` float DEFAULT NULL,
  `cargo_4_temp` float DEFAULT NULL,
  `relative_humidity` float DEFAULT NULL,
  `alarm_present` int DEFAULT NULL,
  `alarm_number` int DEFAULT NULL,
  `controlling_mode` varchar(30) DEFAULT NULL,
  `power_state` int DEFAULT NULL,
  `defrost_term_temp` float DEFAULT NULL,
  `defrost_interval` float DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `telemetria_id` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `telemetrias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_telefono` varchar(255) DEFAULT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `estado` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `usuario_empresa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `empresa_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `estado` int DEFAULT '1',
  `permiso` int DEFAULT '2',
  `correo` varchar(255) DEFAULT 'prueba@gmail.com',
  `password` varchar(255) DEFAULT NULL,
  `ultimo_acceso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` VALUES (1,'zgroup','Central','Zgroup',1,2,'admin@zgroup.pe','$2y$10$vS5ajG877UWuW1dFDbA2ZehRJk0MKD8G/5gnlfauELXVYOQ6pk5y6','2023-02-21 01:21:25','2023-02-21 01:21:25','2023-02-27 20:24:59');