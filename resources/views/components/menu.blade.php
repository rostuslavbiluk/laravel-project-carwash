<div>
    <ul class="main-menu">
        <li>
            <a href="{{ route('dashboard.index') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-window-content"></div>
                </div>
                <span>Рабочий стол</span></a>
        </li>

        <li class="has-sub-menu active">
            <a href="{{ route('dashboard.index') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-hierarchy-structure-2"></div>
                </div>
                <span>Контент</span></a>
            <ul class="sub-menu">
                <li>
                    <a href="{{ route('iblock.index') }}">Инфоблоки</a>
                </li>
                <li>
                    <a href="{{ route('iblock.type') }}">Настройка инфоблоков</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('profile') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-grid-squares"></div>
                </div>
                <span>Настройки</span></a>
        </li>

        <li>
            <a href="{{ route('requisites.index') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-tasks-checked"></div>
                </div>
                <span>Реквизиты</span></a>
        </li>

        <li>
            <a href="{{ route('articles.show', ['code' => 'help']) }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-newspaper"></div>
                </div>
                <span>Как это работает?</span>
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-cancel-square"></div>
                </div>
                <span>Выход</span></a>
        </li>
    </ul>
</div>