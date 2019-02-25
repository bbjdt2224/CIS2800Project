<?php


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/employee/home', 'UserController@employeeHome')->name('employeeHome');

Route::post('/employee/new-shift', 'UserController@createShift')->name('newShift');

Route::post('/employee/edit-shift', 'UserController@editShift')->name('editShift');

Route::post('/employee/delete-shift', 'UserController@deleteShift')->name('deleteShift');

Route::post('/employee/sign', 'UserController@sign')->name('sign');

Route::post('/employee/submit', 'UserController@submitTimesheet')->name('submitTimesheet');

Route::post('/employee/past-timesheet', 'UserController@pastTimesheet')->name('pastTimesheet');

Route::get('admin/home', 'AdminController@adminHome')->name('adminHome');

Route::get('admin/timesheet/{userId}', 'AdminController@viewTimesheet')->name('viewTimesheet');

Route::get('/login', 'AuthenticationController@login')->name('login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

