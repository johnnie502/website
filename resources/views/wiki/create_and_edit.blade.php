@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                {{ isset($wiki->id) ? '编辑条目' : '创建条目' }}
            </h1>
        </div>
        <div class="panel-body">
            @if($wiki->id)
                <form action="{{ route('wiki.update', $wiki->id) }}" method="wiki">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('wiki.store') }}" method="wiki">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="node-field">Node</label>
                    @if($wiki->id)
                        {{ $node->name }}
                    @else
                        <select class="form-control" name="node" id="node-field" required placeholder="请选择一个节点">
                            @foreach ($nodes as $node)
                                <option value="{{ $node->id }}">{{ $node->name . ' / ' . $node->slug }}</option>
                            @endforeach
                       </select>
                    @endif
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" required placeholder="8～80个字符" value="{{ old('title', $wiki->title) }}" />
                </div>
                <div class="form-group">
                	<label for="content-field">Content</label>
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
                 </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection