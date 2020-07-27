<?php

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

Route::post('login', 'Api\Controllers\Auth\AuthController@login'); //params - login password
Route::post('register', 'Api\Controllers\Auth\AuthController@register'); //params - login email password password_confirmation

Route::get('blog', 'Api\Controllers\BlogController@getPosts'); //without params
Route::get('blog/post/{postName}', 'Api\Controllers\BlogController@getPostByTitle'); //param in url - навзавание статьи из колонки title табл posts

Route::get('users', 'Api\Controllers\UserController@getUsers'); //without params
Route::get('users/blog/{name}', 'Api\Controllers\UserController@getUserByName'); //param in url - имя автора из колонки name табл users

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::prefix('blog')->group(function () {
        Route::post('/create', 'Api\Controllers\BlogController@createPost'); //params - title post(текст поста)
        Route::delete('/delete', 'Api\Controllers\BlogController@deletePost'); //params - name post_id
        Route::put('/update', 'Api\Controllers\BlogController@updatePost'); //params - (name post_id - general), (title post - additional)
    });

    Route::prefix('users')->group(function () {
        Route::post('/create', 'Api\Controllers\UserController@createUser'); //params - (login password email - general), (about, role - additional)
        Route::delete('/delete', 'Api\Controllers\UserController@deleteUser'); //params - имя пользователя из колонки name табл users
        Route::put('/update', 'Api\Controllers\UserController@updateUser'); //params (name - general) (password email about role - additional)
    });
});
