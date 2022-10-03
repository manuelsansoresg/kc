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
        @if ($is_report === false)
        <li>
            <a class="pointer" href="/panel/kc-check-up-actions/{{ $id }}">
                <em class="icon ni ni-card-view"></em><span>Ver acciones</span></a>
        </li>
        @else
        <li>
            <a class="pointer" href="/panel/kc-check-up/report/{{ $id }}">
                <em class="icon ni ni-card-view"></em><span>Ver acciones</span></a>
        </li>
        @endif
       
        
    </ul>
</div>
</div>