@extends('template.app')

@section('title', 'Персональный раздел')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin') }}">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <span>Персональный раздел</span>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="user-profile compact">
                <div class="up-head-w" style="background-image:url({{ asset('template/img/profile_bg1.jpg')}})">
                    <!--div class="up-social">
                        <a href="#"><i class="os-icon os-icon-twitter"></i></a>
                        <a href="#"><i class="os-icon os-icon-facebook"></i></a>
                    </div-->
                    <div class="up-main-info">
                        <h2 class="up-header">{{ $result['user']['name'] }} </h2>
                        <h6 class="up-sub-header">
                            @if (!empty($result['user']['roles']))
                                @foreach($result['user']['roles'] as $item)
                                    {{ $item['name'] ?? '' }} @if (!$loop->last) <br/> @endif
                                @endforeach
                            @endif
                        </h6>
                    </div>
                    <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                         preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                            <path class="decor-path"
                                  d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path>
                        </g>
                    </svg>
                </div>
                <div class="up-controls">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="value-pair">
                                <div class="label">Статус профиля:</div>
                                <div class="value badge badge-pill @if ($result['user']['active'] === 'Y')badge-success @else badge-danger @endif">
                                    @if ($result['user']['active'] === 'Y') Активный @else Не активный @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            {{--<a class="btn btn-primary btn-sm" href=""><i class="os-icon os-icon-link-3"></i>
                                <span>&nbsp;</span></a>--}}
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($result['entity']))
                <div class="element-wrapper" style="padding-bottom: 20px;">
                    <div class="element-box">
                        <h6 class="element-header">Организация</h6>
                        <div class="profile-tile">
                            <div class="profile-tile-meta" style="padding-left: 0px;">
                                <ul>
                                    <li>
                                        Наименование организации:
                                        <strong>{{ $result['entity']['name'] ?? '' }}</strong>
                                    </li>
                                    <li>
                                        Адрес:
                                        <strong>{{ $result['entity']['preview_text'] ?? '' }}</strong>
                                    </li>
                                    <li>
                                        Контактныйтелефон:
                                        <strong>{{ $result['entity']['phone'] ?? '' }}</strong>
                                    </li>
                                    <li>
                                        <br/>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('support.index', ['title' => 'Запрос на редактирование информации по организации']) }}">
                                            <i class="os-icon os-icon-link-3"></i><span>Редактировать</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="element-wrapper" style="padding-bottom: 20px;">
                    <div class="element-box">
                        <h6 class="element-header">Реквизиты организации</h6>
                        <a class="btn btn-primary btn-sm" href="{{ route('requisites.index') }}">
                            <i class="os-icon os-icon-link-3"></i><span>Редактировать</span>
                        </a>
                    </div>
                </div>
                @if (isset($result['carwash']) && $result['carwash'] === 'Y')
                <div class="element-wrapper" style="padding-bottom: 20px;">
                    <div class="element-box">
                        <h6 class="element-header">Услуги организации</h6>
                        <a class="btn btn-primary btn-sm" href="{{ route('services.index') }}">
                            <i class="os-icon os-icon-link-3"></i><span>Редактировать</span>
                        </a>
                    </div>
                </div>
                @endif
            @endif
        </div>

        <div class="col-lg-6">
            <div class="element-wrapper">
                <div class="element-box">
                    <form id="formValidate" method="POST" novalidate="true"
                          action="{{ route('profile.edit', ['user' => $result['user']['id'] ?? 0]) }}">
                        @csrf
                        <div class="element-info">
                            <div class="element-info-with-icon">
                                <div class="element-info-icon">
                                    <div class="os-icon os-icon-user-male-circle2"></div>
                                </div>
                                <div class="element-info-text">
                                    <h5 class="element-inner-header">Настройки профиля</h5>
                                    <div class="element-inner-desc">Заполните основную информацию профиля</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="text-danger">
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                @endif
                            </p>
                        </div>
                        <div class="form-group{{ $errors->has('personal_phone') ? ' has-error' : '' }}">
                            <label> Телефон</label>
                            <input class="form-control phone-mask" data-error="Недопустимые значения"
                                   name="personal_phone"
                                   @if ($result['user']['is_admin'] !== 'Y') disabled @endif
                                   placeholder="{{ $result['user']['personal_phone'] ?? '' }}" type="text"
                                   autocomplete="off"/>
                            возможность изменения номера телефона возможна только через обращение в техподдержку
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label> E-Mail</label>
                            <input class="form-control" data-error="Недопустимый адрес электронной почты"
                                   placeholder="{{ $result['user']['email'] ?? '' }}" name="email" type="email">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label> Новый пароль</label>
                                    <input class="form-control" data-minlength="6" name="password"
                                           placeholder="Новый пароль" type="password">
                                    <div class="help-block form-text text-muted form-control-feedback">
                                        Минимальная длина пароля 6 символов
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label>Подтверждение пароля</label>
                                    <input class="form-control" data-match-error="Пароли не совпадают"
                                           name="password_confirmation"
                                           placeholder="Подтверждение пароля" type="password">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Город</label>
                            <select class="form-control select2" name="personal_city">
                                @if(!empty($result['city']['list']))
                                    @foreach($result['city']['list'] as $item)
                                        <option value="{{ $item['id'] }}"
                                                @isset($result['user']['city']['id'])
                                                @if ((int)$item['id'] === (int)$result['user']['city']['id']) selected @endif
                                                @endisset
                                        >{{ $item['name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">Не установлено</option>
                                @endif
                            </select>
                        </div>
                        @if (!empty($result['roles']['list']))
                            <div class="form-group">
                                <label>Принадлежность к группам</label>
                                <select class="form-control select2" multiple="true" name="groups[]">
                                    @php
                                    $selectRoles = array_column($result['user']['roles'], 'id');
                                    @endphp
                                    @foreach($result['roles']['list'] as $item)
                                        <option value="{{ $item['id'] }}"
                                                @if(!empty($result['user']['roles']))
                                                @if (in_array($item['id'], $selectRoles, true)) selected @endif
                                                @endif
                                        >{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <fieldset class="form-group">
                            <legend><span>Личные данные</span></legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>Имя</label>
                                        <input name="name" class="form-control" data-error="Введите ваше имя"
                                               placeholder="{{ $result['user']['name'] ?? '' }}" type="text"/>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label>Фамилия</label>
                                        <input name="last_name" class="form-control" type="text"
                                               data-error="Please input your Last Name"
                                               placeholder="{{ $result['user']['last_name'] ?? '' }}"/>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('second_name') ? ' has-error' : '' }}">
                                        <label>Отчество</label>
                                        <input name="second_name" class="form-control" type="text"
                                               data-error="Please input your Last Name"
                                               placeholder="{{ $result['user']['second_name'] ?? '' }}"/>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('personal_birthdate') ? ' has-error' : '' }}">
                                        <label>Дата рождения</label>
                                        <input name="personal_birthdate" class="single-daterange form-control"
                                               placeholder="Дата рождения" type="text"
                                               @if (isset($result['user']['personal_birthdate']) && !empty($result['user']['personal_birthdate']))
                                               value="{{ date("m/d/Y", strtotime($result['user']['personal_birthdate'])) }}"
                                                @endif >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('personal_gender') ? ' has-error' : '' }}">
                                        <label>Пол</label>
                                        <select class="form-control" name="personal_gender">
                                            <option value="" selected>Не установлено</option>
                                            @foreach($result['gender']['list'] as $item)
                                                <option value="{{ $item['id'] }}"
                                                        @if (isset($result['user']['personal_gender']) && (int)$item['id'] === (int)$result['user']['personal_gender']) selected @endif>
                                                    {{ $item['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('personal_mobile') ? ' has-error' : '' }}">
                                        <label>Дополнительный телефон</label>
                                        <input class="form-control phone-mask" name="personal_mobile" type="text"
                                               placeholder="{{ $result['user']['personal_mobile'] ?? '' }}"/>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="confim" value="Y" required="required"
                                       type="checkbox">Я согласен с правилами и условиями</label>
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit"> Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
