<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LessonAnswerResource;
use App\Http\Resources\LessonResourceDeVorba;
use App\Http\Resources\LessonQuestionAnswerResource;
use App\Models\Lesson;
use App\Models\LessonAnswer;

class DeVorbaController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();

        //total number of lessons
        $total = Lesson::query()->where('user_id', $user->id)->count();

        //latest lessons
        $latest = Lesson::query()->where('user_id', $user->id)->latest('created_at')->first();

        // Total Number of answers
        $totalAnswers = LessonAnswer::query()
            ->join('lessons', 'lesson_answers.lesson_id', '=', 'lessons.id')
            ->where('lessons.user_id', $user->id)
            ->count();

        //latest 5 answer
        $latestAnswers = LessonAnswer::query()
        ->join('lessons', 'lesson_answers.lesson_id', '=', 'lessons.id')
        ->where('lessons.user_id', $user->id)
        ->orderBy('end_date', 'DESC')
        ->limit(5)
        ->getModels('lesson_answers.*');

    return [
        'totalLessons' => $total,
        'latestLesson' => $latest ? new LessonResourceDeVorba($latest) : null,
        'totalAnswers' => $totalAnswers,
        'latestAnswers' => LessonAnswerResource::collection($latestAnswers)
    ];
    }

    public function getLastAnswerForLastLesson($lessonId)
{
    $lastAnswer = LessonQuestionAnswer::query()
        ->where('lesson_id', $lessonId)
        ->orderByDesc('created_at')
        ->first();

    return new LessonQuestionAnswerResource($lastAnswer);
}

}
