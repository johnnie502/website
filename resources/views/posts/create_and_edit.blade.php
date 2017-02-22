    <div class="panel-body">
        @if (Auth::check())
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
                            ['bold', 'italic', 'underline', 'superscript', 'subscript', 'spechars', 'blockquote', 'insertcode', 'link', 'unlink',  'inserttitle', 'paragraph', '|', 'undo', 'redo', 'selectall', 'pasteplain', 'removeformat', '|', 'fontfamily', 'fontsize', 'forecolor', '|', 'emotion', 'simpleupload', 'source']
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
    @else
        <div id="">@lang('global.login_request')</div>
    @endif
</div>