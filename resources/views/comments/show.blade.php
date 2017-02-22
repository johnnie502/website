@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>Comment / Show #{{$comment->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('comments.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('comments.edit', $comment->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <label>User</label>
<p>
	{{ $comment->user }}
</p> <label>Replyto</label>
<p>
	{{ $comment->replyto }}
</p> <label>Content</label>
<p>
	{{ $comment->content }}
</p> <label>Type</label>
<p>
	{{ $comment->type }}
</p> <label>Status</label>
<p>
	{{ $comment->status }}
</p> <label>Model</label>
<p>
	{{ $comment->model }}
</p> <label>Moderated_at</label>
<p>
	{{ $comment->moderated_at }}
</p> <label>Moderated_by</label>
<p>
	{{ $comment->moderated_by }}
</p>
        </div>
        
    </div>
</div>

@endsection
