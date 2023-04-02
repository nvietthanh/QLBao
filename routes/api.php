<?php

// use App\Http\Controllers\Api\BackEnd\CategoryController;

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
Route::get('/category/get-all/{category}', [PostController::class, 'getListPostCategory'])->name('category.list-post');
// Route::get('/get-post/{slugPost}', [PostController::class, 'getPost'])->name('post.get-post');
Route::get('/get-list-post-creator/id={id}', [PostController::class, 'getListPostCreator'])->name('post.get-list-post-creator');

// Infor cretor
// Route::get('/get-infor-user/{id}', [CreatorController::class, 'getInfor'])->name('cretor.get-infor');

// List user popular
Route::get('/get-list-user-popular/{id?}', [CreatorController::class, 'getListPopular'])->name('cretor.get-list-popular');

// Search post header
Route::get('/search-header', [PostController::class, 'searchHeader'])->name('search-header');
