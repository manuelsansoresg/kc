@foreach ($breadcumbs as $breadcumb)
    <li class="breadcrumb-item {{ $breadcumb['active'] == true? 'active' : '' }} "><a {{ $breadcumb['link'] != null? 'href='. $breadcumb['link'].'' : '' }} target="_blank"> <span class="text-primary"> {{ $breadcumb['title'] }} <i class="fa-solid fa-arrow-up-right-from-square"></i> </span>  </a></li>
@endforeach