@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
                <div class="row">
                    <label>@lang('global.username')</label>
	           {{ $user->username }}
                    <label>@lang('global.email')</label>
                   {{ $user->email }}
                    <label>@lang('global.points')</label>
                    {{ $user->point }}
               </div>
               <!-- Tabs -->
               <ul class="nav nav-tabs">
                   <li class="active'"><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#topics' }}">@lang('global.topics')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username . '#replies' ) }}">@lang('global.repiles')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#created_wiki' }}">@lang('global.created_wiki')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#edited_wiki' }}">@lang('global.edited_wiki')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#comments' }}">@lang('global.comments')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username . '#followers' ) }}">@lang('global.followers')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username . '#following' ) }}">@lang('global.following')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#votes' }}">@lang('global.votes')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#favicons' }}">@lang('global.favicons')</a></li>
                   @if (Auth::check() && $account->id == $user->id)
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#points' }}">@lang('global.points')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#notifications' }}">@lang('global.notifications')</a></li>
                   @endif
            </ul>
            <!-- Tabs content -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="topics">
                    @if ($user->topic_count > 0)
                    <ul class="list-group">
                        @foreach($user->topics as $topic)
                        <li class="list-group-item">
                            @if ($topic->replies > 0)
                            <span class="badge">{{ $topic->replies }}</span>
                            @endif
                            <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a><br>
                            <div>
                                <a href="{{ route('nodes.show', $topic->nodes->slug) }}">{{ $topic->nodes->name }}</a>&nbsp;•&nbsp;
                            @if (isset($topic->replied_at ))
                                {{ $topic->replied_at->diffForHumans() }}&nbsp;•&nbsp;
                                @lang('global.last_reply')
                            @else
                                {{ $topic->created_at->diffForHumans() }}
                            @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                @else
                    <div>empty!</div>
                @endif
            </div>
            <div class="tab-pane fade" id="replies">
                @if ($user->reply_count > 0)
                  <div></div>
                @else
                  <div>empty!</div>                
                @endif
            </div>
        </div>
    </div>
</div>
@endsection