@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>File / Show #{{$file->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('files.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('files.edit', $file->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <label>User</label>
<p>
	{{ $file->user }}
</p> <label>Name</label>
<p>
	{{ $file->name }}
</p> <label>Description</label>
<p>
	{{ $file->description }}
</p> <label>Path</label>
<p>
	{{ $file->path }}
</p> <label>Type</label>
<p>
	{{ $file->type }}
</p> <label>Ststus</label>
<p>
	{{ $file->ststus }}
</p>
        </div>
        
    </div>
</div>

@endsection
