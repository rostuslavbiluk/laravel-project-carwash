<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;


class Requisites extends BaseModel
{
    protected $guarded = ['id'];

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)->firstOrFail();
    }

}
