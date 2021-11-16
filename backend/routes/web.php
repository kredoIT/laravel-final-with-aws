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

Route::group([
        'as'			=> 'admin.',
        'prefix'		=> 'admin',
        'namespace'		=> 'Admin',
        'middleware'	=> 'can:admin'
    ], function () {


    Route::get('/', [UsersController::class, 'index'])->name('index');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
    	Route::get('/{id}/show', [UsersController::class, 'show'])->name('show');

    	Route::patch('/{id}/activate', [UsersController::class, 'activate'])->name('activate');
    	Route::patch('/{id}/deactivate', [UsersController::class, 'deactivate'])->name('deactivate');
    });

    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function() {
    	Route::get('/', [PostsController::class, 'index'])->name('index');

    	Route::patch('/{id}/activate', [PostsController::class, 'activate'])->name('activate');
    	Route::patch('/{id}/deactivate', [PostsController::class, 'deactivate'])->name('deactivate');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function() {
    	Route::get('/', [CategoriesController::class, 'index'])->name('index');

    	Route::post('/store', [CategoriesController::class, 'store'])->name('store');
    	Route::patch('/{id}/update', [CategoriesController::class, 'update'])->name('update');
    	Route::delete('/{id}/destroy', [CategoriesController::class, 'destroy'])->name('destroy');
    });
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'index'])->name('index');

	Route::group(['prefix' => 'post', 'as' => 'post.'], function() {

		Route::get('/create', [PostController::class, 'create'])->name('create');
		Route::post('/store', [PostController::class, 'store'])->name('store');

		Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
		Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');

		Route::delete('/{id}/delete', [PostController::class, 'delete'])->name('delete');

		Route::get('/{id}/show', [PostController::class, 'show'])->name('show');

	});

	Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
		Route::get('/{id}/show', [ProfileController::class, 'show'])->name('show');
		Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
		Route::patch('/{id}/update', [ProfileController::class, 'update'])->name('update');
	});

	Route::group(['prefix' => 'follow', 'as' => 'follow.'], function() {
		Route::post('/{id}/store', [FollowController::class, 'store'])->name('store');
		Route::delete('/{id}/destroy', [FollowController::class, 'destroy'])->name('destroy');
	});

	Route::group(['prefix' => 'like', 'as' => 'like.'], function() {
		Route::post('/{id}/store', [LikeController::class, 'store'])->name('store');
		Route::delete('/{id}/destroy', [LikeController::class, 'destroy'])->name('destroy');
	});

	Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
		Route::post('/{id}/store', [CommentController::class, 'store'])->name('store');
	});
});
