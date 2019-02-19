<?php


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/employee/home', 'UserController@employeeHome')->name('employeeHome');

Route::get('/login', 'AuthenticationController@login')->name('login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
