<?php

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

Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

Route::group([
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'],
    'prefix' => 'admin'
], function () {
    //  Dashboard Home Route
    Route::get('/dashboard', [
        'as' => 'dashboard',
        'uses' => 'AdminController@dashboard'
    ]);

    //  Category Routes
    Route::get('category/{category}/remove', [
        'as' => 'category.remove',
        'uses' => 'CategoryController@remove'
    ]);

    Route::get('category/trash', [
        'as' => 'category.trash',
        'uses' => 'CategoryController@trash'
    ]);

    Route::get('category/recover/{id}', [
        'as' => 'category.recover',
        'uses' => 'CategoryController@recoverCategory'
    ]);

    //  Product Routes
    Route::get('product/{product}/remove', [
        'as' => 'product.remove',
        'uses' => 'ProductController@remove'
    ]);

    Route::get('product/trash', [
        'as' => 'product.trash',
        'uses' => 'ProductController@trash'
    ]);

    Route::get('product/recover/{id}', [
        'as' => 'product.recover',
        'uses' => 'ProductController@recoverProduct'
    ]);

    Route::view('product/extras', [
        'as' => 'product.extras',
        'uses' => 'admin.partials.extras'
    ]);

    //  Profile Routes
    Route::get('profile/{profile}/remove', [
        'as' => 'profile.remove',
        'uses' => 'ProfileController@remove'
    ]);

    Route::get('profile/trash', [
        'as' => 'profile.trash',
        'uses' => 'ProfileController@trash'
    ]);

    Route::get('profile/recover/{id}', [
        'as' => 'profile.recover',
        'uses' => 'ProfileController@recoverProfile'
    ]);

    Route::get('profile/states/{id?}', [
        'as' => 'profile.states',
        'uses' => 'ProfileController@getStates'
    ]);
    Route::get('profile/cities/{id?}', [
        'as' => 'profile.cities',
        'uses' => 'ProfileController@getCities'
    ]);

    //  Resources Routes
    Route::resource('product', 'ProductController');
    Route::resource('category', 'CategoryController');
    Route::resource('profile', 'ProfileController');
});
