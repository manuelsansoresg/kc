<?php

use Illuminate\Support\Facades\Route;


Route::resource('home', '\App\Http\Controllers\Admin\PanelController')->middleware('auth');

Route::group(['prefix' => 'user'], function () {
    Route::resource('admin', '\App\Http\Controllers\Admin\AdminController')->middleware('auth');
    Route::post('admin/password/update', ['\App\Http\Controllers\Admin\AdminController', 'updatePassword'])->middleware('auth');
});
