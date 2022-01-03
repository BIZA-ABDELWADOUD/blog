<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;

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




Route::prefix('app')->middleware([AdminCheck::class])->group(function(){
    Route::get('/get_tags','TagController@index');
    Route::post('/create_tag','TagController@store');
    Route::post('/edit_tag','TagController@update');
    Route::post('/delete_tag','TagController@destroy');
    
    Route::post('/create_user','UserController@store');
    Route::post('/user_login','UserController@LoginMethod');
    Route::post('/edit_user','UserController@update');
    Route::get('/get_users','UserController@index');
    Route::post('/delete_user','UserController@destroy');

    Route::get('/get_roles','RoleController@index');
    Route::post('/create_role','RoleController@store');
    Route::post('/edit_role','RoleController@update');
    Route::post('/delete_role','RoleController@destroy');


    Route::post('/assign_roles','RoleController@assignroles');

    
    Route::post('/upload','CategoryController@upload');
    Route::post('/upload/edit','CategoryController@uploadedit');
    Route::post('/delete_icon','CategoryController@deleIconfromserver');
    Route::post('/create_category','CategoryController@store');
    Route::get('/get_categories','CategoryController@index');
    Route::post('/edit_category','CategoryController@update');
    Route::post('/delete_category','CategoryController@destroy');
});


Route::post('blogs','BlogController@uploadEditorImage');

Route::get('/login', function () {
    return view('login');
})->middleware('guest:web')->name('login');



Route::get('/logout','UserController@logout');


Route::get('/','HomeController@index')->middleware('auth')->name('home');

Route::get('{slug}','HomeController@index')->middleware('auth')->name('home')->where('slug', '([A-z\d-\/_.]+)?');
// Route::any('{slug}',function(){
//     return view('welcome');
// });
