<?php

use Illuminate\Support\Facades\Route;


Route::resource('home', '\App\Http\Controllers\Panel\PanelController')->middleware('auth');

Route::group(['prefix' => 'user'], function () {
    //*admin
    Route::resource('administrador', '\App\Http\Controllers\Panel\User\AdminController')->middleware('auth');
    Route::get('administrador/list/show', ['\App\Http\Controllers\Panel\User\AdminController', 'list'])->middleware('auth');
    Route::post('administrador/password/update', ['\App\Http\Controllers\Panel\User\AdminController', 'updatePassword'])->middleware('auth');
    
    //*asesor
    Route::resource('asesor', '\App\Http\Controllers\Panel\User\AsesoresController')->middleware('auth');
    Route::get('asesor/list/show', ['\App\Http\Controllers\Panel\User\AsesoresController', 'list'])->middleware('auth');
    Route::post('asesor/password/update', ['\App\Http\Controllers\Panel\User\AsesoresController', 'updatePassword'])->middleware('auth');
    
    //*esta ruta equivale tanto como administrador como asesor
    Route::get('administrador/{id}/delete', ['\App\Http\Controllers\Panel\User\AdminController', 'destroy'])->middleware('auth');

});

Route::resource('product', '\App\Http\Controllers\Panel\ProductController')->middleware('auth');
Route::get('product/list/show', ['\App\Http\Controllers\Panel\ProductController', 'list'])->middleware('auth');
Route::get('product/{product_id}/delete', ['\App\Http\Controllers\Panel\ProductController', 'destroy'])->middleware('auth');

