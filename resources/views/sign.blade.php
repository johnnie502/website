@extends('layouts.app')
@section('title')
@stop
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('global.sign')</div>
                <div class="panel-body">
                    @if (!empty($signed) && \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $signed->first()->signed_at)->isToday())
                    <ul class="list-group">
                        @foreach ($signed as $sign)
                            <li class="list-group-item">{{ $sign->signed_at }} {{ $sign->points }} {{ $account->signed }} {{ $account->points }}</li>
                        @endforeach
                    </ul>
                    @else
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('sign') }}">
                        {{ csrf_field() }}
                        <input type="submit" name="sign" value="sign" />
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop