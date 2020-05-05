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

    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <h6 class="element-header">
                    Основные настройки сайта
                </h6>
                <div class="element-content">
                    <div class="row">

                        @if (!empty($arResult['ITEMS']))
                            @foreach($arResult['ITEMS'] as $arItem)

                                <div class="col-sm-4">
                                    <div class="element-box el-tablo">
                                        <div class="label">
                                            {{ $arItem['name'] }}
                                        </div>
                                        <div class="value">
                                            <div class="pt-btn">
                                                <a class="btn btn-success btn-sm"
                                                   href="{{ url($arItem['code']) }}">Перейти</a>
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


    {{--}}

    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="nav nav-tabs upper">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab_overview">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_sales">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_sales">Closed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_sales">Required</a>
                </li>
            </ul>
            <ul class="nav nav-pills smaller hidden-md-down">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#">Today</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#">7 Days</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#">14 Days</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#">Last Month</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="padded-lg">
                <div class="projects-list">

                    <div class="project-box">
                        <div class="project-head">
                            <div class="project-title">
                                <h5>
                                    Название объекта 1
                                </h5>
                            </div>
                            <div class="project-users">
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar3.jpg') !!}">
                                </div>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar1.jpg') !!}">
                                </div>

                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar5.jpg') !!}">
                                </div>

                                <div class="avatar">
                                    <img alt="" src="{{ asset('template/img/avatar2.jpg') }}">
                                </div>

                                <div class="more">
                                    + 2000 еще
                                </div>
                            </div>
                        </div>
                        <div class="project-info">
                            <div class="row align-items-center">
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="el-tablo highlight">
                                                <div class="label">
                                                    Кол-во пользователей
                                                </div>
                                                <div class="value">
                                                    15
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="el-tablo highlight">
                                                <div class="label">
                                                    Кол-во воспользовались
                                                </div>
                                                <div class="value">
                                                    24
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5 offset-sm-2">
                                    <div class="os-progress-bar blue">
                                        <div class="bar-labels">
                                            <div class="bar-label-left">
                                                <span>Диманика активности</span><span class="positive">+10</span>
                                            </div>
                                            <div class="bar-label-right">
                                                <span class="info">72/100</span>
                                            </div>
                                        </div>
                                        <div class="bar-level-1" style="width: 100%">
                                            <div class="bar-level-2" style="width: 72%">
                                                <div class="bar-level-3" style="width: 36%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="project-box">
                        <div class="project-head">
                            <div class="project-title">
                                <h5>
                                    Название объекта 2
                                </h5>
                            </div>
                            <div class="project-users">
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar1.jpg') !!}">
                                </div>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar6.jpg') !!}">
                                </div>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar4.jpg') !!}">
                                </div>

                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar1.jpg') !!}">
                                </div>

                                <div class="more">
                                    + 200 еще
                                </div>
                            </div>
                        </div>
                        <div class="project-info">
                            <div class="row align-items-center">
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="el-tablo highlight">
                                                <div class="label">
                                                    Кол-во пользователей
                                                </div>
                                                <div class="value">
                                                    27
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="el-tablo highlight">
                                                <div class="label">
                                                    Кол-во воспользовались
                                                </div>
                                                <div class="value">
                                                    12
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5 offset-sm-2">
                                    <div class="os-progress-bar blue">
                                        <div class="bar-labels">
                                            <div class="bar-label-left">
                                                <span>Динамика активности</span><span class="positive">+10</span>
                                            </div>
                                            <div class="bar-label-right">
                                                <span class="info">56/100</span>
                                            </div>
                                        </div>
                                        <div class="bar-level-1" style="width: 100%">
                                            <div class="bar-level-2" style="width: 56%">
                                                <div class="bar-level-3" style="width: 28%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-5 b-l-lg">
            <div class="padded-lg">
                <div class="element-wrapper">

                    <div class="element-actions">
                        <form class="form-inline justify-content-sm-end">
                            <select class="form-control form-control-sm rounded">
                                <option value="Pending">
                                    За сегодня
                                </option>
                                <option value="Active">
                                    За неделю
                                </option>
                                <option value="Cancelled">
                                    За месяц
                                </option>
                            </select>
                        </form>
                    </div>

                    <h6 class="element-header">
                        Проектная статистика
                    </h6>
                    <div class="element-box">
                        <div class="padded m-b">
                            <div class="centered-header">
                                <h6>
                                    Статистика за период
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-6 b-r b-b">
                                    <div class="el-tablo centered padded-v-big highlight bigger">
                                        <div class="label">
                                            Новых
                                        </div>
                                        <div class="value">
                                            24
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 b-b">
                                    <div class="el-tablo centered padded-v-big highlight bigger">
                                        <div class="label">
                                            Активных
                                        </div>
                                        <div class="value">
                                            251
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="padded m-b">
                            <div class="centered-header">
                                <h6>
                                    Динамика подключений
                                </h6>
                            </div>
                            <div class="os-progress-bar blue">
                                <div class="bar-labels">
                                    <div class="bar-label-left">
                                        <span>Progress</span><span class="positive">+12</span>
                                    </div>
                                    <div class="bar-label-right">
                                        <span class="info">72/100</span>
                                    </div>
                                </div>
                                <div class="bar-level-1" style="width: 100%">
                                    <div class="bar-level-2" style="width: 72%">
                                        <div class="bar-level-3" style="width: 25%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="os-progress-bar blue">
                                <div class="bar-labels">
                                    <div class="bar-label-left">
                                        <span>Progress</span><span class="negative">-5</span>
                                    </div>
                                    <div class="bar-label-right">
                                        <span class="info">54/100</span>
                                    </div>
                                </div>
                                <div class="bar-level-1" style="width: 100%">
                                    <div class="bar-level-2" style="width: 54%">
                                        <div class="bar-level-3" style="width: 25%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="os-progress-bar blue">
                                <div class="bar-labels">
                                    <div class="bar-label-left">
                                        <span>Progress</span><span class="positive">+5</span>
                                    </div>
                                    <div class="bar-label-right">
                                        <span class="info">86/100</span>
                                    </div>
                                </div>
                                <div class="bar-level-1" style="width: 100%">
                                    <div class="bar-level-2" style="width: 86%">
                                        <div class="bar-level-3" style="width: 25%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="padded">
                            <div class="centered-header">
                                <h6>
                                    Динамика роста активности
                                </h6>
                            </div>
                            <div class="el-chart-w">
                                <canvas height="130" id="liteLineChart" width="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="floated-chat-btn">
        <i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
    </div>
    <div class="floated-chat-w">
        <div class="floated-chat-i">
            <div class="chat-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            <div class="chat-head">
                <div class="user-w with-status status-green">
                    <div class="user-avatar-w">
                        <div class="user-avatar">
                            <img alt="" src="img/avatar1.jpg">
                        </div>
                    </div>
                    <div class="user-name">
                        <h6 class="user-title">
                            John Mayers
                        </h6>
                        <div class="user-role">
                            Account Manager
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-messages">
                <div class="message">
                    <div class="message-content">
                        Hi, how can I help you?
                    </div>
                </div>
                <div class="date-break">
                    Mon 10:20am
                </div>
                <div class="message">
                    <div class="message-content">
                        Hi, my name is Mike, I will be happy to assist you
                    </div>
                </div>
                <div class="message self">
                    <div class="message-content">
                        Hi, I tried ordering this product and it keeps showing me error code.
                    </div>
                </div>
            </div>
            <div class="chat-controls">
                <input class="message-input" placeholder="Type your message here..." type="text">
                <div class="chat-extra">
                    <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
                </div>
            </div>
        </div>
    </div>
    {{--}}


@endsection
