<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function authed(Request $request)
    {
        return $request->user();
    }

    public function committers(Request $request)
    {
        return User::select(['id', 'name', 'profile_image'])->get();
    }
}
