<?php

use App\Http\Controllers\ApiController;
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

Route::get('/', [ApiController::class, 'index']);
Route::get('/faqs', [ApiController::class, 'faqs']);
Route::get('/categories', [ApiController::class, 'categories']);
Route::get('/projects', [ApiController::class, 'projects']);
Route::get('/project/{id}', [ApiController::class, 'project']);
Route::get('/project/{id}/details', [ApiController::class, 'projectDetails']);
Route::get('/project/{id}/galleries', [ApiController::class, 'projectGalleries']);
