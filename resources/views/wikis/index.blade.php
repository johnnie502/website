@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Wiki
                <a class="btn btn-success pull-right" href="{{ route('wikis.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
            </h1>
        </div>

        <div class="panel-body">
            @if($wikis->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>User</th> <th>Category</th> <th>Title</th> <th>Content</th> <th>Type</th> <th>Status</th> <th>Redirect</th> <th>Views</th> <th>Edits</th> <th>Lastedit</th> <th>Favicons</th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($wikis as $wiki)
                            <tr>
                                <td class="text-center"><strong>{{$wiki->id}}</strong></td>

                                <td>{{$wiki->user}}</td> <td>{{$wiki->category}}</td> <td>{{$wiki->title}}</td> <td>{{$wiki->content}}</td> <td>{{$wiki->type}}</td> <td>{{$wiki->status}}</td> <td>{{$wiki->redirect}}</td> <td>{{$wiki->views}}</td> <td>{{$wiki->edits}}</td> <td>{{$wiki->lastedit}}</td> <td>{{$wiki->favicons}}</td>
                                
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('wikis.show', $wiki->id) }}">
                                        <i class="glyphicon glyphicon-eye-open"></i> 
                                    </a>
                                    
                                    <a class="btn btn-xs btn-warning" href="{{ route('wikis.edit', $wiki->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i> 
                                    </a>

                                    <form action="{{ route('wikis.destroy', $wiki->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $wikis->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>

@endsection