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

//if (Auth::guest()) {
//    return redirect()->route('login');
//}
//return redirect()->route('profile', ['name'=>'name']);

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('profile/{id}', 'UserController@profile')->name('profile');

Route::get('/home', 'HomeController@index');

Route::post('/profile', 'UserController@update_avatar');

Route::get('/profile', 'HomeController@index')->name('home');

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('edit', 'UserController@edit');

Route::patch('profile/{id}', 'UserController@update');

Route::get('/users', 'UserController@get_users')->name('users');

Route::get('/post', 'PostController@get_posts')->name('post');

Route::post('/createpost', 'PostController@create_post')->name('post.create');

Route::get('/deletepost/{id}', 'PostController@delete_post')->name('post.delete');

Route::post('/editpost', 'PostController@edit_post')->name('editpost');

Route::post('/likepost', 'PostController@like_post')->name('likepost');

// Last Task

Route::get('accept_auth_code/{extSocset}', 'AuthThroughExternal@acceptAuthCode');
Route::get('api/login', 'AuthThroughExternal@apiLogin');
Route::post('api/login', 'AuthThroughExternal@redirectBack');
Route::post('api/token', 'AuthThroughExternal@returnToken');
Route::get('api/profile/{id}', 'AuthThroughExternal@getProfile')->where('id', '[0-9]+');