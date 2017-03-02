@extends('backpack::layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('global.login')</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url(config('backpack.base.route_prefix').'/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">@lang('validation.attributes.username')</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required placeholder="用户名或邮箱，3～30个字符" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">@lang('validation.attributes.password')</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="8~50个字符，要求包含大小写字母，数字和符号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('global.remember_me')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('global.login')
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    @lang('global.forgot_password')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
