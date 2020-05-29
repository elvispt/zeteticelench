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
