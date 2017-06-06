<?php

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/settings', 'SettingsController', ['only' => ['index', 'store']]);


// Disable registration
Route::any('/register', function() {
    return redirect('/home');
});
