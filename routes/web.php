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

use App\Http\Controllers\Api\InspireController;
use App\Http\Controllers\Api\SystemInfoController;
use App\Http\Controllers\HackerNews\HackerNewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Notes\NotesController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::namespace('Notes')
    ->prefix('notes')
    ->middleware('auth')
    ->group(static function () {
        Route::get('', [NotesController::class, 'index'])
            ->name('notes');

        Route::get('/create', [NotesController::class, 'create'])
            ->name('notesCreate');

        Route::post('/create', [NotesController::class, 'add'])
            ->name('notesAdd');

        Route::get('/tags', [NotesController::class, 'tags'])
            ->name('notesTags');

        Route::get('/tags/create', [NotesController::class, 'tagCreate'])
            ->name('notesTagsCreate');

        Route::post('/tags/create', [NotesController::class, 'tagAdd'])
            ->name('notesTagsAdd');

        Route::get('/tags/{tagId?}', [NotesController::class, 'tags'])
            ->name('notesTags');

        Route::get('/{noteId}', [NotesController::class, 'show'])
            ->name('notesShow');

        Route::get('/edit/{noteId}', [NotesController::class, 'edit'])
            ->name('notesEdit');

        Route::put('/{noteId}', [NotesController::class, 'update'])
            ->name('notesUpdate');

        Route::delete('/{noteId}', [NotesController::class, 'destroy'])
            ->name('notesDestroy');
    });

Route::namespace('HackerNews')
    ->prefix('hackernews')
    ->middleware('auth')
    ->group(static function () {
        Route::get('top', [HackerNewsController::class, 'top'])
            ->name('hackernews-top');

        Route::get('best', [HackerNewsController::class, 'best'])
            ->name('hackernews-best');

        Route::get('new', [HackerNewsController::class, 'newStories'])
            ->name('hackernews-new');

        Route::get('jobs', [HackerNewsController::class, 'jobs'])
            ->name('hackernews-jobs');

        Route::get('bookmarks', [HackerNewsController::class, 'bookmarkList'])
            ->name('hackernews-bookmark-list');

        Route::post('bookmarks', [HackerNewsController::class, 'bookmarkAdd'])
            ->name('hackernews-bookmark-add');

        Route::post(
            'bookmarks/manual',
            [HackerNewsController::class, 'bookmarkManualAdd']
        )
            ->name('hackernews-bookmark-manual-add');

        Route::delete(
            'bookmarks',
            [HackerNewsController::class, 'bookmarkDestroy']
        )
            ->name('hackernews-bookmark-destroy');

        Route::get('item/{id}', [HackerNewsController::class, 'item'])
            ->name('hackernews-item');

        Route::post(
            'item/{id}/comments/collapse',
            [HackerNewsController::class, 'itemCommentCollapse']
        )
            ->name('hackernews-item-comments-collapse');

        Route::delete(
            'item/{id}/comments/collapse',
            [HackerNewsController::class, 'itemCommentRemoveCollapse']
        )
            ->name('hackernews-item-comments-remove-collapse');
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

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

// move to api namespace
Route::get('/api/inspire', [InspireController::class, 'index']);
Route::get('/api/system-info', [SystemInfoController::class, 'index']);
