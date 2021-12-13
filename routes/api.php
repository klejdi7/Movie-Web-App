<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

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

Route::middleware('api')->group(function () {
    Route::resource('posts', PostsController::class);
    Route::post('/checkLiked', [PostsController::class, 'checkLike']);
    Route::post('/likeItem', [PostsController::class, 'likeItem']);
    Route::post('/hateItem', [PostsController::class, 'hateItem']);
    Route::post('/sortMovies', [PostsController::class, 'sortItems']);
    Route::get('/userPost/{id}', [PostsController::class, 'userPost']);
    Route::post('/retractVote', [PostsController::class, 'retractVote']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);

    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
