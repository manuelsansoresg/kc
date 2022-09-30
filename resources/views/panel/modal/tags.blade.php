@php
    $tags = config('enums.temperatures');
@endphp
<div class="modal fade" id="modal-tags" aria-modal="true" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="modal-tags-title"></h5>

                <form method="post" id="frm-tags" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Etiquetas</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="data[temperature_id]" id="modal-tags-tag"  data-search="on">
                                        @foreach ($tags as $key => $tag)
                                            <option value="{{ $key }}">{{ $tag }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                        
                        <input type="hidden" id="modal-tag-lead_id" name="lead_id">
                        
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