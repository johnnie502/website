@extends('layouts.app')
@section('title')
    @lang('global.view_topic'): {{ $topic->title }}
@stop
@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1>{{ $topic->title }}</h1>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    @foreach ($topic->tags as $tag)
                        <a href="{{ route('topics.tags', $tag->name) }}"><span class="label label-primary">{{ $tag->name }}</span></a>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <span class="pull-right">
                    @if ($topic->created_at->subMonth()->gte(\Carbon\Carbon::now()))
                        {{ $topic->created_at->toDateString() }}
                    @else
                        {{ $topic->created_at->diffForHumans() }} 
                    @endif
                    </span>
                    @can('update', $topic)
                         <a class="pull-right" href="{{ route('topics.edit', $topic->id) }}">@lang('global.edit')</a>
                    @endcan
                </div>
        </div>
        {{ $topic->countVoters() }}
        <div class="pull-right">
            <img alt="" src="/avatars/{{ $topic->user}}.png" width="128" height="128"><br>
            <a href="{{ route('users.show', $topic->users->username) }}">{{ $topic->users->username }}</a>
        </div>
        @markdown($posts->first()->content)
        <!-- Social Share -->
        <div class="social-share"></div>
        {{ $topic->upvotes }}
        <!-- Comments -->
        @if ($posts->first()->comment_count > 0)
            @foreach ($posts->first()->comments as $comment)
                <ul class="list-group">
                    <li class="list-group-item"><a link="{{ route('user.show', $comment->user) }}">{{ $comment->users->username }}</a> . ': ' . {{ $comment->content }}</li>
                </ul>
            @endforeach
        @endif
        @can('create', App\Models\Comment::class)
            @if ($posts->first()->comment_count > 0)
                <form action="{{ route('topics.posts.comments.update', [$topic->id, 0, $posts->first()->comment_count]) }}" method="POST">
                    <input type="text" name="content" id="comments" value="{{ old($posts->first()->comments->first()->content, '') }}">
            @else
                <form action="{{ route('topics.posts.comments.store', [$topic->id, 0, 1]) }}" method="POST">
                    <input type="text" name="content" id="comments">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" name="submit" value="@lang('global.submit')">
                </form>
            @endif
        @endcan
        </div>
        <!-- Posts -->
        @if ($topic->reply_count > 0)
            @if (isset($posts))
                @foreach ($posts as $reply)
                    {{ $reply->countVoters() }}
                    @if ($reply->post > 0)
                        <ul class="list-group"> 
                            @can('update', $reply)
                                 <a class="pull-right" href="{{ route('topics.posts.edit', [$topic->id, $reply->id]) }}">@lang('global.edit')</a>
                            @endcan
                            <span><a href="{{ route('users.show', $reply->users->username) }}">{{ $reply->users->username }}</a></span>
                             <div class="pull-right">
                                 @if ($reply->created_at->subMonth()->gte(\Carbon\Carbon::now()))
                                     {{ $reply->created_at->toDateString() }}
                                 @else
                                    {{ $reply->created_at->diffForHumans() }} 
                                 @endif
                                 <a href={{ route('topics.posts.show', [$topic, $reply]) }}><span class="label label-primary">#{{ $reply->post }}</span></a>
                            </div>
                            <li class="list-group-item post-item">
                                <div><img alt="" src="/avatars/{{ $reply->user}}.png" width="32" height="32"></div>
                                <div>@markdown($reply->content)<hr/><span>顶&nbsp;({{ $reply->upvotes }})</span><span>踩&nbsp;({{ $reply->downvotes }})</span></div>
                            </li>
                        </ul>
                        <!-- Comments -->
                        @if ($reply->comment_count > 0)
                             @foreach ($reply->comments as $comment)
                                 <ul class="list-group">
                                     <li class="list-group-item"><a link="{{ route('user.show', $comment->users) }}">{{ $comment->users->username }}</a> . ': ' . {{ $comment->content }}</li>
                                 </ul>
                            @endforeach
                        @endif
                        @can('create', \App\Models\Comment::class)
                            @if ($reply->comment_count > 0)
                                 <form action="{{ route('topics.posts.comments.update', [$topic->id, $reply->id, $reply->comments->last()->id]) }}" method="POST">
                                     <input type="text" name="content" value="{{ old('content', '') }}">
                             @else
                                 <form action="{{ route('topics.posts.comments.store', [$topic->id, $reply->id, 1]) }}" method="POST">
                                     <input type="text" name="content" value=" {{ old('content', '') }}">
                             @endif
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                     <input type="submit" name="submit" value="@lang('global.submit')">
                                 </form>
                         @endcan
                    @endif
                @endforeach
           @else
                <ul class="list-group"> 
                    <a href="{{ route('topics.posts.show', [$topic, $post]) }}">{{ $post->post }}</a><li class="list-group-item"> {{ $post->content }}</li>
                </ul>
                <a href="{{ route('topics.show', $topic) }}">@lang('global.view_all_posts')</a>
            @endif
        @endif
        <!-- reply editor -->
        @can('create', \App\Models\Post::class)
            @if ($posts->last()->post < $topic->reply_count)
                <form action="{{ route('topics.posts.update', [$topic->id, $topic->reply_count + 1]) }}" method="POST">
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
                                @include('vendor.ueditor.assets')
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
                        <input type="submit" name="submit" value="@lang('global.submit')">
                    </div>
                </form> 
        @else
            @if (\Auth::check())
                <div>You don't have permission</div>
            @else
                <div>@lang('global.login_request')
            @endif
        @endcan
    </div>
</div>
@stop