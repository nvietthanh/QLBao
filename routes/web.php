<?php

use App\Http\Controllers\BackEnd\Auth\ForgotPasswordController;
use App\Http\Controllers\BackEnd\Auth\LoginController;
use App\Http\Controllers\BackEnd\Auth\ResgisterController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Models\Account;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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

Route::get('test', function() {
    return Account::find(1)->following;
});

Route::post('login', [LoginController::class, 'login'])->name('guest.login');
Route::get('logout', [LoginController::class, 'logout'])->name('guest.logout');
Route::post('change-password', [LoginController::class, 'changePassword'])->name('guest.change-password');
Route::get('send-otp-forgot-password', [ForgotPasswordController::class, 'forgotPassword'])
    ->name('guest.forgot-password');
Route::post('check-otp-forgot-password', [ForgotPasswordController::class, 'checkOtp'])
    ->name('guest.check-otp');
Route::post('change-forgot-password', [ForgotPasswordController::class, 'changeForgotPassword'])
    ->name('guest.change-forgot-password');
Route::post('resgister', [ResgisterController::class, 'resgister'])
    ->name('guest.resgister');


Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return 1;
    })->name('dashboard');
});

Route::get('/home', function () {
    return redirect()->route('home');
});

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/category/{category}', [HomeController::class, 'category'])->name('list-category');

Route::get('/post/{slugPost}', [HomeController::class, 'post'])->name('post');

Route::get('/creator/id={id}', [HomeController::class, 'creator'])->name('creator');

Route::get('/hagtag/{slug}', [HomeController::class, 'listPostHagtag'])->name('list-post-hagtag');


Route::get('/dieu-khoan-su-dung', function () {
    return Inertia::render('TermOfUse');
})->name('termofuse');

// Route::get('/profile/list-post', function () {
//     return Inertia::render('Creater/ListPost');
// })->name('creater.list-post');

Route::middleware(['auth:accounts'])->prefix('user')->group(function () {
    Route::get('my-profile', function () {
        return Inertia::render('User/MyProfile');
    })->name('user.my-profile');
    
    Route::get('follows', function () {
        return Inertia::render('User/ListFollow');
    })->name('user.list-follow');
    
    Route::get('list-read', function () {
        return Inertia::render('User/ListRead');
    })->name('user.list-read');
    
    Route::get('list-save', function () {
        return Inertia::render('User/ListSave');
    })->name('user.list-save');
    
    Route::middleware('is_creator')->group(function () {
        Route::get('my-post', function () {
            return Inertia::render('Creater/ListPost');
        })->name('user.my-post');
    });
});


