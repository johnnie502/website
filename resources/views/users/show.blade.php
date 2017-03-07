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
                    {{ $user->points }}
               </div>
               <!-- Tabs -->
               <ul class="nav nav-tabs">
                   <li class="{{ Route::currentRouteName() == 'users.topics' ? 'active' : '' }}"><a href="{{ route('users.topics', $user->username) }}">@lang('global.topics')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.replies' ? 'active' : '' }}"><a href="{{ route('users.replies', $user->username) }}">@lang('global.repiles')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.created_wiki' ? 'active' : '' }}"><a href="{{ route('users.created_wiki', $user->username) }}">@lang('global.created_wiki')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.edited_wiki' ? 'active' : '' }}"><a href="{{ route('users.edited_wiki', $user->username) }}">@lang('global.edited_wiki')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.comments' ? 'active' : '' }}"><a href="{{ route('users.comments', $user->username) }}">@lang('global.comments')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.followers' ? 'active' : '' }}"><a href="{{ route('users.followers', $user->username) }}">@lang('global.followers')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.following' ? 'active' : '' }}"><a href="{{ route('users.following', $user->username) }}">@lang('global.following')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.votes' ? 'active' : '' }}"><a href="{{ route('users.votes', $user->username) }}">@lang('global.votes')</a></li>
                   <li class="{{ Route::currentRouteName() == 'users.favicons' ? 'active' : '' }}"><a href="{{ route('users.favicons', $user->username) }}">@lang('global.favicons')</a></li>
                   @if (Auth::check() && $account->id == $user->id)
                   <li class="{{ Route::currentRouteName() == 'users.notifications' ? 'active' : '' }}"><a href="{{ route('users.notifications', $user->username) }}">@lang('global.notifications')</a></li>
                   @endif
            </ul>
            <!-- Tabs content -->
            <div class="tab-content">
                <div class="tab-pane" id="topics">
                    @if ($user->topic > 0)
                    <ul class="list-group">
                        @foreach($user->topics as $topic)
                        <li class="list-group-item">
                            @if ($topic->replies > 0)
                            <span class="badge">{{ $topic->replies }}</span>
                            @endif
                            <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a><br>
                            <div>
                                <a href="{{ route('nodes.show', $topic->nodes->slug) }}">{{ $topic->nodes->name }}</a>&nbsp;•&nbsp;
                            @if (isset($topic->replytime ))
                                {{ $topic->replytime->diffForHumans() }}&nbsp;•&nbsp;
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
        </div>
    </div>
</div>
@endsection