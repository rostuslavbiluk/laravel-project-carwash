<?php


namespace App\Classes\Enum;

/**
 * Class UserGroupRolesEnum
 * @package App\Classes\Enum
 */
class UserGroupRolesEnum
{
    public const DEFAULT_ROLE = [
        self::USER_ROLE['MEMBER'],
    ];

    public const ROLE = [
        'MEMBER' => 'member',
        'MEMBER_TAXIPARK' => 'member_taxipark',
        'ROOT_TAXIPARK' => 'root_taxipark',
        'MEMBER_CARWASH' => 'member_carwash',
        'ROOT_CARWASH' => 'root_carwash',
        'ADMIN' => 'admin',
    ];

    public const USER_ROLE = [
        'ADMIN' => 1,
        'ROOT_CARWASH' => 3,
        'MEMBER_CARWASH' => 999999,
        'ROOT_TAXIPARK' => 4,
        'MEMBER_TAXIPARK' => 888888,
        'MEMBER' => 2,
    ];

    public const ROLE_NAME = [
        'ADMIN' => 'Администратор',
        'ROOT_CARWASH' => 'Администратор автомойки',
        'MEMBER_CARWASH' => 'Менеджер автомойки',
        'ROOT_TAXIPARK' => 'Администратор таксопарка',
        'MEMBER_TAXIPARK' => 'Менеджер таксопарка',
        'MEMBER' => 'Пользователь',
    ];
}