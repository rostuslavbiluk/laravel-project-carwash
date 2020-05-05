@extends('template.app')

@section('title', 'Добавление нового типа инфоблока')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/iblock') }}">Информационные страницы</a>
        </li>
        <li class="breadcrumb-item">
            <span>Добавление нового типа инфоблока</span>
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

                        <input type="hidden" name="SEND_FORM" value="Y">
                        <input type="hidden" name="TYPE_FORM" value="{{$arResult['TYPE_FORM']}}">

                        @php /*<input type="hidden" name="ID" value="{{ $arResult['ID'] }}">*/ @endphp

                        <h5 class="form-header">
                            Информационный блок
                        </h5>
                        <div class="form-desc">
                            Модуль Информационные блоки предназначен для управления различными блоками однородной информации.
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-5" for="active"> Информационный блок активен</label>
                            <div class="col-sm-7">
                                <input class="form-check-input" id="active"
                                    @if (isset($arResult['FIELDS']['active']) && $arResult['FIELDS']['active'] == 'Y')
                                        checked
                                    @elseif(!isset($arResult['FIELDS']['active']))
                                        checked
                                    @endif
                                    name="active" type="checkbox" value="Y">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-4" for="name"> Название</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="name"
                                    name="name" type="text" required="required"
                                    @if (isset($arResult['FIELDS']['name']))
                                        value="{{ $arResult['FIELDS']['name'] }}"
                                    @endif
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-4" for="code"> Символьный код</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="code"
                                    name="code" type="text" required="required"
                                    @if (isset($arResult['FIELDS']['code']))
                                        value="{{ $arResult['FIELDS']['code'] }}"
                                    @endif
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-4" for="sort"> Сортировка</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="sort"
                                    name="sort" type="text"
                                    @if (isset($arResult['FIELDS']['sort']))
                                        value="{{ $arResult['FIELDS']['sort'] }}"
                                    @else
                                       value="500"
                                    @endif
                                >
                            </div>
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit"> Сохранить</button>

                            <a class="btn btn-cancel"
                               data-click="step-trigger-btn" href="{{ url('/admin/iblock') }}"> Вернуться назад </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    </div>
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

                    <a class="btn btn-white btn-sm" href="{{ url('/admin/iblock/type/add') }}">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Добавить новый инфоблок</span></a>

                    <a class="btn btn-white btn-sm" href="{{ url('/admin/iblock/type') }}">
                        <i class="os-icon os-icon-window-content"></i><span>Список инфоблоков</span></a>

                </div>
            </div>
        </div>

@endsection