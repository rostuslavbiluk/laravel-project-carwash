<?php

namespace App\Classes\Entity\Profile\Admin;

/**
 * Class IndexPage
 * @package App\Classes\Entity\Profile\Admin
 */
class IndexPage
{

    public static function index()
    {
        $returnResult['ITEMS'] = [
            [
                'name' => 'Настройки СМС',
                'code' => '/admin/settings/sms',
            ], [
                'name' => 'Реквизиты',
                'code' => '/admin/settings/requisites',
            ], [
                'name' => 'Настройки Телеграмм',
                'code' => '/admin/settings/telegram',
            ]
        ];
        return $returnResult;
    }
}