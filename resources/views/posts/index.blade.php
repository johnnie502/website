@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Post
                <a class="btn btn-success pull-right" href="{{ route('posts.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
            </h1>
        </div>

        <div class="panel-body">
            @if($posts->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>User</th> <th>Post</th> <th>Subpost</th> <th>Title</th> <th>Content</th> <th>Type</th> <th>Status</th> <th>Favicons</th> <th>Votes</th> <th>Moderated_at</th> <th>Moderated_by</th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td class="text-center"><strong>{{$post->id}}</strong></td>

                                <td>{{$post->user}}</td> <td>{{$post->post}}</td> <td>{{$post->subpost}}</td> <td>{{$post->title}}</td> <td>{{$post->content}}</td> <td>{{$post->type}}</td> <td>{{$post->status}}</td> <td>{{$post->favicons}}</td> <td>{{$post->votes}}</td> <td>{{$post->moderated_at}}</td> <td>{{$post->moderated_by}}</td>
                                
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('posts.show', $post->id) }}">
                                        <i class="glyphicon glyphicon-eye-open"></i> 
                                    </a>
                                    
                                    <a class="btn btn-xs btn-warning" href="{{ route('posts.edit', $post->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i> 
                                    </a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $posts->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>

@endsection