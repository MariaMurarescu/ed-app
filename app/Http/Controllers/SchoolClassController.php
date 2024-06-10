<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function generateEnrollmentCode(Request $request)
    {
         
        Log::info('User Role: ' . auth()->user()->role_id);
        abort_unless(auth()->user()->role_id == 2, 403, 'This action is unauthorized.');
        $code = strtoupper(Str::random(6));
        $schoolClass = new SchoolClass();
        $schoolClass->code = $code;
        $schoolClass->save();

        return response()->json(['code' => $code]);
    }

    public function enrollStudent(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:school_classes,code',
        ]);

        $schoolClass = SchoolClass::where('code', $request->input('code'))->first();
        $user = auth()->user();

        if ($user->enrolledClasses->contains($schoolClass)) {
            return response()->json(['message' => 'Student is already enrolled']);
        }

        // Enroll the student with role 1 (role 1 is for students)
        $enrollmentCode = strtoupper(Str::random(6));
        $user->enrolledClasses()->attach($schoolClass->id, ['role' => 1, 'enrollment_code' => $enrollmentCode]);

        return response()->json(['message' => 'Enrollment successful']);
    }

    public function getStudentLessons(Request $request)
    {
        $user = $request->user();
        $lessons = $user->lessons; 

        return response()->json(['lessons' => $lessons]);
    }

}