<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsersList(Request $request)
    {
        $users = User::ofRole(Role::ROLE_USER)
            ->withCount('lessons')
            ->when($request->sort && $request->sort === 'lessons', function ($query) {
                $query->orderByDesc('lessons_count');
            })
            ->get();

        $lessonsCount = Lesson::count();
        $ranks = $users->pluck('lessons_count')->unique()->sort()->reverse()->values()->toArray();
        $users->map(function ($user) use ($lessonsCount, $ranks) {
            $user->progress = round((100 * $user->lessons_count) / $lessonsCount);
            $user->rank = array_search($user->lessons_count, $ranks, true) + 1;
        });

        return UserResource::collection($users);
    }
}
