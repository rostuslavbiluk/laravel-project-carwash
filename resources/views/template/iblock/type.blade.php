@extends('template.app')

@section('title', $result['title'] ?? '')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('iblock.index') }}">Информационные страницы</a>
        </li>
        <li class="breadcrumb-item">
            <span>{{ $result['title'] ?? '' }}</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <h6 class="element-header">{{ $result['title'] ?? '' }}</h6>
                @include('template.layouts.block-table')
                <div class="form-buttons-w text-left">
                    <a class="btn btn-primary" data-click="step-trigger-btn" href="{{ route('') }}">Вернуться назад</a>
                </div>
            </div>
        </div>
    </div>
@endsection