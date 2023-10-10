@php
$user = Auth::user();
@endphp
<div class="content-options">
    <div class="drodown"> <a href="#" class="dropdown-toggle btn btn-icon btn-trigger d-none d-md-block" data-bs-toggle="dropdown">
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
                    <a class="pointer" href="/panel/lead/{{ $id }}/profile">
                        <em class="icon ni ni-user-fill"></em>
                        <span class="">Ver perfil</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
