@extends('layouts.app')

@section('title', 'Авторизация на портале')

@section('content')
    <div class="all-wrapper menu-side with-pattern">
        <div class="auth-box-w">
            <div class="logo-w">
                <a href="{{url('/')}}"><img src="{{ asset('template/img/logo-big.png') }}"></a>
            </div>
            <h4 class="auth-header">Авторизация
                <div class="login-popup-title-description">Пожалуйста, авторизуйтесь</div>
            </h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <p class="text-danger">
                        @if (session('message'))
                            {{ session('message') }}
                        @endif
                        @if (session('error'))
                            {{ session('error') }}
                        @endif
                    </p>
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="phone">Телефон</label>
                    <input class="form-control" name="username" id="username" placeholder="Телефон"
                           type="text" value="{{ old('username') }}">
                    <div class="pre-icon os-icon os-icon-user-male-circle"></div>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="">Пароль</label>
                    <input class="form-control" name="password" placeholder="Введите пароль" type="password">
                    <div class="pre-icon os-icon os-icon-fingerprint"></div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="buttons-w">
                    <button class="btn btn-primary">Войти</button>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="remember" type="checkbox">Запомнить</label>
                    </div>
                    @php
                        /*
                        <a class="btn btn-link" href="{{ url('/register') }}">Зарегестрироваться</a>
                        <!--a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a-->
                        */
                    @endphp
                </div>

            </form>
        </div>
    </div>
@endsection
