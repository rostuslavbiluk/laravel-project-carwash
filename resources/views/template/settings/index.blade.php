@extends('template.app')

@section('title', 'Основный настройки сайта')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <span>Настройки сайта</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">

        </div>
    </div>
@endsection

@section('scripts')
<script>


</script>
@endsection