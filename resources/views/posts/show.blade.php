@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>Post / Show #{{$post->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('posts.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('posts.edit', $post->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <label>User</label>
<p>
	{{ $post->user }}
</p> <label>Post</label>
<p>
	{{ $post->post }}
</p> <label>Subpost</label>
<p>
	{{ $post->subpost }}
</p> <label>Title</label>
<p>
	{{ $post->title }}
</p> <label>Content</label>
<p>
	{{ $post->content }}
</p> <label>Type</label>
<p>
	{{ $post->type }}
</p> <label>Status</label>
<p>
	{{ $post->status }}
</p> <label>Favicons</label>
<p>
	{{ $post->favicons }}
</p> <label>Votes</label>
<p>
	{{ $post->votes }}
</p> <label>Moderated_at</label>
<p>
	{{ $post->moderated_at }}
</p> <label>Moderated_by</label>
<p>
	{{ $post->moderated_by }}
</p>
        </div>
        
    </div>
</div>

@endsection
