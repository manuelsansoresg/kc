@php
$user = Auth::user();
@endphp
<ul class="nk-tb-actions gx-1">
    <li class="nk-tb-action-hidden">
        <a href="/panel/lead/{{ $id }}/profile" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfíl">
            <em class="icon ni ni-user-fill"></em>
        </a>
    </li>
    <li class="nk-tb-action-hidden">
        <a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Siguiente">
            <em class="icon ni ni-arrow-right-circle"></em>
        </a>
    </li>
    <li class="nk-tb-action-hidden">
        <a  onclick="archiveModal({{ $id }})" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Archivar">
            <em class="icon ni ni-archive-fill"></em>
        </a>
    </li>
    <li>
        <div class="drodown">
            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em
                    class="icon ni ni-more-h"></em></a>
            <div class="dropdown-menu dropdown-menu-end">
                <ul class="link-list-opt no-bdr">
                    <li>
                        <a class="pointer" href="/panel/lead/{{ $id }}/edit">
                            <em class="icon ni ni-edit"></em><span>Editar</span></a>
                    </li>
                    <li>
                        <a class="pointer" onclick="modalNoteLead({{ $id }})">
                            <em class="icon ni ni-edit"></em><span>Agregar nota</span></a>
                    </li>
                    <li>
                        <a href="/panel/lead/{{ $id }}/profile">
                            <em class="icon ni ni-users-fill"></em><span>Perfíl</span></a>
                    </li>
                    <li>
                        <a class="pointer" onclick="createClientPerson({{ $id }})">
                            <em class="icon ni ni-users-fill"></em><span>Crear cuenta</span></a>
                    </li>
                    <li>
                        <a class="pointer" onclick="modalTags({{ $id }})">
                            <em class="icon ni ni-tag"></em><span>Etiquetas</span></a>
                    </li>
                    <li>
                        <a class="pointer" onclick="archiveModal({{ $id }})">
                            <em class="icon ni ni-files"></em><span>Archivar</span></a>
                    </li>
                    <li>
                        <a class="pointer" onclick="actionModal({{ $id }}, true)">
                            <em class="icon ni ni-calendar-check-fill"></em><span>Acción</span></a>
                    </li>
                    @if ($user->hasRole('Asesor') != true)
                        <li>
                            <a class="pointer" onclick="modalAdvisor({{ $id }})">
                                <em class="icon ni ni-users-fill"></em><span>Asignar asesor</span></a>
                        </li>
                    @endif
                    <li>
                        <a class="pointer" onclick="modalValidate({{ $id }}, 'lead')">
                            <em class="icon ni ni-alert-circle-fill"></em><span>Ver validaciónes</span></a>
                    </li>

                    <li>
                        <a class="pointer" onclick="deleteLead({{ $id }})">
                            <em class="icon ni ni-trash"></em><span>Borrar</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</ul>
