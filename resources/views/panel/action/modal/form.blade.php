@inject('m_user', 'App\Models\User')
@inject('m_action', 'App\Models\Action')

<div class="modal fade" id="modal-action">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                @php
                    $types    = config('enums.type_actions');
                    $advisors = $m_user->getUserRole('Asesor');
                    $user     = Auth::user();
                    $sections = config('enums.status_actions');
                @endphp
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Acciones</h5>
                    <form id="frm-action" action="" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="create-task-name">Tipo</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" name="data[type]" id="modal-action-type"  data-search="on">
                                            <option value="">Escribe para buscar</option>
                                            @foreach ($types as $key => $type)
                                                <option value="{{ $key }}">{{ $type }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="create-task-name">Asunto</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="data[subject]" id="modal-action-subject">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-start-date">Fecha inicio</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" id="modal-action-start_date"  name="data[start_date]" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-dead-date">hora inicio</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-clock"></em>
                                        </div>
                                        <input type="text" name="data[start_time]" class="form-control  time-picker" id="modal-action-start_time">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-dead-date">Fecha fin</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" id="modal-action-end_date" name="data[end_date]" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-dead-date">Hora fin</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-clock"></em>
                                        </div>
                                        <input type="text" name="data[end_time]" class="form-control time-picker-fin" id="modal-action-end_time">
                                    </div>
                                </div>
                            </div>
                           
                           
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Descripción</label>
                                    <div class="form-control-wrap">
                                        <!-- Create the editor container -->
                                        <textarea name="data[description]" id="modal-action-description" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Asesor</label>
                                    <div class="form-control-wrap">
                                        @if ($user->hasRole('Asesor') == true)
                                            <select class="form-select" name="data[advisor_id]" id="lead-asesor-id"  data-search="on" disabled>
                                                @foreach ($advisors as $advisor)
                                                    <option value="{{ $advisor->id }}" {{ ($user->id == $advisor->id)? 'selected' : '' }} >{{ $advisor->name }} {{ $advisor->last_name }} {{ $advisor->second_last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select class="form-select js-select2" name="data[advisor_id]" id="lead-asesor-id"  data-search="on">
                                                <option value="">Escribe para buscar</option>
                                                @foreach ($advisors as $advisor)
                                                    <option value="{{ $advisor->id }}">{{ $advisor->name }} {{ $advisor->last_name }} {{ $advisor->second_last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Seccion</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="lead-asesor-id"  data-search="on" disabled>
                                            @foreach ($sections as $key => $section)
                                                <option value="{{ $key  }}" {{ ($key === $model)? 'selelected' : '' }}>{{ $section }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                            @if ($m_action::LEAD == $model)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nombre</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="modal-action-id-rel-lead"  data-search="on" disabled>
                                            
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif
                            <input type="hidden" id="modal-action-id-rel" name="data[id_rel]" value="">
                            <input type="hidden" name="data[section]" value="{{ $model }}">
                            <input type="hidden" name="data[status]" id="modal-action-status" value="{{ $model }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Completado</label>
                                    <div class="form-control-wrap">
                                        <ul class="custom-control-group g-3 align-center flex-wrap">
                                            <li>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"  name="status" id="edit-course-active" value="1">
                                                    <label class="custom-control-label" for="edit-course-active">Sí</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="status" id="edit-course-pending" value="0">
                                                    <label class="custom-control-label" for="edit-course-pending">No</label>
                                                </div>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="tags">Tags</label>
                                    <div class="form-control-wrap">
                                        <div class="d-flex gx-3 mb-3">
                                            <div class="g w-100">
                                                <input type="text" class="form-control" id="tags" required>
                                            </div>
                                            <div class="g">
                                                <button class="btn btn-icon btn-outline-light"><em class="icon ni ni-plus"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Edit Modal-Content -->