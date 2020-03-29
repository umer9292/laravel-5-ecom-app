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

Route::group(['as' => 'products.', 'prefix' => 'products'], function () {
    Route::get('/', [
        'as' => 'all',
        'uses' => 'ProductController@show'
    ]);
});

Route::group(['as' => 'category.', 'prefix' => 'category'], function () {
    Route::get('/category', [
        'as' => 'products',
        'uses' => 'ProductController@products'
    ]);
});

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin']], function ()
{
    //  Dashboard Home Route
    Route::get('/dashboard', [
        'as' => 'dashboard',
        'uses' => 'AdminController@dashboard'
    ]);

    //  Category Group Routes
    Route::group(['prefix' => 'category'], function () {
        Route::get('/{category}/remove', [
            'as' => 'category.remove',
            'uses' => 'CategoryController@remove'
        ]);

        Route::get('/trash', [
            'as' => 'category.trash',
            'uses' => 'CategoryController@trash'
        ]);

        Route::get('/recover/{id}', [
            'as' => 'category.recover',
            'uses' => 'CategoryController@recoverCategory'
        ]);
    });

    //  Product Group Routes
    Route::group(['prefix' => 'product'], function () {
        Route::get('/{product}/remove', [
            'as' => 'product.remove',
            'uses' => 'ProductController@remove'
        ]);

        Route::get('/trash', [
            'as' => 'product.trash',
            'uses' => 'ProductController@trash'
        ]);

        Route::get('/recover/{id}', [
            'as' => 'product.recover',
            'uses' => 'ProductController@recoverProduct'
        ]);

        Route::view(
            '/extras',
            'admin.partials.extras'
        )->name('product.extras');
    });

    //  Profile Group Routes
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/{profile}/remove', [
            'as' => 'profile.remove',
            'uses' => 'ProfileController@remove'
        ]);

        Route::get('/trash', [
            'as' => 'profile.trash',
            'uses' => 'ProfileController@trash'
        ]);

        Route::get('/recover/{id}', [
            'as' => 'profile.recover',
            'uses' => 'ProfileController@recoverProfile'
        ]);

        Route::get('/states/{id?}', [
            'as' => 'profile.states',
            'uses' => 'ProfileController@getStates'
        ]);

        Route::get('/cities/{id?}', [
            'as' => 'profile.cities',
            'uses' => 'ProfileController@getCities'
        ]);
    });

    //  Resources Routes
    Route::resource('product', 'ProductController');
    Route::resource('category', 'CategoryController');
    Route::resource('profile', 'ProfileController');
});
