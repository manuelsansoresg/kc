@inject('m_file', 'App\Models\File')

@php
    $path = $m_file::PATH;
@endphp
<div class="col-12 col-md-3 mt-4">
    @if (strstr($file->name, '.pdf'))
        <div class="tex-center col-12">
            <em class="icon ni ni-file-pdf h2 text-center"></em>
        </div>
    @else
        <img src="{{ asset($path.'/'.$file->name) }}" alt="">
    @endif
    <p class="text-center mt-3">
        <a onclick="deleteFileTemplate({{ $model }},{{ $file->id }})" class="btn btn-danger btn-sm">Borrar</a>
    </p>
</div>