<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
    
        // Create student account
        $student = User::create([
            'name' => 'Student Name',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role_id' => $studentRole->id,
        ]);
        $student->roles()->attach($studentRole);

                // Create teacher accounts
                $teacher = User::create([
                    'name' => 'Teacher',
                    'email' => 'teacher@example.com',
                    'password' => Hash::make('password'),
                    'role_id' => $teacherRole->id,
                ]);
        $teacher->roles()->attach($teacherRole);
    }
}
