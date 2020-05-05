<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @OA\Schema(
 *     schema="Profile",
 *     type="object",
 *     title="Profile - example return request",
 *     @OA\Property(property="id", format="int64", type="integer", readOnly=true),
 *     @OA\Property(property="user_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="cost", format="int64", type="integer", example="500"),
 *     @OA\Property(property="type", format="int64", type="integer", example="1", description="id entity of type profile"),
 *     @OA\Property(property="brand", format="int64", type="integer", example="1", description="id entity of brands type"),
 *     @OA\Property(property="active", type="string", example="Y/N"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Profile extends BaseModel
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
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'user_id',
            'CODE' => 'user_id',
            'NAME' => 'Привязка к пользователю',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],/*[
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'org_id',
            'CODE' => 'org_id',
            'NAME' => 'Привязка к организации',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],*/[
            'TYPE' => 'S',
            'INPUT_NAME' => 'address',
            'CODE' => 'address',
            'NAME' => 'Номер',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'brand',
            'CODE' => 'brand',
            'NAME' => 'Марка',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'type',
            'CODE' => 'type',
            'NAME' => 'Тип профиля',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'cost',
            'CODE' => 'cost',
            'NAME' => 'Сумма на счету',
            'VALUE' => '',
            'DEFAULT' => '0',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ]
    ];
}
