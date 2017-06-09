<?php

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/alerts', 'AlertsController', ['only' => ['index', 'store', 'destroy']]);
    Route::resource('/notifications', 'NotificationsController', ['only' => ['index']]);
    Route::resource('/settings', 'SettingsController', ['only' => ['index', 'store']]);
    Route::resource('/thresholds', 'ThresholdsController', ['only' => ['index', 'store', 'destroy']]);

    Route::group(['prefix' => '/api'], function() {
        Route::group(['prefix' => '/charts'], function() {
            Route::resource('eth', 'EtherController', ['only' => 'index']);
        });
        Route::get('/notifications', 'NotificationsController@all');
    });

    Route::group(['middleware' => 'developer'], function() {
        Route::resource('users', 'UsersController', ['only' => ['index', 'store', 'destroy']]);
    });
});

// Disable registration
Route::any('/register', function() {
    return redirect('/home');
});
