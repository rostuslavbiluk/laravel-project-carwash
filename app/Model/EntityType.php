<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class EntityType extends BaseModel
{
    protected $guarded = ['id'];

    public static $arFieldsEntity = [
        [
            'TYPE' => 'S:checkbox',
            'INPUT_NAME' => 'active',
            'CODE' => 'active',
            'NAME' => 'Активный',
            'VALUE' => '',
            'DEFAULT' => 'Y',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-check-input"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'name',
            'CODE' => 'name',
            'NAME' => 'Название',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'code',
            'CODE' => 'code',
            'NAME' => 'Символьный код',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S:html',
            'INPUT_NAME' => 'description',
            'CODE' => 'description',
            'NAME' => 'Краткое описание',
            'VALUE' => '',
            'DEFAULT' => '100',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ]
    ];
}
