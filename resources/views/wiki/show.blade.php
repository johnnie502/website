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
                        <a href="{{ route('wiki.categories', $category->name) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
                @can('update', $wiki)
                    <a class="pull-right" href="{{ route('wiki.edit', $wiki->id) }}">Edit</a>
                @endcan
            </div>
        <!-- Title -->
        {{ $wiki->title }}
        <!-- Title of Contents -->
        {{ $wiki->toc }}
        <!-- Contents -->
	@markdown($wiki->content)
        </div>
    </div>
</div>
@endsection