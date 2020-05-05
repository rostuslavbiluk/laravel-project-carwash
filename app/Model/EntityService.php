<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class EntityService extends BaseModel
{
    protected $guarded = ['id'];

    public function entity()
    {
        return $this->hasOne( Entity::class, 'id', 'entity_id');
    }

    public function service()
    {
        return $this->hasOne( Service::class, 'id', 'service_id');
    }

    public function profile()
    {
        return $this->hasOne( ProfilesService::class, 'id', 'profile_id');
    }
}
