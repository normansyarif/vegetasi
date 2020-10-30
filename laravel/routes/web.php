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

// Route::get('/', 'PageController@prediksiView');
// Route::post('/upload-dataset', 'PageController@uploadDataset')->name('upload-dataset');
// Route::get('/prediksi', 'PageController@prediksi')->name('prediksi');
// Route::get('/tes', 'PageController@tesPiton')->name('tes');

Route::get('/', 'PageController@show');
Route::post('/uploadTrain', 'PageController@uploadTrain')->name('upload-train');
Route::post('/uploadFull', 'PageController@uploadFull')->name('upload-full');

Route::get('/traindel', 'PageController@traindel')->name('ds-train-delete');
Route::get('/fulldel', 'PageController@fulldel')->name('ds-full-delete');