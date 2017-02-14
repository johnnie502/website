@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> Node / 
                @if($node->id)
                    Edit #{{$node->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>
        <div class="panel-body">
            @if($node->id)
                <form action="{{ route('nodes.update', $node->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('nodes.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                	<label for="name-field">Name</label>
                	<input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $node->name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="slug-field">Slug</label>
                	<input class="form-control" type="text" name="slug" id="slug-field" value="{{ old('slug', $node->slug ) }}" />
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $node->type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="parent-field">Parent</label>
                    <input class="form-control" type="text" name="parent" id="parent-field" value="{{ old('parent', $node->parent ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $node->description ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="topics-field">Topics</label>
                    <input class="form-control" type="text" name="topics" id="topics-field" value="{{ old('topics', $node->topics ) }}" />
                </div> 
                <div class="form-group">
                    <label for="-field"></label>
                    <input class="form-control" type="text" name="" id="-field" value="{{ old('', $node-> ) }}" />
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('nodes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection