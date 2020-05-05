<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <meta content="" name="keywords">
    <meta content="" name="author">
    <meta content="" name="description">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('template/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('template/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
{{--}}
    <link href="{!! asset('template/bower_components/select2/dist/css/select2.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/bootstrap-daterangepicker/daterangepicker.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/dropzone/dist/dropzone.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/css/main.css?version=3.1') !!}" rel="stylesheet">
    <link href="{!! asset('template/css/template_css.css') !!}" rel="stylesheet">
{{--}}
    <link href="{!! asset('template/bower_components/slick-carousel/slick/slick.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/css/front/main.css?version=3.1') !!}" rel="stylesheet">

</head>
<body>

    <div class="all-wrapper">
    <div class="fade1"></div>
    <div class="desktop-menu menu-top-w menu-activated-on-hover">
        <div class="menu-top-i os-container">
            <div class="logo-w">
                <div class="logo-element"></div>
            </div>
            <ul class="main-menu">
                <li class="active">
                    <a href="#sectionIntro">Главная</a>
                </li>
                <li>
                    <a href="#sectionTestimonials">Отзывы</a>
                </li>
            </ul>
            <ul class="small-menu">
                <li>
                    <a href="{{ route('/') }}"><i class="os-icon os-icon-email-forward"></i><span>Контакты</span></a>
                </li>
                @guest
                    <li class="separate">
                        <a href="{{ route('login') }}">Авторизация</a>
                    </li>
                    @if (Route::has('register'))
                    <li>
                        <a class="highlight" href="{{ route('/') }}">Подключиться</a>
                    </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <div class="mobile-menu-w">
            <div class="mobile-menu-holder color-scheme-dark">
                <ul class="mobile-menu">
                    <li class="active">
                        <a href="#sectionIntro">Главная</a>
                    </li>
                    <li>
                        <a href="#sectionTestimonials">Отзывы</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}">Контакты</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Авторизация</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}">Подключиться</a>
                    </li>
                </ul>
            </div>
            <div class="mobile-menu-i">
                <div class="mobile-logo-w">
                    <div class="logo-element"></div>
                </div>
                <div class="mobile-menu-trigger">
                    <i class="os-icon os-icon-hamburger-menu-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-w layout-v1" id="sectionIntro">
        <div class="os-container">
            <div class="fade2"></div>
            <div class="intro-i">
                <div class="intro-description">
                    <h1 class="intro-heading">
                        Текст слоган <span>АвтоМойка 24</span> для демонстрации
                    </h1>
                    <div class="intro-text">
                        Стартовый текст для демонстрации. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст..
                    </div>
                    <div class="intro-buttons">
                        <a class="btn btn-primary" href="{{ url('/') }}" target="_blank">
                            <i class="os-icon"></i>
                            <span>Подключиться</span></a>
                    </div>
                </div>
                <div class="intro-media">
                    <div class="shot shot1">
                        <div class="shot-i" style="background-image: url({{ asset('template/img/front/intro_chat.jpg') }})"></div>
                    </div>
                    <div class="shot shot2">
                        <div class="shot-i" style="background-image: url({{ asset('template/img/front/intro_profile.jpg') }})"></div>
                    </div>
                    <div class="shot shot3">
                        <div class="shot-i" style="background-image: url({{ asset('template/img/front/intro_dash.jpg') }})"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="counters-w">
        <div class="os-container">
            <div class="counters-i">
                <div class="counter">
                    <div class="counter-value-w">
                        <div class="counter-value">
                            700
                        </div>
                        <div class="counter-name">
                            Объектов
                        </div>
                    </div>
                    <div class="counter-description">
                        Общее количество подключенных объектов
                    </div>
                </div>
                <div class="counter">
                    <div class="counter-value-w">
                        <div class="counter-value">
                            80
                        </div>
                        <div class="counter-name">
                            Углуг
                        </div>
                    </div>
                    <div class="counter-description">
                        Суммарное количество услуг
                    </div>
                </div>
                <div class="counter">
                    <div class="counter-value-w">
                        <div class="counter-value">
                            12000
                        </div>
                        <div class="counter-name">
                            Пользователей
                        </div>
                    </div>
                    <div class="counter-description">
                        Счастливые клиенты, использующие наш продукт
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="testimonials-w relative" id="sectionTestimonials">
        <div class="fade4"></div>
        <div class="testimonials-i">
            <div class="os-container">
                <div class="section-header dark">
                    <h5 class="section-sub-title">
                        Слушайте, что говорят наши клиенты
                    </h5>
                    <h2 class="section-title">
                        Отзывы клиентов
                    </h2>
                    <div class="section-desc">
                        Блок содержит отзывы клиентов о разработанной системе.
                    </div>
                </div>
            </div>
            <div class="testimonials-slider-w">
                <div class="testimonials-slider">
                    <div class="slide-w">
                        <div class="slide">
                            <div class="testimonial-title">
                                Крутой сервис!
                            </div>
                            <div class="testimonial-content">
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                            </div>
                            <div class="testimonial-by">
                                <strong>Имя Фамилия</strong><span>Москва</span>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar1.jpg') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-w">
                        <div class="slide">
                            <div class="testimonial-title">
                                Крутой сервис!
                            </div>
                            <div class="testimonial-content">
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                            </div>
                            <div class="testimonial-by">
                                <strong>Имя Фамилия</strong><span>Москва</span>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar2.jpg') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-w">
                        <div class="slide">
                            <div class="testimonial-title">
                                Крутой сервис!
                            </div>
                            <div class="testimonial-content">
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                            </div>
                            <div class="testimonial-by">
                                <strong>Имя Фамилия</strong><span>Москва</span>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar3.jpg') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-w">
                        <div class="slide">
                            <div class="testimonial-title">
                                Крутой сервис!
                            </div>
                            <div class="testimonial-content">
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                            </div>
                            <div class="testimonial-by">
                                <strong>Имя Фамилия</strong><span>Москва</span>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar4.jpg') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-w">
                        <div class="slide">
                            <div class="testimonial-title">
                                Крутой сервис!
                            </div>
                            <div class="testimonial-content">
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                            </div>
                            <div class="testimonial-by">
                                <strong>Имя Фамилия</strong><span>Москва</span>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar5.jpg') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-w">
                        <div class="slide">
                            <div class="testimonial-title">
                                Крутой сервис!
                            </div>
                            <div class="testimonial-content">
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                            </div>
                            <div class="testimonial-by">
                                <strong>Имя Фамилия</strong><span>Москва</span>
                                <div class="avatar">
                                    <img alt="" src="{!! asset('template/img/avatar6.jpg') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="call-to-action">
        <h3 class="cta-header">
            Хотите попробовать сейчас?
        </h3>
        <div class="cta-desc">
            Установите приложениесейчас и приступите к созданию своего следующего бизнес-предприятия с помощью этого продукта
        </div>
        <div class="cta-btn">
            <a class="btn btn-primary btn-lg btn-rounded" href="#">
                <span>Установить приложение</span>
                <i class="os-icon os-icon-arrow-right4"></i>
                <i class="os-icon os-icon-arrow-right4"></i></a>
        </div>
    </div>
    <div class="footer-w">
        <div class="fade3"></div>
        <div class="os-container">
            <div class="footer-i">
                <div class="row">
                    <div class="col-sm-7 col-lg-4 b-r padded">
                        <div class="logo-element"></div>
                        <h3 class="heading-big">
                            АвтоМойка 24
                        </h3>
                        <h6 class="heading-small">
                            Приложение объекта
                        </h6>
                        <p>
                            Мы любим отличный пользовательский интерфейс и приятный пользовательский интерфейс,
                            поэтому мы потратили столько времени на то, чтобы сделать приложение максимально комфортным в использовании.
                        </p>
                    </div>
                    <div class="col-sm-5 col-lg-8">
                        <div class="row">
                            <div class="col-lg-4 b-r padded">
                                <h6 class="heading-small">
                                    Местонахождение
                                </h6>
                                <p>
                                    456 Голливудский бул. <br/>Москва, 95543
                                </p>
                            </div>
                            <div class="col-lg-4 b-r padded">
                                <h6 class="heading-small">
                                    Телефонные номера
                                </h6>
                                <ul>
                                    <li>
                                        888.345.6362
                                    </li>
                                    <li>
                                        800.244.6272
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4 padded">
                                <h6 class="heading-small">
                                    Социальные ссылки
                                </h6>
                                <ul class="social-links">
                                    <li>
                                        <a href="#"><i class="os-icon os-icon-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="os-icon os-icon-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="deep-footer">
                Использование этого сайта означает принятие нашего
                <a href="#">Пользовательского Соглашения</a> и
                <a href="#">Политика конфиденциальности</a>. &copy; 2018 Все права защищены.
            </div>
        </div>
    </div>
    <div class="display-type"></div>
</div>
{{--}}
    <div class="all-wrapper menu-side with-pattern">
        <div class="container">
            <div class="row">


                <ul>
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Welcome</div>

                        <div class="panel-body">
                            Your Application's Landing Page.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
{{--}}

    <script src="{!! asset('template/bower_components/jquery/dist/jquery.min.js') !!}"></script>

{{--}}
    <script src="{!! asset('template/bower_components/moment/moment.js') !!}"></script>
    <script src="{!! asset('template/bower_components/chart.js/dist/Chart.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/select2/dist/js/select2.full.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/ckeditor/ckeditor.js') !!}"></script>
    <script src="{!! asset('template/bower_components/bootstrap-validator/dist/validator.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/bootstrap-daterangepicker/daterangepicker.js') !!}"></script>
    <script src="{!! asset('template/bower_components/dropzone/dist/dropzone.js') !!}"></script>
    <script src="{!! asset('template/bower_components/editable-table/mindmup-editabletable.js') !!}"></script>
    <script src="{!! asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/bootstrap/js/dist/util.js') !!}"></script>
    <script src="{!! asset('template/bower_components/bootstrap/js/dist/tab.js') !!}"></script>
    <script src="{!! asset('template/js/main.js?version=3.1') !!}"></script>
{{--}}
    <script src="{!! asset('template/bower_components/slick-carousel/slick/slick.min.js') !!}"></script>
    <script src="{!! asset('template/js/main_front.js?version=3.0') !!}"></script>

    <script src="{!! asset('template/js/jquery.maskedinput.min.js') !!}"></script>
    <script src="{!! asset('template/js/ext.script.js') !!}"></script>

    @include('layouts.counters')
    @yield('scripts','')
</body>
</html>
