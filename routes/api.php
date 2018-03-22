<?php

use Illuminate\Http\Request;

Route::post('/auth/register', 'API\RegisterController@register'); // OK
Route::post('auth/login', 'API\AuthController@login');
Route::post('auth/refresh', 'API\AuthController@refresh');
Route::get('auth/logout', 'API\AuthController@logout');


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('products', 'ProductController');

    Route::resource('categories', 'CategoryController');
});
