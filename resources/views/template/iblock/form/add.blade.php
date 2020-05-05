@extends('template.app')

@section('title', 'Добавление новой записи')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/iblock') }}">Информационные страницы</a>
        </li>
        <li class="breadcrumb-item">
            <span>Добавление новой записи</span>
        </li>
    </ul>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <h6 class="element-header">
                    Информационные блоки: Добавление
                </h6>

                <div class="element-box">
                    <form method="POST" action="{{ url($arResult['ACTION']) }}">
                    {{csrf_field()}}

                        @if (isset($arResult['TITLE']))
                        <h5 class="form-header">
                            {{$arResult['TITLE']}}
                        </h5>
                        @endif

                        @if (isset($arResult['DESCRIPTION']))
                        <div class="form-desc">
                            {{$arResult['DESCRIPTION']}}
                        </div>
                        @endif

                        @include('template.iblock.form.include-fields')

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit"> Сохранить</button>

                            <a class="btn btn-cancel"
                               data-click="step-trigger-btn" href="{{ url($arResult['BACK']) }}"> Вернуться назад </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    </div>

    @php/*
    <div class="content-panel">
        <div class="content-panel-close">
            <i class="os-icon os-icon-close"></i>
        </div>
        <div class="element-wrapper">
            <h6 class="element-header">
                Меню управления
            </h6>
            <div class="element-box-tp">
                <div class="el-buttons-list full-width">

                    <a class="btn btn-white btn-sm" href="#">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Добавить новый инфоблок</span></a>

                    <a class="btn btn-white btn-sm" href="#">
                        <i class="os-icon os-icon-window-content"></i><span>Список инфоблоков</span></a>

                </div>
            </div>
        </div>
        */@endphp

@endsection
