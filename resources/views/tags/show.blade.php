@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1></h1>
        </div>
        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        @foreach ($topics as $topic)
                            {{ $topic->title }}
                        @endforeach
                    </div>
                </div>
            </div>
	</div>
    </div>
</div>
@endsection