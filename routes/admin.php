<?php

use Illuminate\Support\Facades\Route;


Route::resource('home', '\App\Http\Controllers\Panel\PanelController')->middleware('auth');

Route::group(['prefix' => 'user'], function () {
    //*admin
    Route::resource('admin', '\App\Http\Controllers\Panel\User\AdminController')->middleware('auth');
    Route::get('admin/list/show', ['\App\Http\Controllers\Panel\User\AdminController', 'list'])->middleware('auth');
    Route::post('admin/password/update', ['\App\Http\Controllers\Panel\User\AdminController', 'updatePassword'])->middleware('auth');
   //*asesor
    Route::resource('asesor', '\App\Http\Controllers\Panel\User\AsesoresController')->middleware('auth');
    Route::get('asesor/list/show', ['\App\Http\Controllers\Panel\User\AsesoresController', 'list'])->middleware('auth');
    Route::post('asesor/password/update', ['\App\Http\Controllers\Panel\User\AsesoresController', 'updatePassword'])->middleware('auth');
});
