<form method="post" id="{{ $name_form }}" action="">
    @csrf
    <span class="preview-title-lg overline-title">Generales</span>
    <div class="row gy-4">
        @foreach ($elements as $element)
        @php
            $indicator_required =  $element['is_required'] == true ? '*' : '';
        @endphp
        @if ($element['type'] == 'text')
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{ $indicator_required }} {{ $element['title']}}</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}">
                </div>
            </div>
        </div>
        @endif
            @if ($element['type'] == 'select2')
                @php
                    $options = $element['options'];
                @endphp
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"> {{ $indicator_required }} {{ $element['title']}}</label>
                        <div class="form-control-wrap">

                            <select class="form-select js-select2" name="{{ $element['name_field'] }}" id="{{ $element['id_field'] }}"
                                data-search="on">
                                <option></option>
                                @foreach ($options as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                                <option value="0">Otro</option>
                            </select>
                        </div>
                    </div>
                    @if ($element['name_field'] == 'agreement_id')
                    <div class="form-group" id="lead-content-agreement" style="display: none">
                        <label class="form-label">Otra organización</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="new_agreement" id="new_agreement">
                        </div>
                    </div>
                    @endif
                    
                </div>
            @endif
        @endforeach
        
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
