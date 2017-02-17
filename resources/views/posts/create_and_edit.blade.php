@section('post')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>
                <i class="glyphicon glyphicon-edit"></i> Post / 
                @if($post->id)
                    Edit #{{$post->id}}
                @else
                    Create 
                @endif
            </h1>
        </div>
        <div class="panel-body">
            @if($post->id)
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('posts.store') }}" method="POST">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">                
                <div class="form-group">
                    <label for="title-field">Title</label>
                    <label for="content-field">Content</label>
                    @include('UEditor::head')
                        <script id="container" name="content" type="text/plain">
                        @markdown(old('content', $topic->content))
                        </script>
                        <script type="text/javascript">
                            var ue = UE.getEditor('container');
                            <!-- 定制工具栏按钮 -->
                          toolbars: [
                            ['bold', 'italic', 'underline', 'superscript', 'subscript', 'spechars', 'blockquote', 'link', 'unlink', '|', 'undo', 'redo', 'selectall', 'pasteplain', 'removeformat', '|', 'fontfamily', 'fontsize', 'forecolor', '|', 'emotion', 'simpleupload']
                          ]
                            ue.ready(function() {
                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                            });
                        </script>
                </div> 
                </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-link pull-right" href="{{ route('posts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection