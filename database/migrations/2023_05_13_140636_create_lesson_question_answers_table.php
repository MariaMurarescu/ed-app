<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Lesson::class, 'lesson_id');
            $table->foreignIdFor(\App\Models\LessonQuestion::class, 'lesson_question_id');
            $table->foreignIdFor(\App\Models\LessonAnswer::class, 'lesson_answer_id');
            $table->string('email'); 
            $table->text('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_question_answers');
    }
};
