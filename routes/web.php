<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
});*/

Auth::routes();
Route::get('/', function () {
    return redirect()->intended('home');
});


Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', 'HomeController@index')->name('home');
	Route::post('/storeofficedata', 'OfficeSessionController@storeSessionData');
	Route::post('/getcardriverdata', 'OfficeSessionController@getCarDriverData')->name('getcardriverdata');

	Route::resource('dispatcher','DispatcherController');
	Route::resource('jobautoqueue','JobAutoQueueController');

	Route::post('/voucher', 'DispatcherController@voucher')->name('voucher');
	Route::post('/jobList', 'DispatcherController@jobList')->name('jobList');
	Route::post('/downloadPDF','DispatcherController@downloadPDF')->name('downloadPDF');
	Route::get('/searchbylocation', 'DispatcherController@jobSearchByLocation')->name('searchbylocation');
	Route::post('/searchbylocation', 'DispatcherController@jobSearchByLocation')->name('searchbylocation');
	Route::get('/dispatcher/showCarDriver/{id}', 'DispatcherController@showCarDriver')->name('showCarDriver');
	//Route::get('ajaxJobAutoQueue', 'DispatcherController@ajaxJobAutoQueue')->name('ajaxJobAutoQueue');
	Route::post('removeJobAutoQueue', 'JobAutoQueueController@removeJobAutoQueue')->name('removeJobAutoQueue');
	Route::post('/savefile', 'AjaxUploadController@store')->name('savefile');
	Route::get('/getjobfile/{id}', 'AjaxUploadController@index')->name('getjobfile');
	Route::post('/removefile', 'AjaxUploadController@remove')->name('removefile');

	// Reports section

	Route::any('/recapitulation', 'DispatcherReportController@recapitulation')->name('recapitulation');
	Route::any('/numberoftrip', 'DispatcherReportController@numberoftrip')->name('numberoftrip');
});

