@extends('layouts.app')
@section('title')
    @lang('global.topics')
@stop
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <div class="pull-left panel-title">@lang('global.topics')</div>
            @can('create', \App\Models\Topic::class)
                <a class="pull-right" href="{{ route('topics.create') }}">@lang('global.create_topic')</a> 
            @endif
        </div>
        <div class="panel-body remove-padding-horizontal">
            @if($topics->count())
                <ul class="list-group">
                    @foreach($topics as $topic)
                        @if ($topic->nodes->status > 0)
                        <li class="list-group-item">
                            {{ $topic->upVote }}
                            @if ($topic->reply_count > 0)
                                <span class="badge">{{ $topic->reply_count }}</span>
                            @endif
                            <div class="pull-left">
                                <img alt="" src="/avatars/{{ $topic->user }}.png" width="32" height="32"></span>
                            </div>
                            <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a><br>
                            <div>
                                <a href="{{ route('nodes.show', $topic->nodes->slug) }}">{{ $topic->nodes->name }}</a>&nbsp;•&nbsp;
                                <a href="{{ route('users.show', $topic->users->username) }}">{{ $topic->users->username }}</a>&nbsp;•&nbsp;
                            @if (isset($topic->replied_at ))
                                @if ($topic->replied_at->subMonth()->gte(\Carbon\Carbon::now()))
                                    {{ $topic->replied_at->toDateString() }}&nbsp;*&nbsp;
                                @else
                                    {{ $topic->replied_at->diffForHumans() }}&nbsp;•&nbsp;
                                @endif
                                @if ($topic->lastreply > 0)
                                    @lang('global.last_reply'): {{ \App\Models\User::find($topic->lastreply)->username }}
                                @endif
                            @else
                                {{ $topic->created_at->diffForHumans() }}
                            @endif
                            </div>
                        </li>
                        @endif
                    @endforeach
                </ul>
                {!! $topics->links() !!}
            @else
                <div class="empty-block">Empty!</div>
            @endif
        </div>
    </div>
</div>
@stop