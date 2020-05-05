<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;


/**
 * @OA\Schema(
 *     schema="Service",
 *     type="object",
 *     title="Service - example return request",
 *     required={"name", "category_id"},
 *     @OA\Property(property="id", format="int64", type="integer", readOnly=true),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="category_id", format="int32", type="integer", example="1"),
 *     @OA\Property(property="active_from", type="string", format="date-time"),
 *     @OA\Property(property="active_to", type="string", format="date-time"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="active", type="string", example="Y"),
 *     @OA\Property(property="sort", format="int64", type="integer", example="500"),
 *     @OA\Property(property="preview_picture", format="int32", type="integer"),
 *     @OA\Property(property="preview_text", type="string"),
 *     @OA\Property(property="detail_picture", format="int32", type="integer"),
 *     @OA\Property(property="detail_text", type="string"),
 *     @OA\Property(property="xml_id", type="string"),
 *     @OA\Property(property="params", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Service extends BaseModel
{
    protected $guarded = ['id'];

    public static $arFieldsEntity = [
        [
            'TYPE' => 'S:checkbox',
            'INPUT_NAME' => 'active',
            'CODE' => 'active',
            'NAME' => 'Активный',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-check-input"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'name',
            'CODE' => 'name',
            'NAME' => 'Название',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'category',
            'CODE' => 'category',
            'NAME' => 'Категория Услуги',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'code',
            'CODE' => 'code',
            'NAME' => 'Символьный код',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S:date',
            'INPUT_NAME' => 'active_from',
            'CODE' => 'active_from',
            'NAME' => 'Дата начала активности',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control single-daterange"',
        ], [
            'TYPE' => 'S:date',
            'INPUT_NAME' => 'active_to',
            'CODE' => 'active_to',
            'NAME' => 'Дата окончания активности',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control single-daterange"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'sort',
            'CODE' => 'sort',
            'NAME' => 'Сортировка',
            'VALUE' => '',
            'DEFAULT' => '100',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S:html',
            'INPUT_NAME' => 'preview_text',
            'CODE' => 'preview_text',
            'NAME' => 'Краткое описание',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control" rows="3"',
        ], [
            'TYPE' => 'S:html',
            'INPUT_NAME' => 'detail_text',
            'CODE' => 'detail_text',
            'NAME' => 'Детальное описание',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control" rows="3"',
        ]
    ];
}
