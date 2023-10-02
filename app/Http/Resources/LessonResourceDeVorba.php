<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\URL;

class LessonResourceDeVorba extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => !!$this->status,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'expire_date' => $this->expire_date,
            'questions' => $this->questions()->count(),
            'answers' => $this->answers()->count()
        ];
    }
}