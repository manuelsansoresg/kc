<div class="modal fade" id="modal-user-password" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="user-admin-title"></h5>

                <form method="post" id="frmpassword" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-pass">Contraseña</label>
                                <input type="password" name="user_password" class="form-control" id="user_password"
                                     value="" ></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-confirm-pass">Confirmar contraseña</label>
                                <input type="password" class="form-control" name="user_pass_confirm" id="user_pass_confirm"
                                     value="" ></div>
                        </div>
                        <input type="hidden" id="password_user_id" name="password_user_id">
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