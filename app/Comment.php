<?php

namespace App;

class Comment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

}
