<?php

use App\Http\Controllers\Api\BackEnd\Admin\CategoryController;
use App\Http\Controllers\Api\BackEnd\Admin\PostController as AdminPostController;
use App\Http\Controllers\Api\BackEnd\Admin\UserController;
use App\Http\Controllers\Api\BackEnd\CommentController;
use App\Http\Controllers\Api\BackEnd\Creator\PostController;
use App\Http\Controllers\Api\BackEnd\FollowController;
use App\Http\Controllers\Api\BackEnd\HomeController;
use App\Http\Controllers\Api\BackEnd\ProfileController;
use App\Http\Controllers\Api\FrontEnd\CreatorController;
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


Route::middleware(['auth:accounts', 'is_creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::post('/posts/{id}', [PostController::class, 'update'])
        ->name('posts.update');
});



// Get comment
Route::get('/get-comments', [CommentController::class, 'getComments'])->name('get-comments');
Route::get('/get-post/{slugPost}', [HomeController::class, 'getPost'])->name('post.get-post');

// Infor cretor
Route::get('/get-infor-user/{id}', [CreatorController::class, 'getInfor'])->name('cretor.get-infor');

Route::middleware(['auth:accounts'])->prefix('user')->group(function () {
    Route::apiResource('profiles', ProfileController::class);
    Route::post('/profiles/{id}', [ProfileController::class, 'update'])->name('profiles.update');

    // user create comment
    Route::post('/comment/{id}', [CommentController::class, 'createComment'])->name('create-comment');

    // like comment
    Route::get('/like-comments/{id}', [CommentController::class, 'likeComment'])->name('like-comment');
    Route::get('/unlike-comments/{id}', [CommentController::class, 'unlikeComment'])->name('unlike-comment');

    // list follow
    Route::get('/list-follows', [FollowController::class, 'listFollow'])->name('list-follows');

    // follow account
    Route::get('/follow-account/{code}', [FollowController::class, 'follow'])->name('follow-account');
    Route::get('/unfollow-account/{code}', [FollowController::class, 'unfollow'])->name('unfollow-account');

    // list read post
    Route::get('/list-read-post', [HomeController::class, 'getListRead'])->name('get-list-read');

    // list save post
    Route::get('/list-save-post', [HomeController::class, 'getListSave'])->name('get-list-save');

    // save post
    Route::get('/save-post/{id}', [HomeController::class, 'savePost'])->name('save-post');
    Route::get('/unsave-post/{id}', [HomeController::class, 'unsavePost'])->name('unsave-post');
    Route::get('/unsave-all-post', [HomeController::class, 'unsaveAllPost'])->name('unsave-all-post');
});


// admin
Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::get('/change-status-user', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::post('/delete-selected-account', [UserController::class, 'deleteAccounts'])->name('users.delete-accounts');

    Route::apiResource('categories', CategoryController::class);
    Route::get('/change-status-category', [CategoryController::class, 'changeStatus'])->name('categories.change-status');

    Route::apiResource('/posts', AdminPostController::class);
});