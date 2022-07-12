<?php

use Illuminate\Support\Facades\Route;


Route::resource('home', '\App\Http\Controllers\Admin\PanelController')->middleware('auth');