<div class="drodown"><a href="#"
    class="dropdown-toggle btn btn-icon btn-trigger"
    data-bs-toggle="dropdown"><em
        class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
    <ul class="link-list-opt no-bdr">
        @for ($i_option = 0; $i_option < count($options); $i_option++)
             <li>
                <a class="pointer" {{ $options[$i_option]['link'] != '' ? 'href='.$options[$i_option]['link'].'' : '' }}>
                    <em class="icon ni ni-card-view"></em><span>{{ $options[$i_option]['name']}}</span></a>
            </li>
            
        @endfor
       
       
       
        
    </ul>
</div>
</div>