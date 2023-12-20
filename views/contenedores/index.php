<form id="frmContenedor" autocomplete="off">
    <div class="card mb-2">
        <div class="card-body">
            <input type="hidden" id="id_contenedor" name="id_contenedor">
            <div class="row">
                <div class="col-md-4">
                   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <input type="text" class="form-control" id="nombre_contenedor" name="nombre_contenedor" placeholder="Nombre de Contenedor...">
                    </div>
                </div>
                <div class="col-md-4">
                 
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion...">
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card mr-1"></i> Tipo</span>
                            </div>
                            <select id="tipo" name="tipo" class="form-control">
                                <option value="Reefer">Reefer</option>
                                <option value="Madurador">Madurador</option>

                            </select>
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
            <table class="table table-striped table-hover" style="width: 100%;" id="table_contenedores">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Contenedor</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
