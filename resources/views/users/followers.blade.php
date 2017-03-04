@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($followers as $follower)
        {{ $follower->username }}
    @endforeach
</div>
@endsection