<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users', 'UsersController@show');




Route::post('login', 'UsersController@UserLogIn');




Route::post('send', 'FileItemController@SendFile');

Route::get('show', 'FileItemController@show');



Route::post('inbox_by_status', 'FileItemController@inbox_by_status');

Route::post('inbox_list', 'FileItemController@inbox_list');


Route::post('item_audit_trail', 'FileItemController@item_audit_trail');


Route::post('add_viewer', 'FileItemController@add_viewer');



Route::post('reply_message', 'FileItemController@reply_message');



Route::post('decline_signature', 'FileItemController@decline_signature');


Route::post('delete_file', 'FileItemController@delete_file');


Route::post('pki_sign_file', 'FileItemController@pki_sign_file');


Route::post('signed', 'FileItemController@signed');


Route::post('e_sign_file', 'FileItemController@e_sign_file');


Route::post('lock_file', 'FileItemController@lock_file');
