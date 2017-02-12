@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> File / 
                @if($file->id)
                    Edit #{{$file->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>

        @include('error')

        <div class="panel-body">
            @if($file->id)
                <form action="{{ route('files.update', $file->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('files.store') }}" method="POST">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                
                <div class="form-group">
                    <label for="user-field">User</label>
                    <input class="form-control" type="text" name="user" id="user-field" value="{{ old('user', $file->user ) }}" />
                </div> 
                <div class="form-group">
                	<label for="name-field">Name</label>
                	<input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $file->name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<input class="form-control" type="text" name="description" id="description-field" value="{{ old('description', $file->description ) }}" />
                </div> 
                <div class="form-group">
                	<label for="path-field">Path</label>
                	<input class="form-control" type="text" name="path" id="path-field" value="{{ old('path', $file->path ) }}" />
                </div> 
                <div class="form-group">
                    <label for="type-field">Type</label>
                    <input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $file->type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="ststus-field">Ststus</label>
                    <input class="form-control" type="text" name="ststus" id="ststus-field" value="{{ old('ststus', $file->ststus ) }}" />
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('files.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection