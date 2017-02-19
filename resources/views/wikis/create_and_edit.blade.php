@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> Wiki / 
                @if($wiki->id)
                    Edit #{{$wiki->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>

        @include('error')

        <div class="panel-body">
            @if($wiki->id)
                <form action="{{ route('wikis.update', $wiki->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('wikis.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                    <label for="user-field">User</label>
                    <input class="form-control" type="text" name="user" id="user-field" value="{{ old('user', $wiki->user ) }}" />
                </div> 
                <div class="form-group">
                    <label for="category-field">Category</label>
                    <input class="form-control" type="text" name="category" id="category-field" value="{{ old('category', $wiki->category ) }}" />
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $wiki->title ) }}" />
                </div> 
                <div class="form-group">
                    <label for="content-field">Content</label>
                    <input class="form-control" type="text" name="content" id="content-field" value="{{ old('content', $wiki->content ) }}" />
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $wiki->type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="status-field">Status</label>
                    <input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $wiki->status ) }}" />
                </div> 
                <div class="form-group">
                    <label for="redirect-field">Redirect</label>
                    <input class="form-control" type="text" name="redirect" id="redirect-field" value="{{ old('redirect', $wiki->redirect ) }}" />
                </div> 
                <div class="form-group">
                    <label for="views-field">Views</label>
                    <input class="form-control" type="text" name="views" id="views-field" value="{{ old('views', $wiki->views ) }}" />
                </div> 
                <div class="form-group">
                    <label for="edits-field">Edits</label>
                    <input class="form-control" type="text" name="edits" id="edits-field" value="{{ old('edits', $wiki->edits ) }}" />
                </div> 
                <div class="form-group">
                    <label for="lastedit-field">Lastedit</label>
                    <input class="form-control" type="text" name="lastedit" id="lastedit-field" value="{{ old('lastedit', $wiki->lastedit ) }}" />
                </div> 
                <div class="form-group">
                    <label for="favicons-field">Favicons</label>
                    <input class="form-control" type="text" name="favicons" id="favicons-field" value="{{ old('favicons', $wiki->favicons ) }}" />
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('wikis.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection