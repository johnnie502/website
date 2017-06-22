@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">403 - Forbidden</div>
                <div class="panel-body">
                    @lang('global.403_forbidden')
                </div>
            </div>
        </div>
    </div>
</div>
@stop
