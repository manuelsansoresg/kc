<div class="modal fade" id="modal-note" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="note-title"></h5>

                <form method="post" id="frm-note" action="">
                    @csrf
                    <div class="row gy-4">
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Nota</label>
                                <div class="form-control-wrap">
                                    <textarea name="description" id="modal-lead-description" cols="30" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="id_rel" name="id_rel">
                        <input type="hidden" id="model_note">
                        
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