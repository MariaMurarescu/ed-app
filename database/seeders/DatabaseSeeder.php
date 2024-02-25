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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
    
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

                        // Create admin accounts
                        $admin= User::create([
                            'name' => 'Admin',
                            'email' => 'admin@example.com',
                            'password' => Hash::make('password'),
                            'role_id' => $adminRole->id,
                        ]);
        $admin->roles()->attach($adminRole);
    }
}