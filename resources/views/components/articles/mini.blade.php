<div {{ $attributes }}>
    <h5 class="form-header">
        <a href="{{ route('articles.show', ['code' => $code ?? '']) }}">
            {{ $title ?? '' }}
        </a>
    </h5>
    <div class="form-desc">
        {!! $content ?? '' !!}
    </div>
</div>