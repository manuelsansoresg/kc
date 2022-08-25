@if ($client !== null)
<div class="user-card">
    <div class="user-info">
        <span class="tb-lead">{{ $client->name }} {{ $client->last_name }} <span class="dot dot-success d-md-none ms-1"></span>
       </span><span>{{ $client->email }}</span>
    </div>
</div>
@endif
