@foreach ($breadcumbs as $breadcumb)
    <li class="breadcrumb-item {{ $breadcumb['active'] == true? 'active' : '' }} ">
        @if ($breadcumb['link'] != null)
            <a {{ $breadcumb['link'] != null? 'href='. $breadcumb['link'].'' : '' }}>
        @endif
         {{ $breadcumb['title'] }} 
            
        @if ($breadcumb['link'] != null)
            </a>    
        @endif
    </li>
@endforeach