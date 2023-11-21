@php
$user = Auth::user();
@endphp
<div class="content-options">
    <ul class="nk-tb-actions gx-1">
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            @php
                $url_profile = isset($credit) ? '/panel/credit/'.$model->id_rel : '/panel/lead/'.$model->id_rel.'/profile';
            @endphp
            <a href="{{ $url_profile }}" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfíl">
                <em class="icon ni ni-user-fill"></em>
            </a>
        </li>
        @if ($status == 'in_progress')
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a class="btn btn-trigger btn-icon" onclick="modalRegisterAction({{ $model->section}},{{ $model->id }})" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Completar">
                <em class="icon ni ni-check-circle-fill"></em>
            </a>
        </li>
        @else
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a class="btn btn-trigger btn-icon" onclick="setModalAction({{ $model->id }}, false, {{ $model->section }})" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Ver registro">
                <em class="icon ni ni-todo-fill"></em>
            </a>
        </li>
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como pendiente" onclick="deleteRegisterAction({{ $model->id }}, true)"><em class="icon ni ni-minus-circle-fill"></em></a>
        </li>
        @endif
        <li>
            <div class="drodown">
                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger d-none d-md-block" data-bs-toggle="dropdown">
                    <em
                        class="icon ni ni-more-h"></em>
                </a>
               
                <a href="#" class="dropdown-toggle btn btn-primary  d-block d-md-none" data-bs-toggle="dropdown">
                    <em
                        class="icon ni ni-more-h"></em>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <ul class="link-list-opt no-bdr">
                        <li>
                            <a href="{{ $url_profile }}">
                                <em class="icon ni ni-user-fill"></em><span>Ver perfíl</span></a>
                        </li>
                        @if (isset($lead))
                        <li>
                            <a href="https://web.whatsapp.com/send/?phone={{ $lead->cellphone }}&text&type=phone_number&app_absent=0"  target="_blank">
                                <em class="icon ni ni-whatsapp"></em><span>Whatsapp</span></a>
                        </li>
                        @endif
                        @if ($status == 'in_progress')
                       
                        <li>
                            <a onclick="modalRegisterAction({{ $model->section}},{{ $model->id }})">
                                <em class="icon ni ni-check-circle-fill"></em><span>Marcar como completada</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="setModalAction({{ $model->id }}, false, {{ $model->section }})">
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
</div>