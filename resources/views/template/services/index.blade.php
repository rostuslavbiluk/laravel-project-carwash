@extends('template.app')

@section('title', 'Услуги организации')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <span>Услуги организации</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="element-wrapper">
                <div class="element-box">
                    <form method="POST" action="{{ route('services.edit') }}">
                        @csrf
                        <h5 class="form-header">Настройка услуг</h5>
                        <div class="form-desc">
                            В данном блоке устанавливается привязка услуг которые оказывает организация, после
                            выбора вариантов предоставляемых услуг, будет доступен функционал установки стоимости за
                            услуги.
                        </div>
                        <div class="form-group">
                            <p class="text-danger">
                                @if(session('messageServicesEdit'))
                                    {{session('messageServicesEdit')}}
                                @endif
                            </p>
                        </div>
                        <fieldset class="form-group">
                            <legend><span>Доступные варианты оплат</span></legend>
                            <label>Варианты оплаты с которыми вы работаете</label>
                            <select name="payments[]" class="form-control select2" multiple="true">
                                @if (!empty($result['payments']))
                                    @foreach ($result['payments'] as $item)
                                        <option value="{{ $item['id'] }}"
                                                @isset($result['selected']['payments'])
                                                @if (in_array($item['id'], $result['selected']['payments'], true))
                                                selected
                                                @endif
                                                @endisset
                                        >
                                            {{ $item['name'] }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Не установлено</option>
                                @endif
                            </select>
                        </fieldset>
                        <fieldset class="form-group">
                            <legend><span>Доступные кузова автомобилей</span></legend>
                            <label>Выберите варианты кузова, с которыми вы работаете</label>
                            <select name="profiles_service[]" class="form-control select2" multiple="true">
                                @if (!empty($result['profiles_service']))
                                    @foreach ($result['profiles_service'] as $item)
                                        <option value="{{ $item['id'] }}"
                                                @isset($result['selected']['profiles'])
                                                @if (in_array($item['id'], $result['selected']['profiles'], true))
                                                selected
                                                @endif
                                                @endisset
                                        >
                                            {{ $item['name'] }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Не установлено</option>
                                @endif
                            </select>
                        </fieldset>
                        <fieldset class="form-group">
                            <legend><span>Доступный список услуг</span></legend>
                            <label>Выберите услуги которые вы оказываете</label>
                            <select name="services[]" class="form-control select2" multiple="true">
                                @if (!empty($result['services']))
                                    @foreach ($result['services'] as $item)
                                        <option value="{{ $item['id'] }}"
                                                @isset($result['selected']['services'])
                                                @if (in_array($item['id'], $result['selected']['services'], true))
                                                selected
                                                @endif
                                                @endisset
                                        >
                                            {{ $item['name'] }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Не установлено</option>
                                @endif
                            </select>
                        </fieldset>
                        <div class="form-group">
                            <div class="text-right">
                                <a class="btn btn-secondary btn-sm" target="_blank"
                                   href="{{ route('support.index', ['title' => 'Запрос на добавление новой услуги']) }}">
                                    Добавить новую услугу
                                </a>
                            </div>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit">Сохранить</button>
                        </div>
                    </form>
                </div>

                <div class="element-box">
                    <form method="POST" action="{{ route('services.price.edit') }}">
                        @csrf
                        <h5 class="form-header">Настройка стоимости услуг</h5>
                        <div class="form-desc">
                            В данном блоке устанавливается стоимость услуг которые оказывает организация.
                        </div>
                        <fieldset class="form-group">
                            <legend><span>Стоимость оказания услуг</span></legend>
                            @if (empty($result['selected']['profiles']) || empty($result['selected']['services']))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class=" form-desc">
                                            Для установки стоимости, выберите выше услугу
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="form-desc">
                                    Для редактирования цены, необходимо установить курсор в поле и ввести стоимость.
                                </div>
                                @if (isset($result['selected']['profiles'], $result['selected']['services'])
                                    && (!empty($result['selected']['profiles']) && !empty($result['selected']['services'])))
                                    <table id="editableTable"
                                           class="table table-editable table-striped table-lightfont">
                                        <thead>
                                        <tr>
                                            <th>Услуга\Профиль</th>
                                            @isset($result['selected']['profiles'])
                                                @foreach($result['selected']['profiles'] as $profileId)
                                                    @php
                                                        $item = false;
                                                        $itemFind = array_filter($result['profiles_service'], function($item, $key) use ($profileId) {
                                                            return (int)$item['id'] === (int)$profileId;
                                                        }, ARRAY_FILTER_USE_BOTH);
                                                        if (!empty($itemFind)) {
                                                            $item = array_shift($itemFind);
                                                        }
                                                    @endphp
                                                    <th>{{ $item['name'] ?? '' }}</th>
                                                @endforeach
                                            @endisset
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($result['selected']['services'])
                                            @foreach($result['selected']['services'] as $serviceId)
                                                <tr>
                                                    @php
                                                        $itemService = false;
                                                        $itemFind = array_filter($result['services'], function($item, $key) use ($serviceId) {
                                                            return (int)$item['id'] === (int)$serviceId;
                                                        }, ARRAY_FILTER_USE_BOTH);
                                                        if (!empty($itemFind)) {
                                                            $itemService = array_shift($itemFind);
                                                        }
                                                        $priceList = array_filter($result['related']['services'], function($item, $key) use ($serviceId) {
                                                            return ((int)$item['service_id'] === (int)$serviceId);
                                                        }, ARRAY_FILTER_USE_BOTH);
                                                    @endphp
                                                    <th>{{ $itemService['name'] ?? '' }}</th>
                                                    @isset($result['selected']['profiles'])
                                                        @foreach($result['selected']['profiles'] as $profileId)
                                                            @php
                                                                $itemPrice = false;
                                                                $itemFind = array_filter($priceList, function($item, $key) use ($serviceId, $profileId) {
                                                                    return ((int)$item['service_id'] === (int)$serviceId && (int)$item['profile_id'] === (int)$profileId);
                                                                }, ARRAY_FILTER_USE_BOTH);
                                                                if (!empty($itemFind)) {
                                                                    $itemPrice = array_shift($itemFind);
                                                                }
                                                            @endphp
                                                            <td data-serviceId="{{ $itemPrice['id'] ?? '' }}">{{ $itemPrice['cost'] ?? '0' }}</td>
                                                        @endforeach
                                                    @endisset
                                                </tr>
                                            @endforeach
                                        @endisset
                                        </tbody>
                                    </table>
                                @endif
                            @endif
                        </fieldset>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection