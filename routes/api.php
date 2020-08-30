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

Route::post('login', 'Api\Controllers\AuthController@login');
Route::post('register', 'Api\Controllers\AuthController@registration');

Route::get('categories', 'Api\Controllers\CategoryController@getAllCategory');
Route::get('categories/items', 'Api\Controllers\ItemController@getItemsFromCategory');
Route::get('item', 'Api\Controllers\ItemController@getItem');

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::prefix('categories')->group(function () {
        Route::post('/create', 'Api\Controllers\CategoryController@createCategory');
        Route::delete('/delete', 'Api\Controllers\CategoryController@deleteCategory');
        Route::put('/update', 'Api\Controllers\CategoryController@updateCategory');
    });

    Route::prefix('items')->group(function () {
        Route::put('/addcategory', 'Api\Controllers\CategoryController@addCategoryToItem');
        Route::post('/create', 'Api\Controllers\ItemController@createItem');
        Route::delete('/delete', 'Api\Controllers\ItemController@deleteItem');
        Route::put('/update', 'Api\Controllers\ItemController@updateItem');
    });
});
