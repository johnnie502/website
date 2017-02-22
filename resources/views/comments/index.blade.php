@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Comment
                <a class="btn btn-success pull-right" href="{{ route('comments.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
            </h1>
        </div>

        <div class="panel-body">
            @if($comments->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>User</th> <th>Replyto</th> <th>Content</th> <th>Type</th> <th>Status</th> <th>Model</th> <th>Moderated_at</th> <th>Moderated_by</th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td class="text-center"><strong>{{$comment->id}}</strong></td>

                                <td>{{$comment->user}}</td> <td>{{$comment->replyto}}</td> <td>{{$comment->content}}</td> <td>{{$comment->type}}</td> <td>{{$comment->status}}</td> <td>{{$comment->model}}</td> <td>{{$comment->moderated_at}}</td> <td>{{$comment->moderated_by}}</td>
                                
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('comments.show', $comment->id) }}">
                                        <i class="glyphicon glyphicon-eye-open"></i> 
                                    </a>
                                    
                                    <a class="btn btn-xs btn-warning" href="{{ route('comments.edit', $comment->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i> 
                                    </a>

                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $comments->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>

@endsection