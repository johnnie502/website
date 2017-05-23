@extends('layouts.app')
@section('title')
    @lang('global.view_user'): {{ $user->username }}
@stop
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
                <div class="row">
                    <div>{{ $user->username }}，{{ config('app.name') }}第{{ $user->id }}号会员，注册于{{ $user->created_at }}。</div>
                    <div class="pull-right"><img alt="{{ $user->username }}" src="/avatars/{{ $user->id }}.png" width="128" height="128">
	           </div>
               <!-- Tabs -->
               <ul class="nav nav-tabs">
                   <li class="active'"><a data-toggle="pill" href="{{ route('users.show', $user->username) . '#topics' }}">@lang('global.topics')</a></li>
                   <li><a data-toggle="pill" href="{{ route('users.show', $user->username . '#replies' ) }}">@lang('global.replies')</a></li>
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
                            @if ($topic->reply_count > 0)
                            <span class="badge">{{ $topic->reply_count }}</span>
                            @endif
                            <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a><br>
                            <div>
                                <a href="{{ route('nodes.show', $topic->nodes->slug) }}">{{ $topic->nodes->name }}</a>&nbsp;•&nbsp;
                            @if (isset($topic->replied_at ))
                                {{ $topic->replied_at }}&nbsp;•&nbsp;
                                @lang('global.last_reply')
                            @else
                                {{ $topic->created_at }}
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
                  <ul class="list-group">
                        @foreach($user->posts as $reply)
                            @if ($reply->post > 0)
                                <li class="list-group-item">
                                    <a href="{{ route('topics.show', $reply->topics->id) }}">{{ $reply->topics->title }}</a>
                                    <a href="{{ route('topics.posts.show', [$reply->topic, $reply->id]) }}">{{ substr($reply->content. 0, 100) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                  <div>empty!</div>                
                @endif
            </div>
            <div class="tab-pane fade" id="created_wiki">
                @if ($user->wiki_count > 0)
                    <ul class="list-group">
                        @foreach ($user->wikis as $wiki)
                            @if ($wiki->version == 1)
                            <li class="list-group-item">
                                <a href="{{ route('wiki.show', $wiki->title) }}">{{ $wiki->title }}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div>empty!</div> 
                @endif
            </div>
            <div class="tab-pane-fade" id="edited_wiki">
                @if ($user->wiki_count > 0)
                    <ul class="list-group">
                        @foreach ($user->wikis as $wiki)
                            @if ($wiki->version > 1)
                            <li class="list-group-item">
                                <a href="{{ route('wiki.show', $wiki->title) }}">{{ $wiki->title }}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div>empty!</div> 
                @endif
            </div>
            <div class="tab-pane-fade" id="followers">
                <ul class="list-group"> 
                    @foreach ($user->followers(User::class) as $follower)
                        <li class="list-group-item">
                            <a href={{ route('users.show', $follower->username) }}>{{ $follower->username }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane-fade" id="following">
                <ul class="list-group"> 
                    @foreach ($user->followings() as $following)
                        <li class="list-group-item">
                            <a href={{ route('users.show', $following->username) }}>{{ $following->username }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="points">
                <ul class="list-group">
                        @foreach ($user->points as $point)
                            <li class="list-group-item">{{ $point->got_at }} {{ $point->point }} {{ $user->signed }} {{ $point->total_points }}</li>
                        @endforeach
                    </ul>
            </div>
        </div>
    </div>
</div>
@stop