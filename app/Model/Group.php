<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Group extends BaseModel
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
            'INPUT_NAME' => 'sort',
            'CODE' => 'sort',
            'NAME' => 'Сортировка',
            'VALUE' => '',
            'DEFAULT' => '100',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S:html',
            'INPUT_NAME' => 'text',
            'CODE' => 'text',
            'NAME' => 'Описание',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control" rows="3"',
        ]
    ];

    /**
     * Пользователи, принадлежащие роли.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
