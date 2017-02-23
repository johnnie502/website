    <div class="panel-body">
        @if (Auth::check())
            @if($comment->id)
                <form action="{{ route('comments.update', $comment->id) }}" method="comment">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('comments.store') }}" method="comment">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">                
                <div class="form-group">
                    <label for="content-field">Content</label>
                    <input type="text" value="" />    
                </div> 
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-link pull-right" href="{{ route('comments.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>
        </div>
    @else
        <div id="">@lang('global.login_request')</div>
    @endif
</div>