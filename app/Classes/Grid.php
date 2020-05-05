<?php

namespace App\Classes;

class Grid
{
    public static $nameColumns = [
        'id' => ['NAME' => 'Ид', 'SHOW' => 'Y', 'SORT' => '10'],
        'code' => ['NAME' => 'Символьный код', 'SHOW' => 'N', 'SORT' => '30'],
        'name' => ['NAME' => 'Наименование', 'SHOW' => 'Y', 'SORT' => '20'],
        'sort' => ['NAME' => 'Сортировка', 'SHOW' => 'Y', 'SORT' => '40'],
        'active' => ['NAME' => 'Активен', 'SHOW' => 'Y', 'SORT' => '15'],
        'picture' => ['NAME' => 'Изображение', 'SHOW' => 'N', 'SORT' => '50'],
        'description' => ['NAME' => 'Описание', 'SHOW' => 'N', 'SORT' => '60'],
        'params' => ['NAME' => 'Параметры', 'SHOW' => 'N', 'SORT' => '100'],
        'xml_id' => ['NAME' => 'XML_ID', 'SHOW' => 'N', 'SORT' => '950'],
        'status' => ['NAME' => 'Статус', 'SHOW' => 'N', 'SORT' => '70'],

        /* user_table */
        'username' => ['NAME' => 'Логин', 'SHOW' => 'Y', 'SORT' => '100'],
        //'name' => ['NAME' => 'Имя', 'SHOW' => 'Y', 'SORT' => '100'],
        'last_name' => ['NAME' => 'Фамилия', 'SHOW' => 'Y', 'SORT' => '100'],
        'second_name' => ['NAME' => 'Отчество', 'SHOW' => 'Y', 'SORT' => '100'],
        'email' => ['NAME' => 'Емаил', 'SHOW' => 'N', 'SORT' => '100'],
        'password' => ['NAME' => 'Пароль', 'SHOW' => 'N', 'SORT' => '100'],
        'checkword' => ['NAME' => 'Контрольное слово', 'SHOW' => 'N', 'SORT' => '100'],
        'personal_photo' => ['NAME' => 'Фото', 'SHOW' => 'Y', 'SORT' => '100'],
        'personal_phone' => ['NAME' => 'Телефон', 'SHOW' => 'Y', 'SORT' => '100'],
        'personal_gender' => ['NAME' => 'Пол', 'SHOW' => 'Y', 'SORT' => '100'],
        'personal_birthdate' => ['NAME' => 'Дата рождения', 'SHOW' => 'Y', 'SORT' => '100'],
        'personal_mobile' => ['NAME' => 'Телефон доп.', 'SHOW' => 'Y', 'SORT' => '100'],
        'personal_city' => ['NAME' => 'Город', 'SHOW' => 'Y', 'SORT' => '100'],
        'external_auth_id' => ['NAME' => 'Тип регистрации', 'SHOW' => 'N', 'SORT' => '100'],
        'confirm_code' => ['NAME' => 'Код подтверждения', 'SHOW' => 'N', 'SORT' => '100'],
        'last_login' => ['NAME' => 'Дата последней авторизации', 'SHOW' => 'N', 'SORT' => '100'],

        /* groups_table */
        'text' => ['NAME' => 'Описание', 'SHOW' => 'Y', 'SORT' => '100'],

        /* user_cards_table */
        'user_id' => ['NAME' => 'Привязка к пользователю', 'SHOW' => 'Y', 'SORT' => '100'],
        'number' => ['NAME' => 'Номер карты', 'SHOW' => 'Y', 'SORT' => '100'],

        /* entity_table */
        'active_from' => ['NAME' => 'Начало активности', 'SHOW' => 'N', 'SORT' => '100'],
        'active_to' => ['NAME' => 'Окончание активности', 'SHOW' => 'N', 'SORT' => '100'],
        'preview_picture' => ['NAME' => 'Картинка анонса', 'SHOW' => 'N', 'SORT' => '100'],
        'preview_text' => ['NAME' => 'Адрес', 'SHOW' => 'Y', 'SORT' => '100'],
        'detail_picture' => ['NAME' => 'Изображение', 'SHOW' => 'N', 'SORT' => '100'],
        'detail_text' => ['NAME' => 'Описание', 'SHOW' => 'Y', 'SORT' => '100'],
        'phone' => ['NAME' => 'Телефон', 'SHOW' => 'Y', 'SORT' => '100'],
        'created_by' => ['NAME' => 'Автор', 'SHOW' => 'N', 'SORT' => '100'],

        /* entity_services_table */
        'cost' => ['NAME' => 'Сумма', 'SHOW' => 'Y', 'SORT' => '100'],

        /* supports_table */
        'title' => ['NAME' => 'Заголовок', 'SHOW' => 'Y', 'SORT' => '100'],

        /* profiles_user (payment) */
        'address' => ['NAME' => 'Номер', 'SHOW' => 'Y', 'SORT' => '100'],
        'brand' => ['NAME' => 'Марка', 'SHOW' => 'Y', 'SORT' => '100'],

        'category' => ['NAME' => 'Категория', 'SHOW' => 'Y', 'SORT' => '100'],

    ];

    protected static $prepareSettings = [
        'SHOW_ALL_SELECT' => 'Y',
        'SHOW_ACTION' => 'Y',
        'H1' => '',
        'MAIN_ACTIONS' => [
            'ADD' => '',
            'EDIT' => '',
            'DELETE' => '',
        ],
        'ITEMS' => [
            'ITEM' => [],
            'ACTIONS' => [
                [
                    'EVENT' => '',
                    'CLASS_BUTTON' => '',
                    'ICON' => '<i class="os-icon os-icon-pencil-2"></i>',
                ], [
                    'EVENT' => '',
                    'CLASS_BUTTON' => 'danger',
                    'ICON' => '<i class="os-icon os-icon-database-remove"></i>',
                ],
            ],
        ],
    ];

    public static function prepareSettings($arSettings)
    {
        $arResult = self::$prepareSettings;

        if (isset($arSettings['SHOW_ALL_SELECT'])) {
            $arResult['SHOW_ALL_SELECT'] = $arSettings['SHOW_ALL_SELECT'];
        }

        if (isset($arSettings['SHOW_ACTION'])) {
            $arResult['SHOW_ACTION'] = $arSettings['SHOW_ACTION'];
        }

        if (isset($arSettings['H1'])) {
            $arResult['H1'] = $arSettings['H1'];
        }

        if (isset($arSettings['ITEM'])) {
            if (is_array($arSettings['ITEM'])) {
                $arResult['ITEMS']['ITEM'] = $arSettings['ITEM'];
            }
        }

        if (isset($arSettings['ACTIONS'])) {
            if (is_array($arSettings['ACTIONS']) && !empty($arSettings['ACTIONS'])) {

                foreach ($arSettings['ACTIONS'] as $key => $item) {
                    $bItems = $item;
                    $indexArray = key($bItems);

                    if (isset($arResult['ITEMS']['ACTIONS'][$key][$indexArray])) {
                        $arResult['ITEMS']['ACTIONS'][$key][$indexArray] = $item[$indexArray];
                    }
                }
                //$arResult['ITEMS']['ACTIONS'] = $arSettings['ACTIONS'];
            }
        }

        if (isset($arSettings['MAIN_ACTIONS'])) {
            if (is_array($arSettings['MAIN_ACTIONS']) && !empty($arSettings['MAIN_ACTIONS'])) {

                foreach ($arSettings['MAIN_ACTIONS'] as $key => $item) {
                    $bItems = $item;
                    $indexArray = key($bItems);

                    if (isset($arResult['MAIN_ACTIONS'][$indexArray])) {
                        $arResult['MAIN_ACTIONS'][$indexArray] = $item[$indexArray];
                    }
                }
                //$arResult['MAIN_ACTIONS'] = $arSettings['MAIN_ACTIONS'];
            }
        }

        if (!empty($arResult['ITEMS']['ITEM'])) {
            $arForGetColumns = $arResult['ITEMS']['ITEM'];
            foreach (array_shift($arForGetColumns) as $item) {
                $arResult['COLUMNS'][] = $item['NAME'];
            }
        }

        return $arResult;
    }

    /**
     * @param array $data
     * @param array $columns
     * @return array
     */
    public static function getStructureData(array $data, array $columns): array
    {
        if (!empty($data)) {
            foreach ($data as $items) {
                $nIndexArray = (isset($arrItems['id'])) ? $items['id'] : $items['ID'];
                foreach ($items as $code => $value) {
                    if (isset($columns[$code])) {
                        if ($columns[$code]['SHOW'] == 'Y') {
                            $result[$nIndexArray][] = [
                                'SCODE' => $code,
                                'NAME' => $columns[$code]['NAME'],
                                'VALUE' => $value,
                                'SORT' => $columns[$code]['SORT'],
                            ];
                        }
                    }
                }
            }
        }
        return $result ?? [];
    }
}
