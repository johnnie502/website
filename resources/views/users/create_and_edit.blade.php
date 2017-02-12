@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> User / 
                @if($user->id)
                    Edit #{{$user->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>

        @include('error')

        <div class="panel-body">
            @if($user->id)
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('users.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                	<label for="driver-field">Driver</label>
                	<input class="form-control" type="text" name="driver" id="driver-field" value="{{ old('driver', $user->driver ) }}" />
                </div> 
                <div class="form-group">
                    <label for="oauth-field">Oauth</label>
                    <input class="form-control" type="text" name="oauth" id="oauth-field" value="{{ old('oauth', $user->oauth ) }}" />
                </div> 
                <div class="form-group">
                    <label for="unsigned-field">Unsigned</label>
                    <input class="form-control" type="text" name="unsigned" id="unsigned-field" value="{{ old('unsigned', $user->unsigned ) }}" />
                </div> 
                <div class="form-group">
                	<label for="username-field">Username</label>
                	<input class="form-control" type="text" name="username" id="username-field" value="{{ old('username', $user->username ) }}" />
                </div> 
                <div class="form-group">
                	<label for="email-field">Email</label>
                	<input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email ) }}" />
                </div> 
                <div class="form-group">
                	<label for="password-field">Password</label>
                	<input class="form-control" type="text" name="password" id="password-field" value="{{ old('password', $user->password ) }}" />
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $user->type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="status-field">Status</label>
                    <input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $user->status ) }}" />
                </div> 
                <div class="form-group">
                    <label for="points-field">Points</label>
                    <input class="form-control" type="text" name="points" id="points-field" value="{{ old('points', $user->points ) }}" />
                </div> 
                <div class="form-group">
                    <label for="notifications-field">Notifications</label>
                    <input class="form-control" type="text" name="notifications" id="notifications-field" value="{{ old('notifications', $user->notifications ) }}" />
                </div> 
                <div class="form-group">
                	<label for="regip-field">Regip</label>
                	<input class="form-control" type="text" name="regip" id="regip-field" value="{{ old('regip', $user->regip ) }}" />
                </div> 
                <div class="form-group">
                	<label for="lastip-field">Lastip</label>
                	<input class="form-control" type="text" name="lastip" id="lastip-field" value="{{ old('lastip', $user->lastip ) }}" />
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection