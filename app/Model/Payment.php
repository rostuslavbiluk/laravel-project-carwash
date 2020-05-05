<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @OA\Schema(
 *     schema="Payments",
 *     type="object",
 *     title="Payment - example return request",
 *     required={"name"},
 *     @OA\Property(property="id", format="int64", type="integer", readOnly=true),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="active", type="string", example="Y"),
 *     @OA\Property(property="sort", format="int64", type="integer", example="500"),
 *     @OA\Property(property="picture", format="int32", type="integer"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="xml_id", type="string"),
 *     @OA\Property(property="params", type="string"),
 * )
 */
class Payment extends BaseModel
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
            'TYPE' => 'S',
            'INPUT_NAME' => 'code',
            'CODE' => 'code',
            'NAME' => 'Символьный код',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => 'Y',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
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
            'INPUT_NAME' => 'description',
            'CODE' => 'description',
            'NAME' => 'Описание',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control" rows="3"',
        ]
    ];

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        $active = $this->getAttribute('active');
        return ($active === 'Y') ?? false;
    }

    /**
     * @return bool
     */
    public function isPaymentBill()
    {
        $code = $this->getAttribute('code');
        return ($code === 'bill') ?? false;
    }
}
