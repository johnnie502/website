@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Node
                <a class="btn btn-success pull-right" href="{{ route('nodes.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
            </h1>
        </div>
        <div class="panel-body">
            @if($nodes->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th> <th>Slug</th> <th>Type</th> <th>Parent</th> <th>Description</th> <th>Topics</th> <th></th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nodes as $node)
                            <tr>
                                <td class="text-center"><strong>{{$node->id}}</strong></td>

                                <td>{{$node->name}}</td> <td>{{$node->slug}}</td> <td>{{$node->type}}</td> <td>{{$node->parent}}</td> <td>{{$node->description}}</td> <td>{{$node->topics}}</td> <td>{{$node->}}</td>
                                
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('nodes.show', $node->id) }}">
                                        <i class="glyphicon glyphicon-eye-open"></i> 
                                    </a>
                                    
                                    <a class="btn btn-xs btn-warning" href="{{ route('nodes.edit', $node->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i> 
                                    </a>

                                    <form action="{{ route('nodes.destroy', $node->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $nodes->links() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>
@stop
