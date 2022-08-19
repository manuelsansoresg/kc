<div class="modal fade" id="modal-user-admin" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="user-admin-title"></h5>

                <form method="post" id="frmadmin" action="/panel/user/administrador">
                    @csrf
                    <ul class="nav nav-tabs">
                        <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Cuenta</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">nav</a> </li>
                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#tabItem3">nav</a> </li>
                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#tabItem4">nav</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem1">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="frm-user-admin-name">Nombre</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="name" class="form-control" id="name"
                                                value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Primer apellido</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="last_name" class="form-control" id="last_name"
                                                value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Segundo apellido</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="second_last_name" class="form-control"
                                                id="second_last_name" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="edit-open-deal">Celular </label>
                                        <input type="text" class="form-control" name="cellphone" id="cellphone"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="edit-close-deal">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" value="">
                                        <span id="admin_email-error-exist" class="error" style="display:none">El correo ya se
                                            encuentra registrado.</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="form-label">Estatus</label>
                                        <div class="form-control-select">
                                            <select name="status" class="form-control" id="status">
                                                <option value="">Selecciona una opción</option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="content-password" style="display: none">
                                    <div class="form-group">
                                        <label class="form-label" for="frm-user-admin-pass">Contraseña</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6" id="content-pass_confirm" style="display: none">
                                    <div class="form-group">
                                        <label class="form-label" for="frm-user-admin-confirm-pass">Confirmar
                                            contraseña</label>
                                        <input type="password" class="form-control" name="pass_confirm" id="pass_confirm"
                                            value="">
                                    </div>
                                </div>
                                <input type="hidden" id="user_id" name="user_id">
                                <input type="hidden" id="type_user" name="type_user">
        
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                            <button class="btn btn-primary">Guardar</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabItem2">
                            <p>content</p>
                        </div>
                        <div class="tab-pane" id="tabItem3">
                            <p>contnet</p>
                        </div>
                        <div class="tab-pane" id="tabItem4">
                            <p>contnet</p>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
