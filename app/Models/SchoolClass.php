<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    public function students()
    {
        return $this->belongsToMany(User::class, 'user_school_class')
            ->withPivot('enrollment_code')
            ->wherePivot('role', 1); // Assuming role 1 is for students
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_school_class', 'school_class_id', 'user_id')
        ->withPivot('role', 'enrollment_code');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

}
