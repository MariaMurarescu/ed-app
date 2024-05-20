<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = ['lesson_id', 'lesson_question_answer_id', 'feedback'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function answer()
    {
        return $this->belongsTo(LessonQuestionAnswer::class, 'lesson_question_answer_id');
    }
    
    public function lessonQuestionAnswer()
    {
        return $this->belongsTo(LessonQuestionAnswer::class);
    }
}
