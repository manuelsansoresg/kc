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
    
    Route::get('{lead_id}/profile', ['\App\Http\Controllers\Panel\LeadController', 'profile'])->middleware('auth');
    
    Route::post('{lead_id}/advisor/store', ['\App\Http\Controllers\Panel\LeadController', 'advisorStore'])->middleware('auth');
    Route::post('{lead_id}/client-person/store', ['\App\Http\Controllers\Panel\LeadController', 'storeClientPerson'])->middleware('auth');
    Route::post('{lead_id}/tag/update', ['\App\Http\Controllers\Panel\LeadController', 'updateTag'])->middleware('auth');

    //* mover del lugar
    Route::post('{id_rel}/move/archive', ['\App\Http\Controllers\Panel\LeadController', 'moveArchive'])->middleware('auth');
    Route::get('financial/{lead_id}/show', ['\App\Http\Controllers\Panel\LeadController', 'listFinancial'])->middleware('auth');
});


Route::get('{id}/{model}/validate/show', ['\App\Http\Controllers\Panel\PanelController', 'showValidate'])->middleware('auth');
Route::post('{model}/note', ['\App\Http\Controllers\Panel\PanelController', 'noteStore'])->middleware('auth');

Route::group(['prefix' => 'archive'], function () {
    Route::get('lead', ['\App\Http\Controllers\Panel\LeadController', 'archive'])->middleware('auth');
    Route::get('lead/list/show', ['\App\Http\Controllers\Panel\LeadController', 'listArchive'])->middleware('auth');
});

Route::get('notification/{model}/show', ['\App\Http\Controllers\Panel\NotificationController', 'show'])->middleware('auth');

//Route::get('notification/{id}/delete', ['\App\Http\Controllers\Panel\NotificationController', 'destroy'])->middleware('auth');

//*action
Route::resource('action', '\App\Http\Controllers\Panel\ActionController')->middleware('auth');
Route::group(['prefix' => 'action'], function () {
    Route::get('list/{id}/{model}/{status}', ['\App\Http\Controllers\Panel\ActionController', 'listAction'])->middleware('auth');
    Route::get('{status}/view', ['\App\Http\Controllers\Panel\ActionController', 'viewAction'])->middleware('auth');
    Route::get('{status}/dt/show', ['\App\Http\Controllers\Panel\ActionController', 'list'])->middleware('auth');
    Route::get('module/{name_status}', ['\App\Http\Controllers\Panel\ActionController', 'viewModuleAction'])->middleware('auth');
    Route::get('module/{name_status}/list', ['\App\Http\Controllers\Panel\ActionController', 'listModuleAction'])->middleware('auth');
});

//*dropzone file
Route::group(['prefix' => 'temp'], function () {
    Route::post('images/{model}', ['\App\Http\Controllers\Panel\ActionController', 'storeFile'])->middleware('auth');
    Route::get('images/{model}/show', ['\App\Http\Controllers\Panel\ActionController', 'showFiles'])->middleware('auth');
    Route::get('images/{id}/delete', ['\App\Http\Controllers\Panel\ActionController', 'deleteFile'])->middleware('auth');
});

Route::group(['prefix' => 'files'], function () {
    Route::get('images/{model}/{id_rel}/get/config', ['\App\Http\Controllers\Panel\ActionController', 'configFilesTemplate'])->middleware('auth');
    Route::post('images/{model}/{id_rel}/{template_config_id}', ['\App\Http\Controllers\Panel\ActionController', 'storeFilesTemplate'])->middleware('auth');
    
    Route::post('template/date', ['\App\Http\Controllers\Panel\ActionController', 'storeFilesDateTemplate'])->middleware('auth');
    Route::get('template/{model}/{id_rel}/show', ['\App\Http\Controllers\Panel\ActionController', 'getDataTemplate'])->middleware('auth');
});
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

Route::resource('financial', '\App\Http\Controllers\Panel\Financial\FinancialController')->middleware('auth');

Route::group(['prefix' => 'financial'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Financial\FinancialController', 'list'])->middleware('auth');
    Route::get('product/{financial_id}/list/show', ['\App\Http\Controllers\Panel\Financial\FinancialController', 'listProduct'])->middleware('auth');
});

Route::resource('financial-product', '\App\Http\Controllers\Panel\Financial\FinancialProductController')->middleware('auth');

Route::group(['prefix' => 'financial-product'], function () {
    Route::get('{financial_id}/create', ['\App\Http\Controllers\Panel\Financial\FinancialProductController', 'create'])->middleware('auth');
});

Route::get('{section}/{id}/move', ['\App\Http\Controllers\Panel\PanelController', 'move'])->middleware('auth');

//*Client
Route::resource('client', '\App\Http\Controllers\Panel\Client\ClientPersonController')->middleware('auth');
//*modules
Route::resource('kc-check-up', '\App\Http\Controllers\Panel\Module\KcCheckup\KcCheckupController')->middleware('auth');
Route::group(['prefix' => 'kc-check-up'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\KcCheckupController', 'list'])->middleware('auth');
    Route::get('list/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\KcCheckupController', 'listStep'])->middleware('auth');
    
    Route::resource('report', '\App\Http\Controllers\Panel\Module\KcCheckup\ReportController')->middleware('auth');
    Route::get('/report/list/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'list'])->middleware('auth');
    Route::get('/report/answer_module/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'actionReport'])->middleware('auth');
});

Route::resource('kc-check-up-actions', '\App\Http\Controllers\Panel\Module\ActionController')->middleware('auth');
Route::group(['prefix' => 'kc-check-up-actions'], function () {
    Route::get('list/{history_id}/show', ['\App\Http\Controllers\Panel\Module\ActionController', 'list'])->middleware('auth');
    
    
});

//*credit
Route::resource('credit', '\App\Http\Controllers\Panel\Credit\CreditController')->middleware('auth');
Route::group(['prefix' => 'credit'], function () {
    Route::post('tag/store', ['\App\Http\Controllers\Panel\Credit\CreditController', 'storeTag'])->middleware('auth');
    Route::get('tag/{credit_id}/get-all', ['\App\Http\Controllers\Panel\Credit\CreditController', 'getTag'])->middleware('auth');
    Route::get('tag/{tag_id}/drop', ['\App\Http\Controllers\Panel\Credit\CreditController', 'deleteTag'])->middleware('auth');
    Route::get('note/{credit_id}/get-all', ['\App\Http\Controllers\Panel\Credit\CreditController', 'getNote'])->middleware('auth');

    Route::get('note/{credit_id}/get-all', ['\App\Http\Controllers\Panel\Credit\CreditController', 'getNote'])->middleware('auth');
    Route::get('action/{credit_id}/list', ['\App\Http\Controllers\Panel\Credit\CreditController', 'getListAction'])->middleware('auth');

    
});

//* actions template
Route::resource('action-form', '\App\Http\Controllers\Panel\Module\FormController')->middleware('auth');
Route::resource('action-document', '\App\Http\Controllers\Panel\Credit\DocumentController')->middleware('auth');

Route::group(['prefix' => 'action-form'], function () {
    Route::get('{model}/{id_rel}/form', ['\App\Http\Controllers\Panel\Module\FormController', 'index'])->middleware('auth');
});
