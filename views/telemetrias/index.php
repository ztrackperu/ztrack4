<form id="frmTelemetria" autocomplete="off">
    <div class="card mb-2">
        <div class="card-body">
            <input type="hidden" id="id_telemetria" name="id_telemetria">
            <div class="row">
                <div class="col-md-6">
                   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" placeholder="Numero Asignado...">
                    </div>
                </div>
                <div class="col-md-6">
                 
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="imei" name="imei" placeholder="IMEI asignado...">
                    </div>
                </div>

            </div>
            



        </div>
        <div class="card-footer text-right">
            <button type="button" class="btn btn-danger" id="btn-nuevo">Nuevo</button>
            <button type="submit" class="btn btn-primary" id="btn-save">Guardar</button>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" style="width: 100%;" id="table_telemetrias">
                <thead>
                    <tr>
                    <th scope="col">#</th>
            <th scope="col">Número Asignado</th>
            <th scope="col">IMEI</th>     
            <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
