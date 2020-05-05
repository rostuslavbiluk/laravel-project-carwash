<div {{ $attributes }}>
    <a class="{{ $prefix }}logo" href="{{ route('dashboard.index') }}">
        <img src="{{ asset('template/img/logo.png') }}"/><span>Админ панель</span>
    </a>
    {{ $slot }}
</div>