@inject('m_history', 'App\Models\HistoryLog')
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
        @if ($percent_form == 100)
            <li>
                <a class="pointer" href="/reporte/{{ $id }}">
                    <em class="icon ni ni-reports"></em><span>Ver reporte</span></a>
            </li>
        @endif
        <li>
            <a class="pointer" href="/panel/template/steps/{{ $route }}/{{ $id }}/show">
                <em class="icon ni ni-list-thumb-fill"></em><span>Ver etapas</span></a>
        </li>
        <li>
            <a class="pointer" href="/panel/client/{{ $client->id }}">
                <em class="icon ni ni-user-fill"></em><span>Ver perfil cliente</span></a>
        </li>
        <li>
            <a class="pointer" href="/panel/credit/{{ $credit_id }}">
                <em class="icon ni ni-report-profit"></em><span>Ver perfil crédito</span></a>
        </li>
        <li>
            <a onclick="moveModal('Cancelar', {{ $credit_id }}, '{{ $m_history::CREDIT_CANCELED }}', '{{ $status_id }}', 'dt-check-up')" class="pointer">
                <em class="icon ni ni-cross-circle-fill"></em><span>Cancelar</span></a>
        </li>
       
        <li>
            <a onclick="moveModal('Rechazar', {{ $credit_id }}, '{{ $m_history::CREDIT_REJECTED }}','{{ $status_id }}' , 'dt-check-up')" class="pointer">
                <em class="icon ni ni-cross-round-fill"></em><span>Rechazar</span></a>
        </li>
        <li>
            <a onclick="moveModal('Archivar', {{ $credit_id }}, '{{ $m_history::CREDIT_ARCHIVE }}', '{{ $status_id }}' , 'dt-check-up')" class="pointer">
                <em class="icon ni ni-archive-fill"></em><span>Archivar</span></a>
        </li>
      
    </ul>
</div>
</div>