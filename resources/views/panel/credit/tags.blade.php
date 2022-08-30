<ul class="g-1">
    @foreach ($tags as $credit_tag)
    @php
        $tag = $credit_tag->tag;
    @endphp
    <li class="btn-group">
        
        <a class="btn btn-xs btn-light btn-dim"> {{ $tag->name }}</a>
        <a class="btn btn-xs btn-icon btn-light btn-dim" onclick="deleteTag({{$credit_tag->id}})"><em class="icon ni ni-cross"></em></a>
    </li>
    @endforeach
</ul>