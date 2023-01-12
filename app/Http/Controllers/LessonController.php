<?php

namespace App\Http\Controllers;

use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::withCount('users')->orderByDesc('users_count')->get();
        return Inertia::render('Lessons', [
            'lessons' => LessonResource::collection($lessons),
        ]);
    }

    public function getUserLessons($id)
    {
        $user = User::with('lessons')->find($id);
        return $user->lessons->pluck('name');
    }
}
