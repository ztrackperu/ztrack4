<form id="frmGenerador" autocomplete="off">
    <div class="card mb-2">
        <div class="card-body">
            <input type="hidden" id="id_generador" name="id_generador">
            <div class="row">
                <div class="col-md-6">
                   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <input type="text" class="form-control" id="nombre_generador" name="nombre_generador" placeholder="Nombre de Generador...">
                    </div>
                </div>
                <div class="col-md-6">
                 
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion...">
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
            <table class="table table-striped table-hover" style="width: 100%;" id="table_generadores">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Generador</th>
                        <th scope="col">Descripcion</th>
                       
                        <th scope="col"> Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
