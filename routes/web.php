<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\HelpCenterController;
use App\Models\Folder;

Auth::routes();

/* ---------- PUBLIC LANDING (guest → welcome, auth → dashboard) -- */
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('landing');
});

Auth::routes();

/* ---------- DASHBOARD (auth required) -- */
Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
});
Route::get('/dashboard', function () {
    $folders = Folder::with('teacher')->withCount('notes')->latest()->take(9)->get();
    return view('dashboard', compact('folders'));
})->middleware(['auth'])->name('dashboard');

/* ---------- AUTHENTICATED ROUTES -- */
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [NoteController::class, 'index'])->name('dashboard');
    Route::get('/notes/{note}/download', [NoteController::class, 'download'])->name('notes.download');
    // Quiz taking route (for students)
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/take', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');
    // Assignment routes
    Route::get('/notes/{note}/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/notes/{note}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    // Settings routes
    Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

    // Teacher-only routes
    Route::middleware(['can:access-teacher-features'])->group(function () {
        Route::get('/folders', [FolderController::class, 'index'])->name('folders.index');
        Route::post('/folders', [FolderController::class, 'store'])->name('folders.store');
        Route::delete('/folders/{folder}', [FolderController::class, 'destroy'])->name('folders.destroy');
        Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
        Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::get('/quizzes/{quiz}/results/teacher', [QuizController::class, 'resultsTeacher'])->name('quizzes.results.teacher');
        Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
        Route::get('/quizzes/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
        Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
        Route::post('/assignments/{assignment}/grade', [AssignmentController::class, 'grade'])->name('assignments.grade');
        Route::get('/assignments/{assignment}/download', [AssignmentController::class, 'download'])->name('assignments.download');
    });
});

// Admin routes (only for admin users)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::get('/notes', [AdminController::class, 'notes'])->name('notes');
    Route::get('/notes/create', [AdminController::class, 'createNote'])->name('notes.create');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

    Route::post('/notes/{note}/approve', [AdminController::class, 'approveNote'])->name('notes.approve');
    Route::delete('/notes/{note}', [AdminController::class, 'rejectNote'])->name('notes.reject');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

// Help Center routes
Route::middleware(['auth'])->group(function () {
    Route::get('/help', [HelpCenterController::class, 'index'])->name('help.index');
    Route::post('/help/contact', [HelpCenterController::class, 'contact'])->name('help.contact');
});
