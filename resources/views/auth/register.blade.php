@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('global.register')</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">@lang('validation.attributes.username')</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required placeholder="3~20个字符" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">@lang('validation.attributes.email')</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="5~30个字符">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label"> @lang('validation.attributes.password')</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="8~50个字符，要求包含大小写字母，数字和符号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">@lang('validation.attributes.password_confirmation')</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="请再次输入密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('global.register')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection