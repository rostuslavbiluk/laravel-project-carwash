@extends('template.app')

@section('title', $articles['title'] ?? '')

@section('breadcrumb')

    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <span>{{ $articles['title'] ?? '' }}</span>
        </li>
    </ul>

@endsection

@section('content')

    @foreach($articles['list'] as $item)
        <x-articles.mini class="element-box"
                :code="$item['code']"
                :title="$item['name']"
                :content="$item['preview']" />
    @endforeach

@endsection