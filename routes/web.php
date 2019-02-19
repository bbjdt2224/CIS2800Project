<?php


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/employee/home', 'UserController@employeeHome')->name('employeeHome');