<?php


namespace App\Classes\Enum;

/**
 * Class StatusEntityEnum
 * @package App\Classes\Enum
 */
class StatusEntityEnum
{
    public const TYPE = [
        'F' => ['id' => 'F', 'name' => 'Свободно'],
        'L' => ['id' => 'L', 'name' => 'Средняя загрузка'],
        'U' => ['id' => 'U', 'name' => 'Загружено'],
        'C' => ['id' => 'C', 'name' => 'Занято'],
        'N' => ['id' => 'N', 'name' => 'Не доступно'],
    ];
}