<?php

// use App\Http\Controllers\Api\BackEnd\CategoryController;

use App\Http\Controllers\Api\BackEnd\Admin\AboutUsController;
use App\Http\Controllers\Api\Backend\Admin\AdvertistController;
use App\Http\Controllers\Api\BackEnd\Admin\PrivatePolicyController;
use App\Http\Controllers\Api\BackEnd\Admin\TermOfUseController;
use App\Http\Controllers\Api\BackEnd\Creator\HagTagController;
use App\Http\Controllers\Api\FrontEnd\PostController;
use App\Http\Controllers\Api\FrontEnd\CreatorController;
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

Route::get('/get-new-post', [PostController::class, 'getNewPost'])->name('post.get-new-all');

// List category
Route::post('/category/get-all/{category}', [PostController::class, 'getListPostCategory'])->name('category.list-post');

// Route::get('/get-post/{slugPost}', [PostController::class, 'getPost'])->name('post.get-post');

Route::get('/get-list-post-creator/id={id}', [PostController::class, 'getListPostCreator'])->name('post.get-list-post-creator');

Route::post('/get-list-post-hagtag/{slug}', [PostController::class, 'getListPostHagtag'])->name('post.get-list-post-hagtag');

Route::get('/get-list-post-popular', [PostController::class, 'getListPostPopular'])->name('post.get-list-post-popular');

Route::post('/get-list-post-hagtag-popular', [PostController::class, 'getListHagtagPopular'])->name('post.get-list-hagtag-popular');

Route::get('/get-list-post-relates', [PostController::class, 'getListPostRelate'])->name('post.get-list-post-relate');

// Infor cretor
// Route::get('/get-infor-user/{id}', [CreatorController::class, 'getInfor'])->name('cretor.get-infor');

// List user popular
Route::get('/get-list-account-popular/{id?}', [CreatorController::class, 'getListPopular'])->name('cretor.get-list-popular');

// Search post header
Route::get('/search-header', [PostController::class, 'searchHeader'])->name('search-header');

// List Hagtag
Route::get('/list-hagtag', [HagTagController::class, 'getAllHagTag'])->name('list-hagtag');

// Page
Route::get('/get-term-of-use', [TermOfUseController::class, 'index'])->name('get-term-of-use');
Route::get('/get-private-policy', [PrivatePolicyController::class, 'index'])->name('get-private-policy');
Route::get('/get-about-us', [AboutUsController::class, 'index'])->name('get-about-us');
Route::post('/send-contact', [AboutUsController::class, 'send'])->name('send-contact');
Route::get('/get-all-advertist', [AdvertistController::class, 'getAll'])->name('advertists.get-all');

