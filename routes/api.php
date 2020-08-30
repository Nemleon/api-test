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

Route::post('login', 'Api\Controllers\AuthController@login'); //params - login password
Route::post('register', 'Api\Controllers\AuthController@registration'); //params - login password

Route::get('categories', 'Api\Controllers\CategoryController@getAllCategory'); //without params
Route::get('categories/items', 'Api\Controllers\ItemController@getItemsFromCategory'); //without params
Route::get('item', 'Api\Controllers\ItemController@getItem');

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::prefix('categories')->group(function () {
        Route::post('/create', 'Api\Controllers\CategoryController@createCategory'); //params - title post(текст поста)
        Route::delete('/delete', 'Api\Controllers\CategoryController@deleteCategory'); //params - name post_id
        Route::put('/update', 'Api\Controllers\CategoryController@updateCategory'); //params - (name post_id - general), (title post - additional)
    });

    Route::prefix('items')->group(function () {
        Route::put('/addcategory', 'Api\Controllers\CategoryController@addCategoryToItem');
        Route::post('/create', 'Api\Controllers\ItemController@createItem'); //params - (login password email - general), (about, role - additional)
        Route::delete('/delete', 'Api\Controllers\ItemController@deleteItem'); //params - имя пользователя из колонки name табл users
        Route::put('/update', 'Api\Controllers\ItemController@updateItem'); //params (name - general) (password email about role - additional)
    });
});
