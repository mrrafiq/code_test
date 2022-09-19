<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'App\Http\Controllers\API'], function(){
    Route::group(['middleware' => ['api']], function () {
        Route::post('/login', 'AuthController@login')->name('login');
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'espresence'], function () {
            Route::get('/', 'EspresenceController@index')->name('index_user');
            Route::post('/in', 'EspresenceController@storeIn')->name('store_in');
            Route::post('/out', 'EspresenceController@storeOut')->name('store_out');
            Route::post('/update', 'EspresenceController@update')->name('update');
        });

        Route::post('/logout', 'AuthController@logout')->name('logout');
    });
});

