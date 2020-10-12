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

Route::middleware('api')->group(function () {

    Route::prefix('events')->group(function() {
        //Events CRUD
        Route::get('list', 'App\Http\Controllers\EventsController@list');
        Route::post('save', 'App\Http\Controllers\EventsController@store');
        Route::get('view/{event_id}', 'App\Http\Controllers\EventsController@retrieve');
        Route::put('update/{event_id}', 'App\Http\Controllers\EventsController@update');
        Route::delete('delete/{event_id}', 'App\Http\Controllers\EventsController@delete');
        Route::post('bind/organizers/event/{event_id}', 'App\Http\Controllers\EventsController@bindOrganizers');
    });

    Route::prefix('organizers')->group(function() {
        //Users Organizers CRUD
        Route::get('list', 'App\Http\Controllers\OrganizersController@list');
        Route::post('save', 'App\Http\Controllers\OrganizersController@store');
        Route::get('view/{organizer_id}', 'App\Http\Controllers\OrganizersController@retrieve');
        Route::put('update/{organizer_id}', 'App\Http\Controllers\OrganizersController@update');
        Route::delete('delete/{organizer_id}', 'App\Http\Controllers\OrganizersController@delete');
    });
});
