<?php


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/employee/home', 'UserController@employeeHome')->name('employeeHome');

Route::post('/employee/new-shift', 'UserController@createShift')->name('newShift');

Route::post('/employee/edit-shift', 'UserController@editShift')->name('editShift');

Route::post('/employee/past-timesheet', 'UserController@pastTimesheet')->name('pastTimesheet');

Route::get('admin/home', 'AdminController@adminHome')->name('adminHome');

Route::get('/login', 'AuthenticationController@login')->name('login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

