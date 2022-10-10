
@foreach ($notifications as $row_notification)
<div class="nk-notification-item dropdown-inner">
    <div class="nk-notification-icon">
        <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
    </div>
    <div class="nk-notification-content">
        <div class="nk-notification-text">{{ $row_notification['body'] }}</div>
        <div class="nk-notification-time">{{ $row_notification['date']->diffForHumans() }}</div>
    </div>
</div>
@endforeach