<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @OA\Schema(
 *     schema="Entity",
 *     type="object",
 *     title="Entity - example return request",
 *     required={"name"},
 *     @OA\Property(property="id", format="int64", type="integer", readOnly=true),
 *     @OA\Property(property="active", type="string", example="Y/N"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="user_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="active_from", type="string", format="date-time"),
 *     @OA\Property(property="active_to", type="string", format="date-time"),
 *     @OA\Property(property="sort", format="int64", type="integer", example="500"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="preview_picture", format="int32", type="integer"),
 *     @OA\Property(property="preview_text", type="string"),
 *     @OA\Property(property="detail_picture", format="int32", type="integer"),
 *     @OA\Property(property="detail_text", type="string"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="xml_id", type="string"),
 *     @OA\Property(property="params", type="string"),
 *     @OA\Property(property="location", type="string", example="55.909098, 37.719785"),
 *     @OA\Property(property="type_entity", format="int64", type="integer", example="1"),
 *     @OA\Property(property="apikey", type="string", example="kiuysdf86764ds8hdskf97"),
 *     @OA\Property(property="host", type="string", example="http://localhost/"),
 *     @OA\Property(property="commission", format="int32", type="integer", example="10"),
 *     @OA\Property(property="simple", type="string", example="Y/null"),
 *     @OA\Property(property="step_cost", type="string", example="Y/null"),
 *     @OA\Property(property="limit_min_cost", type="string", example="Y/null"),
 *     @OA\Property(property="status", type="string", example="F|O|C"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Entity extends BaseModel
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $dates    = [
        'updated_at',
        'created_at',
    ];

    /**
     * Карты, принадлежащие организации.
     * @return mixed
     */
    public function paymentCards()
    {
        return $this->hasMany(UserCards::class, 'entity_id', 'id');
    }

    public function servicesRelated()
    {
        return $this->hasMany(EntityService::class, 'entity_id', 'id');
    }

    public function paymentsRelated()
    {
        //return $this->belongsToMany(EntityPayment::class, 'entity_payments', 'entity_id', 'payment_id');
        return $this->hasMany(EntityPayment::class,  'entity_id', 'id');
    }

    public function requisites()
    {
        return $this->hasOne( Requisites::class, 'entity_id', 'id');
    }

    public function typeService()
    {
        return $this->hasOne( EntityType::class, 'type_entity', 'id');
    }

    public static $arFieldsEntity = [
        [
            'TYPE' => 'S:checkbox',
            'INPUT_NAME' => 'active',
            'CODE' => 'active',
            'NAME' => 'Активный',
            'VALUE' => '',
            'DEFAULT' => 'Y',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-check-input"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'name',
            'CODE' => 'name',
            'NAME' => 'Наименование',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'phone',
            'CODE' => 'phone',
            'NAME' => 'Телефон',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control phone-mask"',
        ],[
            'TYPE' => 'S:date',
            'INPUT_NAME' => 'active_from',
            'CODE' => 'active_from',
            'NAME' => 'Дата начала активности',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="single-daterange form-control"',
        ],[
            'TYPE' => 'S:date',
            'INPUT_NAME' => 'active_to',
            'CODE' => 'active_to',
            'NAME' => 'Дата окончания активности',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="single-daterange form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'code',
            'CODE' => 'code',
            'NAME' => 'Символьный код',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S:html',
            'INPUT_NAME' => 'preview_text',
            'CODE' => 'preview_text',
            'NAME' => 'Адрес',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S:html',
            'INPUT_NAME' => 'detail_text',
            'CODE' => 'detail_text',
            'NAME' => 'Детальное описание',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'location',
            'CODE' => 'location',
            'NAME' => 'Местоположение(координаты точек)',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'user_id',
            'CODE' => 'user_id',
            'NAME' => 'Ответственный пользователь',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'type_entity',
            'CODE' => 'type_entity',
            'NAME' => 'Тип объекта',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'status',
            'CODE' => 'status',
            'NAME' => 'Статус загрузки',
            'VALUE' => 'F',
            'DEFAULT' => 'F',
            'REQUIRED' => '',
            'HIDDEN' => 'Y',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'apikey',
            'CODE' => 'apikey',
            'NAME' => 'ApiKey для подключения',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'host',
            'CODE' => 'host',
            'NAME' => 'Хост для подключения <br/>(http:// или https://)',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S',
            'INPUT_NAME' => 'commission',
            'CODE' => 'commission',
            'NAME' => 'Коммисия (%)',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ],[
            'TYPE' => 'S:checkbox',
            'INPUT_NAME' => 'simple',
            'CODE' => 'simple',
            'NAME' => 'Упрощенный режим услуг',
            'VALUE' => '',
            'DEFAULT' => 'N',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-check-input"',
        ]
    ];
}
