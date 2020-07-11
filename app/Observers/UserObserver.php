<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->profile_image ??= '#'. str_pad(dechex(rand(0, 16777215)), 6, '0', STR_PAD_LEFT);
    }
}
