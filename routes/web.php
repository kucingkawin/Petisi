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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::group(['prefix' => 'user'], function () 
{
    Route::get('/', 'UserController@index')->name('user.index');

    Route::group(['prefix' => 'petisi'], function () 
    {
        Route::get('/', 'UserController@lihatPetisi')->name('user.lihatPetisi');
        Route::get('/detail', 'UserController@detailPetisi')->name('user.detailPetisi');
        Route::post('/detail/tandatangani', 'UserController@postTandatanganiPetisi')->name('user.postTandatanganiPetisi');
        Route::post('/detail/komentar', 'UserController@postKomentarPetisi')->name('user.postKomentarPetisi');
        Route::get('/saya', 'UserController@petisiSaya')->name('user.petisiSaya');
        Route::get('/ditandatangani', 'UserController@petisiDitandatangani')->name('user.petisiDitandatangani');
        Route::get('/dikomentari', 'UserController@petisiDikomentari')->name('user.petisiDikomentari');
        Route::get('/modifikasi', 'UserController@modifikasiPetisi')->name('user.modifikasiPetisi');
        Route::post('/modifikasi', 'UserController@postModifikasiPetisi')->name('user.postModifikasiPetisi');
    });
});

Route::group(['prefix' => 'admin'], function () 
{
    Route::get('/', 'AdminController@index')->name('admin.index');
});