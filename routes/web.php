<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/usertimesheet', 'HomeController@index')->name('usertimesheet');

Route::post('/usertimesheet', 'HomeController@store')->name('usertimesheet');

Route::get('/home/{date}', 'HomeController@getWeek')->name('date');

Route::get('/home', 'HomeController@select')->name('home');

Route::get('/new', 'HomeController@new')->name('new');

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/change/{id}', 'AdminController@hours')->name('change');

Route::post('/admin', 'AdminController@change')->name('admin');

Route::get('/timesheet/{id}/{date}', 'AdminController@viewUser')->name('timesheet');

Route::get('/remove/{id}', 'AdminController@remove')->name('remove');

Route::get('/records', function(){
	return view('admin.search');
})->name('records');

Route::post('/search', 'AdminController@getRecords')->name('search');

Route::get('/prevusers', 'AdminController@getPastUsers')->name('prevusers');

Route::get('/restore/{id}', 'AdminController@restorePast')->name('revive');

Route::post('/signature', 'HomeController@saveSignature')->name('signature');

Route::get('/allowEdit/{id}/{date}', 'AdminController@allowEdit')->name('allowEdit');

Route::get('/editEmployees', 'AdminController@allEmployees')->name('edit');

Route::post('/updateEmployees', 'AdminController@update')->name('update');

Route::post('/group', 'AdminController@group')->name('group');

Route::get('/email', 'AdminController@email')->name('email');

Route::post('/sendEmail', 'AdminController@sendEmail')->name('sendemail');

Route::post('/changeclasses', 'SurveyController@changeclasses')->name('changeclasses');

Route::get('/survey', 'SurveyController@index')->name('survey');

Route::post('/submitsurvey', 'SurveyController@submit')->name('submitsurvey');

Route::get('/insertClass', 'ClassesController@insertClass')->name('insertClass');

Route::post('/addClass', 'ClassesController@add')->name('addClass');

Route::get('/edit', 'ClassesController@editClasses')->name('editClass');

Route::post('/editClasses', 'ClassesController@edit')->name('editClasses');

Route::get('/deleteClass/{id}', 'ClassesController@delete')->name('delete');