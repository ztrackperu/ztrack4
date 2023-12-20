estoy en trama madurador
<form id="frmTramaMadurador" autocomplete="off">
    <div class="card mb-2">
        <p></p>
        <H2 align ="center"> Contenedores tipo Madurador</H2>
    </div>
</form>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" style="width: 100%;" id="table_madurador">
                <thead>
                    <tr>
                    <th scope="col">Nombre Contenedor</th>
                    <th scope="col">Última Conexion</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Telemetria </th>
                    <th scope="col">Temperatura </th>
                    <th scope="col">Latitud</th>
                    <th scope="col">Longitud</th>


                    </tr>
                </thead>
                <tbody>
                
                <?php
require_once 'models/api.php';;
$api = new ApiModel();

$R = $api->ListaMadurador();

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
      
      <td><a class="edit"  href="#" onclick="listaTramaR(<?= $refer['telemetria_id']  ?>)"><?= $refer['nombre_contenedor']  ?></a></td>
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
  




                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalTramaReffer" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tramas de tipo Madurador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" >
                <!-- html permisos -->
                <form id="frmTramaMadurador3">

                </form>
                <div class="row">
      <div class="col-md-12">
      <div class="card">
    <div class="card-body">
        <div class="table-responsive">
      <table class="table table-striped table-hover" style="width: 100%;" id="table_madurador1">
  <thead>
    <tr>
     
      <th scope="col">Fecha Recepción</th>
      <th scope="col">set_point</th>
      <th scope="col">temp_supply </th>
      <th scope="col">latitud</th>
      <th scope="col">longitud</th>
      <th scope="col">return_air</th>
      <th scope="col">evaporation_coil </th>
      <th scope="col">ambient_air </th>
      <th scope="col">cargo_1_temp</th>
      <th scope="col">relative_humidity</th>
      <th scope="col">alarm_present</th>
      <th scope="col">alarm_number</th>
      <th scope="col">controlling_mode</th>
      <th scope="col">power_state</th>
      <th scope="col">defrost_term_temp</th>
      <th scope="col">defrost_interval</th>
    </tr>
  </thead>
  <tbody id="frmTramaMadurador2">

                  </tbody>
</table>
</div>
</div>
</div>

      </div>
      </div>
            </div>
        </div>
    </div>
</div>