@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>Topic / Show #{{$topic->id}}</h1>
        </div>

        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-link" href="{{ route('topics.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('topics.edit', $topic->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

 <label>Title</label>
<p>
	{{ $topic->title }}
</p> <label>Content</label>
<p>
	{{ $topic->content }}
</p>
        </div>
        @yield('post')
    </div>
</div>

@endsection
