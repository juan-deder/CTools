<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
