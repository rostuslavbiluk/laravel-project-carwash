<?php

namespace App\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'password_confirmation'
    ];

    /**
     * @var array
     */
    protected $guarded = ['id', 'password_confirmation'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'checkword',
            'CODE' => 'checkword',
            'NAME' => '',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => 'Y',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'confirm_code',
            'CODE' => 'confirm_code',
            'NAME' => '',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => 'Y',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'username',
            'CODE' => 'username',
            'NAME' => 'Логин',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => 'Y',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'name',
            'CODE' => 'name',
            'NAME' => 'Имя',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'last_name',
            'CODE' => 'last_name',
            'NAME' => 'Фамилия',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'second_name',
            'CODE' => 'second_name',
            'NAME' => 'Отчество',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'password',
            'CODE' => 'password',
            'NAME' => 'Пароль',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'personal_phone',
            'CODE' => 'personal_phone',
            'NAME' => 'Телефон',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control phone-mask"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'email',
            'CODE' => 'email',
            'NAME' => 'Email',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S',
            'INPUT_NAME' => 'personal_mobile',
            'CODE' => 'personal_mobile',
            'NAME' => 'Телефон доп.',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control phone-mask"',
        ], [
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'personal_gender',
            'CODE' => 'personal_gender',
            'NAME' => 'Пол',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'S:date',
            'INPUT_NAME' => 'personal_birthdate',
            'CODE' => 'personal_birthdate',
            'NAME' => 'Дата рождения',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="single-daterange form-control"',
        ], [
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'personal_city',
            'CODE' => 'personal_city',
            'NAME' => 'Город',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control"',
        ], [
            'TYPE' => 'L:select',
            'INPUT_NAME' => 'user_group[]',
            'CODE' => 'user_group',
            'NAME' => 'Группа пользователя',
            'VALUE' => '',
            'DEFAULT' => '',
            'REQUIRED' => '',
            'HIDDEN' => '',
            'PARAMS' => 'class="form-control" multiple',
        ]
    ];

    /**
     * Роли, принадлежащие пользователю.
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Group::class, 'user_groups', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne(Cities::class, 'id', 'personal_city');
    }

    /**
     * Получить все профили пользователей (платежных)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pointCarwash()
    {
        return $this->hasOne(Entity::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxipark()
    {
        return $this->hasOne(Organizations::class, 'user_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getRoleIds()
    {
        return $this->roles()->allRelatedIds();
    }

    /**
     * Получить уникальный идентификатор пользователя.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Получить пароль пользователя.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Получить адрес e-mail для отправки напоминания о пароле.
     * @return string
     */
    public function getReminderEmail(): string
    {
        return (string)$this->email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }
}
