@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>{{$topic->title}}</h1>
        </div>
        <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        @foreach ($topic->tags as $tag)
                            <a href="{{ route('tag', $tag->name) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        @if (Auth::check() && ($topic->user == $account->id or $account->type >= 3))
                             <a class="pull-right" href="{{ route('topics.edit', $topic->id) }}">Edit</a>
                        @endif
                    </div>
            </div>
            <div class="pull-right">
                <img alt="" src="/avatars/{{ $topic->user}}.png" width="128" height="128" /><br>
                <a href="{{ route('users.show', $topic->users->id) }}">{{ $topic->users->username }}</a>
            </div>
             @markdown($posts->first()->content)
        </div>
        <!-- Posts -->
        @if ($topic->replies > 0)
            @foreach ($posts as $reply)
                <div class="list-group"> 
                    <ul>
                    <li>
                    {{ $reply->conetent }}
                    </li>
                    </ul>
                </div>
            @endforeach
        @endif
        <!-- reply editor -->
        @if (Auth::check())
            @if($posts->first()->id <= $topic->replies)
                <form action="{{ route('topics.posts.update', [$topic->id, $topic->replies + 1]) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('topics.posts.store', $topic) }}" method="POST">
            @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="content-field">Reply</label>
                            @include('UEditor::head')
                            <script id="ueditor" name="content" type="text/plain"></script>
                            <script type="text/javascript">
                            var ue = UE.getEditor('ueditor', {
                                <!-- 定制工具栏按钮 -->
                                 toolbars: [
                                  ['bold', 'italic', 'underline', 'superscript', 'subscript', 'spechars', 'blockquote', 'insertcode', 'link', 'unlink',  'inserttitle', 'paragraph', '|', 'undo', 'redo', 'selectall', 'pasteplain', 'removeformat', '|', 'fontfamily', 'fontsize', 'forecolor', '|', 'emotion', 'simpleupload', 'source']
                                  ]
                              });
                            ue.ready(function() {
                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                            });
                        </script>
                        <input type="submit" name="submit" value="@lang('global.submit')" />
                    </div>
                </form> 
        @else
            <div>@lang('global.login_request')
        @endif
    </div>
</div>
@endsection