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
                                    <select class="form-select js-select2" name="data[state]" id="frm-register-action-state" data-search="on">
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
                                    <textarea name="data[comment]" id="frm-register-action-comment" cols="30" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Archivo</label>
                                <div class="form-control-wrap">
                                    <div class="upload-zone"  data-accepted-files="image/*">
                                        <div class="dz-message" data-dz-message> 
                                            <span class="dz-message-text">Arrastra y suelta el archivo</span>
                                             <span class="dz-message-or">o</span> <button
                                                class="btn btn-primary">Selecciona</button> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div  id="frm-register-action-preview"></div>

                        <input type="hidden" name="data[action_id]" id="register-action-id-rel">
                        <input type="hidden" name="model"  id="register-action-model" value="{{  (isset($model))? $model : null  }}">

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
