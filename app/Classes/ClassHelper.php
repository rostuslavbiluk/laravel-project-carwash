<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Model\{Brands,
    EntityType,
    Organizations,
    PaymentOption,
    Entity,
    Cities,
    Group,
    Profile,
    Requisites,
    Service,
    ServiceCategory,
    User};


class ClassHelper
{
    /**
     * Получаем объект класса в зависимости от страницы
     * @param $code
     * @return array
     */
    public static function getEntityModel(string $code)
    {
        switch ($code) {
            case 'payment_option':
                $entity = new PaymentOption();
                break;
            case 'entities':
                $entity = new Entity();
                break;
            case 'cities':
                $entity = new Cities();
                break;
            case 'user_group':
                $entity = new Group();
                break;
            case 'service_list':
                $entity = new Service();
                break;
            case 'user':
                $entity = new User();
                break;
            case 'brands':
                $entity = new Brands();
                break;
            case 'organizations':
                $entity = new Organizations();
                break;
            case 'profiles':
                $entity = new Profile();
                break;
            case 'entity_types':
                $entity = new EntityType();
                break;
            case 'requisites':
                $entity = new Requisites();
                break;
            case 'service_category':
                $entity = new ServiceCategory();
                break;
        }
        return $entity ?? null;
    }

    /**
     * получаем по символьному коду дополнительные данные для вывода
     * @param $entityName
     * @param $arFields
     */
    public static function getEntityData($entityName, &$arFields, $arRequest = [])
    {

    }
}
