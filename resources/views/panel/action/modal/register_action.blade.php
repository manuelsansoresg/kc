@inject('m_user', 'App\Models\User')
@php
$status = config('enums.status_register_actions');
@endphp
<div class="modal fade" id="modal-register-action" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Acciones</h5>

                <form method="post" id="frm-register-action" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Estado</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" name="data[state]" data-search="on">
                                        <option value="">Escribe para buscar</option>
                                        @foreach ($status as $key => $status)
                                            <option value="{{ $key }}">{{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Comentario</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data[comment]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Archivo</label>
                                <div class="form-control-wrap">
                                    <div class="upload-zone">
                                        <div class="dz-message" data-dz-message> 
                                            <span class="dz-message-text">Arrastra y suelta el archivo</span>
                                             <span class="dz-message-or">o</span> <button
                                                class="btn btn-primary">Selecciona</button> </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="data[id_rel]" id="register-action-id-rel">
                        <input type="hidden" id="model-file-temp" value="{{ $model_file  }}">

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
