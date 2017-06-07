// Breadcrumbs for iView
@if ($breadcrumbs)
    <template>
        <breadcrumb>
	        @foreach ($breadcrumbs as $breadcrumb)
	            @if (!$breadcrumb->last)
	                <breadcrumb-item href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</breadcrumb-item>
	            @else
	                <breadcrumb>{{ $breadcrumb->title }}</breadcrumb>
	            @endif
	        @endforeach
        </breadcrumb>
    </template>
@endif