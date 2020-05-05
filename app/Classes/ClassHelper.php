<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Model\{Brands,
    EntityType,
    Organizations,
    PaymentOption,
    Entity,
    Cities,
    Group,
    Profile,
    Requisites,
    Service,
    ServiceCategory,
    User};


class ClassHelper
{
    public static $arGender = [
        'M' => ['ID' => 'M', 'NAME' => 'Мужской', 'SELECTED' => ''],
        'W' => ['ID' => 'W', 'NAME' => 'Женский', 'SELECTED' => ''],
    ];

    public static $arStatus = [
        'F' => ['ID' => 'F', 'NAME' => 'Свободно', 'SELECTED' => ''],
        'L' => ['ID' => 'L', 'NAME' => 'Средняя загрузка', 'SELECTED' => ''],
        'U' => ['ID' => 'U', 'NAME' => 'Загружено', 'SELECTED' => ''],
    ];

    public static $arOrderStatus = [
        '0' => ['ID' => '0', 'NAME' => '--', 'SELECTED' => ''],
        '1' => ['ID' => '1', 'NAME' => 'Отклонить', 'SELECTED' => ''],
        '2' => ['ID' => '2', 'NAME' => 'Принять', 'SELECTED' => ''],
    ];

    public static $arFieldsNotSave = [
        '_token',
        'entity',
        'send_form',
        'SEND_FORM',
        //'created_by',
    ];

    /**
     * Получаем объект класса в зависимости от страницы
     * @param $code
     * @return array
     */
    public static function getEntityModel(string $code)
    {
        $entity = null;
        $title = '';
        switch ($code) {
            case 'payment_option':
                $entity = new PaymentOption();
                $title = 'Инфоблок Тип оплаты';
                break;
            case 'entities':
                $entity = new Entity();
                $title = 'Инфоблок Объекты';
                break;
            case 'cities':
                $entity = new Cities();
                $title = 'Инфоблок Города';
                break;
            case 'user_group':
                $entity = new Group();
                $title = 'Инфоблок Группы пользователей';
                break;
            case 'service_list':
                $entity = new Service();
                $title = 'Инфоблок Услуги';
                break;
            case 'user':
                $entity = new User();
                $title = 'Инфоблок Пользователи';
                break;
            case 'brands':
                $entity = new Brands();
                $title = 'Инфоблок Брандов';
                break;
            case 'organizations':
                $entity = new Organizations();
                $title = 'Инфоблок Организаций';
                break;
            case 'profiles':
                $entity = new Profile();
                $title = 'Инфоблок Профили пользователей';
                break;
            case 'entity_types':
                $entity = new EntityType();
                $title = 'Инфоблок Типов объектов';
                break;
            case 'requisites':
                $entity = new Requisites();
                $title = 'Инфоблок Реквизиты Организаций';
                break;
            case 'service_category':
                $entity = new ServiceCategory();
                $title = 'Инфоблок Категорий Услуг';
                break;
        }
        return [$entity, $title];
    }

    /**
     * получаем по символьному коду дополнительные данные для вывода
     * @param $entityName
     * @param $arFields
     */
    public static function getEntityData($entityName, &$arFields, $arRequest = [])
    {

        if (!empty($arFields)) {
            foreach ($arFields as &$arField) {

                if (isset($arField['CODE'])) {
                    if (in_array($arField['CODE'], ['confirm_code'])) {
                        $arField['VALUE'] = str_random(8);
                    }

                    if (in_array($arField['CODE'], ['personal_gender'])) {
                        $arField['LIST'] = self::$arGender;
                    }

                    if (in_array($arField['CODE'], ['checkword'])) {
                        $arField['VALUE'] = 'ch' . time();
                    }

                    if (in_array($arField['CODE'], ['personal_city'])) {

                        $objCities = \App\Cities::all();
                        if ($objCities) {
                            $arCities = $objCities->toArray();
                            $arField['LIST'] = $arCities;
                        }
                    }

                    if (in_array($arField['CODE'], ['user_group'])) {

                        $objGroups = \App\Group::all();
                        if ($objGroups) {

                            $arGroups = $objGroups->toArray();
                            $arNewGroups = [];
                            if (!empty($arGroups)) {
                                foreach ($arGroups as $arGroup) {
                                    $arNewGroups[$arGroup['id']] = [
                                        'ID' => $arGroup['id'],
                                        'NAME' => $arGroup['name'],
                                        'SORT' => $arGroup['sort'],
                                    ];
                                }
                            }

                            if (!empty($arRequest)) {

                                if ((isset($arRequest['code'])
                                        && $arRequest['code'] == 'user')
                                    && (int)$arRequest['id'] > 0) {

                                    $objGroupUser = \App\UserGroups::where('user_id', $arRequest['id'])->get()->toArray();

                                    if (!empty($objGroupUser)) {

                                        foreach ($objGroupUser as $item) {

                                            if (isset($arNewGroups[$item['group_id']])) {
                                                $arNewGroups[$item['group_id']]['SELECTED'] = 'Y';
                                            }
                                        }
                                    }
                                }
                            }

                            $arField['LIST'] = $arNewGroups;
                        }
                    }

                    if (in_array($arField['CODE'], ['status'])) {

                        $arField['LIST'] = self::$arStatus;
                    }

                    if (in_array($arField['CODE'], ['user_id'])) {

                        $objAllUser = \App\User::all();
                        if ($objAllUser) {

                            $arAllUser = $objAllUser->toArray();
                            if (!empty($arAllUser)) {

                                foreach ($arAllUser as &$item) {
                                    $item['name'] = $item['last_name'] . ' ' . $item['name'] . ' ' . $item['second_name'];
                                }
                                unset($item);

                                $arField['LIST'] = $arAllUser;
                            }
                        }
                    }

                    if (in_array($arField['CODE'], ['org_id'])) {

                        $objAllOrganizations = \App\Organizations::all();
                        if ($objAllOrganizations) {

                            $arAllOrganizations = $objAllOrganizations->toArray();

                            if (!empty($arAllOrganizations)) {
                                $arField['LIST'] = $arAllOrganizations;
                            }
                        }
                    }

                    if (in_array($arField['CODE'], ['type_entity'])) {

                        $objAllEntityTypeList = \App\EntityTypeList::all();
                        if ($objAllEntityTypeList) {

                            $arAllEntityTypeList = $objAllEntityTypeList->toArray();
                            if (!empty($arAllEntityTypeList)) {

                                foreach ($arAllEntityTypeList as &$item) {
                                    $item['id_'] = $item['id'];
                                    $item['id'] = $item['code'];
                                }
                                unset($item);

                                $arField['LIST'] = $arAllEntityTypeList;
                            }
                        }
                    }

                    if (in_array($arField['CODE'], ['type'])) {

                        $objProfilesService = \App\ProfilesService::all();
                        if ($objProfilesService) {

                            $arProfService = $objProfilesService->toArray();
                            $arField['LIST'] = $arProfService;
                        }
                    }

                    if (in_array($arField['CODE'], ['brand'])) {

                        $objBrand = \App\Brands::all();
                        if ($objBrand) {

                            $arBrand = $objBrand->toArray();
                            $arField['LIST'] = $arBrand;
                        }
                    }

                    if (in_array($arField['CODE'], ['category'])) {

                        $objServiceCategory = \App\ServiceCategory::all();
                        if ($objServiceCategory) {

                            $arServiceCategory = $objServiceCategory->toArray();
                            $arField['LIST'] = $arServiceCategory;
                        }
                    }
                }

            }

            unset($arField);
        }
    }

    /**
     * удаляем ненужные параметры из реквеста, для сохранения в БД
     * @param $arClearParams
     * @param $arSaveParams
     */
    public static function clearParamsForSave($arClearParams, &$arSaveParams)
    {
        $arFieldsNotSave = array_merge(
            \App\Classes\ClassHelper::$arFieldsNotSave,
            $arClearParams
        );

        if (!empty($arSaveParams)) {
            foreach ($arSaveParams as $key => $arDatum) {

                if (in_array($key, $arFieldsNotSave)) {
                    unset($arSaveParams[$key]);
                }
            }
        }
    }

    public static function genEmail($prefix)
    {
        return $prefix . '@' .'laravel.loc';
    }

    public static function genPassword($prefix)
    {
        $sSaltWorld = '1khj21f423k4vbj34hgbyosfxmwdxyfowufrv38745b' . time();
        $sConfimCode = Str::random(8, $sSaltWorld . $prefix);

        return $sConfimCode;
    }

    public static function genStrCode($prefix)
    {
        $sSaltWorld = '1khj21f423k4vbj34hgbyosfxmwdxyfowufrv38745b' . time();
        $sConfimCode = Str::random(5, $sSaltWorld . $prefix);

        return $sConfimCode;
    }

    public static function clearNumberPhone($nNumberPhone)
    {
        if (isset($nNumberPhone) && !empty($nNumberPhone)) {

            $sPhone = preg_replace('~\D~', '', $nNumberPhone);

            $sCodeCountry = substr($sPhone, 0, 1);
            if ($sCodeCountry == '7') {
                $sPhone = substr($sPhone, 1, strlen($sPhone));
            }

            return $sPhone;
        }

        return false;
    }

    public static function formatNumberPhone($sPhone)
    {
        $sPhone = preg_replace('~\D~', '', $sPhone);

        if (strlen($sPhone) != 10) {
            return '';
        }

        $sArea = substr($sPhone, 0, 3);
        $sPrefix = substr($sPhone, 3, 3);
        $sNumber = substr($sPhone, 6, 2);
        $sNumberLast = substr($sPhone, 8, 2);

        $sPhone = "+7 (".$sArea.") " . $sPrefix . "-" . $sNumber . "-" . $sNumberLast;

        return $sPhone;
    }

    /*
    public static function OnBeforeIBlockElementUpdate(&$arParams, $objEntity)
    {
        if (!empty($arParams['entity'])) {



            // отдельная логика для объекта users
            if ($arParams['entity'] == 'user') {

                if (!empty($arParams['personal_phone'])) {
                    $arParams['personal_phone'] = preg_replace('~\D~', '', $arParams['personal_phone']);
                    $arParams['personal_mobile'] = preg_replace('~\D~', '', $arParams['personal_mobile']);

                    $arParams['username'] = $arParams['personal_phone'];
                }

                if (empty($arParams['password'])) {
                    \App\Classes\ClassHelper::$arFieldsNotSave[] = 'password';
                }

                \App\Classes\ClassHelper::$arFieldsNotSave[] = 'user_id';
            }


            if ($objEntity) {

                // удаляем лишние параметры для сохранения реквеста в БД
                if (isset(\App\Classes\ClassHelper::$arFieldsNotSave)) {

                    $arEntityNotSave = (isset($objEntity::$arFieldsNotSave)) ? $objEntity::$arFieldsNotSave : [];

                    $arFieldsNotSave = array_merge(
                        \App\Classes\ClassHelper::$arFieldsNotSave,
                        $arEntityNotSave
                    );

                    if (isset($arFieldsNotSave)
                        && !empty($arFieldsNotSave)) {

                        \App\Classes\ClassHelper::clearParamsForSave($arFieldsNotSave, $arParams);
                    }
                }

            }

        }
    }


    public static function OnAfterIBlockElementUpdate($arParams, $arAllParams, $objEntity)
    {

        // если объект у нас пользователь обновляем группу пользователч
        if ($arAllParams['entity'] == 'user') {

            if (!empty($arAllParams['user_group'])) {
                $objEntity->roles()->sync($arAllParams['user_group']);
            }
        }
    }
    */

}
