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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::namespace('Notes')
    ->prefix('notes')
    ->middleware('auth')
    ->group(function () {

        Route::get('/create', 'NotesController@create')
             ->name('notesCreate');

        Route::post('/create', 'NotesController@add')
             ->name('notesAdd');

        Route::get('/tags', 'NotesController@tags')
             ->name('notesTags');

        Route::get('/tags/{tagId?}', 'NotesController@tags')
             ->name('notesTags');

        Route::get('/{noteId?}', 'NotesController@index')
             ->name('notes');

        Route::put('/{noteId}', 'NotesController@update')
            ->name('notesUpdate');

        Route::delete('/{noteId}', 'NotesController@destroy')
             ->name('notesDestroy');
    });

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
