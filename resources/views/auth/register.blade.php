@extends('layouts.app')

@section('title', 'Регистрация на портале')

@section('content')
    <div class="all-wrapper menu-side with-pattern">
        <div class="auth-box-w wider">
            <div class="logo-w">
                <a href="{{ url('/admin') }}"><img src="{{ asset('template/img/logo-big.png') }}"></a>
            </div>
            <h4 class="auth-header">Регистрация на портале</h4>
            <form action="{{ url('/register') }}" method="POST">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="">Имя</label>
                    <input class="form-control" placeholder="Введите ваше имя" type="text" name="name" value="{{ old('name') }}">
                    <div class="pre-icon os-icon os-icon-text-input"></div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="">Ваш телефон</label>
                    <input class="form-control phone-mask" placeholder="Ваш телефон" type="text" name="phone" value="{{ old('phone') }}">
                    <div class="pre-icon os-icon os-icon-phone-15"></div>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>

                @php
                    /*
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="">Ваш емаил</label>
                        <input class="form-control" placeholder="Введите ваш емаил" type="email" name="email" value="{{ old('email') }}">
                        <div class="pre-icon os-icon os-icon-email-2-at2"></div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div> */
                @endphp

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for=""> Пароль</label>
                            <input class="form-control" placeholder="Пароль" type="password" name="password">
                            <div class="pre-icon os-icon os-icon-fingerprint"></div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="">Подтвердите пароль</label>
                            <input class="form-control" placeholder="Подтвердите пароль" type="password" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="buttons-w">
                    <button class="btn btn-primary">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>

@endsection
