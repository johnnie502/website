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
    </div>
</div>
@endsection