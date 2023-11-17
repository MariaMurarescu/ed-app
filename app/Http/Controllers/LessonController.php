<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonAnswerRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\LessonAnswer;
use App\Models\LessonQuestion;
use App\Models\LessonQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = request('per_page', 10);
        $search = request('search', '');

        $query = Lesson::where('user_id', $user->id)
        ->orderBy('created_at', 'DESC');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
    });
}

return LessonResource::collection($query->paginate($perPage));
        
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        $data = $request->validated();

        // Check if image was given and save on local file system
        if (isset($data['image'])){
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $lesson = Lesson::create($data);


        // Create new questions
        foreach ($data['questions'] as $question) {
         $question['lesson_id'] = $lesson->id;
         $this->createQuestion($question);
        }

        return new LessonResource($lesson);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $lesson->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        return new LessonResource($lesson);
    }

    public function showForGuest(Lesson $lesson)
    {
        return new LessonResource($lesson);
    }

    public function storeAnswer(StoreLessonAnswerRequest $request, Lesson $lesson)
    {
        $validated = $request->validated();
        $lessonAnswer = LessonAnswer::create([
            'lesson_id' =>$lesson->id,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
        ]);
            //very important to ensure that each question is correct associated with the correct lesson 
            foreach ($validated['answers'] as $questionId => $answer) {
                $question = LessonQuestion::where(['id' => $questionId, 'lesson_id' => $lesson->id])->get();
                if (!$question) {
                    return response("Invalid question ID: \"$questionId\"", 400);
                }
    
                $data = [
                    'lesson_question_id' => $questionId,
                    'lesson_answer_id' => $lessonAnswer->id,
                    'answer' => is_array($answer) ? json_encode($answer) : $answer
                ];
    
                $questionAnswer = LessonQuestionAnswer::create($data);
            }
    
            return response("", 201);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $data = $request->validated();

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            // If there is an old image, delete it
            if ($lesson->image) {
                $absolutePath = public_path($lesson->image);
                File::delete($absolutePath);
            }
        }

        // Update lesson in the database
        $lesson->update($data);

        // Get ids as plain array of existing questions
        $existingIds = $lesson->questions()->pluck('id')->toArray();

        // Get ids as plain array of new questions
        $newIds = Arr::pluck($data['questions'], 'id');

        // Find questions to delete
        $toDelete = array_diff($existingIds, $newIds);
        
        //Find questions to add
        $toAdd = array_diff($newIds, $existingIds);

        // Delete questions by $toDelete array
        LessonQuestion::destroy($toDelete);

        // Create new questions
        foreach ($data['questions'] as $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['lesson_id'] = $lesson->id;
                $this->createQuestion($question);
            }
        }

        // Update existing questions
        $questionMap = collect($data['questions'])->keyBy('id');
        foreach ($lesson->questions as $question) {
            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }

        return new LessonResource($lesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $lesson->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        $lesson->delete();

        // If there is an old image, delete it
        if ($lesson->image) {
            $absolutePath = public_path($lesson->image);
            File::delete($absolutePath);
        }

        return response('', 204);
    }

    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }

    /**
     * Create a question and return
     */

    private function createQuestion($data)
    {
        if (is_array($data['data'])) { //array in php, object in javascript
            $data['data'] = json_encode($data['data']); //we cannot save array in the database and we encoded asa json
        }
        $validator = Validator::make($data, [
            'question' => 'required|string',
            'type' => ['required', Rule::in([
                Lesson::TYPE_TEXT,
                Lesson::TYPE_TEXTAREA,
                Lesson::TYPE_SELECT,
                Lesson::TYPE_RADIO,
                Lesson::TYPE_CHECKBOX,
            ])],
            'description' => 'nullable|string',
            'data' => 'present',
            'lesson_id' => 'exists:App\Models\Lesson,id'
        ]);

        return LessonQuestion::create($validator->validated());
    }

    /**
     * Update question
     */

    private function updateQuestion(LessonQuestion $question, $data)
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'id' => 'exists:App\Models\LessonQuestion,id',
            'question' => 'required|string',
            'type' => ['required', Rule::in([
                Lesson::TYPE_TEXT,
                Lesson::TYPE_TEXTAREA,
                Lesson::TYPE_SELECT,
                Lesson::TYPE_RADIO,
                Lesson::TYPE_CHECKBOX,
            ])],
            'description' => 'nullable|string',
            'aim' => 'nullable|string',
            'data' => 'present',
        ]);

        return $question->update($validator->validated());
    }

    public function createQuestionAnswer($data)
    {
        if (is_array($data['answer'])) {
            $data['answer'] = json_encode($data['answer']);
        }
    }
}