<?php

// app/Http/Resources/LessonQuestionAnswerResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonQuestionAnswerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'lesson_question_id' => $this->lesson_question_id,
            'lesson_answer_id' => $this->lesson_answer_id,
            'email'=>$this->email,
            'answer' => $this->answer,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
