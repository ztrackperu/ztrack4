<form id="frmEmpresa" autocomplete="off">
    <div class="card mb-2">
        <div class="card-body">
            <input type="hidden" id="id_empresa" name="id_empresa">
            <div class="row">
                <div class="col-md-4">
                   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Empresa...">
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
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="text" class="form-control" id="temp_contratada" name="temp_contratada" placeholder="Temperatura...">
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
            <table class="table table-striped table-hover" style="width: 100%;" id="table_empresas">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Temperatura Default</th>
                        <th scope="col"> Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalEmpresa-Dispositivo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Dispositivos a Empresas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- html permisos -->
                <form id="frmAsignarDispositivo">                  
                </form>
                <form id="frmAsignarDispositivo1">                 
               </form>

            </div>
        </div>
    </div>
</div>
