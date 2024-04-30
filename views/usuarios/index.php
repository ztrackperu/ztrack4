<form id="frmUser" autocomplete="off">
    <div class="card mb-2">
        <div class="card-body">
            <input type="hidden" id="id_user" name="id_user">
            <div class="row">
                <div class="col-md-4">
                   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario...">
                    </div>
                </div>
                <div class="col-md-4">
                 
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres...">
                    </div>
                </div>
                <div class="col-md-4">
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos...">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="correo ...">
                    </div>
                </div>
                <div class="col-md-6">
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña...">
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
            <table class="table table-striped table-hover" style="width: 100%;" id="table_users">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Ultima Conexión</th>
                        <th> Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>






<div id="modalUsuario-Empresa" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Empresas a Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- html permisos -->
                <form id="frmAsignarEmpresa">

                    
                </form>
            </div>
        </div>
    </div>
</div>