<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

	Route::get('/', 'StatisticsController@index')->name('statistics');

    // Matches
	Route::get('/matches', 'MatchController@index')->name('matches');
	Route::post('/match', 'MatchController@store')->name('match.add');
	Route::post('/match/details', 'MatchController@storeComplete')->name('match.details');
	Route::get('/match/{id}', 'MatchController@view')->name('match.view');
	Route::delete('/match/{match}', 'MatchController@destroy')->name('match.destroy');

    // Players
	Route::get('/players', 'PlayerController@index')->name('players');
	Route::post('/player', 'PlayerController@store')->name('player.add');
	Route::get('/player/{name}', 'PlayerController@view')->name('player.view');
	Route::delete('/player/{player}', 'PlayerController@destroy')->name('players.destroy');

	Route::auth();

});

Route::get('test', function() {
	$match = App\Match::find(8);
	return storage_path() . env('PHOTO_STORAGE_DIR');
});