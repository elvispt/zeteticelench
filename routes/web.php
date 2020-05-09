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

use App\Http\Controllers\Api\HackerNewsController as HackerNewsApiController;
use App\Http\Controllers\Api\InspireController;
use App\Http\Controllers\Api\NextHolidaysController;
use App\Http\Controllers\Api\NotesController as NotesApiController;
use App\Http\Controllers\Api\RemoteJobsController;
use App\Http\Controllers\Api\SystemInfoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HackerNewsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(static function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('home');

    Route::get('/notes', [NotesController::class, 'index'])
        ->name('notes');

    Route::get('/hn', [HackerNewsController::class, 'index'])
         ->name('hackernews');
});

Route::namespace('Users')
    ->prefix('users')
    ->middleware('auth')
    ->group(static function () {
        Route::get('', [UsersController::class, 'index'])
            ->name('users-list');

        Route::get('edit/{id}', [UsersController::class, 'edit'])
            ->name('users-edit');

        Route::put('update', [UsersController::class, 'update'])
            ->name('users-update');

        Route::get('create', [UsersController::class, 'create'])
            ->name('users-create');

        Route::post('create', [UsersController::class, 'add'])
            ->name('users-add');

        Route::delete('destroy', [UsersController::class, 'destroy'])
            ->name('users-destroy');
    });

Auth::routes(['register' => false]);

Route::namespace('Api')
    ->prefix('api')
    ->middleware('auth')
    ->group(static function () {
        // dashboard
        Route::get('inspire', [InspireController::class, 'index'])
            ->name('apiInspire');
        Route::get('system-info', [SystemInfoController::class, 'index'])
            ->name('apiSystemInfo');
        Route::get('next-holidays', [NextHolidaysController::class, 'index'])
            ->name('apiNextHolidays');
        Route::get('remote-jobs', [RemoteJobsController::class, 'index'])
            ->name('apiRemoteJobs');

        // notes
        Route::get('notes', [NotesApiController::class, 'index'])
            ->name('apiNotesList');
        Route::get('notes/tags', [NotesApiController::class, 'tags'])
            ->name('apiNotesTagsList');
        Route::get('notes/{noteId}', [NotesApiController::class, 'show'])
            ->name('apiNote');
        Route::post('notecreate', [NotesApiController::class, 'add'])
            ->name('apiNoteAdd');
        Route::put('noteupdate/{noteId}', [NotesApiController::class, 'update'])
            ->name('apiNoteUpdate');
        Route::delete('notedestroy/{noteId}', [NotesApiController::class, 'destroy'])
            ->name('apiNoteDestroy');
        Route::post('notetagcreate', [NotesApiController::class, 'tagAdd'])
            ->name('apiNotesTagAdd');

        // hn bookmarks
        Route::get('bookmarks', [HackerNewsApiController::class, 'bookmarks'])
            ->name('hackernews-bookmark-list');
        Route::post('bookmarks', [HackerNewsApiController::class, 'bookmarkAdd'])
            ->name('hackernews-bookmark-add');
        Route::delete('bookmarks',[HackerNewsApiController::class, 'bookmarkDestroy'])
            ->name('hackernews-bookmark-destroy');
    });
