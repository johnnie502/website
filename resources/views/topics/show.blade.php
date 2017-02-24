@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>{{$topic->title}}</h1>
        </div>
        <div class="panel-body">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        @foreach ($topic->tags as $tag)
                            <a href="{{ route('tag', $tag->name) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                         <a class="btn btn-sm btn-warning pull-right" href="{{ route('topics.edit', $topic->id) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <img alt="" src="/avatars/{{ $topic->user}}.png" width="128" height="128" /><br>
                <a href="{{ route('users.show', $topic->users->id) }}">{{ $topic->users->username }}</a>
            </div>
             @markdown($post->content)
        </div>
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
        @include('posts.create_and_edit')
    </div>
</div>
@endsection