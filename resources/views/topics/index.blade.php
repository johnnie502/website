@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <div class="pull-left panel-title">@lang('global.topics')</div>
        </div>
        <div class="panel-body remove-padding-horizontal">
            @if($topics->count())
                <ul class="list-group">
                    @foreach($topics as $topic)
                        @if ($topic->nodes->status > 0)
                        <li class="list-group-item">
                            @if ($topic->replies > 0)
                            <span class="badge">{{ $topic->replies }}</span>
                            @endif
                            <div class="pull-left">
                                <img alt="" src="/avatars/{{ $topic->user }}.png" width="32" height="32" /></span>
                            </div>
                            <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a><br>
                            <div>
                                <a href="{{ route('nodes.show', $topic->nodes->slug) }}">{{ $topic->nodes->name }}</a>&nbsp;•&nbsp;
                                <a href="{{ route('users.show', $topic->users->username) }}">{{ $topic->users->username }}</a>&nbsp;•&nbsp;
                            @if (isset($topic->replytime ))
                                {{ $topic->replytime->diffForHumans() }}&nbsp;•&nbsp;
                                @lang('global.last_reply')
                            @else
                                {{ $topic->created_at->diffForHumans() }}
                            @endif
                            </div>
                        </li>
                        @endif
                    @endforeach
                </ul>
                {!! $topics->render() !!}
            @else
                <div class="empty-block">Empty!</div>
            @endif
        </div>
    </div>
</div>
@endsection