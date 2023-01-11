<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsersList()
    {
        $users = User::ofRole(Role::ROLE_USER)->with('lessons')->get();
        return UserResource::collection($users);
    }
}
