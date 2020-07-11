<?php

namespace App;

    use Illuminate\Database\Eloquent\Model as BaseModel;

    class Model extends BaseModel
{
    protected $hidden = ['created_at', 'updated_at'];
}
