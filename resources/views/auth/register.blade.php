@extends('layouts.app')
@section('title')
    @lang('global.register')
@stop
@section('content')
    <template>
        <card>
            <p slot="title">@lang('global.register')</p>
            <form model="formItem" :label-width="80" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <form-ltem label="@lang('validation.attributes.username')">
                    <input type="text" v-model="formitem.username" name="username" value="{{ old('username') }}" required placeholder="3～20个字符" autofocus>
                </form-ltem>
                <form-item label="@lang('validation.attributes.email')">
                    <input type="email" v-model="formitem.email" name="email" value="{{ old('email') }}" required placeholder="5~30个字符">
                </form-item>
                <form-item label="@lang('validation.attributes.password')">
                    <input type="password" v-model="formitem.password" name="password" required placeholder="8~50个字符，要求包含大小写字母和数字">
                </form-item>
                <form-item label="@lang('validation.attributes.password_confirmation')">
                    <input type="password" v-model="formitem.password_confirmation" name="password_confirmation" required placeholder="请再次输入密码">
                </form-item>
                @if (App::environment() === 'production')
                    {!! Recaptcha::render() !!}
                @endif
                <form-item>
                    <button type="submit">@lang('global.register')</button>
                </form-item>
                <a href="{{ url('/login') }}">@lang('global.login')</a>
            </form>
        </card>
    </template>
@stop