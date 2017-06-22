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
        <div class="panel-body">
            @if($user->id)
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('users.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                <div class="form-group">
                	<label for="username-field">Username</label>
                	<input class="form-control" type="text" name="username" id="username-field" value="{{ old('username', $user->username ) }}" required placeholder="5~20个字符"/>
                </div> 
                <div class="form-group">
                	<label for="email-field">Email</label>
                	<input class="form-control" type="email" name="email" id="email-field" value="{{ old('email', $user->email ) }}" required placeholder="5~30个字符"/>
                </div> 
                <div class="form-group">
                	<label for="password-field">Password</label>
                	<input class="form-control" type="text" name="password" id="password-field" value="{{ old('password') }}" required placeholder="8~50个字符，要求包含大小写字母和数字"/>
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $user->type ) }}">
                </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-link pull-right" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-backward"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop