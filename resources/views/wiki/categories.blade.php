@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1></h1>
        </div>
        <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group">
                            @foreach ($wikis as $wiki)
                                <li class="list-group-item">
                            <div class="pull-left">
                                <img alt="" src="/avatars/{{ $wiki->user }}.png" width="32" height="32" /></span>
                            </div>
                            <a href="{{ route('wiki.show', $wiki->title) }}">{{ $wiki->title }}</a><br>
                            <div>
                                <a href="{{ route('users.show', $wiki->users->username) }}">{{ $wiki->users->username }}</a>&nbsp;•&nbsp;
                            </div>
                        </li>
                            @endforeach
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection