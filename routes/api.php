<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("sign-up", [AuthController::class, "signUp"]);
Route::post("login", [AuthController::class, "login"]);
// Route::post("user/{id}/fields", function () {
    
    // });
    
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post("/logout", [AuthController::class, "logout"]);

    Route::post('/ask-question', [QuestionController::class, "askQuestion"]);
    Route::get('/questions', [QuestionController::class, "getAllQuestions"]);
    Route::get('/questions/{question}', [QuestionController::class, "getFullQuestion"]);
    Route::post('/delete-question/{id}', [QuestionController::class, "deleteQuestion"]);

    Route::post('/answer-question/{id}', [AnswerController::class, "answerQuestion"]);
    Route::get('/answers/user/{id}', [AnswerController::class, "getAllAnswers"]);
    Route::post('/delete-answer/{id}', [AnswerController::class, "deleteAnswer"]);
});
