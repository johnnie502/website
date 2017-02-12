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
@include('UEditor::head')
@if (Auth::check())
  <div class="card card-content">
    <div class="alert alert-warning">
	为了保证资源的质量，上传的资源需要审核，请耐心等待审核通过
    </div>
	<div class="card-primary">
      <h2>上传资源</h2>
    </div>
    <div class="container">
	  <div class="card-block">
        <form class="form-horizontal" action="" method="post" enctype="multipart//form-data">
          <div class="form-control label-floating">
            <label class="form-control-label" for="name">名称</label>
          <input class="form-control" name="name" id="name" type="text" required placeholder="资源名称，5~30个字符" value="{{ old('name') }}" min="5" max="30">
          </div>
		  <div class="form-control label-floating">
            <label class="form-control-label" for="type">类型</label>
            <input class="form-control" name="type" id="type" type="select" required value="{{ old('type') }}">
          </div>
          <div class="form-control label-floating">
            <label class="form-control-label" for="tags">标签</label>
            <br>
            <input class="form-control" type="text" name="tags" id="tags" required placeholder="按Enter添加标签" value="{{ old('tags') }}">
          </div>	
          <div class="form-control label-floating">
            <label class="form-control-label" for="dedscription">描述</label>
		    <!-- 加载编辑器的容器 -->
            <script name="content" id="description" type="text/plain">
		    {{ old('description') }}
			</script>
		    <!-- 实例化编辑器 -->
            <script type="text/javascript">
		      var ue = UE.getEditor('description', {
		        <!-- 定制工具栏按钮 -->
		          toolbars: [
                    ['bold', 'italic', 'underline', 'superscript', 'subscript', 'spechars', 'blockquote', 'link', 'unlink', '|', 'undo', 'redo', 'selectall', 'pasteplain', 'removeformat', '|', 'fontfamily', 'fontsize', 'forecolor', '|', 'emotion', 'simpleupload']
                  ]
		        });
		        ue.ready(function() {
		        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
		      });
		    </script>
          </div>
		  <div class="form-control label-floating">
            <input type="file" name="file" id="file" required>
            <input type="text" readonly="" class="form-control" required placeholder="选择文件">
          </div>
		  {!! csrf_field() !!}
          <input type="submit" value="上传资源" class="btn btn-raised btn-primary">
        </form>
      </div>
    </div>
  </div>
@else
    View('errors.403')
@endif
@stop