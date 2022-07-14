<div class="modal fade" id="modal-user-admin" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="user-admin-title"></h5>
                <form method="post" id="frm-modal-user-admin" action="">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="edit-name">Nombre</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="edit-name"
                                        value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="form-label">Primer apellido</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="edit-name"
                                    value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Segundo apellido</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="edit-name"
                                    value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="edit-open-deal">Celular </label>
                                <input type="text" class="form-control" id="edit-open-deal"
                                     value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="edit-close-deal">Email</label>
                                <input type="text" class="form-control" id="edit-close-deal"
                                     value=""></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="form-label">Status</label>
                                <div class="form-control-wrap">
                                    <select
                                        class="form-select js-select2 select2-hidden-accessible" data-select2-id="25"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="default_option" data-select2-id="27">Activo</option>
                                        <option value="pending">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="edit-close-deal">Contraseña</label>
                                <input type="text" class="form-control" id="edit-close-deal"
                                     value=""></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="edit-close-deal">Confirmar contraseña</label>
                                <input type="text" class="form-control" id="edit-close-deal"
                                     value=""></div>
                        </div>
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                    <button class="btn btn-primary">Guardar</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>