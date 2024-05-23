<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('landing/Index');
})->name('dashboard');

Route::post('/upload-excel', [ExcelController::class, 'uploadExcel']);
Route::get('/vragen', function () {
    return Inertia::render('QuestionsPage');
})->name('questions');

Route::get('/questions-by-category/{category}', [QuestionController::class, 'getQuestionsByCategory']);
Route::get('/questions-by-filename/{filename}', [QuestionController::class, 'getQuestionsByFilename']); // Add this line
Route::get('/questions/{id}', [QuestionController::class, 'getQuestionById']);
Route::get('/answers/{questionId}', [AnswerController::class, 'getAnswersByQuestion']);
Route::get('/questions-list/{filename}', [QuestionController::class, 'showQuestionsList']);