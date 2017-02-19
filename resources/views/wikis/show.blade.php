@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>Wiki / Show #{{$wiki->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('wikis.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('wikis.edit', $wiki->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <label>User</label>
<p>
	{{ $wiki->user }}
</p> <label>Category</label>
<p>
	{{ $wiki->category }}
</p> <label>Title</label>
<p>
	{{ $wiki->title }}
</p> <label>Content</label>
<p>
	{{ $wiki->content }}
</p> <label>Type</label>
<p>
	{{ $wiki->type }}
</p> <label>Status</label>
<p>
	{{ $wiki->status }}
</p> <label>Redirect</label>
<p>
	{{ $wiki->redirect }}
</p> <label>Views</label>
<p>
	{{ $wiki->views }}
</p> <label>Edits</label>
<p>
	{{ $wiki->edits }}
</p> <label>Lastedit</label>
<p>
	{{ $wiki->lastedit }}
</p> <label>Favicons</label>
<p>
	{{ $wiki->favicons }}
</p>
        </div>
        
    </div>
</div>

@endsection
