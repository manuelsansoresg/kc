<div class="modal fade" id="modal-archive" aria-modal="true" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="modal-archive-title"></h5>

                <form method="post" id="frm-archive" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Motivo</label>
                                <div class="form-control-wrap">
                                    @php
                                        $reasons = config('enums.reason_archive');
                                    @endphp
                                    <select class="form-select" name="data[reason]" id="modal-reason-id"  data-search="on">
                                        @foreach ($reasons as $key => $reason)
                                            <option value="{{ $key }}">{{ $reason }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Comentario</label>
                                <div class="form-control-wrap">
                                  <textarea id="" cols="30" rows="4" name="data[comment]" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="id_rel" name="id_rel">
                       
                        
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
                <input type="hidden" id="statusid">
                <input type="hidden" id="old_status_id">
                <input type="hidden" id="dt">
            </div>
        </div>
    </div>
</div>