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

Route::get('/', function () {
   //var_dump(Post::all()); exit();
   return view('welcome');
});

Route::get('/welcome', ['middleware' => ['older:100,100'], function () {
   return view('welcome');
}]);

Route::get('/tasks', function () {
   return view('tasks');
})->middleware('auth');

Route::get('user/{id}', ['uses' => 'UserController@showProfile', 'as' => 'userProfile']);
Route::get('user/password/{id}', ['middleware' => 'auth', 'uses' => 'UserController@showPassword']);
Route::get('register', ['uses' => 'UserController@registerUser']);
Route::resource('user_api', 'UserApiController', [
    'names' => ['index' => '…\(o_o)/\(ob_ov)/\(o_o)/…'],
    'except' => ['create', 'edit', 'destroy'],
    'only' => ['show', 'index', 'update', 'store']
]);
//Route::get('user/{id}', ['uses' => 'UserController@showProfile', 'as' => 'userProfile']);
//Route::get('user/password/{id}', ['middleware' => 'auth', 'uses' => 'UserController@showPassword']);

//Route::resource('test','TestController');

Route::controller('test', 'TestController', [
        'getSite'=>'testssss'
]);

Route::auth();

Route::get('/home', 'HomeController@index');
