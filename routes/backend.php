<?php

use App\Http\Controllers\Api\BackEnd\Admin\AccountController;
use App\Http\Controllers\Api\BackEnd\Admin\CategoryController;
use App\Http\Controllers\Api\BackEnd\Admin\HagtagController;
use App\Http\Controllers\Api\BackEnd\Admin\PostController as AdminPostController;
use App\Http\Controllers\Api\BackEnd\Admin\ReportAccountController;
use App\Http\Controllers\Api\BackEnd\Admin\ReportPostController;
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


Route::middleware(['is_approved', 'auth:accounts', 'is_creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::post('/posts/{id}', [PostController::class, 'update'])
        ->name('posts.update');
});



// Get comment
Route::middleware('is_approved')->get('/get-comments', [CommentController::class, 'getComments'])->name('get-comments');
Route::middleware('is_approved')->get('/get-post/{slugPost}', [HomeController::class, 'getPost'])->name('post.get-post');

// Infor creator
Route::get('/get-infor-user/{id}', [CreatorController::class, 'getInfor'])->name('cretor.get-infor');

Route::middleware([
    'is_approved',
    'auth:accounts'
])
->prefix('user')->group(function () {
    Route::apiResource('profiles', ProfileController::class);
    Route::post('/profiles/{id}', [ProfileController::class, 'update'])->name('profiles.update');

    // create comment
    Route::post('/comment/{id}', [CommentController::class, 'createComment'])->name('create-comment');
    Route::post('/comment-child/{id}', [CommentController::class, 'createCommentChild'])->name('create-comment-child');
    // like comment
    Route::get('/like-comments/{id}', [CommentController::class, 'likeComment'])->name('like-comment');
    Route::get('/unlike-comments/{id}', [CommentController::class, 'unlikeComment'])->name('unlike-comment');
    // delete comment
    Route::get('/delete-comment/{id}', [CommentController::class, 'deleteComment'])->name('delete-comment');
    // update comment
    Route::post('/update-comment/{id}', [CommentController::class, 'updateComment'])->name('update-comment');

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

    // report post
    Route::post('/report-post/{id}', [HomeController::class, 'reportPost'])->name('report-post');

});


// admin
Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
    Route::apiResource('accounts', AccountController::class);
    Route::post('/change-status-account/{id}', [AccountController::class, 'changeStatus'])->name('accounts.change-status');
    Route::get('/get-status-account/{id}', [AccountController::class, 'getStatus'])->name('accounts.get-status');
    Route::post('/delete-selected-accounts', [AccountController::class, 'deleteAccounts'])->name('accounts.delete-accounts');

    Route::apiResource('categories', CategoryController::class);
    Route::get('/change-status-category', [CategoryController::class, 'changeStatus'])->name('categories.change-status');

    Route::apiResource('/posts', AdminPostController::class);
    Route::post('/posts/{id}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::get('/change-approved-post/{id}', [AdminPostController::class, 'changeApproved'])->name('posts.change-approved');
    Route::get('/change-status-post/{id}', [AdminPostController::class, 'changestatus'])->name('posts.change-status');
    Route::post('/delete-select-posts', [AdminPostController::class, 'deletePosts'])->name('posts.delete-posts');

    Route::apiResource('/hagtags', HagtagController::class);
    Route::post('/hagtags/{id}', [HagtagController::class, 'update'])->name('hagtags.update');
    Route::post('/delete-select-hagtags', [HagtagController::class, 'deleteHagtags'])->name('hagtags.delete-hagtags');

    Route::get('/report-posts', [ReportPostController::class, 'index'])->name('report-posts.index');
    Route::get('/report-posts/{id}', [ReportPostController::class, 'showReport'])->name('report-posts.show-report');
    Route::post('/delete-report-posts', [ReportPostController::class, 'deletePosts'])->name('report-posts.delete-posts');
    Route::get('/report-posts/show-post/{id}', [ReportPostController::class, 'showPost'])->name('report-posts.show-post');

    Route::get('/report-accounts', [ReportAccountController::class, 'index'])->name('report-accounts.index');
    Route::get('/report-accounts/{id}', [ReportAccountController::class, 'showReport'])->name('report-accounts.show-report');
    Route::post('/delete-report-accounts', [ReportAccountController::class, 'deleteAccounts'])->name('report-accounts.delete-accounts');
});