@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>
$(document).ready(function(){
  $('#categories').tagsinput({
    tagClass: 'tag-primary',
    maxTags: 5,
    maxChars: 12,
    trimValue: true
  });
});
</script><div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                {{ isset($wiki->id) ? '编辑条目' : '创建条目' }}
            </h1>
        </div>
        <div class="panel-body">
            @if($wiki->id)
                <form action="{{ route('wiki.update', $wiki->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('wiki.store') }}" method="POST">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" required placeholder="8～80个字符" value="{{ old('title', $wiki->title) }}" />
                </div>
                <div class="form-group">
                    <label for="categories-field">Categories</label>
                    <input class="form-control" type="text" name="categories" id="categories" data-role="tagsinput" required placeholder="按Enter添加分类" value="{{ old('categories', $wiki->tagList) }}">
                </div>
                <div class="form-group">
                    <label for="title-field">Redirect</label>
                    <input class="form-control" type="text" name="redirect" id="redirect-field" placeholder="" value="{{ old('redirect', $wiki->redirect) }}" />
                </div>
                <div class="form-group">
                    <label for="template-field">Template</label>
                    <select class="form-control" name="node" id="node-field" required placeholder="(可选)选择一个模板">
                        @if (isset($templates))
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                	<label for="content-field">Content</label>
                        @if (Agent::isPhone())
                            {!! editor_css() !!}
                            {!! editor_js() !!}
                            {!! editor_config('mdeditor') !!}
                            <textarea name="content" style="display:none;">
                            {{ old('content', isset($wiki) ? $wiki->content : '' ) }}
                            </textarea>
                        @else
                            @include('UEditor::head')
                            <script id="ueditor" name="content" type="text/plain">@markdown(old('content', isset($wiki) ? $wiki->content : '' ))</script>
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
                        @endif
                 </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop