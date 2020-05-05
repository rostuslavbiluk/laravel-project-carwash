<div {{ $attributes }}>
    <div class="logged-user-avatar-info">
        <x-user.mini-info/>
    </div>
    <div class="bg-icon">
        <i class="os-icon os-icon-wallet-loaded"></i>
    </div>
    <ul>
        <li>
            <a href="{{ route('profile') }}">
                <i class="os-icon os-icon-user-male-circle2"></i>
                <span>Настройки</span>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                <i class="os-icon os-icon-signs-11"></i>
                <span>Выход</span>
            </a>
        </li>
    </ul>
</div>