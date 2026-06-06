@php
    $alertTypes = [
        'primary'   => 'ri-user-smile-line',
        'secondary' => 'ri-check-double-line',
        'success'   => 'ri-notification-off-line',
        'danger'    => 'ri-error-warning-line',
        'warning'   => 'ri-alert-line',
        'info'      => 'ri-airplay-line',
        'light'     => 'ri-mail-line',
        'dark'      => 'ri-refresh-line'
    ];
@endphp

@foreach ($alertTypes as $type => $icon)
    @if(session()->has($type))
        <div class="alert alert-{{ $type }} alert-border-left alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="{{ $icon }} me-2 fs-4"></i>
            <div>
                <strong>{{ ucfirst($type) }}:</strong> {{ session()->get($type) }}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach
