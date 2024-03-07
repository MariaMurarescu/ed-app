<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Lesson extends Model
{
    use HasFactory, HasSlug;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';

    protected $fillable = ['user_id', 'image', 'title', 'slug', 'status', 'description', 'aim', 'keywords', 'expire_date'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function questions()
    {
        return $this->hasMany(LessonQuestion::class);
    }

    public function answers()
    {
        return $this->hasMany(LessonAnswer::class);
    }

    public function questionAnswers()
    {
        return $this->hasMany(LessonQuestionAnswer::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
