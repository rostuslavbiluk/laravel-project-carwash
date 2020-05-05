@extends('template.app')

@section('title', $article['name'] ?? '')

@section('breadcrumb')

    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('articles.index') }}">Информация</a>
        </li>
        <li class="breadcrumb-item">
            <span>{{ $article['name'] ?? '' }}</span>
        </li>
    </ul>

@endsection

@section('content')

    <x-articles.show class="section-heading centered" :title="$article['name']" :content="$article['content']" />

@endsection