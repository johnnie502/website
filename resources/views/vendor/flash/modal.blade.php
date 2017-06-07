<template>
    <modal
        v-modal="flash-modal"
        title="{{ $title }}"
        @on-ok="ok">
        <p>{!! $body !!}</p>
    </modal>
</template>