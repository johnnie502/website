@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($topics as $topic)
        {{ $topic->title }}
    @endforeach
</div>
@endsection