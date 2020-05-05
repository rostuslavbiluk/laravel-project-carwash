<?php


namespace App\Classes\Enum;

/**
 * Class StatusOrderEnum
 * @package App\Classes\Enum
 */
class StatusOrderEnum
{
    public const TYPE = [
        'NEW' => ['id' => '0', 'NAME' => '--'],
        'CANCEL' => ['id' => '1', 'NAME' => 'Отклонить'],
        'FINISHED' => ['id' => '2', 'NAME' => 'Принять'],
    ];
}