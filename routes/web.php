<?php

use App\Http\Controllers\HomeController\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashoardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LiveSessionController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

// Auth::routes();




Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('/features', [HomeController::class,'features'])->name('features');
Route::get('/studyRoom', [HomeController::class,'studyRoom'])->name('studyRoom');



Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/magic-register/verify/{token}', [AuthController::class, 'verifyMagicRegister'])->name('magic.register.verify');


Route::get('/magic-login', function () {
    return view('auth.magic-login');
})->name('magic.login');

Route::middleware(['auth'])->group(function () {
    // View Profile Page
    Route::get('/profile', [HomeController::class, 'viewProfile'])->name('profile.view');

});

// routes/web.php
Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
Route::put('/profile/update-image', [AuthController::class, 'updateImage'])->name('profile.update.image');


Route::middleware(['auth'])->group(function () {
    Route::post('/live-session/start', [LiveSessionController::class, 'start'])->name('live.session.start');
    Route::post('/live-session/end', [LiveSessionController::class, 'end'])->name('live.session.end');
});
