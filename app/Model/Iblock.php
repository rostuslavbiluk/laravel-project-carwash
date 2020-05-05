<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Iblock extends BaseModel
{
    protected $guarded = ['id'];

    public static $nameColumns = [
        'id' => ['NAME' => 'Ид', 'SHOW' => 'Y', 'SORT' => '10'],
        'code' => ['NAME' => 'Символьный код', 'SHOW' => 'Y', 'SORT' => '30'],
        'name' => ['NAME' => 'Название', 'SHOW' => 'Y', 'SORT' => '20'],
        'sort' => ['NAME' => 'Сортировка', 'SHOW' => 'Y', 'SORT' => '40'],
        'active' => ['NAME' => 'Активен', 'SHOW' => 'Y', 'SORT' => '15'],
        'picture' => ['NAME' => 'Изображение', 'SHOW' => 'N', 'SORT' => '50'],
        'description' => ['NAME' => 'Описание', 'SHOW' => 'N', 'SORT' => '60'],
        'params' => ['NAME' => 'Параметры', 'SHOW' => 'N', 'SORT' => '70'],
    ];

    public static $arFieldsEntity = [];
}
