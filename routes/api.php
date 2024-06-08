<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ToolsController;
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

// Ensure that only authenticated users can access the user info
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/faqs', FaqController::class);
Route::apiResource('/projects/categories', CategoryController::class);
Route::apiResource('/projects/clients', ClientController::class);
Route::apiResource('/projects', ProjectController::class);
Route::apiResource('/tools', ToolsController::class);
Route::apiResource('/roles', RolesController::class);
Route::get('/konfigurasi', [KonfigurasiController::class, 'index']);
Route::post('/konfigurasi', [KonfigurasiController::class, 'update']);
Route::post('/login', [LoginController::class, 'login']);
