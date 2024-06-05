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

// Public routes (assuming 'index' and 'show' methods are public)
Route::apiResource('/faqs', FaqController::class)->only(['index', 'show']);
Route::apiResource('/projects/categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('/projects/clients', ClientController::class)->only(['index', 'show']);
Route::apiResource('/projects', ProjectController::class)->only(['index', 'show']);
Route::apiResource('/tools', ToolsController::class)->only(['index', 'show']);
Route::apiResource('/roles', RolesController::class)->only(['index', 'show']);
Route::get('/konfigurasi', [KonfigurasiController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);

// Routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/faqs', FaqController::class)->except(['index', 'show']);
    Route::apiResource('/projects/categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('/projects/clients', ClientController::class)->except(['index', 'show']);
    Route::post('/projects/clients/{id}', [ClientController::class, 'update']);

    Route::apiResource('/projects', ProjectController::class)->except(['index', 'show']);
    Route::post('/projects/{id}', [ProjectController::class, 'update']);

    Route::apiResource('/tools', ToolsController::class)->except(['index', 'show']);
    Route::post('/tools/{id}', [ToolsController::class, 'update']);

    Route::apiResource('/roles', RolesController::class)->except(['index', 'show']);
    Route::post('/roles/{id}', [RolesController::class, 'update']);

    Route::post('/konfigurasi', [KonfigurasiController::class, 'update']);
});
