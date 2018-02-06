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
Route::resource('project','ProjectController');
Route::get('project', 'ProjectController@index');
Route::get('project/edit/{id}','ProjectController@edit');
Route::put('edit-item/{id}', 'ProjectController@update');

Route::get('member_projects', 'MemberProjectController@index');
Route::put('member_projects/update', 'MemberProjectController@update');
Route::post('member_projects/create', 'MemberProjectController@store');
Route::delete('member_projects/destroy', [
  'as'=> 'member_projects',
  'uses'=> 'MemberProjectController@destroy',
 ]);
Route::get('members', 'MemberController@index');
Route::put('members/update', 'MemberController@update');
Route::post('members/create', 'MemberController@store');
Route::delete('members/destroy', [
  'as'=> 'members',
  'uses'=> 'MemberController@destroy',
 ]);


Route::post('project/create', 'ProjectController@store');
Route::delete('project/destroy', [
  'as'=> 'project',
  'uses'=> 'ProjectController@destroy',
 ]);

