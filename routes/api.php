<?php

use App\Http\Controllers\Api\HackerNewsController;
use App\Http\Controllers\Api\InspireController;
use App\Http\Controllers\Api\NextHolidaysController;
use App\Http\Controllers\Api\NotesController;
use App\Http\Controllers\Api\SystemInfoController;
use App\Http\Controllers\Api\UsersController;
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

Route::middleware('auth:sanctum')
    ->group(static function () {
        // dashboard
        Route::get('inspire', [InspireController::class, 'index'])
            ->name('apiInspire');
        Route::get('system-info', [SystemInfoController::class, 'index'])
            ->name('apiSystemInfo');
        Route::get('next-holidays', [NextHolidaysController::class, 'index'])
            ->name('apiNextHolidays');

        // notes
        Route::get('notes', [NotesController::class, 'index'])
            ->name('apiNotesList');
        Route::get('notes/tags', [NotesController::class, 'tags'])
            ->name('apiNotesTagsList');
        Route::get('notes/{noteId}', [NotesController::class, 'show'])
            ->name('apiNote');
        Route::post('notecreate', [NotesController::class, 'add'])
            ->name('apiNoteAdd');
        Route::put('noteupdate/{noteId}', [NotesController::class, 'update'])
            ->name('apiNoteUpdate');
        Route::delete('notedestroy/{noteId}', [NotesController::class, 'destroy'])
            ->name('apiNoteDestroy');
        Route::post('notetagcreate', [NotesController::class, 'tagAdd'])
            ->name('apiNotesTagAdd');

        // hn bookmarks
        Route::get('bookmarks', [HackerNewsController::class, 'bookmarks'])
            ->name('hackernews-bookmark-list');
        Route::post('bookmarks', [HackerNewsController::class, 'bookmarkAdd'])
            ->name('hackernews-bookmark-add');
        Route::delete('bookmarks',[HackerNewsController::class, 'bookmarkDestroy'])
            ->name('hackernews-bookmark-destroy');

        Route::get('users', [UsersController::class, 'index'])
            ->name('users');
        Route::put('users/update', [UsersController::class, 'update'])
            ->name('usersUpdate');
        Route::delete('users/destroy', [UsersController::class, 'destroy'])
            ->name('usersDestroy');
    });
