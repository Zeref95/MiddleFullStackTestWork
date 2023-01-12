<?php

namespace App\Http\Controllers;

use App\Http\Resources\LessonResource;
use App\Models\Lesson;
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
}
