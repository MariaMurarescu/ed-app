<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($roleName)
    {
        return $this->roles->pluck('name')->contains($roleName);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_user');
    }

    public function enrolledClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'user_school_class')
            ->withPivot('enrollement_code')
            ->wherePivot('role', 1); //1 for student
    }

    public function teachingClasses()
    {
        return $this->bleongToMany(SchoolClass::class, 'user_scholl_class')
            ->withPivot('enrollment_code')
            ->wherePivot('role', 2); //2 for teacher
    }

    public function isTeacher()
    {
        return $this->roles()->where('id', 2)
            ->exists();
    }
}