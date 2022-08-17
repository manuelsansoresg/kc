@php
    $icons = config('enums.type_icon_actions');
    $enum_actions = config('enums.type_actions');
@endphp
@foreach ($actions as $action)
    <div class="card mt-3">
        <div class="kanban-item">
            <div class="kanban-item-title">
                <h6 class="title">
                    <em class="{{ $icons[$action->type] }}"></em>
                    {{ $enum_actions[$action->type] }}
                </h6>
            </div>
            <div class="kanban-item-text">
                <p>{{ $action->subject }}</p>
            </div>
            
            <div class="kanban-item-meta">
                @if ($status == 'in_progress')
                <ul class="kanban-item-meta-list">
                    <li><em class="icon ni ni-calendar"></em><span>{{ $action->created_at->diffForHumans() }}</span>
                    </li>

                </ul>
                <ul class="kanban-item-meta-list">
                    <li>
                        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Marcar como completada" onclick="modalRegisterAction({{ $model}}, {{ $action->id }})"><em
                                class="icon ni ni-check-round"></em></a>
                    </li>
                    <li>
                        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Editar" onclick="setModalAction({{ $action->id }}, false)"><em
                                class="icon ni ni-edit-alt"></em></a>
                    </li>
                    <li>
                        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Eliminar" onclick="alerDeleteAction({{ $action->id }})"><em
                                class="icon ni ni-trash-alt"></em></a>
                    </li>
                </ul>
                @else
                <ul class="kanban-item-meta-list">
                    <li><em class="icon ni ni-calendar"></em><span>{{ $action->created_at->diffForHumans() }}</span></li>
                    
                </ul>
                <ul class="kanban-item-meta-list">
                    <li>
                        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver registro de accion" onclick="setModalAction({{ $action->id }}, true)"><em class="icon ni ni-todo-fill"></em></a>
                    </li>
                    {{-- <li>
                        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como pendiente" onclick=""><em class="icon ni ni-minus-round"></em></a>
                    </li> --}}
                    <li>
                        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" onclick="alerDeleteAction({{ $action->id }})"><em class="icon ni ni-trash-alt"></em></a> 
                    </li>
                </ul>
                @endif
                
            </div>
        </div>
    </div>
@endforeach
