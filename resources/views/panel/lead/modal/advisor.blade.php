@inject('m_user', 'App\Models\User')
@php
    $advisors = $m_user->getUserRole('Asesor');
@endphp
<div class="modal fade" id="modal-advisor" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Asignar asesor</h5>

                <form method="post" id="frm-advisor" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Asesor</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" name="data[asesor_id]" id="modal-advisor-id"  data-search="on">
                                        @foreach ($advisors as $advisor)
                                            <option value="{{ $advisor->id }}">{{ $advisor->name }} {{ $advisor->last_name }} {{ $advisor->second_last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="lead_advisor_id" name="lead_id">
                        
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