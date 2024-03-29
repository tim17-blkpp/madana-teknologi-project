<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\FaqController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route
// Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/', function () {
  return view('welcome');
});
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');
Route::get('/page-home', [HomePage::class, 'index'])->name('pages-home');

// Main Page Route
Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');


// Faq Route
Route::resource('/dashboard/faq', FaqController::class);
// Route::get('/dashboard/faq', [FaqController::class, 'index'])->name('faq.index');
// Route::post('/dashboard/faq', [FaqController::class, 'store'])->name('faq.store');
// Route::put('/dashboard/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
// Route::delete('/dashboard/faq/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
