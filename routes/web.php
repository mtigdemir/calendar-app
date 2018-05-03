<?php

Route::get('/', function () {
    return redirect()->to('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('events', 'EventController')->except('show');
