@inject('m_file', 'App\Models\File')

@php
    $path = $m_file::PATH;
@endphp
<div class="row">

    @foreach ($files as $file)
    <div class="col-12 col-md-3 mt-4">
        <img src="{{ asset($path.'/'.$file->name) }}" alt="">
        <p class="text-center mt-3">
            <a onclick="deleteFile({{ $model }},{{ $file->id }})" class="btn btn-danger btn-sm">Borrar</a>
        </p>
    </div>
    @endforeach
</div>