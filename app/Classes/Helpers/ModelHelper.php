<?php


namespace App\Classes\Helpers;

use Illuminate\Database\Eloquent\Model;


class ModelHelper
{
    /**
     * @param string $class
     * @param $list
     */
    public static function getReferenceList(string $class, &$list)
    {
        try {
            $list = [];
            /** @var Model $entity */
            $entity = new $class();
            $entityList = $entity::all();
            if ($entityList) {
                $list = $entityList->toArray();
            }
        } catch (Error $e) {}
    }
}
