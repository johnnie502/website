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
                            <a href="{{ route('topics.tags', $tag->name) }}"><span class="label label-primary">{{ $tag->name }}</span></a>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        @can('update', $topic)
                             <a class="pull-right" href="{{ route('topics.edit', $topic->id) }}">@lang('global.edit')</a>
                        @endcan
                        <span class="pull-right">{{ $topic->created_at->diffForHumans() }}</span>
                    </div>
            </div>
            {{ $topic->countVoters() }}
            <div class="pull-right">
                <img alt="" src="/avatars/{{ $topic->user}}.png" width="128" height="128" /><br>
                <a href="{{ route('users.show', $topic->users->username) }}">{{ $topic->users->username }}</a>
            </div>
             @markdown($posts->first()->content)
             $topic->upvotes
             <!-- Comments -->
             @foreach ($topic->comments as $comment)
                 <ul class="list-group">
                     <li class="list-group-item"><a link="{{ route('user.show', $comment->user) }}">{{ $comment->user->username }}</a> . ': ' . {{ $comment->content }}</li>
                 </ul>
             @endforeach
             @if (Auth::check())
                 @if (isset($comment->id))
                     <form action="{{ route('topics.posts.comments.update', $topic->id, 0, $comment->id) }}" method="POST">
                @else
                     <form action="{{ route('topics.posts.comments.create', $topic->id, 0, 1) }}" method="POST">
                @endif
                     <textarea name="comments" id="comments">{{ old($comment->content) }}</textarea>
                 </form>
            @endif
        </div>
        <!-- Posts -->
        @if ($topic->replies > 0)
            @if (isset($posts))
                @foreach ($posts as $reply)
                    {{ $reply->countVoters() }}
                    @if ($reply->post > 0)
                        <ul class="list-group"> 
                            <span><a href="{{ route('users.show', $reply->users->username) }}">{{ $reply->users->username }}</a></span>
                            @can('update', $reply)
                                 <a class="pull-right" href="{{ route('topics.posts.edit', [$topic->id, $reply->id]) }}">@lang('global.edit')</a>
                            @endcan
                            <div class="pull-right">
                                {{ $reply->created_at->diffForHumans() }} 
                                <a href={{ route('topics.posts.show', [$topic, $reply]) }}><span class="label label-primary">#{{ $reply->post }}</span></a>
                            </div>
                            <li class="list-group-item post-item">
                                <div><img alt="" src="/avatars/{{ $topic->user}}.png" width="32" height="32" /></div>

                                <div>{{ $reply->content }}<hr/><span>顶&nbsp;({{ $reply->upvotes }})</span><span>踩&nbsp;({{ $reply->downvotes }})</span></div>
                            </li>
                        </ul>
                        <!-- Comments -->
                        @foreach ($post->comments as $comment)
                             <ul class="list-group">
                                 <li class="list-group-item"><a link="{{ route('user.show', $comment->user) }}">{{ $comment->user->username }}</a> . ': ' . {{ $comment->content }}</li>
                             </ul>
                        @endforeach
                        @if (Auth::check())
                            @if (isset($comment->id))
                                <form action="{{ route('topics.posts.comments.update', $topic->id, $post->id, $comment->id) }}" method="POST">
                           @else
                                <form action="{{ route('topics.posts.comments.create', $topic->id, $post->id, $comments->id) }}" method="POST">
                           @endif
                                <textarea name="comments" id="comments">{{ old($comment->content) }}</textarea>
                            </form>
                        @endif
                    @endif
                @endforeach
            @else
                <ul class="list-group"> 
                    <a href={{ route('topics.posts.show', [$topic, $post]) }}>#{{ $post->post }}</a><li class="list-group-item"> {{ $post->content }}</li>
                </ul>
                <a href="{{ route('topics.show', $topic) }}">查看全部帖子</a>
            @endif
        @endif
        <!-- reply editor -->
        @if (Auth::check())
            @if($posts->last()->post < $topic->replies)
                <form action="{{ route('topics.posts.update', [$topic->id, $topic->replies + 1]) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('topics.posts.store', $topic) }}" method="POST">
            @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="content-field">Reply</label>
                            @if (Agent::isPhone())
                                {!! editor_css() !!}
                                {!! editor_js() !!}
                                {!! editor_config('mdeditor') !!}
                                <textarea name="content" style="display:none;">
                                </textarea>
                            @else
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
                            @endif
                        <input type="submit" name="submit" value="@lang('global.submit')" />
                    </div>
                </form> 
        @else
            <div>@lang('global.login_request')
        @endif
    </div>
</div>
@endsection