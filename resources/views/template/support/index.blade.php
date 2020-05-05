@extends('template.app')

@section('title', 'Обращение в Техподдержку')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('support.index') }}">Обращение в Техподдержку</a>
        </li>
        <li class="breadcrumb-item">
            <span>Новый тикет</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <div class="element-box">
                    <div class="form-group">
                        <p class="text-danger">
                            @if (session('errors'))
                                {{ session('errors') }}
                            @endif
                        </p>
                    </div>
                    <form id="formValidate" method="POST" action="{{ route('support.send') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="active" value="Y">
                        <input type="hidden" name="status" value="S">
                        <h5 class="form-header">Служба техподдержки</h5>
                        <div class="form-desc">
                            Пожалуйста, предоставьте всю информацию, необходимую для ответа. Для того чтобы избежать
                            дополнительных вопросов, рекомендуем использовать следующие простые правила:
                            При создании обращения укажите все источники, где вы искали и не нашли ответ. Это избавит
                            вас от получения ссылок вместо ответа.
                        </div>
                        <div class="form-desc">
                            Ответ будет отправлен на вашу почту
                            {!! $user['email'] ?? '<a href="' . route('profile') . '">указать почту</a>' !!}
                        </div>
                        <div class="form-group">
                            <label for="">Тема сообщения</label>
                            <input name="title" value="{{ $title ?? '' }}" class="form-control"
                                   data-error="Введите тему сообщения" placeholder="Введите тему" required="required"
                                   type="text">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Текст сообщения</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" checked required="required" type="checkbox">Я согласен с
                                правилами и условиями</label>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit"> Отправить сообщение</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection