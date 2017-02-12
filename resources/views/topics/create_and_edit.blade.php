@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>
$(document).ready(function(){
  $('#tags').tagsinput({
    tagClass: 'tag-primary',
    maxTags: 5,
    maxChars: 12,
    trimValue: true
  });
});
</script>
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> Topic / 
                @if($topic->id)
                    Edit #{{$topic->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>
        <div class="panel-body">
            @if($topic->id)
                <form action="{{ route('topics.update', $topic->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('topics.store') }}" method="POST">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="node-field">Node</label>
                    <input class="form-control" type="text" name="node" id="node-field" value="{{ old('node', $topic->node) }}" />
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title) }}" />
                </div>
                <div class="form-group">
                	<label for="title-field">Tags</label>
                	<input class="form-control" type="text" name="tags" id="tags" required placeholder="按Enter添加标签" value="{{ old('tags') }}">
                </div>
                <div class="form-group">
                	<label for="content-field">Content</label>
                        @include('UEditor::head')
                        <script id="container" name="content" type="text/plain">
                        @markdown(old('content', $topic->content))
                        </script>
                        <script type="text/javascript">
	                    var ue = UE.getEditor('container');
		            ue.ready(function() {
		            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
	                });
                        </script>
                </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-link pull-right" href="{{ route('topics.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
