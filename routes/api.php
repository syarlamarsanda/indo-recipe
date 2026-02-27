<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// -- PUBLIC --
// AUTH
Route::post('v1/register',[AuthController::class, 'register']);
Route::post('v1/login',[AuthController::class, 'login']);

//CATEGORY
Route::get('v1/categories',[CategoryController::class,'index']);
Route::get('login', function(){
    return response()->json(['message'=>'invalid token', 401]);
})->name('login');

//RECIPE
Route::get('v1/recipes',[RecipeController::class,'index']);
Route::get('v1/recipes/{slug}',[RecipeController::class,'show']);

//COMMENT
Route::get('v1/comment',[CommentController::class,'index']);

//RATING
Route::get('v1/rating',[RatingController::class,'index']);


// -- PRIVATE --
Route::middleware('auth:sanctum')->group(function() {
    //AUTH
    Route::post('v1/logout',[AuthController::class,'logout']);

    //CATEGORY
    Route::post('v1/categories',[CategoryController::class,'store']);
    Route::delete('v1/categories/{slug}',[CategoryController::class,'destroy']);

    //RECIPE
    Route::post('v1/recipes',[RecipeController::class,'store']);
    Route::delete('v1/recipes/{slug}',[RecipeController::class,'destroy']);

    //COMMENT
    Route::post('v1/comments',[CommentController::class,'store']);
    Route::delete('v1/comments/{id}',[CommentController::class,'destroy']);

    //RATING
    Route::post('v1/ratings',[RatingController::class,'store']);
    Route::delete('v1/ratings/{id}',[RatingController::class,'detroy']);
});
