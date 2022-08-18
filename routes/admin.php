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
    //*cliente persona
    Route::resource('cliente-persona', '\App\Http\Controllers\Panel\User\ClientPersonaController')->middleware('auth');
    Route::get('cliente-persona/list/show', ['\App\Http\Controllers\Panel\User\ClientPersonaController', 'list'])->middleware('auth');
    Route::post('cliente-persona/password/update', ['\App\Http\Controllers\Panel\User\ClientPersonaController', 'updatePassword'])->middleware('auth');
    //*cliente financiera
    Route::resource('cliente-financiera', '\App\Http\Controllers\Panel\User\ClientFinancieraController')->middleware('auth');
    
    Route::get('cliente-financiera/list/show', ['\App\Http\Controllers\Panel\User\ClientFinancieraController', 'list'])->middleware('auth');
    Route::post('cliente-financiera/password/update', ['\App\Http\Controllers\Panel\User\ClientFinancieraController', 'updatePassword'])->middleware('auth');
    
    //*esta ruta equivale tanto como administrador como asesor
    Route::get('administrador/{id}/delete', ['\App\Http\Controllers\Panel\User\AdminController', 'destroy'])->middleware('auth');

    //*client profile
    Route::resource('client-profile', '\App\Http\Controllers\Panel\User\ClientProfileController')->middleware('auth');
});

Route::resource('product', '\App\Http\Controllers\Panel\ProductController')->middleware('auth');
Route::get('product/list/show', ['\App\Http\Controllers\Panel\ProductController', 'list'])->middleware('auth');
Route::get('product/{product_id}/delete', ['\App\Http\Controllers\Panel\ProductController', 'destroy'])->middleware('auth');

//*agreement
Route::resource('agreement', '\App\Http\Controllers\Panel\AgreementController')->middleware('auth');
Route::get('agreement/list/show', ['\App\Http\Controllers\Panel\AgreementController', 'list'])->middleware('auth');
Route::get('agreement/{product_id}/delete', ['\App\Http\Controllers\Panel\AgreementController', 'destroy'])->middleware('auth');

//*leads
Route::resource('lead', '\App\Http\Controllers\Panel\LeadController')->middleware('auth');
Route::group(['prefix' => 'lead'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\LeadController', 'list'])->middleware('auth');
    Route::get('{lead_id}/delete', ['\App\Http\Controllers\Panel\LeadController', 'destroy'])->middleware('auth');
    Route::get('{lead_id}/origin', ['\App\Http\Controllers\Panel\LeadController', 'listOrigin'])->middleware('auth');
    Route::post('{lead_id}/note', ['\App\Http\Controllers\Panel\LeadController', 'noteStore'])->middleware('auth');
    Route::get('{lead_id}/profile', ['\App\Http\Controllers\Panel\LeadController', 'profile'])->middleware('auth');
    
    Route::post('{lead_id}/advisor/store', ['\App\Http\Controllers\Panel\LeadController', 'advisorStore'])->middleware('auth');
    Route::post('{lead_id}/client-person/store', ['\App\Http\Controllers\Panel\LeadController', 'storeClientPerson'])->middleware('auth');
    Route::post('{lead_id}/tag/update', ['\App\Http\Controllers\Panel\LeadController', 'updateTag'])->middleware('auth');

    //* mover del lugar
    Route::post('{id_rel}/move/archive', ['\App\Http\Controllers\Panel\LeadController', 'moveArchive'])->middleware('auth');
});


Route::get('{id}/{model}/validate/show', ['\App\Http\Controllers\Panel\PanelController', 'showValidate'])->middleware('auth');

Route::group(['prefix' => 'archive'], function () {
    Route::get('lead', ['\App\Http\Controllers\Panel\LeadController', 'archive'])->middleware('auth');
    Route::get('lead/list/show', ['\App\Http\Controllers\Panel\LeadController', 'listArchive'])->middleware('auth');
});

Route::get('notification/{model}/show', ['\App\Http\Controllers\Panel\NotificationController', 'show'])->middleware('auth');

//Route::get('notification/{id}/delete', ['\App\Http\Controllers\Panel\NotificationController', 'destroy'])->middleware('auth');

Route::resource('action', '\App\Http\Controllers\Panel\ActionController')->middleware('auth');
Route::group(['prefix' => 'action'], function () {
    Route::get('list/{id}/{model}/{status}', ['\App\Http\Controllers\Panel\ActionController', 'listAction'])->middleware('auth');
    Route::get('{status}/view', ['\App\Http\Controllers\Panel\ActionController', 'viewAction'])->middleware('auth');
    Route::get('{status}/dt/show', ['\App\Http\Controllers\Panel\ActionController', 'list'])->middleware('auth');
});
//*dropzone file
Route::post('temp/images/{model}', ['\App\Http\Controllers\Panel\ActionController', 'storeFile'])->middleware('auth');
Route::get('temp/images/{model}/show', ['\App\Http\Controllers\Panel\ActionController', 'showFiles'])->middleware('auth');
Route::get('temp/images/{id}/delete', ['\App\Http\Controllers\Panel\ActionController', 'deleteFile'])->middleware('auth');
//*register action
Route::resource('register-action', '\App\Http\Controllers\Panel\RegisterActionController')->middleware('auth');
Route::group(['prefix' => 'register-action'], function () {
    Route::get('set-id/{id}/set', ['\App\Http\Controllers\Panel\RegisterActionController', 'setIdRel'])->middleware('auth');
    Route::get('set-model/{id}/set', ['\App\Http\Controllers\Panel\RegisterActionController', 'setModel'])->middleware('auth');
});

Route::resource('tag', '\App\Http\Controllers\Panel\TagController')->middleware('auth');
Route::group(['prefix' => 'tag'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\TagController', 'list'])->middleware('auth');
});
