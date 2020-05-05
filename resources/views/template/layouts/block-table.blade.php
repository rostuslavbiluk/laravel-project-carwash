<div class="element-box-tp">

    @if(session('message'))
        <div class="table-records-info info-message text-success"><p>{{session('message')}}</p></div>
    @endif
    <div class="controls-above-table">
        <div class="row">
            <div class="col-sm-6">
                <!--a class="btn btn-sm btn-secondary" href="#">Экспортировать в CSV</a-->

                @if (isset($arResult['MAIN_ACTIONS']['ADD']))
                <a class="btn btn-sm btn-danger" href="{{ url($arResult['MAIN_ACTIONS']['ADD']) }}">Добавить</a>
                @endif

                @php /*
                @if (isset($arResult['MAIN_ACTIONS']['EDIT']))
                <a class="btn btn-sm btn-secondary" href="{{ url($arResult['MAIN_ACTIONS']['EDIT']) }}">Редактировать</a>
                @endif

                @if (isset($arResult['MAIN_ACTIONS']['DELETE']))
                <a class="btn btn-sm btn-secondary" href="{{ url($arResult['MAIN_ACTIONS']['DELETE']) }}">Удалить</a>
                @endif
                */
                @endphp

            </div>
            <div class="col-sm-6">
                <form class="form-inline justify-content-sm-end">
                    <input class="form-control form-control-sm rounded bright"
                           placeholder="Поиск" type="text">
                    <!--select class="form-control form-control-sm rounded bright">
                        <option selected="selected" value="">
                            Select Status
                        </option>
                        <option value="Pending">
                            Pending
                        </option>
                        <option value="Active">
                            Active
                        </option>
                        <option value="Cancelled">
                            Cancelled
                        </option>
                    </select-->

                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-lg table-v2 table-striped table-hover">
            <thead>
                <tr>
                @if($arResult['SHOW_ALL_SELECT'] == 'Y')
                    <th class="text-center">
                        <input class="form-control" type="checkbox">
                    </th>
                @endif

                    @if(!empty($arResult['COLUMNS']))
                        @foreach($arResult['COLUMNS'] as $arItems)
                        <th>
                            {!! $arItems !!}
                        </th>
                        @endforeach
                    @endif

                @if($arResult['SHOW_ACTION'] == 'Y')
                    <th>
                        Действия
                    </th>
                @endif
                </tr>
            </thead>
            <tbody>

            @if(!empty($arResult['ITEMS']['ITEM']))
                @foreach($arResult['ITEMS']['ITEM'] as $nId => $arItems)
            <tr>
                    @if($arResult['SHOW_ALL_SELECT'] == 'Y')
                        <td class="text-center">
                            <input class="form-control input-checkbox-type" value="{!! $nId !!}" name="ID" type="checkbox">
                        </td>
                    @endif

                    @foreach($arItems as $item)
                        <td>
                            {!! $item['VALUE'] !!}
                        </td>
                    @endforeach

                    @if($arResult['SHOW_ACTION'] == 'Y')
                        <td class="row-actions">

                            @if(!empty($arResult['ITEMS']['ACTIONS']))
                                @foreach ($arResult['ITEMS']['ACTIONS'] as $key => $action)

                                    <a
                                       @if(!empty($action['EVENT']))
                                            href="{{$action['EVENT']}}/{!! $nId !!}"
                                       @else
                                            href="javascript:void(0);"
                                       @endif

                                       @if(!empty($action['CLASS_BUTTON']))
                                            class="{!! $action['CLASS_BUTTON'] !!}"
                                       @endif
                                    >{!! $action['ICON'] !!}</a>

                                @endforeach
                            @endif
                        </td>
                    @endif
            </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>

    <div class="controls-below-table">
        @if(!empty($arResult['ITEMS']['ITEM']))
        <div class="table-records-info">
            Отображено записей 1 - {{ count($arResult['ITEMS']['ITEM']) }}
        </div>
        @endif
        @php /*
        <div class="table-records-pages">
            <ul>
                <li>
                    <a href="#">Предедущая</a>
                </li>
                <li>
                    <a class="current" href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <!--li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#">4</a>
                </li-->
                <li>
                    <a href="#">Следующая</a>
                </li>
            </ul>
        </div>
        */ @endphp

    </div>

</div>