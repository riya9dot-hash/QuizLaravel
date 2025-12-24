<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizCategoryController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandUserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PriorityController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Role Management (Admin only)
    Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDestroy'])->name('roles.bulk-delete');
    Route::resource('roles', RoleController::class);
    
    // Permission Management (Admin only)
    Route::post('/permissions/bulk-delete', [PermissionController::class, 'bulkDestroy'])->name('permissions.bulk-delete');
    Route::resource('permissions', PermissionController::class);
    
    // User Management (Super Admin only - Full CRUD for Admin Users)
    Route::post('/users/bulk-delete', [UserController::class, 'bulkDestroy'])->name('users.bulk-delete');
    Route::resource('users', UserController::class);
    
    // Module Management (Super Admin only)
    Route::resource('modules', \App\Http\Controllers\ModuleController::class);
    
    // Brand Management (Admin only)
    Route::post('/brands/bulk-delete', [BrandController::class, 'bulkDestroy'])->name('brands.bulk-delete');
    Route::resource('brands', BrandController::class);
    
    // Brand User Management (Admin only)
    Route::post('/brand-users/bulk-delete', [BrandUserController::class, 'bulkDestroy'])->name('brand-users.bulk-delete');
    Route::resource('brand-users', BrandUserController::class);
    
    // Language Management (Admin only)
    Route::post('/languages/bulk-delete', [LanguageController::class, 'bulkDestroy'])->name('languages.bulk-delete');
    Route::resource('languages', LanguageController::class);
    
    // Priority Management (Admin only)
    Route::post('/priority/bulk-delete', [PriorityController::class, 'bulkDestroy'])->name('priority.bulk-delete');
    Route::resource('priority', PriorityController::class);
    
    // Quiz Category Management (Admin only)
    Route::post('/quiz-category/bulk-delete', [QuizCategoryController::class, 'bulkDestroy'])->name('quiz-category.bulk-delete');
    Route::resource('quiz-category', QuizCategoryController::class);
    
    // Quiz Management (Admin only)
    Route::resource('quiz', QuizController::class);
    
    // Quiz Assignment Routes (Admin only)
    Route::get('/quiz/assign-category/{categoryId}', [QuizController::class, 'assignCategoryForm'])->name('quiz.assign-category');
    Route::post('/quiz/assign-category/{categoryId}', [QuizController::class, 'assignCategory'])->name('quiz.assign-category.store');
    Route::get('/quiz/assign-quiz/{quiz}', [QuizController::class, 'assignQuizForm'])->name('quiz.assign-quiz');
    Route::post('/quiz/assign-quiz/{quiz}', [QuizController::class, 'assignQuiz'])->name('quiz.assign-quiz.store');
    Route::get('/quiz/category/{categoryId}/assignments', [QuizController::class, 'viewCategoryAssignments'])->name('quiz.category-assignments');
    Route::delete('/quiz/assignment/{assignment}', [QuizController::class, 'removeAssignment'])->name('quiz.assignment.remove');
    
    // User Quiz Routes (For normal users to take quizzes)
    Route::get('/user-quiz', [UserQuizController::class, 'index'])->name('user-quiz.index');
    Route::get('/user-quiz/quiz-name/{quizName}', [UserQuizController::class, 'showByQuizName'])->name('user-quiz.quiz-name');
    Route::get('/user-quiz/start/{quizName}', [UserQuizController::class, 'startQuiz'])->name('user-quiz.start');
    Route::get('/user-quiz/take/{session}/{question}', [UserQuizController::class, 'takeQuiz'])->name('user-quiz.take');
    Route::post('/user-quiz/submit-answer/{session}/{question}', [UserQuizController::class, 'submitAnswer'])->name('user-quiz.submit-answer');
    Route::get('/user-quiz/session/{session}/result', [UserQuizController::class, 'sessionResult'])->name('user-quiz.session-result');
    Route::get('/user-quiz/session/{session}/details', [UserQuizController::class, 'showSessionDetails'])->name('user-quiz.session-details');
    Route::get('/user-quiz/{quiz}', [UserQuizController::class, 'show'])->name('user-quiz.show');
    Route::post('/user-quiz/{quiz}/submit', [UserQuizController::class, 'submit'])->name('user-quiz.submit');
    Route::get('/user-quiz/{quiz}/result', [UserQuizController::class, 'result'])->name('user-quiz.result');
    Route::get('/user-quiz-history', [UserQuizController::class, 'history'])->name('user-quiz.history');
});
