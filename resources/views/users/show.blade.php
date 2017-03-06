@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
                <div class="row">
               </div>
<label>@lang('global.username')</label>
<p>
	{{ $user->username }}
</p> <label>@lang('global.email')</label>
<p>
	{{ $user->email }}
</p><label>@lang('global.points')</label>
<p>
	{{ $user->points }}
</p> 
        </div>
        <ul class="nav nav-tabs">
        <li class="{{ Route::currentRouteName() == 'users.topics' ? 'active' : '' }}"><a href="{{ route ('users.topics', $user-username) }}">@lang('global.topics')</a></li>
        <li class="{{ Route::currentRouteName() == 'users.replies' ? 'active' : '' }}"><a href="{{ route ('users.replies', $user-username) }}">@lang('global.repiles')</a></li>
        <li class="{{ Route::currentRouteName() == 'users.notifications' ? 'active' : '' }}"><a href="{{ route ('users.topics', $user-username) }}">@lang('global.notifications')</a></li>
</ul>
        <li class="{{ Route::currentRouteName() == 'users.followers' ? 'active' : '' }}"><a href="{{ route ('users.topics', $user-username) }}">@lang('global.followers')</a></li>
        <li class="{{ Route::currentRouteName() == 'users.topics' ? 'active' : '' }}"><a href="{{ route ('users.followings', $user-username) }}">@lang('global.followings')</a></li>
    </div>
</div>
@endsection