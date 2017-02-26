@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
                <div class="row">
               </div>
<label>Username</label>
<p>
	{{ $users->username }}
</p> <label>Email</label>
<p>
	{{ $users->email }}
</p><label>Points</label>
<p>
	{{ $users->points }}
</p> 
        </div>
    </div>
</div>
@endsection