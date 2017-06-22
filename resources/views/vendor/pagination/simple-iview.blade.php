@if ($paginator->hasPages())
    <template>
        <page :current="{{ $results->currentPage() }}" :total="{{ $results->count() }}" simple></page>
@endif
