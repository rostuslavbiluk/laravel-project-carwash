@extends('template.app')

@section('title', 'Рабочий стол')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin') }}">Рабочий стол</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="all-wrapper menu-side with-side-panel">
        <div class="layout-w">
            <div class="content-w">
                <div class="content-i">
                    <div class="content-box">

                        <div class="row">
                            @if ($arResult['SHOW_BLOCK_NEW_ORDERS'] == 'Y')
                                @php
                                    $sClass = 'col-sm-12';
                                    if (isset($arResult['ENTITY']) && !empty($arResult['ENTITY'])) {
                                        $sClass = 'col-sm-8';
                                    }
                                @endphp

                                <div class="@php echo $sClass @endphp">
                                    <div class="element-wrapper">
                                        <h6 class="element-header">Новые заказы</h6>
                                        <div class="element-box">
                                            <div class="table-responsive">
                                                <table class="table table-lightborder">
                                                    <thead>
                                                    <tr>
                                                        <th>Номер заказа</th>
                                                        <th>Дата</th>
                                                        <th class="text-center">Действия</th>
                                                        <th>Пользователь</th>
                                                        <th>Список услуг</th>
                                                        <th class="text-right">Сумма заказа</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($arResult['NEW_ORDERS'] as $order)
                                                        <tr id="row_order_{{$order['id']}}">
                                                            <td>{{ $order['id'] }}</td>
                                                            <td>{{ $order['created_at'] }}</td>
                                                            <td>
                                                                <form class="form-inline justify-content-sm-end">
                                                                    <select class="form-control form-control-sm rounded bright"
                                                                            data-orderId="{{$order['id']}}"
                                                                            onchange="changeStatus(this)">
                                                                        <option selected="selected" value="0">
                                                                            --
                                                                        </option>
                                                                        <option @if ((int)$order['status'] === 2) {{ 'selected="selected"' }} @endif value="2">
                                                                            Принять
                                                                        </option>
                                                                        <option @if ((int)$order['status'] === 1) {{ 'selected="selected"' }} @endif value="1">
                                                                            Отклонить
                                                                        </option>
                                                                    </select>
                                                                </form>
                                                            </td>
                                                            <td class="nowrap">
                                                                {{ $arResult['USERS'][$order['user_id']]['name'] ?? '' }}<br/>
                                                                {{ $arResult['USERS'][$order['user_id']]['last_name'] ?? '' }}<br/>
                                                                {{ $arResult['USERS'][$order['user_id']]['second_name'] ?? '' }}<br/>
                                                                <p class="text-info">
                                                                    {{ $arResult['PROFILES'][$order['profile_id']]['TYPE'] ?? '' }}
                                                                    <br/>
                                                                    {{ $arResult['PROFILES'][$order['profile_id']]['BRAND'] ?? '' }}
                                                                    <br/>
                                                                    {{ $arResult['PROFILES'][$order['profile_id']]['NUMBER'] ?? '' }}
                                                                    <br/>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <div class="text-left">
                                                                    @foreach(json_decode($order['services_id']) as $value)
                                                                        {{ $arResult['SERVICES'][$value]['SERVICE'] }}
                                                                        <br/>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $order['cost'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($arResult['SHOW_BLOCK_STATISTICS'] == 'Y')
                                <div class="col-sm-8">
                                    <div class="element-wrapper">
                                        <div class="element-actions">
                                            <form class="form-inline justify-content-sm-end">
                                                <select class="form-control form-control-sm rounded">
                                                    <option value="Pending">
                                                        Сегодня
                                                    </option>
                                                    <option value="Active">
                                                        За неделю
                                                    </option>
                                                    <option value="Cancelled">
                                                        За месяц
                                                    </option>
                                                </select>
                                            </form>
                                        </div>
                                        <h6 class="element-header">
                                            Статистика заказов
                                        </h6>
                                        <div class="element-content">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="element-box el-tablo">
                                                        <div class="label">
                                                            Products Sold
                                                        </div>
                                                        <div class="value">
                                                            57
                                                        </div>
                                                        <div class="trending trending-up">
                                                            <span>12%</span><i class="os-icon os-icon-arrow-up2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="element-box el-tablo">
                                                        <div class="label">
                                                            Gross Profit
                                                        </div>
                                                        <div class="value">
                                                            $457
                                                        </div>
                                                        <div class="trending trending-down-basic">
                                                            <span>12%</span><i class="os-icon os-icon-arrow-2-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="element-box el-tablo">
                                                        <div class="label">
                                                            New Customers
                                                        </div>
                                                        <div class="value">
                                                            125
                                                        </div>
                                                        <div class="trending trending-down-basic">
                                                            <span>9%</span><i class="os-icon os-icon-graph-down"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($arResult['SHOW_BLOCK_ENTITY'] == 'Y')
                                @if (!empty($arResult['ENTITY']))
                                    <div class="col-sm-4">
                                        <div class="element-wrapper">
                                            <h6 class="element-header">Информация по организации</h6>
                                            <div class="element-box-tp">
                                                <div class="col-sm-14">
                                                    <div class="profile-tile" style="border-bottom: 0px;padding-bottom:0px;">
                                                        <div class="profile-tile-meta" style="padding-left: 0px;padding-top: 10px;">
                                                            <ul>
                                                                <li>
                                                                    @if ($arResult['SHOW_BLOCK_STATISTICS'] == 'Y')
                                                                        Наименование организации: <br/>
                                                                    @endif
                                                                    <strong style="margin-left: 0px;">
                                                                        {{ $arResult['ENTITY']['name'] }}
                                                                    </strong>
                                                                </li>
                                                                <li>
                                                                    Статус:<strong>
                                                                        @if ($arResult['ENTITY']['active'] == 'Y')
                                                                            Активна
                                                                        @else
                                                                            Не активна
                                                                        @endif
                                                                    </strong>
                                                                </li>
                                                                @if (isset($arResult['ENTITY']['preview_text']))
                                                                    <li>
                                                                        Адрес:<strong>{{ $arResult['ENTITY']['preview_text'] }}</strong>
                                                                    </li>
                                                                @endif
                                                                @if (isset($arResult['ENTITY']['phone']))
                                                                    <li>
                                                                        Контактный
                                                                        телефон:<strong>{{ $arResult['ENTITY']['phone'] }}</strong>
                                                                    </li>
                                                                @endif
                                                                @if ($arResult['SHOW_BLOCK_STATISTICS'] !== 'Y')
                                                                    <li>
                                                                        <div>На счету денег:
                                                                            <div class="value badge badge-pill badge-success"
                                                                                 style="font-size: 0.675rem;">
                                                                                1 000
                                                                            </div>
                                                                            руб.
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                                @if (isset($arResult['ENTITY']['status']))
                                                                    <li>Статус загруженности объекта:</li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if (isset($arResult['ENTITY']['status']))
                                                    <div class="el-buttons-list full-width">

                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                        @if ($arResult['SHOW_BLOCK_COMPLETE_ORDERS'] == 'Y')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="element-wrapper">
                                        <h6 class="element-header">
                                            Все заказы
                                        </h6>
                                        <div class="element-box">
                                            <div class="controls-above-table">
                                            </div>
                                            <div class="table-responsive">
                                                <table id="dataTable1" width="100%"
                                                       class="table table-striped table-lightfont">
                                                    <thead>
                                                    <tr>
                                                        <th>Номер заказа</th>
                                                        <th>Дата</th>
                                                        <th>Пользователь</th>
                                                        <th>Список услуг</th>
                                                        <th>Сумма заказа</th>
                                                        <th>Способ оплаты</th>
                                                        <th>Статус</th>
                                                        <th>Комментарий</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($arResult['COMPLETE_ORDERS'] as $order)
                                                        <tr>
                                                            <td>{{ $order['id'] }}</td>
                                                            <td>{{ $order['created_at'] }}</td>
                                                            <td>
                                                                {{ $arResult['USERS'][$order['user_id']]['name'] ?? '' }}
                                                                <br/>
                                                                {{ $arResult['USERS'][$order['user_id']]['last_name'] ?? '' }}
                                                                <br/>
                                                                {{ $arResult['USERS'][$order['user_id']]['second_name'] ?? '' }}
                                                                <br/>

                                                                <p class="text-info">
                                                                    {{ $arResult['PROFILES'][$order['profile_id']]['TYPE'] ?? '' }}
                                                                    <br/>
                                                                    {{ $arResult['PROFILES'][$order['profile_id']]['BRAND'] ?? '' }}
                                                                    <br/>
                                                                    {{ $arResult['PROFILES'][$order['profile_id']]['NUMBER'] ?? '' }}
                                                                    <br/>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                @foreach(json_decode($order['services_id']) as $value)
                                                                    {{$arResult['SERVICES'][$value]['SERVICE']}}<br/>
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $order['cost'] }}</td>
                                                            <td>{{ $arResult['PAYMENTS'][$order['payment_id']]['PAYMENT'] }}</td>
                                                            <td>
                                                                @if ((int)$order['status'] === 1) {{ 'Отклонить' }} @endif
                                                                @if ((int)$order['status'] === 2) {{ 'Принять' }} @endif
                                                            </td>
                                                            <td>{{ $order['comment'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('template/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>

        $(function () {
            $('.btn-setStatus').on('click', function () {

                var statusId = $(this).data('id');
                var entityId = $(this).data('entity-id');

                if (statusId && entityId) {
                    $.ajax({
                        type: 'POST',
                        url: '/admin/ajax/change_status_entity',
                        data: {
                            entity_id: entityId,
                            status: statusId
                        },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data == 'Y') {
                                location.reload();
                            }
                        },
                        error: function (result) {
                        }
                    });
                }
            });
        });

        function changeStatus(obj) {
            $.ajax({
                type: 'POST',
                url: '/admin/ajax/change_status_order',
                data: {
                    order_id: $(obj).attr('data-orderId'),
                    value: $(obj).val()
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {

                    if (data == 'Y') {
                        location.reload();
                    }

                    /*$('#row_order_' + $(obj).attr('data-orderId')).remove();
                    $('#dataTable1').DataTable().row.add(data).draw();*/
                },
                error: function (result) {
                }
            });
        }
    </script>
@endsection