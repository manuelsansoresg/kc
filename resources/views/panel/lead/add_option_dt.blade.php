@php
$user = Auth::user();
@endphp
@inject('m_history', 'App\Models\HistoryLog')
<div class="content-options">
    <ul class="nk-tb-actions gx-1">
        @if ($lead->manychat_id != null)
            <li class="nk-tb-action-hidden d-sm-none d-md-block">
            
                <a class="btn btn-trigger btn-icon" href="https://manychat.com/fb861553/chat/{{ $lead->manychat_id }}"  data-bs-toggle="tooltip" data-bs-placement="top" target="_blank">
                    <em class="icon ni ni-whatsapp"></em><span></span>  </a>
            </li>
        @endif
        
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a href="/panel/lead/{{ $id }}/profile" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfíl">
                <em class="icon ni ni-user-fill"></em>
            </a>
    
        </li>
        <li class="nk-tb-action-hidden d-sm-none d-md-block">
            <a class="btn btn-trigger btn-icon" href="/panel/lead/{{ $id }}/edit"  data-bs-toggle="tooltip" data-bs-placement="top">
                <em class="icon ni ni-edit"></em><span></span></a>
        
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
                        @if ($validate['error'] === true)
                            <li>
                                <a class="pointer" onclick="modalValidate({{ $id }}, 'lead', 'dt-lead')">
                                    <em class="icon ni ni-arrow-right-circle"></em>Continuar</span></a>
                            </li>
                        @else
                            <li>
                                <a class="pointer moveElement"  onclick="moveElement('lead', {{ $id }})">
                                    <em class="icon ni ni-arrow-right-circle"></em>Continuar</span></a>
                            </li>
                        @endif
                       
                       
                        <li>
                            <a class="pointer" onclick="modalNote({{ $id }}, 'lead')">
                                <em class="icon ni ni-note-add"></em><span>Agregar nota</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="showNotes({{ $id }}, true)">
                                <em class="icon ni ni-notes-alt"></em><span>Notas</span></a>
                        </li>
                        <li>
                            <a href="/panel/lead/{{ $id }}/profile">
                                <em class="icon ni ni-user-fill"></em><span>Perfíl</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="modalPreviewProfile({{ $id }})">
                                <em class="icon ni ni-user-list-fill"></em><span>Vistazo</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="modalTags({{ $id }})">
                                <em class="icon ni ni-tag"></em><span>Etiquetas</span></a>
                        </li>
                  
                        <li>
                            <a class="pointer" onclick="actionModal({{ $id }}, true, true)">
                                <em class="icon ni ni-calendar-check-fill"></em><span>Agregar acción</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="showModalActions({{ $id }}, true)">
                                <em class="icon ni ni-calendar"></em><span>Ver acciones</span></a>
                        </li>
                        @if ($user->hasRole('Asesor') != true)
                            <li>
                                <a class="pointer" onclick="modalAdvisor({{ $id }})">
                                    <em class="icon ni ni-headphone"></em><span>Asignar asesor</span></a>
                            </li>
                        @endif
                        <li>
                            <a class="pointer" onclick="modalValidate({{ $id }}, 'lead')">
                                <em class="icon ni ni-alert-circle-fill"></em><span>Ver validaciónes</span></a>
                        </li>
                        <li>
                            <a class="pointer" onclick="moveModalLead('Archivar', {{ $id }}, '{{ $m_history::LEAD_ARCHIVE }}', '{{ $m_history::CREATE_PROSPECT }}', 'dt-lead')">
                                <em class="icon ni ni-archive"></em><span>Archivar</span></a>
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
</div>