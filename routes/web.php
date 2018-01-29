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
Route::apiResources([
    'members' => 'MemberController'
]);
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
Route::get('project', 'ProjectController@index');
Route::put('project/update', 'ProjectController@update');
Route::post('project/create', 'ProjectController@store');
Route::delete('project/destroy', [
  'as'=> 'project',
  'uses'=> 'ProjectController@destroy',
 ]);
