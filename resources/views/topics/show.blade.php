@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>{{$topic->title}}</h1>
        </div>
        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        @foreach ($topic->tags as $tag)
                            <a href="{{ route('tag', $tag->name) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('topics.edit', $topic->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
	@markdown($post->content)
        </div>
        @yield('post')
    </div>
</div>
@endsection