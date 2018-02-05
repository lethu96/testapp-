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
Route::get('/display-item','ProjectController@index');
Route::post('/add-item','ProjectController@store');
Route::get('/list', 'MemberController@listMember');
Route::get('/listdele/{id}', 'MemberController@deleteMember');
Route::post('/add', 'MemberController@editMember');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/listmp/{id}', 'MemberProjectController@deleteMemberProject');
Route::get('/edit/{id}', 'MemberProjectController@getEditMemberProject');
Route::post('/edit', 'Mem berProjectController@editMemberProject');
Route::get('/editm/{id}', 'MemberController@getEditMember');
Route::post('/editm', 'MemberController@editMember');
Route::get('/editproject/{id}', 'ProjectController@getEditProject');
Route::post('/editproject', 'ProjectController@editProject');
Route::get('listproject','ProjectController@index');
