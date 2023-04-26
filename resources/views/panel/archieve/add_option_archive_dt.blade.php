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
                    <a href="/panel/credit/{{ $credit_id }}">
                        <em class="icon ni ni-user-fill"></em><span>Ver perfíl crédito</span></a>
                </li>
                <li>
                    <a href="/panel/client/{{ $client_id }}">
                        <em class="icon ni ni-user-fill"></em><span>Ver perfíl cliente</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
