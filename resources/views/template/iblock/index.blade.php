@extends('template.app')

@section('title', 'Информационные страницы')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <span>Список инфоблоков</span>
        </li>
    </ul>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <h6 class="element-header">Список информационных блоков</h6>
                <div class="element-content">
                    <div class="row">
                        @if (!empty($result['items']))
                            @foreach($result['items'] as $item)
                                <div class="col-sm-4">
                                    <div class="element-box el-tablo">
                                        <div class="label">{{ $item['name'] }}</div>
                                        <div class="value">
                                            <div class="pt-btn">
                                                <a class="btn btn-success btn-sm"
                                                   href="{{ route('iblock.list', ['code' => $item['code'] ?? '']) }}">Просмотреть</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
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
            <h6 class="element-header">Меню управления</h6>
            <div class="element-box-tp">
                <div class="el-buttons-list full-width">
                    <a class="btn btn-white btn-sm" href="{{ route('iblock.type.add') }}">
                        <i class="os-icon os-icon-delivery-box-2"></i><span>Добавить инфоблок</span></a>
                    <a class="btn btn-white btn-sm" href="{{ route('iblock.type') }}">
                        <i class="os-icon os-icon-window-content"></i><span>Список инфоблоков</span></a>
                </div>
            </div>
        </div>

@endsection