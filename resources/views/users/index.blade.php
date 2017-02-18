@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> User
                <a class="btn btn-success pull-right" href="{{ route('users.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
            </h1>
        </div>

        <div class="panel-body">
            @if($users->count())
                <table class="table table-condensed table-striped">
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center"><strong>{{$user->id}}</strong></td>

                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('users.show', $user->id) }}">
                                        <i class="glyphicon glyphicon-eye-open"></i> 
                                    </a>
                                    
                                    <a class="btn btn-xs btn-warning" href="{{ route('users.edit', $user->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i> 
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $users->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>

@endsection