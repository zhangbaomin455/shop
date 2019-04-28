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
// Route::prefix('/')->middleware('login')->group(function(){
//     route::any('index','Index\IndexController@index');
//     route::post('store','Index\IndexController@store');
//    route::any('show','Index\IndexController@show');
//    route::get('create/{user_id?}','Index\IndexController@create');
//    route::get('edit/{user_id?}','Index\IndexController@edit');
//    route::post('update{user_id?}','Index\IndexController@update');
//    route::post('indexdd','Index\IndexController@indexdd');
// });
Route::prefix('/')->group(function(){
    route::any('login','User\UserController@login');
    route::any('register','User\UserController@register');
    route::post('logindo','User\UserController@logindo');
    route::post('registerdo','User\UserController@registerdo');
});
Route::prefix('/')->middleware('login')->group(function(){
    route::any('news','News\NewsController@news');
    route::post('newsdd','News\NewsController@newsdd');
    route::post('newsdo','News\NewsController@newsdo');
    route::any('list','News\NewsController@list');
    route::post('newdel','News\NewsController@newdel');
    route::get('newedit/{news_id?}','News\NewsController@newedit');
    route::post('updatedd{news_id?}','News\NewsController@updatedd');
});
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
