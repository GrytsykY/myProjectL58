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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'digging_deeper',], function (){
    Route::get('collections','DiggingDeeperController@collections')
        ->name('digging_deeper.collections');
});

$groupData = [
    'namespace' => 'Blog\Admin',
    'prefix'    => 'admin/blog',
];
Route::group($groupData,function (){
    $methods = ['index','edit','update','create','store'];
    Route::resource('categories','CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    Route::resource('posts','PostController')
        ->except(['show'])
        ->names('blog.admin.posts');
});