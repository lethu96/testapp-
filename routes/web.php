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
Route::post('member/create', 'MemberController@store');
Route::get('member/edit/{id}','MemberController@edit');
Route::post('member/edit-item/{id}', 'MemberController@update');
Route::delete('member/destroy/{id}','MemberController@destroy');
Route::get('member/show/position/{id}','MemberController@showPosition');

Route::resource('project','ProjectController');
Route::get('project', 'ProjectController@index');
Route::get('project/edit/{id}','ProjectController@edit');
Route::post('edit-item/{id}', 'ProjectController@update');
Route::delete('project/destroy/{id}', 'ProjectController@destroy');
Route::post('project/create','ProjectController@store');
Route::get('positions','PositionController@index');
Route::post('member_projects/create', 'MemberProjectController@store');

Route::get('/memberproject/project/{id}','MemberProjectController@show');
Route::get('/memberproject/projectrole/{id}','MemberProjectController@showRole');

Route::get('member_projects', 'MemberProjectController@index');
Route::put('member_projects/update', 'MemberProjectController@update');
Route::post('member_projects/create', 'MemberProjectController@store');
Route::delete('member_projects/destroy', [
  'as'=> 'member_projects',
  'uses'=> 'MemberProjectController@destroy',
 ]);
Route::get('members', 'MemberController@index');

Route::delete('members/destroy', [
  'as'=> 'members',
  'uses'=> 'MemberController@destroy',
 ]);

