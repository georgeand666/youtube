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

/*
Route::get('/youtube/[idVideo?]', function ($idVideo='') {
	return view('youtube');
})->name('API_YouTube');
*/

Route::get('/youtube/{idVideo?}', 'YouTubeController@index')->name('API_YouTube');

Route::match(['get', 'post'], '/search', [
	'uses' => 'YouTubeController@search'
]);

Route::get('/', function () {
	return redirect()->route('API_YouTube');
});
