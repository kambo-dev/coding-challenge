<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'middleware' => 'auth',
    'prefix' => 'users',
    'controller' => UserController::class
], function () {

    Route::get('/data', 'getData')->name('users.data');

    Route::get('/connections', 'getConnections')->name('users.connections');
    Route::put('/connections/attach', 'attachConnections')->name('users.connections_attach');
    Route::get('/suggestions', 'getSuggestions')->name('users.suggestions');

    Route::get('/', 'index')->name('users.index');
    Route::get('/{user_id}', 'show')->name('users.show');
    Route::get('/create', 'create')->name('users.create');
    Route::post('/store', 'store')->name('users.store');
    Route::get('/edit/{user_id}', 'edit')->name('users.edit');
    Route::put('/update/{user_id}', 'update')->name('users.update');
    Route::delete('/delete/{user_id}', 'delete')->name('users.delete');

});
