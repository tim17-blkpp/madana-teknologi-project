<?php

use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/faqs', [FaqController::class, 'index']);
// Route::post('/faqs', [FaqController::class, 'store']);
// Route::put('/faqs/{id}', [FaqController::class, 'update']);

Route::apiResource('faqs', FaqController::class);
