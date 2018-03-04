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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::resource('member', 'MemberController');
Route::get('member', 'MemberController@index');
Route::post('member', 'MemberController@store');
Route::get('member/{id}', 'MemberController@show');
Route::put('member/{id}', 'MemberController@update');
Route::delete('member/{id}','MemberController@destroy');
Route::get('member/show/position/{id}','MemberController@showPosition');

Route::resource('project','ProjectController');
Route::get('project', 'ProjectController@index');
Route::get('project/{id}','ProjectController@show');
Route::put('project/{id}', 'ProjectController@update');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::post('project','ProjectController@store');
Route::get('positions','PositionController@index');
Route::post('member_projects/', 'MemberProjectController@store');

Route::get('/memberproject/project/{id}','MemberProjectController@show');
Route::get('/memberproject/projectrole/{id}','MemberProjectController@showRole');

Route::get('member_projects', 'MemberProjectController@index');
Route::put('member_projects/{id}', 'MemberProjectController@update');
Route::delete('member_projects/{id}', 'MemberProjectController@destroy');

Route::get('/display-item','MemberController@showindex');
Route::get('/display-item-member','MemberController@showindex');
Route::get('/show-item-member/{id}','MemberController@showindex');
Route::get('/edit-item-member/{id}','MemberController@showindex');
Route::get('/add-item','MemberController@showindex');
Route::get('/edit-item/{id}','MemberController@showindex');
Route::get('/show-detail-item/{id}','MemberController@showindex');
Route::get('/add-member-project/{id}','MemberController@showindex');
Route::get('/add-item-member','MemberController@showindex');
