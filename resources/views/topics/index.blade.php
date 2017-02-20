@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            @if($topics->count())
                <table class="table table-condensed table-striped">
                    <tbody>
                        @foreach($topics as $topic)
                            <tr>
                                <td><img alt="" src="/avatars/{{ App\Models\User::find($topic->user)->id }}.png" width="32" height="32" /></td><td><a href="{{ route('nodes.show', App\Models\Node::find($topic->node)->id) }}">{{ App\Models\Node::find($topic->node)->name }}</a></td> <td><a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a></td> <td><a href="{{ route('users.show', App\Models\User::find($topic->user)->id) }}">{{ App\Models\User::find($topic->user)->username }}</a></td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $topics->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>

@endsection
