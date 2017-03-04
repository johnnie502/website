@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($notifications as $notification)
        {{ $notification->content }}
    @endforeach
</div>
@endsection