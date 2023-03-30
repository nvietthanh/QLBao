<?php

use App\Http\Controllers\Api\BackEnd\CommentController;
use App\Http\Controllers\Api\BackEnd\Creator\PostController;
use App\Http\Controllers\Api\BackEnd\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:accounts')->prefix('user')->group(function () {

    Route::apiResource('profiles', ProfileController::class);
    Route::post('/profiles/{id}', [ProfileController::class, 'update'])->name('profiles.update');

    // user create comment
    Route::post('/comment/{id}', [CommentController::class, 'createComment'])->name('create-comment');
});


Route::middleware(['auth:accounts', 'is_creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::post('/posts/{id}', [PostController::class, 'update'])
        ->name('posts.update');
});

// Get comment
Route::get('/get-comments', [CommentController::class, 'getComments'])->name('get-comments');

Route::middleware(['auth:accounts'])->prefix('user')->group(function () {
    // like comment
    Route::get('/like-comments/{id}', [CommentController::class, 'likeComment'])->name('like-comment');
    Route::get('/unlike-comments/{id}', [CommentController::class, 'unlikeComment'])->name('unlike-comment');
});