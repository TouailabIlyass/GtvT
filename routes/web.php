<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','IndexController@index');
Route::get('/index','IndexController@index');


Route::get('/clients','ClientController@index');
Route::post('/clients','ClientController@store');
Route::get('/clients/{client}/edit','ClientController@edit');
Route::put('/clients/{client}','ClientController@update');


Route::get('/vehicules','VehiculeController@list');
Route::get('/payes','ClientController@listOfPayes');

Route::post('/api/clients','ClientController@restStore');
Route::put('/api/clients/{client}','ClientController@restUpdate');
Route::get('/api/clients','ClientController@RestIndex');
Route::get('/api/clients/{client}','ClientController@editRest');
Route::get('/api/clients/find/{keyword}','ClientController@restGetOne');
Route::get('/api/payes','ClientController@listOfPayes');
Route::get('/api/clients/actif/paginate','ClientController@restClientActif');
Route::delete('/api/clients/{client}','ClientController@restDestroy');






//-------------------vehicules Routes---------------
Route::get('/vehicules', 'VehiculeController@index');
Route::get('/vehicules/create', 'VehiculeController@create');
Route::post('/vehicules', 'VehiculeController@store');
Route::get('/vehicules/{vehicule}', 'VehiculeController@show');
Route::get('/vehicules/{vehicule}/edit', 'VehiculeController@edit');
Route::put('/vehicules/{vehicule}', 'VehiculeController@update');
Route::delete('/vehicules/{vehicule}', 'VehiculeController@destroy');
	//----------------Rest for vehicules Table-----------------------
Route::get('/api/vehicules/', 'VehiculeController@restIndex');
Route::get('/api/vehicules/{vehicule}', 'VehiculeController@restShow');
Route::post('/api/vehicules', 'VehiculeController@restStore');
Route::put('/api/vehicules/{vehicule}', 'VehiculeController@restUpdate');
Route::delete('/api/vehicules/{vehicule}', 'VehiculeController@restDestroy');
Route::get('/api/vehicules/find/{keyword}','VehiculeController@restGetOne');
Route::get('/api/vehicules/marque/marques','VehiculeController@restGetAllMarque');
Route::get('/api/vehicules/marque/modeles/{marque}','VehiculeController@restGetModelesByMarque');

Route::get('/api/vehicules/actif/paginate','VehiculeController@restVehiculeActif');

//-------------------End vehicules Routes------------


//-------------------reservations Routes---------------
Route::get('/reservations', 'ReservationController@index');
Route::get('/reservations/create', 'ReservationController@create');
Route::post('/reservations', 'ReservationController@store');
Route::get('/reservations/{reservation}', 'ReservationController@show');
Route::get('/reservations/{reservation}/edit', 'ReservationController@edit');
Route::put('/reservations/{reservation}', 'ReservationController@update');
Route::delete('/reservations/{reservation}', 'ReservationController@destroy');
	//----------------Rest for reservations Table-----------------------
Route::get('/api/reservations', 'ReservationController@restIndex');
Route::get('/api/reservations/{reservation}', 'ReservationController@restShow');
Route::post('/api/reservations', 'ReservationController@restStore');
Route::put('/api/reservations/{reservation}', 'ReservationController@restUpdate');
Route::delete('/api/reservations/{reservation}', 'ReservationController@restDestroy');
Route::get('/api/reservations/actif/paginate','ReservationController@restReservationActif');
Route::get('/api/reservations/find/{keyword}','ReservationController@restGetOne');

//-------------------End reservations Routes------------

	//----------------Rest for prolongations Table-----------------------
Route::get('/api/prolongations/find/{keyword}','ProlongationController@restGetByNumRes');
Route::post('/api/prolongations','ProlongationController@restStore');
Route::delete('/api/prolongations/{prolongation}','ProlongationController@restDestroy');
//-------------------End for prolongations Table-----------------------
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

