<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_question_id', 'lesson_answer_id', 'answer'];
}
