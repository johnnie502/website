@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => session('flash_notification.title'),
            'body'       => session('flash_notification.message')
        ])
    @else
        <template>
        <alert type="{{ session('flash_notification.level') }}" show-icon
            {{ session()->has('flash_notification.important') ? 'closeable' : '' }}"
        >
            {!! session('flash_notification.message') !!}
        </alert>
    @endif
@endif
