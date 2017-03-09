@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>{{$wiki->title}}</h1>
        </div>
        <div class="panel-body">
            <div class="row">
                   <div class="col-md-6">
                    @foreach ($wiki->tags as $category)
                        <a href="{{ route('wikis.categories', $category->name) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="col-md-6">
                     <a class="btn btn-sm btn-warning pull-right" href="{{ route('topics.edit', $wiki->id) }}">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                </div>
            </div>
	@markdown($wiki->content)
        </div>
    </div>
</div>
@endsection