<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonQuestionAnswer;
use App\Models\Feedback;

class FeedbackController extends Controller
{
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
    public function testFeedback(Request $request)
{
    return response()->json(['message' => 'Test feedback received'], 200);
}

}
