<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorProductController;
use App\Http\Controllers\TeamController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TutorProduct routes
Route::get('/get-products', [TutorProductController::class, 'index']);
Route::post('/save-products', [TutorProductController::class, 'store']);
Route::get('/get-products-by-id/{id}', [TutorProductController::class, 'show']);
Route::put('/update-products/{id}', [TutorProductController::class, 'update']);
Route::delete('/drop-products/{id}', [TutorProductController::class, 'destroy']);

// Team routes
Route::get('/get-teams', [TeamController::class, 'index']);
Route::post('/save-teams', [TeamController::class, 'store']);
Route::get('/get-teams-byid/{id}', [TeamController::class, 'show']);
Route::put('/update-teams/{id}', [TeamController::class, 'update']);
Route::delete('/drop-teams/{id}', [TeamController::class, 'destroy']);