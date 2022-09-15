<?php

use App\Http\Controllers\API\ProjectController;
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
Route::post('login', [App\Http\Controllers\API\AuthController::class, 'signin']);

Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('user', [App\Http\Controllers\API\ProjectController::class, 'getUserData']);
    Route::get('project/{project}', [App\Http\Controllers\API\ProjectController::class, 'getprojects']);
    Route::get('survey/{survey}', [App\Http\Controllers\API\SurveyController::class, 'getSurveyData']);
    Route::get('survey', [App\Http\Controllers\API\SurveyController::class, 'show']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});