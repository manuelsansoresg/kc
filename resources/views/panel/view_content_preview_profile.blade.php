<div class="row">
    <div class="col-12">
        <div class="nk-block">
            <div class="profile-ud-list">
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Nombres</span>
                        <span class="profile-ud-value"> {{ $lead->name }} </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Apellidos</span>
                        <span class="profile-ud-value"> {{ $lead->last_name }} {{ $lead->second_last_name }}
                        </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Producto</span>
                        <span class="profile-ud-value">
                            {{ $product != null ? $product->alias : '' }} 
                        </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Organización</span>
                        <span class="profile-ud-value">
                            {{ $agreement != null ? $agreement->name : '' }}
                        </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Tipo de crédito</span>
                        <span class="profile-ud-value">
                            {{ $tipo_credito }} </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Aval</span>
                        <span class="profile-ud-value">
                            @if ($lead->aval_o_garantia !== null)
                            {{ $lead->aval_o_garantia == 1 ? 'Sí' : 'No' }} 
                            @endif
                        </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Buró</span>
                        <span class="profile-ud-value">
                            @if ($lead->consulta_buro !== null)
                            {{ $lead->consulta_buro == 1 ? 'Sí' : 'No' }} 
                            @endif
                         </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-block mt-n5">
            <div class="nk-block-head nk-block-head-line">
                <hr class="preview-hr">
            </div><!-- .nk-block-head -->
            <div class="profile-ud-list">
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Origen</span>
                        <span class="profile-ud-value">
                            {{ $origins[$lead->origin_id] }} </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Canal</span>
                        <span class="profile-ud-value">
                            {{ $channel[$lead->channel_id] }} </span>
                    </div>
                </div>
                <div class="profile-ud-item">
                    <div class="profile-ud wider">
                        <span class="profile-ud-label">Asesor</span>
                        <span class="profile-ud-value"> 
                            @if ($user != null)
                            {{ $user->name }}
                            {{ $user->last_name }} {{ $user->second_last_name }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block mt-n5">
            <div class="nk-block-head nk-block-head-line">
                <hr class="preview-hr">
            </div><!-- .nk-block-head -->
           
        </div>
        <div class="row">
            <div class="col-2">
                <span class="profile-ud-label">Etiquetas</span>
            </div>
            <div class="col-10">
                <ul class="g-1">
                    @foreach ($tags as $tag)
                    <li class="btn-group">
                    <a class="btn btn-xs btn-light btn-dim" href="#"> {{ $tag }} </a>
                    <a class="btn btn-xs btn-icon btn-light btn-dim"><em class="icon ni ni-cross"></em></a>
                </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-2 mt-3">
                <span class="profile-ud-label">Notas</span>
            </div>
            <div class="col-10 mt-3">
                @php
                        $last_note = null;
                    @endphp
                    @if ($notes != null)
                    @foreach ($notes as $row_note)
                        @php
                            $last_note = $row_note->note;
                        @endphp
                        
                    @endforeach
                    <p> {{ $last_note->description }}</p>
                    <p class="text-end text-small">
                      
                            <small>
                                {{ formatDateNameMonth($last_note->created_at) }}
                            </small>
                        
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

