@extends('template.app')

@section('title', 'Сообщение было успешно отправлено в техподдержку')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('support.index') }}">Обращение в Техподдержку</a>
        </li>
        <li class="breadcrumb-item">
            <span>Обращение успешно отправлено</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <div class="element-box">
                    <h5 class="form-header">
                        Обращение успешно отправлено, ожидайте скоро вам перезвонит оператор.
                    </h5><br/>
                    <a class="btn btn-primary" href="{{ route('dashboard.index') }}">
                        <i class=""></i><span>Вернуться на главную</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
