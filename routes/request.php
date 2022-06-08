<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Request Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
        'middleware' => 'auth',
        'prefix' => 'requests',
        'controller' => RequestController::class
    ], function () {

    Route::get('/data', 'getData')->name('requests.data');
    Route::get('/counters', 'getCounters')->name('requests.counters');

    Route::get('/', 'index')->name('requests.index');
    Route::get('/{request_id}', 'show')->name('requests.show');
    Route::get('/create', 'create')->name('requests.create');
    Route::post('/store', 'store')->name('requests.store');
    Route::get('/edit/{request_id}', 'edit')->name('requests.edit');
    Route::put('/update/{request_id}', 'update')->name('requests.update');
    Route::delete('/delete/{request_id}', 'delete')->name('requests.delete');

});
