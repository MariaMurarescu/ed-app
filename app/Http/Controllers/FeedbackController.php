<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonQuestionAnswer;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    //Method to retrive feedback taking into cosideration lessonId and answerId
    public function store(Request $request, $lessonId, $answerId)
    {
        $request->validate([
            'feedback' => 'required|string',
        ]);
    
        $feedback = new Feedback();
        $feedback->lesson_id = $lessonId; 
        $feedback->lesson_question_answer_id = $answerId;
        $feedback->feedback = $request->feedback;
        $feedback->save();
    
        return response()->json(['feedback' => $feedback], 200);
    }

    public function getFeedbackForLesson($lessonId) {
        $feedback = Feedback::where('lesson_id', $lessonId)->get();
        return response()->json($feedback);
    }
    
    
    // Metodă pentru a prelua feedback-ul pentru utilizatorul curent

    public function getFeedbackForUser($userId) {
        $feedback = Feedback::whereHas('user', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->get();
        return response()->json($feedback);
    }
}

