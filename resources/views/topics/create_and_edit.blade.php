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
                {{ isset($topic->id) ? '编辑主题' : '发表主题' }}
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
                    @if($topic->id)
                        {{ $node->name }}
                    @else
                        <select class="form-control" name="node" id="node-field" required placeholder="请选择一个节点">
                            @foreach ($nodes as $node)
                                <option value="{{ $node->id }}">{{ $node->name . '/' . $node->slug }}</option>
                            @endforeach
                       </select>
                    @endif
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" required placeholder="8～80个字符" value="{{ old('title', $topic->title) }}" />
                </div>
                <div class="form-group">
                	<label for="title-field">Tags</label>
                	<input class="form-control" type="text" name="tags" id="tags" data-role="tagsinput" required placeholder="按Enter添加标签" value="{{ old('tags', $topic->tagList) }}">
                </div>
                <div class="form-group">
                	<label for="content-field">Content</label>
                        @include('UEditor::head')
                        <script id="ueditor" name="content" type="text/plain">@markdown(old('content', isset($post) ? $post->content : '' ))</script>
                        <script type="text/javascript">
                            var ue = UE.getEditor('ueditor', {
                                <!-- 定制工具栏按钮 -->
                                 toolbars: [
                                  ['bold', 'italic', 'underline', 'superscript', 'subscript', 'spechars', 'blockquote', 'insertcode', 'link', 'unlink',  'inserttitle', 'paragraph',  'inserttable' , '|', 'undo', 'redo', 'selectall', 'pasteplain', 'removeformat', '|', 'fontfamily', 'fontsize', 'forecolor', '|', 'emotion', 'simpleupload']
                                  ]
                              });
                            var preloadContent = $("#ueditor").html();
                            ue.ready(function() {
                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                                ue.setContent(preloadContent);
                            });
                        </script>
                 </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
