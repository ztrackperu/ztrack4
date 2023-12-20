<?php
require_once '../models/api.php';;
$api = new ApiModel();

$R = $api->ListaReffer();

foreach($R as $refer){
    $empresa =$refer['empresa_id'] ;
    $nombreEmpresa = $api->nombreEmpresa($empresa);

    $telemetria =$refer['telemetria_id'];
    $imeiTelemetria = $api->imeiTelemetria($telemetria);

    $ultimaConexion =$refer['ultima_fecha'];
    $fecha_actual = date("Y-m-d H:i:s");
    $fecha_nueva = strtotime('-30 minute',strtotime($fecha_actual));
    $fecha_nueva=date("Y-m-d H:i:s",$fecha_nueva);
    if($ultimaConexion <= $fecha_nueva ){
      $alarma = "SIN CONEXIÓN";
    }else{
      $alarma = "NORMAL";
    }
    ?>
    <tr>
      
      <td><a class="edit" data-id="<?= $refer['telemetria_id']  ?>" href="#" onclick="verTramas(<?= $refer['telemetria_id']  ?>)><?= $refer['nombre_contenedor'] ?></a></td>
      <td><?= $ultimaConexion ?></td>
      <td>
      <?= $alarma ?>  
      </td>
      <td><?= $nombreEmpresa['nombre_empresa'] ?></td>
      <td><?= $imeiTelemetria['imei']?></td>
      <td><?= $refer['set_point'] ?></td>
      <td><?= $refer['latitud'] ?></td>
      <td><?= $refer['longitud'] ?></td>
  
  
    </tr>
    <?php
  }
  ?>
  