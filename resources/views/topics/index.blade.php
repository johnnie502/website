@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">@lang('global.topics')</div>
        <div class="panel-body">
            @if($topics->count())
                <ul class="list-group">
                    @foreach($topics as $topic)
                        <li class="list-group-item">
                            @if ($topic->replies > 0)
                            <span class="badge">{{ $topic->replies }}</span>
                            @endif
                            <span><img alt="" src="/avatars/{{ $topic->user }}.png" width="32" height="32" /></span>
                            <span><a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a></span><br>
                            <span><a href="{{ route('nodes.show', $topic->nodes->name) }}">{{ $topic->nodes->name }}</a></span>&nbsp;•&nbsp;
                            <span><a href="{{ route('users.show', $topic->user) }}">{{ $topic->users->username }}</a></span>&nbsp;•&nbsp;
                            @if (isset($topic->replytime ))
                            <span>{{ $topic->replytime->diffForHumans() }}</span>&nbsp;•&nbsp;
                            <span>@lang('global.last_reply') . ' ' . </span>
                            @else
                            <span>{{ $topic->created_at->diffForHumans() }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                {!! $topics->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>
@endsection