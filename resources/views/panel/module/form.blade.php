<form method="post" id="{{ $name_form }}" action="">
    @csrf

    <div class="row gy-4">
        @foreach ($elements as $element)
            @php
                $indicator_required = $element['is_required'] == true ? '*' : '';
            @endphp
            @if ($element['title_section'] != '')
                <span class="preview-title-lg overline-title">{{ $element['title_section'] }}</span>
            @endif
            @if ($element['type'] == 'text')
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" {{ $element['is_disabled'] }} name="{{ $element['name_field'] }}"
                                placeholder="{{ $element['placeholder'] }}" id="{{ $element['id_field'] }}">
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

            @if ($element['type'] == 'number')
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control" {{ $element['is_disabled'] }} name="{{ $element['name_field'] }}"
                                id="{{ $element['id_field'] }}">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">
                            <input type="date" class="form-control" {{ $element['is_disabled'] }} name="{{ $element['name_field'] }}"
                                id="{{ $element['id_field'] }}">
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
            @if ($element['type'] == 'select2')
                @php
                    $options = $element['options'];
                    $is_option_array = $element['is_option_array'];
                @endphp
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"> {{ $indicator_required }} {{ $element['title'] }}</label>
                        <div class="form-control-wrap">

                            <select class="form-select js-select2" {{ $element['is_disabled'] }} name="{{ $element['name_field'] }}"
                                id="{{ $element['id_field'] }}" data-search="on">
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
        @endforeach
        
        <input type="hidden" id="type_form" value="{{ $type_form }}">

        <div class="col-12">
            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                <li>
                    {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                    <button class="btn btn-primary">Guardar</button>
                </li>
            </ul>
        </div>
    </div>
</form>
