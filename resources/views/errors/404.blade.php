@extends('layouts.app')
@section('title')
    404 - Not Found
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">404 - Not Found</div>
                <div class="panel-body">
                    <h1><strong>@lang('global.404_not_found')</strong></h1>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
