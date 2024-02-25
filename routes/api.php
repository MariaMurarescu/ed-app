<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\DeVorbaController;
use App\Http\Controllers\SchoolClassController;



/*
|--------------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------------------
|In Laravel, middleware are a way to filter HTTP requests before they reach the application logic,
|it verify the API token attached to the request. If the token is valid, the middleware allows
|the request to proceed to the route handler, where it can be processed. If the token is invalid
|or missing, the middleware returns a 401 Unauthorized response.
|By using middleware, additional layers od security can be easly added without having to
|repeat the same authentication logic in each route handle.
|
| Route::middleware()
| function specifies that this route should be accessible only to authenticated users 
| by passing the auth:sanctum middleware as its parameter. 
| This middleware ensures that the user has a valid token generated by Sanctum before 
| allowing them to access the route.
|
*/

// Define a middleware group for authenticated users
Route::middleware(['auth:sanctum'])->group(function () {
    // Protected routes requiring a specific role (e.g., role_id 1 for students)
    Route::middleware(['role:1'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('/enroll-student', [SchoolClassController::class, 'enrollStudent']);
    });

    // Protected routes requiring a specific role (e.g., role_id 2 for teachers)
    Route::middleware(['role:2'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::resource('/lesson', \App\Http\Controllers\LessonController::class);
        Route::get('/DeVorba', [\App\Http\Controllers\DeVorbaController::class, 'index']);
        Route::get('/lessons/{lessonId}/answers', [LessonController::class, 'getAnswersForLesson']);
        Route::post('/generate-enrollment-code', [SchoolClassController::class, 'generateEnrollmentCode']);
        
        

    });

    // Logout route for authenticated users
    Route::post('/logout', [AuthController::class, 'logout']);
    
});

// Unprotected routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/lesson-by-slug/{lesson:slug}', [LessonController::class, 'showForGuest']);

// Example route that requires authentication but not a specific role
Route::post('/lesson/{lesson}/answer', [LessonController::class, 'storeAnswer']);