@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> Comment / 
                @if($comment->id)
                    Edit #{{$comment->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>

        @include('error')

        <div class="panel-body">
            @if($comment->id)
                <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('comments.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                    <label for="user-field">User</label>
                    <input class="form-control" type="text" name="user" id="user-field" value="{{ old('user', $comment->user ) }}" />
                </div> 
                <div class="form-group">
                    <label for="replyto-field">Replyto</label>
                    <input class="form-control" type="text" name="replyto" id="replyto-field" value="{{ old('replyto', $comment->replyto ) }}" />
                </div> 
                <div class="form-group">
                	<label for="content-field">Content</label>
                	<textarea name="content" id="content-field" class="form-control" rows="3">{{ old('content', $comment->content ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $comment->type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="status-field">Status</label>
                    <input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $comment->status ) }}" />
                </div> 
                <div class="form-group">
                    <label for="model-field">Model</label>
                    <input class="form-control" type="text" name="model" id="model-field" value="{{ old('model', $comment->model ) }}" />
                </div> 
                <div class="form-group">
                    <label for="moderated_at-field">Moderated_at</label>
                    <input class="form-control" type="text" name="moderated_at" id="moderated_at-field" value="{{ old('moderated_at', $comment->moderated_at ) }}" />
                </div> 
                <div class="form-group">
                    <label for="moderated_by-field">Moderated_by</label>
                    <input class="form-control" type="text" name="moderated_by" id="moderated_by-field" value="{{ old('moderated_by', $comment->moderated_by ) }}" />
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('comments.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection