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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/get/all/categories', 'CategoryController@getAllCategories');
    Route::get('/get/all/users', 'UserController@getAllUser');
    Route::get('/get/all/entity/count', 'CommonController@index');
    Route::get('/get/all/books', 'BookController@getAllBooks');
    Route::get('/get/all/reviews', 'ReviewController@getAllReiview');
    Route::get('/get/category/{id}/books', 'CategoryController@booksPerCategory');
    Route::get('/get/book/{id}/categories', 'BookController@categoriesPerBook');
    Route::get('/get/book/{id}', 'BookController@getSingleBook');
    

    Route::group(['prefix' => 'user'], function () {
        Route::post('register', 'UserController@register');
        Route::post('login', 'UserController@login')->name('login');
        Route::get('/verify/{token}','UserController@verifyUser');
        Route::post('/forgot/password', 'UserController@resetPassword');
        Route::post('/reset/password', 'UserController@submitNewPassword');




        Route::group(['middleware' => 'auth:users'], function () {
            Route::post('logout', 'UserController@logout');
            Route::get('profile', 'UserController@profile');
            Route::post('/submit/review', 'ReviewController@index');

        });
    });
    Route::group(['prefix' => 'admin'], function () {

        Route::group(['middleware' => ['auth:users', 'isAdmin']], function () {
            Route::post('/create/categories', 'CategoryController@createCategories');
            Route::post('/delete/category/{id}', 'CategoryController@deleteCategory');
            Route::post('/create/books', 'BookController@createBooks');
            Route::post('/delete/user/{id}', 'UserController@deleteUser');
            Route::post('/delete/book/{id}', 'BookController@deleteDelete');
            Route::post('/update/book/{id}', 'BookController@updateBooks');
        });
    });
});
