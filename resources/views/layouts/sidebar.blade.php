<div class="col-md-3 side-bar">
  <div class="panel panel-default corner-radius">
    @if (isset($node))
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{{ $node->name }}}</h3>
      </div>
    @endif
    <div class="panel-body text-center">
      <div class="btn-group">
        <a href="{{ URL::route('topics.create') }}" class="btn btn-success btn-lg">发帖</a>
      </div>
    </div>
  </div>
@if (Route::currentRouteName() == 'topics')
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body text-center" style="padding: 7px;">
      <a href="https://phphub.org/topics/1531" target="_blank" rel="nofollow" title="">
        <img src="https://dn-phphub.qbox.me/uploads/images/201512/08/1/cziZFHqkm8.png" style="width:240px;">
      </a>
    </div>
  </div>
@endif
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
      <ul class="list">
      </ul>
    </div>
  </div>
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
  </div>
  </div>

  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
      <ul class="list">
      </ul>
    </div>
  </div>
  @if (isset($links) && count($links))
    <div class="panel panel-default corner-radius">
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{ '友情链接' }}</h3>
      </div>
      <div class="panel-body text-center" style="padding-top: 5px;">
        @foreach ($links as $link)
            <a href="{{ $link->link }}" target="_blank" rel="nofollow" title="{{ $link->title }}">
                <img src="{{ $link->cover }}" style="width:150px; margin: 3px 0;">
            </a>
        @endforeach
      </div>
    </div>
  @endif
  @if (isset($nodeTopics) && count($nodeTopics))
    <div class="panel panel-default corner-radius">
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{ '同节点帖子' }}</h3>
      </div>
      <div class="panel-body">
        <ul class="list">
          @foreach ($nodeTopics as $nodeTopic)
            <li>
            <a href="{{ route('topics.show', $nodeTopic->id) }}">
              {{{ $nodeTopic->title }}}
            </a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title">{{ '小贴士' }}</h3>
    </div>
    <div class="panel-body">
      {{ '' }}
    </div>
  </div>
    @if (Route::currentRouteName() == 'topics')
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
      <ul>
      </ul>
    </div>
  </div>
    @endif
</div>