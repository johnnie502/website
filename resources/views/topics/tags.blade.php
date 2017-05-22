@extends('layouts.app')
@section('title')
    @lang('global.tags'): {{ $topics->first()->tags->first() }}
@stop
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
                            @foreach ($topics as $topic)
                                <li class="list-group-item">
                            @if ($topic->reply_count > 0)
                            <span class="badge">{{ $topic->reply_count }}</span>
                            @endif
                            <div class="pull-left">
                                <img alt="" src="/avatars/{{ $topic->user }}.png" width="32" height="32" /></span>
                            </div>
                            <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a><br>
                            <div>
                                <a href="{{ route('nodes.show', $topic->nodes->slug) }}">{{ $topic->nodes->name }}</a>&nbsp;•&nbsp;
                                <a href="{{ route('users.show', $topic->users->username) }}">{{ $topic->users->username }}</a>&nbsp;•&nbsp;
                            @if (isset($topic->replied_at ))
                                {{ $topic->replied_at->diffForHumans() }}&nbsp;•&nbsp;
                                @lang('global.last_reply')
                            @else
                                {{ $topic->created_at->diffForHumans() }}
                            @endif
                            </div>
                        </li>
                            @endforeach
                    </div>
                </div>
        </div>
    </div>
</div>
@stop