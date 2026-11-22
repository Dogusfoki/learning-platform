<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/create', [UserController::class, 'create']);

    Route::post('/users', [UserController::class, 'store']);

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/courses/create', function () {
        return Inertia::render('Courses/Create');
    })->name('courses.create');

    Route::post('/courses', function () {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create([
        ...$data,
        'user_id' => auth()->id(),
        ]);
        return redirect()->route('courses.index')->with('success', 'Course created!');
    })->name('courses.store');


    Route::get('/courses/{course}/edit', function (Course $course) {
        abort_unless($course->user_id === auth()->id(), 403);
        return Inertia::render('Courses/Edit', [
            'course' => $course,
        ]);
    })->name('courses.edit');

    Route::put('courses/{course}', function (Course $course) {
        abort_unless($course->user_id === auth()->id(), 403);
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'Course updated!');
    })->name('course.update');

    Route::delete('/courses/{course}', function (Course $course) {
        abort_unless($course->user_id === auth()->id(), 403);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted!');
    })->name('courses.destroy');

    Route::post('/courses/{course}/topics', function (Course $course) {
        abort_unless($course->user_id === auth()->id(), 403);

        if ($course->topics()->count() >= 2) {
            return redirect()
                ->back()
                ->withErrors([
                    'topic_limit' => 'This course can have a maximum of 2 topics.',
                ]);
        }

        $data = request()->validate([
            'title' => 'required|string|max:150',
        ]);

        $course->topics()->create($data);

        return redirect()->route('courses.index')->with('success', 'Topic created!');
    })->name('courses.topics.store');

    Route::get('/courses', function () {
        return Inertia::render('Courses/Index', [
            'courses' => fn () => App\Models\Course::where('user_id', auth()->id())->paginate(10),
            'topics' => fn () => App\Models\Topic::all()->groupBy('course_id'),]);
    })->name('courses.index');

    Route::get('/topics/{topic}', function (Topic $topic) {
        $topic->load('lessons');
        return Inertia::render('Topics/Show', [
            'topic' => $topic,
            'course' => $topic->course,
            ]);
    })->name('topics.show');
});

Route::delete('/topics/{topic}', function (Topic $topic) {
    abort_unless($topic->course->user_id === auth()->id(), 403);

    $topic->delete();

    return redirect()
        ->route('courses.index')
        ->with('success', 'Topic deleted!');
})->name('topics.destroy');

Route::post('/topics/{topic}/lessons', function (Topic $topic, Request $request) {
    abort_unless($topic->course?->user_id === auth()->id(), 403);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $topic->lessons()->create($validated);

    return redirect()
        ->route('topics.show', $topic)
        ->with('success', 'Lesson created!');
})->name('topics.lessons.store');

Route::delete('/lessons/{lesson}', function (Lesson $lesson) {
    abort_unless($lesson->topic->course?->user_id === auth()->id(), 403);

    $lesson->delete();

    return redirect()
        ->route('topics.show', $lesson->topic)
        ->with('success', 'Lesson deleted!');
})->name('lessons.destroy');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'projects' => fn () => App\Models\Project::withCount('comments')->get(),
        ]);
})->middleware(['auth', 'verified'])->name('dashboard');
