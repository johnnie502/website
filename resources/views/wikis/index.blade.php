@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            @if($wikis->count())
                <table class="table table-condensed table-striped">
                    <tbody>
                        @foreach($wikis as $wiki)
                            <tr>
                                <td><img alt="" src="/avatars/{{ App\Models\User::find($wiki->user)->id }}.png" width="32" height="32" /></td><td><a href="{{ route('nodes.show', App\Models\Node::find($wiki->node)->id) }}">{{ App\Models\Node::find($wiki->node)->name }}</a></td> <td><a href="{{ route('topics.show', $wiki->id) }}">{{ $wiki->title }}</a></td> <td><a href="{{ route('users.show', App\Models\User::find($wiki->user)->id) }}">{{ App\Models\User::find($wiki->user)->username }}</a></td>
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
