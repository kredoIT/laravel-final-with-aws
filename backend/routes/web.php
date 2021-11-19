<?php

use Illuminate\Support\Facades\Route;
/**
 *  Admin Controllers Group
 * 
 **/
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/**
 *  User Controllers Group
 * 
 **/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'can:admin'], function () {

    Route::get('/', [UsersController::class, 'index'])->name('admin.index');

    /** [Users] **/
    Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('admin.users.activate');
    Route::patch('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('admin.users.deactivate');

    /** [Posts] **/
    Route::get('/posts', [PostsController::class, 'index'])->name('admin.posts.index');
    Route::patch('/posts/{id}/activate', [PostsController::class, 'activate'])->name('admin.posts.activate');
    Route::patch('/posts/{id}/deactivate', [PostsController::class, 'deactivate'])->name('admin.posts.deactivate');

    /** [Categories] **/
    Route::get('/categories', [CategoriesController::class, 'index'])->name('admin.categories.index');
	Route::post('/categories/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
	Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('admin.categories.update');
	Route::delete('/categories/{id}/destroy', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'index'])->name('index');

	/** [Post] **/
	Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
	Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

	Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
	Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');

	Route::delete('/post/{id}/delete', [PostController::class, 'delete'])->name('post.delete');

	Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');

	/** [Profile] **/
	Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
	Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');

	/** [Follow] **/
	Route::post('/follow/{id}/store', [FollowController::class, 'store'])->name('follow.store');
	Route::delete('/follow/{id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

	/** [Like] **/
	Route::post('/like/{id}/store', [LikeController::class, 'store'])->name('like.store');
	Route::delete('/like/{id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

	/** [Comment] **/
	Route::post('/comment/{id}/store', [CommentController::class, 'store'])->name('comment.store');
});
