<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses' => 'BlogController@index',
    'as'   => 'blog'
]);

Route::get('/blog/{post}', [
    'uses' => 'BlogController@show',
    'as'   => 'blog.show'
]);

Route::get('/category/{category}', [
    'uses' => 'BlogController@category',
    'as'   => 'category'
]);

Route::auth();

Route::get('/myposts', [
    'uses' => 'PostController@index',
    'as'   => 'blog.posts'
]);

Route::get('/myposts/create', [
    'uses' => 'PostController@create',
    'as'   => 'blog.posts.create'
]);
Route::post('/myposts/create',[
    'uses' => 'PostController@save',
    'as'   => 'blog.posts.save'
]);
Route::get('/myposts/edit/{id}', [
    'uses' => 'PostController@edit',
    'as'   => 'blog.posts.edit'
]);
Route::patch('/myposts/edit/{id}', [
    'uses' => 'PostController@update',
    'as'   => 'blog.posts.update'
]);
Route::delete('/myposts/{id}', [
    'uses' => 'PostController@delete',
    'as'   => 'blog.posts.delete'
]);
Route::get('/myposts/publish/{id}', [
    'uses' => 'PostController@publish',
    'as'   => 'blog.posts.publish'
]);

