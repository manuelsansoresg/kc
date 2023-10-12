<div class="drodown"> <a href="#" class="dropdown-toggle btn btn-icon btn-trigger d-none d-md-block" data-bs-toggle="dropdown">
    <em
        class="icon ni ni-more-h"></em>
</a>

<a href="#" class="dropdown-toggle btn btn-primary  d-block d-md-none" data-bs-toggle="dropdown">
    <em
        class="icon ni ni-more-h"></em>
</a>
<div class="dropdown-menu dropdown-menu-end">
    <ul class="link-list-opt no-bdr">
        @for ($i_option = 0; $i_option < count($options); $i_option++)
             <li>
                <a class="pointer" {{ $options[$i_option]['link'] != '' ? 'href='.$options[$i_option]['link'].'' : '' }}
                        {{ $options[$i_option]['onclick'] != '' ? 'onclick='.$options[$i_option]['onclick'].'' : '' }}
                        {{ isset($options[$i_option]['target']) != '' ? 'target='.$options[$i_option]['target'].'' : '' }}
                        >
                    <em class="{{ isset($options[$i_option]['icon'])? $options[$i_option]['icon'] : 'icon ni ni-view-list-wd' }}"></em>
                    <span class="{{ isset($options[$i_option]['class']) ? $options[$i_option]['class'] : null }}">{{ $options[$i_option]['name']}}</span></a>
            </li>
            
        @endfor
       
       
       
        
    </ul>
</div>
</div>