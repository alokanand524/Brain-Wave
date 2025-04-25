<?php

use App\Http\Controllers\HomeController\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashoardController;
use App\Http\Controllers\WebRTCController;
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



// blade #ROUTE
Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('/features', [HomeController::class,'features'])->name('features');
Route::get('/studyRoom', [HomeController::class,'studyRoom'])->name('studyRoom');
#----------------------------------------------------------------------------------------------------

// OAuth / Google login #ROUTE
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
#-------------------------------------------------------------------------------------------------------

//gmail link verification #Route
Route::get('/magic-register/verify/{token}', [AuthController::class, 'verifyMagicRegister'])->name('magic.register.verify');

Route::get('/magic-login', function () {
    return view('auth.magic-login');
})->name('magic.login');
#----------------------------------------------------------------------------------------------------------

// login / register #ROUTE
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
#------------------------------------------------------------------------------------------------------------

Route::middleware(['auth'])->group(function () {
    // View Profile Page
    Route::get('/profile', [HomeController::class, 'viewProfile'])->name('profile.view');
});
#------------------------------------------------------------------------------------------------------------

// user details update $Route
Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
Route::put('/profile/update-image', [AuthController::class, 'updateImage'])->name('profile.update.image');
#--------------------------------------------------------------------------------------------------------------

//webRTC related $Route
// Route::post('/webrtc/offer', [WebRTCController::class, 'sendOffer']);
// Route::post('/webrtc/answer', [WebRTCController::class, 'sendAnswer']);
// Route::post('/live/start', [LiveSessionController::class, 'start']);
// Route::post('/live/stop', [LiveSessionController::class, 'stop']);

// Laravel routes
Route::post('/webrtc/signal', [WebRTCController::class, 'signal'])->middleware('auth');
