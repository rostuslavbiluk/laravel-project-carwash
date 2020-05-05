@extends('template.app')

@section('title', 'Реквизиты организации')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.index') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <span>Реквизиты организации</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="element-wrapper">
                <div class="element-box">
                    <div class="form-group">
                        <p class="text-danger">
                            @if (session('message'))
                                {{ session('message') }}
                            @endif
                        </p>
                    </div>
                    <form id="formValidate" method="POST" action="{{ route('requisites.edit', ['requisites' => $result['requisites']['id'] ?? null ]) }}">
                        @csrf
                        <h5 class="form-header">Реквизиты</h5>
                        <div class="form-desc">Реквизиты организации необходимы для проведения безналичного платежа, зачисления наличных денежных
                            средств на банковский счет, списания денежных средств с банковского счета</div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input class="form-control" placeholder="Введите название" required="required"
                                           type="text" name="name" value="{{ $result['requisites']['name'] ?? '' }}">
                                    <div class="help-block form-text text-muted form-control-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Тип</label>
                                    <input class="form-control" name="type" required="required" type="text"
                                           placeholder="Тип организации"
                                           value="{{ $result['requisites']['type'] ?? '' }}">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ИНН</label>
                            <input class="form-control" name="inn" placeholder="ИНН" type="text" required="required"
                                   value="{{ $result['requisites']['inn'] ?? '' }}"/>
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>КПП</label>
                            <input class="form-control" name="kpp" placeholder="Введите КПП" required="required"
                                   type="text" value="{{ $result['requisites']['kpp'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>ОГРН (ОГРНИП)</label>
                            <input class="form-control" name="ogrn" placeholder="Введите ОГРН (ОГРНИП)"
                                   required="required" type="text" value="{{ $result['requisites']['ogrn'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Почтовый адрес</label>
                                    <input class="form-control" name="postcode1" placeholder="Индекс"
                                           required="required" type="text"
                                           value="{{ $result['requisites']['postcode1'] ?? '' }}">
                                    <div class="help-block form-text text-muted form-control-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input class="form-control" name="address1"
                                           placeholder="Введите полный адрес" required="required" type="text"
                                           value="{{ $result['requisites']['address1'] ?? '' }}">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Юридический адрес</label>
                                    <input class="form-control" name="postcode2" type="text" placeholder="Индекс"
                                           required="required" value="{{ $result['requisites']['postcode2'] ?? '' }}">
                                    <div class="help-block form-text text-muted form-control-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input class="form-control" name="address2" type="text"
                                           placeholder="Введите полный адрес" required="required"
                                           value="{{ $result['requisites']['address2'] ?? '' }}">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>БИК</label>
                            <input class="form-control" name="bik" placeholder="Введите БИК" required="required"
                                   type="text" value="{{ $result['requisites']['bik'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Название банка</label>
                            <input class="form-control" name="bank_name" placeholder="Введите название банка"
                                   required="required" type="text"
                                   value="{{ $result['requisites']['bank_name'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Город банка</label>
                            <input class="form-control" name="bank_address"
                                   placeholder="Введите город банка" required="required" type="text"
                                   value="{{ $result['requisites']['bank_address'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Кор. счет</label>
                            <input class="form-control" name="kor_account"
                                   placeholder="Введите кор. счет" required="required" type="text"
                                   value="{{ $result['requisites']['kor_account'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Расч. счет</label>
                            <input class="form-control" name="ras_account" placeholder="Введите расч. счет"
                                   required="required" type="text"
                                   value="{{ $result['requisites']['ras_account'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email"
                                   placeholder="Введите Email" required="required" type="email"
                                   value="{{ $result['requisites']['email'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Телефон</label>
                            <input class="form-control phone-mask" name="phone"
                                   placeholder="Введите телефон" required="required" type="text"
                                   value="{{ $result['requisites']['phone'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Налогооблажение</label>
                            <input class="form-control" name="type_nds"
                                   placeholder="Введите тип налогооблажения"
                                   required="required" type="text"
                                   value="{{ $result['requisites']['type_nds'] ?? '' }}">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="policy" required="required" value="Y" type="checkbox">Я согласен с правилами и
                                условиями</label>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="element-wrapper">
                <div class="element-box">
                    <h5 class="form-header">Договор</h5>
                    <div class="form-desc">
                        <div>Номер: <code>{{ $result['contract']['id'] ?? '------' }}</code></div>
                        <div>Дата: <code>{{ $result['contract']['date'] ?? '--.--.--' }}</code></div>
                        <div>Получен:
                            <code>{{ $result['contract']['status'] ?? 'оригинальный договор не получен' }}</code></div>
                    </div>

                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-sm btn-primary" href="#" disabled>Получить договор</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @isset($result['invoice']['businesscard'])
            <div class="element-wrapper">
                <div class="element-box">
                    <h5 class="form-header">Банковские карты для оплаты</h5>
                    <form id="formBusiness" method="POST" action="{{ route('card.create') }}">
                        @csrf
                        @if (!empty($result['invoice']['businesscard']))
                            @foreach($result['invoice']['businesscard'] as $card)
                                <div class="row" id="row-card-user-{{ $card['id'] }}">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="entity_cards"> Корпоративная карта</label>
                                            <input class="form-control" data-error="Недопустимые значения"
                                                   placeholder="{{ $card['number'] }}" name="entity_cards[]" type="text"
                                                   value="{{ $card['number'] }}"/>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button class="form-control btn btn-danger ajax_delete_card"
                                                    data-cardId="{{ $card['id'] }}" type="button">Удалить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="form-group">
                            <label for="entity_cards">Новая корпоративная карта</label>
                            <input class="form-control" required="required" data-error="Недопустимые значения" type="text" value=""
                                   placeholder="Карта 2134 2345 2345 1234" name="entity_cards[]"/>
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit"> Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
            @endisset

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.ajax_delete_card').click(function () {
            var cardId = $(this).attr('data-cardId');
            $('#row-card-user-' + cardId).addClass('table-info');
            $.ajax({
                type: 'POST',
                url: '{{ route('card.delete') }}',
                data: {card_id: cardId},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data === 'Y') {
                        $('#row-card-user-' + cardId).remove();
                    }
                },
                error: function (result) {
                    $('#row-card-user-' + cardId).removeClass('table-info');
                }
            });
        });
    </script>
@endsection