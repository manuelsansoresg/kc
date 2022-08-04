@php
    $user   = Auth::user();
@endphp
<div class="drodown"><a href="#"
    class="dropdown-toggle btn btn-icon btn-trigger"
    data-bs-toggle="dropdown"><em
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
            <a  class="pointer" onclick="createClientPerson({{ $id }})">
                <em class="icon ni ni-users-fill"></em><span>Crear cuenta</span></a>
        </li>
        <li>
            <a  class="pointer" onclick="modalTags({{ $id }})">
                <em class="icon ni ni-tag"></em><span>Etiquetas</span></a>
        </li>
        <li>
            <a class="pointer" onclick="archiveModal({{ $id }})">
                <em class="icon ni ni-files"></em><span>Archivar</span></a>
        </li>
        @if ($user->hasRole('Asesor') != true)
        <li>
            <a onclick="modalAdvisor({{$id}})">
                <em class="icon ni ni-users-fill"></em><span>Asignar asesor</span></a>
        </li>
        @endif
        
        <li>
            <a class="pointer" onclick="deleteLead({{ $id }})">
                <em class="icon ni ni-trash"></em><span>Borrar</span></a>
        </li>
        
    </ul>
</div>
</div>