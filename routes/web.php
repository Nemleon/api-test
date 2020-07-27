<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Web\IndexController@index')->name('mainPage');
Route::get('login', 'Web\Auth\AuthController@loginView')->name('apiLoginVi');
Route::get('register', 'Web\Auth\AuthController@registerView')->name('apiRegisterVi');
Route::post('auth/success', 'Web\Auth\AuthController@apiAuth')->name('apiAuth');
Route::post('auth/logout', 'Web\Auth\AuthController@apiLogout')->name('apiLogout');

Route::prefix('posts')->group(function () {
    Route::get('/', 'Web\BlogController@getAllPosts')->name('getAllPosts');
    Route::get('/{postName}', 'Web\BlogController@getCurrentPost')->name('getCurrentPost');
});

Route::prefix('users')->group(function () {
    Route::get('/', 'Web\UserController@getAllUsers')->name('getAllUsers');
    Route::get('/{userName}', 'Web\UserController@getCurrentUser')->name('getCurrentUser');
});
Route::group(['middleware' => ['auth.web.check']], function (){
    Route::prefix('myblog')->group(function () {
        Route::get('/', 'Web\BlogController@index')->name('myProfile');
        Route::get('/create_post', 'Web\BlogController@createPostView')->name('createMyPostView');
        Route::get('/update_post', 'Web\BlogController@updatePostView')->name('updateMyPostView');
        Route::get('/update_profile_info', 'Web\UserController@updateUserView')->name('updateMySelfView');
        Route::put('/update_profile_info/success', 'Web\UserController@actionWithUser')->name('updateMySelf');
        Route::delete('/delete_profile', 'Web\UserController@actionWithUser')->name('deleteMySelf');
        Route::put('/update_post/success', 'Web\BlogController@actionWithPost')->name('updateMyPost');
        Route::delete('/delete_post', 'Web\BlogController@actionWithPost')->name('deleteMyPost');
        Route::post('/create_post/success', 'Web\BlogController@actionWithPost')->name('createMyPost');
    });
});


