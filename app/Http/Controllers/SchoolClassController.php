<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function generateEnrollmentCode(Request $request)
    {
        //$this->authorize('create', SchoolClass::class); // need to see if I use policies or other authorization mechanisms

        $code = strtoupper(Str::random(6));
        $schoolClass = new SchoolClass();
        $schoolClass->code = $code;
        $schoolClass->save();

        return response()->json(['code' => $code]);
    }

    public function enrollStudent(Request $request)
    {
        //validate the request
        $request->validate([
            'code' => 'required|exists:school_classes,code',
        ]);
        //get the school class and user
        $schoolClass = SchoolClass::where('code', $request->input('code'))->first();
        $user = auth()->user();

        // Check if the user is already enrolled
        if ($user->enrolledClasses->contains($schoolClass)) {
            return response()->json(['message' => 'Student is already enrolled']);
        }

        // Enroll the student
        $role = $user->roles()->where('id', 1)->exists() ? 1 : 2; // Set role based on user's role
        $enrollmentCode = strtoupper(Str::random(6)); 
        $user->enrolledClasses()->attach($schoolClass->id, ['role' => $role, 'enrollment_code' => $enrollmentCode]);

        return response()->json(['message' => 'Enrollment successful']);
    }
}
