<div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em
            class="icon ni ni-more-h"></em></a>
    <div class="dropdown-menu dropdown-menu-end">
        <ul class="link-list-opt no-bdr">
            <li>
                <a class="pointer" onclick="modalUser({{ $type }}, {{ $user_id }})">
                    <em class="icon ni ni-edit"></em><span>Editar</span></a>
            </li>
            <li>
                <a onclick="modalPasswod({{ $user_id }})">
                    <em class="icon ni ni-lock-alt-fill"></em><span>Cambiar contraseña</span></a>
            </li>
            <li>
                <a href="/panel/user/client-profile/{{ $user_id }}">
                    <em class="icon ni ni-users-fill"></em><span>Perfíl</span></a>
            </li>
            <li>
                <a class="pointer" onclick="deleteUser({{ $user_id }})">
                    <em class="icon ni ni-trash"></em><span>Borrar</span></a>
            </li>
        </ul>
    </div>
</div>
