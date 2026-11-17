<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use App\Models\Topic;
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
});

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'projects' => fn () => App\Models\Project::withCount('comments')->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/courses', function () {
    return Inertia::render('Courses/Index', [
        'courses' => fn () => App\Models\Course::paginate(10),
        'topics' => fn () => App\Models\Topic::all()->groupBy('course_id'),]);
})->name('courses.index');

Route::get('/topics/{topic}', function (Topic $topic) {
    return Inertia::render('Topics/Show', [
        'topic' => $topic,
    ]);
})->name('topics.show');

Route::get('/courses/create', function () {
    return Inertia::render('Courses/Create');
})->name('courses.create');

Route::post('/courses', function () {
    $data = request()->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);
    Course::create($data);

    return redirect()->route('courses.index')->with('success', 'Course created!');
})->name('courses.store');

Route::get('/courses/{course}/edit', function (Course $course) {
    return Inertia::render('Courses/Edit', [
        'course' => $course,
    ]);
})->name('courses.edit');

Route::put('courses/{course}', function (Course $course) {
    $data = request()->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string'
    ]);

    $course->update($data);
    return redirect()->route('courses.index')->with('success', 'Course updated!');
})->name('course.update');

Route::delete('/courses/{course}', function (Course $course) {
    $course->delete();

    return redirect()->route('courses.index')->with('success', 'Course deleted!');
})->name('courses.destroy');
