@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($replies as $reply)
        {{ $reply->content }}
    @endforeach
</div>
@endsection