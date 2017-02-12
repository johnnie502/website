@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> Post / 
                @if($post->id)
                    Edit #{{$post->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>

        @include('error')

        <div class="panel-body">
            @if($post->id)
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('posts.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                    <label for="user-field">User</label>
                    <input class="form-control" type="text" name="user" id="user-field" value="{{ old('user', $post->user ) }}" />
                </div> 
                <div class="form-group">
                    <label for="post-field">Post</label>
                    <input class="form-control" type="text" name="post" id="post-field" value="{{ old('post', $post->post ) }}" />
                </div> 
                <div class="form-group">
                    <label for="subpost-field">Subpost</label>
                    <input class="form-control" type="text" name="subpost" id="subpost-field" value="{{ old('subpost', $post->subpost ) }}" />
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $post->title ) }}" />
                </div> 
                <div class="form-group">
                    <label for="content-field">Content</label>
                    <input class="form-control" type="text" name="content" id="content-field" value="{{ old('content', $post->content ) }}" />
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $post->type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="status-field">Status</label>
                    <input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $post->status ) }}" />
                </div> 
                <div class="form-group">
                    <label for="favicons-field">Favicons</label>
                    <input class="form-control" type="text" name="favicons" id="favicons-field" value="{{ old('favicons', $post->favicons ) }}" />
                </div> 
                <div class="form-group">
                    <label for="votes-field">Votes</label>
                    <input class="form-control" type="text" name="votes" id="votes-field" value="{{ old('votes', $post->votes ) }}" />
                </div> 
                <div class="form-group">
                    <label for="moderated_at-field">Moderated_at</label>
                    <input class="form-control" type="text" name="moderated_at" id="moderated_at-field" value="{{ old('moderated_at', $post->moderated_at ) }}" />
                </div> 
                <div class="form-group">
                    <label for="moderated_by-field">Moderated_by</label>
                    <input class="form-control" type="text" name="moderated_by" id="moderated_by-field" value="{{ old('moderated_by', $post->moderated_by ) }}" />
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('posts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection