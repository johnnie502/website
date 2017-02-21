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
            <img alt="" src="/avatars/{{ App\Models\User::find($topic->user)->id }}.png" width="128" height="128" />
            {{ App\Models\User::find($topic->user)->username }}
	    @markdown($post->content)
        </div>
        @include('posts.create_and_edit')
    </div>
</div>
@endsection