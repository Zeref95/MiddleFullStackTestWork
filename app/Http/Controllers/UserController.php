<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsersList(Request $request)
    {
        $users = User::ofRole(Role::ROLE_USER)->with('lessons')->get();
        $lessonsCount = Lesson::count();

        $users->map(function ($user) use ($lessonsCount) {
            $countUserLessons = $user->lessons->count();
            $user->countLessons = $countUserLessons;
            $user->progress = round((100 * $countUserLessons) / $lessonsCount);
        });
        $ranks = $users->pluck('countLessons')->unique()->sort()->reverse()->values()->toArray();
        $users->map(function ($user) use ($ranks) {
            $user->rank = array_search($user->countLessons, $ranks, true) + 1;
        });

        if ($request->sort && $request->sort === 'lessons') {
            $users = $users->sortByDesc('countLessons');
        }
        return UserResource::collection($users);
    }
}
