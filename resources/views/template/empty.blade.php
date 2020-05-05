@extends('template.app')

@section('title', 'АвтоМойка')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Главная</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="os-tabs-w"></div>
    <div class="row">
        <x-functionality-limited class="col-lg-12"/>
    </div>
@endsection
