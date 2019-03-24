<?php


Route::get('/', function () {
    return redirect('login');
})->name('welcome');

Route::get('/login', 'AuthenticationController@login')->name('login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/changePassword/{token}', 'AuthenticationController@changePassword');

Route::post('/updatePassword', 'AuthenticationController@updatePassword')->name('updatePassword');

Route::get('/employee/home', 'UserController@employeeHome')->name('employeeHome');

Route::post('/employee/new-shift', 'UserController@createShift')->name('newShift');

Route::post('/employee/edit-shift', 'UserController@editShift')->name('editShift');

Route::post('/employee/delete-shift', 'UserController@deleteShift')->name('deleteShift');

Route::post('/employee/sign', 'UserController@sign')->name('sign');

Route::post('/employee/submit', 'UserController@submitTimesheet')->name('submitTimesheet');

Route::post('/employee/past-timesheet', 'UserController@pastTimesheet')->name('pastTimesheet');

Route::get('admin/home', 'AdminController@adminHome')->name('adminHome');

Route::get('admin/timesheet/{timesheetId}', 'AdminController@viewTimesheet')->name('viewTimesheet');

Route::post('admin/timesheet/approve', 'AdminController@approveTimesheet')->name('approveTimesheet');

Route::post('admin/timesheet/reject', 'AdminController@rejectTimesheet')->name('rejectTimesheet');

Route::get('admin/employees', 'AdminController@employees')->name('employees');

Route::post('admin/editEmployee', 'AdminController@edit')->name('employeeEdit');

Route::post('admin/archiveEmployee', 'AdminController@archiveEmployee')->name('archiveEmployee');

Route::post('admin/unarchiveEmployee', 'AdminController@unarchiveEmployee')->name('unarchiveEmployee');

Route::post('admin/createEmployee', 'AdminController@createEmployee')->name('createEmployee');

Route::post('admin/getHeaders', 'AdminController@getHeaders')->name('getHeaders');

Route::post('admin/removeHeader', 'AdminController@removeHeader')->name('removeHeader');

Route::get('admin/archivedTimesheets', 'AdminController@viewArchivedTimesheets')->name('archivedTimesheets');

Route::get('admin/archivedEmployees', 'AdminController@viewArchivedEmployees')->name('archivedEmployees');

Route::get('superadmin/home', 'SuperAdminController@home')->name('superadminHome');

Route::post('superadmin/createOrganization', 'SuperAdminController@createOrganization')->name('createOrganization');

Route::post('superadmin/editOrganization', 'SuperAdminController@editOrganization')->name('editOrganization');

Route::post('superadmin/archiveOrganization', 'SuperAdminController@archiveOrganization')->name('archiveOrganization');

Route::get('superadmin/allUsers', 'SuperAdminController@allUsers')->name('allUsers');

Route::post('superadmin/searchUsers', 'SuperAdminController@searchUsers')->name('searchUsers');

Route::post('superadmin/editUser', 'SuperAdminController@editUser')->name('editUser');


