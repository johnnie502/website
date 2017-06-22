@if ($paginator->hasPages())
    <template>
        <page total="{{ $results->count() }}"></page>
    </template>
@endif
