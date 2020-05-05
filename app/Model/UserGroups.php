<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class UserGroups extends BaseModel
{
    public $timestamps = false;

    protected $guarded = ['id'];
}
