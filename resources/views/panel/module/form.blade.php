<form method="post" id="{{ $name_form }}" action="">
    @csrf
    @php
        $name_button = isset($name_button)? $name_button : 'Guardar';
    @endphp

    <div class="row gy-4">
        @foreach ($elements as $element)
            @php
                $indicator_required = $element['is_required'] == true ? '*' : '';
                $value = isset($element['value'])? $element['value'] : null;
            @endphp
            @if ($element['title_section'] != '')
                <span class="preview-title-lg overline-title">{{ $element['title_section'] }}</span>
            @endif
            @if ($element['type'] == 'text')
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" {{ $element['is_disabled'] }}
                                name="{{ $element['name_field'] }}" placeholder="{{ $element['placeholder'] }}"
                                id="{{ $element['id_field'] }}" value="{{ $value }}">
                            @if ($element['comment_admin'] != null)
                                <small>{{ $element['comment_admin'] }}</small>
                            @endif
                            @if ($element['comment_webApp'] != null)
                                <small>{{ $element['comment_webApp'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            @if ($element['type'] == 'textarea')
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <textarea type="text" class="form-control" {{ $element['is_disabled'] }}
                                name="{{ $element['name_field'] }}" placeholder="{{ $element['placeholder'] }}"
                                id="{{ $element['id_field'] }}">{{ $value }}</textarea>
                            @if ($element['comment_admin'] != null)
                                <small>{{ $element['comment_admin'] }}</small>
                            @endif
                            @if ($element['comment_webApp'] != null)
                                <small>{{ $element['comment_webApp'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
           
            @if ($element['type'] == 'href')
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <div class="form-control-wrap">
                           <a target="{{ $element['target'] }}" class="{{ isset($element['class']) && $element['class'] != null? $element['class'] : '' }}" 
                           {{ isset($element['onclick']) && $element['onclick'] != null? 'onclick='. $element['onclick'].'' : '' }}
                           {{ isset($element['link']) && $element['link'] != null? 'href='. $element['link'].'' : '' }}>{{ $element['title'] }}</a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($element['type'] == 'number')
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control" {{ $element['is_disabled'] }}
                                name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}" value="{{ $value }}">
                            @if ($element['comment_admin'] != null)
                                <small>{{ $element['comment_admin'] }}</small>
                            @endif
                            @if ($element['comment_webApp'] != null)
                                <small>{{ $element['comment_webApp'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if ($element['type'] == 'date')
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="date" class="form-control" {{ $element['is_disabled'] }}
                                name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}" value="{{ $value }}">
                            @if ($element['comment_admin'] != null)
                                <small>{{ $element['comment_admin'] }}</small>
                            @endif
                            @if ($element['comment_webApp'] != null)
                                <small>{{ $element['comment_webApp'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($element['type'] == 'email')
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="email" class="form-control" {{ $element['is_disabled'] }}
                                name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}"  value="{{ $value }}">
                            @if ($element['comment_admin'] != null)
                                <small>{{ $element['comment_admin'] }}</small>
                            @endif
                            @if ($element['comment_webApp'] != null)
                                <small>{{ $element['comment_webApp'] }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if ($element['type'] == 'switch')
                @php
                    $options_switch = $element['options'];
                @endphp
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="preview-block"><span class="preview-title form-label"> {{ $indicator_required }} {{ $element['title'] }}</span>
                        @foreach ($options_switch as $key => $option_switch)
                            <div class="custom-control custom-radio"><input type="radio" id="{{ $element['id_field'] }}_{{ $key }}"
                                    name="{{ $element['name_field'] }}" class="custom-control-input" value="{{ $key }}"
                                    ><label
                                    class="custom-control-label" for="{{ $element['id_field'] }}_{{ $key }}">{{ $option_switch }}
                                    &nbsp;</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($element['type'] == 'select2')
                @php
                    $options = $element['options'];
                    $is_option_array = $element['is_option_array'];
                @endphp
                <div class="{{ isset($element['col'])? $element['col'] : 'col-md-6'  }}">
                    <div class="form-group">
                        <label class="form-label"> {{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">

                            <select class="form-select js-select2" {{ $element['is_disabled'] }}
                                name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}" data-search="on">
                                <option></option>
                                @if ($options != null && $is_option_array == false)
                                    @foreach ($options as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                @endif
                                @if ($options != null && $is_option_array == true)
                                    @foreach ($options as $key => $option)
                                        <option value="{{ $key }}"> {{ $option }}</option>
                                    @endforeach
                                @endif
                                @if ($element['name_field'] == 'agreement_id')
                                    <option value="0">Otro</option>
                                @endif
                            </select>
                            @if ($element['comment_admin'] != null)
                                <small>{{ $element['comment_admin'] }}</small>
                            @endif
                            @if ($element['comment_webApp'] != null)
                                <small>{{ $element['comment_webApp'] }}</small>
                            @endif
                        </div>
                    </div>
                    @if ($element['name_field'] == 'agreement_id')
                        <div class="form-group" id="lead-content-agreement" style="display: none">
                            <label class="form-label">Otra organización</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="new_agreement" id="new_agreement">
                                @if ($element['comment_admin'] != null)
                                    <small>{{ $element['comment_admin'] }}</small>
                                @endif
                                @if ($element['comment_webApp'] != null)
                                    <small>{{ $element['comment_webApp'] }}</small>
                                @endif
                            </div>
                        </div>
                    @endif



                </div>
            @endif
            @if ($element['title_section'] == 'Referencias')
                <div class="py-2">
                    <div class="float-end">
                        <a href="/panel/reference/controlDesk/{{ $history_id }}/form?step={{ isset($_GET['step']) ? '?step=' . $_GET['step'] : null }}"
                            class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                    </div>
                    <div class="row gy-4 mt-3">



                        <table id="dt-credit-reference" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido paterno</th>
                                    <th>Apellido materno</th>
                                    <th>Relación</th>
                                    <th></th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            @endif
            @if ($element['type'] == 'hidden')
            <input type="hidden" class="form-control" name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}" value="{{ $value }}">
            @endif
        @endforeach

        <input type="hidden" id="type_form" value="{{ $type_form }}">
        <input type="hidden" id="history_id" name="history_id" value="{{ $history_id }}">
        @if ($type_form != 31)
        @if (!isset($show_btn))
            <div class="col-12">
                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                    <li>
                        {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                        <button class="btn btn-primary">{{ $name_button }}</button>
                    </li>
                </ul>
            </div>
        @endif
            
        @endif
    </div>
</form>
