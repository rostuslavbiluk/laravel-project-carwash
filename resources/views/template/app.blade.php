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

    <link href="{!! asset('template/bower_components/select2/dist/css/select2.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/bootstrap-daterangepicker/daterangepicker.css') !!}"
          rel="stylesheet">
    <link href="{!! asset('template/bower_components/dropzone/dist/dropzone.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}"
          rel="stylesheet">
    <link href="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('template/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css') !!}"
          rel="stylesheet">
    <link href="{!! asset('template/css/main.css?version=3.1') !!}" rel="stylesheet">
    <link href="{!! asset('template/css/template_css.css') !!}" rel="stylesheet">

</head>
<body>
<div class="all-wrapper menu-side with-side-panel">
    <div class="layout-w">
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
            <x-logo :prefix="'mm-'" class="mm-logo-buttons-w">
                <div class="mm-buttons">
                    <div class="mobile-menu-trigger">
                        <div class="os-icon os-icon-hamburger-menu-1"></div>
                    </div>
                </div>
            </x-logo>
            <div class="menu-and-user">
                <div class="logged-user-w">
                    <x-user.mini-info/>
                    {{-- @include('template.layouts.block-user-info') --}}
                </div>
                <x-menu/>
                {{-- @include('template.layouts.block-menu') --}}
                <div class="mobile-menu-magic">
                    <x-sidebar.support/>
                    {{-- @include('template.layouts.block-sidebar') --}}
                </div>
            </div>
        </div>
        <div class="desktop-menu menu-side-w menu-activated-on-click">
            <x-logo :prefix="''" class="logo-w"/>
            <div class="menu-and-user">
                <div class="logged-user-w">
                    <div class="logged-user-i">
                        <x-user.mini-info/>
                        <x-user.popup-user-mini-info class="logged-user-menu"/>
                    </div>
                </div>

                <x-menu/>

                <div class="side-menu-magic">
                    <x-sidebar.support/>
                </div>
            </div>
        </div>
        <div class="content-w">
            @yield('breadcrumb')
            <div class="content-i">
                <div class="content-box">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <div id="notifications_block" class="notifications-all"></div>
    <div class="display-type"></div>
</div>
<script src="{!! asset('template/bower_components/jquery/dist/jquery.min.js') !!}"></script>
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

<script src="{!! asset('template/js/jquery.maskedinput.min.js') !!}"></script>
<script src="{!! asset('template/js/ext.script.js') !!}"></script>

@include('template.counters')

<script>
    /*$(document).ready(function () {
        setInterval(function () {
            //code goes here that will be run every 5 seconds.
            $.ajax({
                type: "POST",
                url: "/dashboard/ajax/notify/get_notification_user",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) { $('#notifications_block').html(data); },
                error: function (msg) { console.log(msg); }
            });
        }, 60000);
    });*/

    function button_close_notification(notification_id) {
        $.ajax({
            type: "POST",
            url: "/dashboard/ajax/notify/read_notification",
            data: {notification_id: notification_id},
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#' + data).remove();
            },
            error: function (msg) {
                console.log(msg);
            }
        });
    }
</script>
@yield('scripts','')
</body>
</html>