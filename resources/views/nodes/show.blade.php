@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>Node / Show #{{$node->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('nodes.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('nodes.edit', $node->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <label>Name</label>
<p>
	{{ $node->name }}
</p> <label>Slug</label>
<p>
	{{ $node->slug }}
</p> <label>Type</label>
<p>
	{{ $node->type }}
</p> <label>Parent</label>
<p>
	{{ $node->parent }}
</p> <label>Description</label>
<p>
	{{ $node->description }}
</p> <label>Topics</label>
<p>
	{{ $node->topics }}
</p> <label></label>
<p>
	{{ $node-> }}
</p>
        </div>
        
    </div>
</div>

@endsection
