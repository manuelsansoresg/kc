@php
$user = Auth::user();
@endphp
<ul class="nk-tb-actions gx-1">
    <li class="nk-tb-action-hidden">
        <a href="/panel/lead/{{ $model->id_rel }}/profile" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfíl">
            <em class="icon ni ni-user-fill"></em>
        </a>
    </li>
    @if ($status == 'in_progress')
    <li class="nk-tb-action-hidden">
        <a class="btn btn-trigger btn-icon" onclick="modalRegisterAction({{ $model->section}},{{ $model->id }})" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Completar">
            <em class="icon ni ni-check-circle-fill"></em>
        </a>
    </li>
    @else
    <li class="nk-tb-action-hidden">
        <a class="btn btn-trigger btn-icon" onclick="setModalAction({{ $model->id }}, true)" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Ver registro">
            <em class="icon ni ni-todo-fill"></em>
        </a>
    </li>
    <li class="nk-tb-action-hidden">
        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como pendiente" onclick="deleteRegisterAction({{ $model->id }}, true)"><em class="icon ni ni-minus-circle-fill"></em></a>
    </li>
    @endif
    <li>
        <div class="drodown">
            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em
                    class="icon ni ni-more-h"></em></a>
            <div class="dropdown-menu dropdown-menu-end">
                <ul class="link-list-opt no-bdr">
                    <li>
                        <a href="/panel/lead/{{ $model->id_rel }}/profile">
                            <em class="icon ni ni-user-fill"></em><span>Ver perfíl</span></a>
                    </li>
                    @if ($status == 'in_progress')
                   
                    <li>
                        <a onclick="modalRegisterAction({{ $model->section}},{{ $model->id }})">
                            <em class="icon ni ni-check-circle-fill"></em><span>Marcar como completada</span></a>
                    </li>
                    <li>
                        <a onclick="setModalAction({{ $model->id }}, false)">
                            <em
                                class="icon ni ni-edit-alt"></em><span>Editar</span></a>
                    </li>
                   
                    
                    @else
                    <li>
                        <a class="pointer" onclick="deleteRegisterAction({{ $model->id }}, true)">
                            <em class="icon ni ni-minus-circle-fill"></em><span>Marcar como pendiente</span></a>
                    </li>
                    @endif
                    <li>
                        <a  class="pointer" onclick="alerDeleteAction({{ $model->id }})">
                            <em
                                class="icon ni ni-trash-alt"></em><span>Eliminar</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</ul>