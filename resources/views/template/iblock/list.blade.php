@extends('template.app')

@section('title', 'Информационные страницы')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/iblock') }}">Информационные страницы</a>
        </li>
        <li class="breadcrumb-item">
            <span>
                @if (isset($arResult['H1']))
                {{ $arResult['H1'] }}
                @else
                    Инфоблок
                @endif
            </span>
        </li>
    </ul>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <h6 class="element-header">
                    @if (isset($arResult['H1']))
                        {{ $arResult['H1'] }}
                    @else
                        Инфоблок
                    @endif
                </h6>

                @include('template.layouts.block-table')

                <div class="form-buttons-w text-left">
                    <a class="btn btn-primary" data-click="step-trigger-btn" href="{{ url('/admin/iblock') }}"> Вернуться назад </a>
                </div>

            </div>
        </div>
    </div>
@endsection