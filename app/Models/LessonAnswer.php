<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAnswer extends Model
{
    use HasFactory;

    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $fillable = ['lesson_id', 'start_date', 'end_date'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
