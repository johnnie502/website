@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>User / Show #{{$user->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('users.edit', $user->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <label>Driver</label>
<p>
	{{ $user->driver }}
</p> <label>Oauth</label>
<p>
	{{ $user->oauth }}
</p> <label>Unsigned</label>
<p>
	{{ $user->unsigned }}
</p> <label>Username</label>
<p>
	{{ $user->username }}
</p> <label>Email</label>
<p>
	{{ $user->email }}
</p> <label>Password</label>
<p>
	{{ $user->password }}
</p> <label>Type</label>
<p>
	{{ $user->type }}
</p> <label>Status</label>
<p>
	{{ $user->status }}
</p> <label>Points</label>
<p>
	{{ $user->points }}
</p> <label>Notifications</label>
<p>
	{{ $user->notifications }}
</p> <label>Regip</label>
<p>
	{{ $user->regip }}
</p> <label>Lastip</label>
<p>
	{{ $user->lastip }}
</p>
        </div>
        
    </div>
</div>

@endsection
