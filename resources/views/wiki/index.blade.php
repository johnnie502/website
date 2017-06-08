@extends('layouts.app')
@section('title')
    @lang('global.wiki')
@stop
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            @can('create')
                <a class="pull-right" href="{{ route('wiki.create') }}">@lang('global.create_wiki')</a> 
            @endcan
            @if($wikis->count())
                <table class="table table-condensed table-striped">
                    <tbody>
                        @foreach($wikis as $wiki)
                            <tr>
                                <td><img alt="" src="/avatars/{{ $wiki->users->id }}.png" width="32" height="32"></td><td><td><a href="{{ route('wiki.show', $wiki->title) }}">{{ $wiki->title }}</a></td> <td><a href="{{ route('users.show', $wiki->users->username) }}">{{ $wiki->users->username }}</a></td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $wikis->links('iview') !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
        </div>
    </div>
</div>
@stop