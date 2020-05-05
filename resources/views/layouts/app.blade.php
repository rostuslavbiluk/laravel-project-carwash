<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

    <link href="{!! asset('template/bower_components/select2/dist/css/select2.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/bootstrap-daterangepicker/daterangepicker.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/dropzone/dist/dropzone.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/css/main.css?version=3.1') !!}" rel="stylesheet">
    <link href="{!! asset('template/css/template_css.css') !!}" rel="stylesheet">

    <script src="{!! asset('template/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <script src="{!! asset('template/js/jquery.maskedinput.min.js') !!}"></script>
    <script src="{!! asset('template/js/ext.script.js') !!}"></script>

</head>
<body class="auth-wrapper">
    @yield('content')
</body>
</html>