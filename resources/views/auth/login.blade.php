@extends('layouts.app')
@section('title')
    @lang('global.login')
@stop
@section('content')
    <template>
        <card>
            <p slot="title">@lang('global.login')</p>
            <form model="formItem" :label-width="80" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <form-ltem label="@lang('validation.attributes.username')">
                    <input type="text" v-model="formitem.username" name="username" value="{{ old('username') }}" required placeholder="用户名或邮箱，3～30个字符" autofocus>
                </form-ltem>
                <form-item label="@lang('validation.attributes.password')">
                    <input type="password" v-model="formitem.password" name="password" required placeholder="8~50个字符，要求包含大小写字母和数字">
                </form-item>
                @if (App::environment() === 'production')
                    {!! Recaptcha::render() !!}
                @endif
                <form-item>
                    <radio label="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>@lang('global.remember_me')</radio>
                </form-item>
                <form-item>
                    <button type="submit">@lang('global.login')</button>
                    <a href="{{ url('/password/reset') }}"></a>
                </form-item>
            </form>
        </card>
    </template>
@stop
