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

        Route::get('', 'NotesController@index')
             ->name('notes');

        Route::get('/create', 'NotesController@create')
             ->name('notesCreate');

        Route::post('/create', 'NotesController@add')
             ->name('notesAdd');

        Route::get('/tags', 'NotesController@tags')
             ->name('notesTags');

        Route::get('/tags/create', 'NotesController@tagCreate')
             ->name('notesTagsCreate');

        Route::post('/tags/create', 'NotesController@tagAdd')
             ->name('notesTagsAdd');

        Route::get('/tags/{tagId?}', 'NotesController@tags')
             ->name('notesTags');

        Route::get('/{noteId}', 'NotesController@edit')
             ->name('notesEdit');

        Route::put('/{noteId}', 'NotesController@update')
            ->name('notesUpdate');

        Route::delete('/{noteId}', 'NotesController@destroy')
             ->name('notesDestroy');
    });

Route::namespace('HackerNews')
     ->prefix('hackernews')
     ->middleware('auth')
     ->group(function () {

         Route::get('top', 'HackerNewsController@top')
              ->name('hackernews-top');

         Route::get('best', 'HackerNewsController@best')
              ->name('hackernews-best');

         Route::get('jobs', 'HackerNewsController@jobs')
              ->name('hackernews-jobs');

         Route::get('item/{id}', 'HackerNewsController@item')
              ->name('hackernews-item');

     });

Route::namespace('Users')
     ->prefix('users')
     ->middleware('auth')
     ->group(function () {

         Route::get('', 'UsersController@index')
              ->name('users-list');

         Route::get('edit/{id}', 'UsersController@edit')
              ->name('users-edit');

         Route::put('update', 'UsersController@update')
              ->name('users-update');

         Route::get('create', 'UsersController@create')
              ->name('users-create');

         Route::post('create', 'UsersController@add')
              ->name('users-add');

         Route::delete('destroy', 'UsersController@destroy')
             ->name('users-destroy');
     });

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
