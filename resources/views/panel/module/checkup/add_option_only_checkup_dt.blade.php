@inject('m_history', 'App\Models\HistoryLog')
<div class="content-options">
    <ul class="nk-tb-actions gx-1">
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a class="btn btn-trigger btn-icon" href="https://web.whatsapp.com/send/?phone={{ $client->cellphone }}&text&type=phone_number&app_absent=0"  data-bs-toggle="tooltip" data-bs-placement="top" target="_blank" title="WhatsApp">
                <em class="icon ni ni-whatsapp"></em><span></span></a>
        </li>
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a onclick="showModalActions({{ $credit_id }}, false)" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver acciones">
                <em class="icon ni ni-calendar"></em>
            </a>
    
        </li>
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a class="btn btn-trigger btn-icon" href="/panel/credit/{{ $credit_id }}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Ver perfíl de crédito">
                <em class="icon ni ni-report-profit"></em><span></span></a>
        
        </li>
       
        <li>
            <div class="drodown">
                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger d-none d-md-block" data-bs-toggle="dropdown">
                    <em
                        class="icon ni ni-more-h"></em>
                </a>
               
                <a href="#" class="dropdown-toggle btn btn-primary  d-block d-md-none" data-bs-toggle="dropdown">
                    <em class="icon ni ni-more-h"></em>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <ul class="link-list-opt no-bdr">
                        <li>
                            <a class="pointer" href="/panel/template/steps/{{ $route }}/{{ $id }}/show">
                                <em class="icon ni ni-list-thumb-fill"></em><span class="text-dark">Ver etapas</span></a>
                        </li>
                        @if ($percent_form == 100)
                            <li>
                                <a class="pointer" target="_blank" href="/reporte/{{ $id }}">
                                    <em class="icon ni ni-reports"></em><span>Ver reporte</span></a>
                            </li>
                        @endif

                        @if ($status_id == 6)
                        <li>
                            <a class="pointer" onclick="copyToClipBoardReport()">
                                <em class="icon ni ni-copy"></em><span>copiar URL</span></a>
                        </li>
                        @endif
                        <li>
                            <a class="pointer" onclick="modalNote({{ $credit_id }}, 'credit')">
                                <em class="icon ni ni-note-add"></em><span>Agregar nota</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="showNotes({{ $credit_id }}, false)">
                                <em class="icon ni ni-notes-alt"></em><span>Notas</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="modalCreditTag({{ $credit_id }})">
                                <em class="icon ni ni-tag"></em><span>Etiquetas</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="actionModal({{ $credit_id }}, true, false)">
                                <em class="icon ni ni-calendar-check-fill"></em><span>Agregar acción</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="showModalActions({{ $credit_id }}, false)">
                                <em class="icon ni ni-calendar"></em><span>Ver acciones</span></a>
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
                            <a class="pointer" href="https://web.whatsapp.com/send/?phone={{ $client->cellphone }}&text&type=phone_number&app_absent=0" target="_blank">
                                <em class="icon ni ni-whatsapp"></em><span>Whatsapp</span></a>
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
                        <li>
                            <a onclick="modalAdvisorCredit({{ $credit_id }})" class="pointer">
                                <em class="icon ni ni-headphone"></em><span>Asignar asesor</span></a>
                        </li>
                    </ul>
                    <input type="hidden" id="url_report" value="{{ asset('reporte/'.$id ) }}">
                </div>
            </div>
        </li>
    </ul>
</div>


