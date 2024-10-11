<?php

use Illuminate\Support\Facades\Route;


//Route::resource('home', '\App\Http\Controllers\Panel\PanelController')->middleware('auth');

Route::get('home', function () {
    return redirect('/panel/lead');
});

Route::get('config', function () {
    return view('construction');
});


//*client profile
Route::resource('user-profile', '\App\Http\Controllers\Panel\User\ClientProfileController')->middleware('auth');

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
    
    //*cliente inversionista
    Route::resource('cliente-inversionista', '\App\Http\Controllers\Panel\User\ClienteInversionistaController')->middleware('auth');
    Route::get('cliente-inversionista/list/show', ['\App\Http\Controllers\Panel\User\ClienteInversionistaController', 'list'])->middleware('auth');
    Route::post('cliente-inversionista/password/update', ['\App\Http\Controllers\Panel\User\ClienteInversionistaController', 'updatePassword'])->middleware('auth');

    //*esta ruta equivale tanto como administrador como asesor
    Route::get('administrador/{id}/delete', ['\App\Http\Controllers\Panel\User\AdminController', 'destroy'])->middleware('auth');

    Route::post('tyc/accept', ['\App\Http\Controllers\Panel\User\AdminController', 'tycAccept'])->middleware('auth');

    //*busqueda
    Route::get('search/view', ['\App\Http\Controllers\Panel\User\AdminController', 'searchView'])->middleware('auth');
    Route::get('search', ['\App\Http\Controllers\Panel\User\AdminController', 'search'])->middleware('auth');
    
});

Route::resource('product', '\App\Http\Controllers\Panel\ProductController')->middleware('auth');
Route::get('product/list/show', ['\App\Http\Controllers\Panel\ProductController', 'list'])->middleware('auth');
Route::get('product/{product_id}/delete', ['\App\Http\Controllers\Panel\ProductController', 'destroy'])->middleware('auth');

//*agreement
Route::resource('agreement', '\App\Http\Controllers\Panel\AgreementController')->middleware('auth');
Route::get('agreement/list/show', ['\App\Http\Controllers\Panel\AgreementController', 'list'])->middleware('auth');
Route::get('agreement/{product_id}/delete', ['\App\Http\Controllers\Panel\AgreementController', 'destroy'])->middleware('auth');
Route::get('agreement/{agreement}/financial-product/show', ['\App\Http\Controllers\Panel\AgreementController', 'getFinancialProducts'])->middleware('auth');

//*leads
Route::resource('lead', '\App\Http\Controllers\Panel\LeadController')->middleware('auth');
Route::group(['prefix' => 'lead'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\LeadController', 'list'])->middleware('auth');
    
    
    Route::get('{lead}/actions/list', ['\App\Http\Controllers\Panel\LeadController', 'listActions'])->middleware('auth');

    Route::get('{lead_id}/delete', ['\App\Http\Controllers\Panel\LeadController', 'destroy'])->middleware('auth');
    Route::get('{lead_id}/origin', ['\App\Http\Controllers\Panel\LeadController', 'listOrigin'])->middleware('auth');
    
    Route::get('{lead_id}/profile', ['\App\Http\Controllers\Panel\LeadController', 'profile'])->middleware('auth');
    Route::get('{clientPerson}/{agreement}/{financialProduct}/soad/get', ['\App\Http\Controllers\Panel\LeadController', 'getSoad'])->middleware('auth');
    
    Route::post('{lead_id}/advisor/store', ['\App\Http\Controllers\Panel\LeadController', 'advisorStore'])->middleware('auth');
    Route::post('{lead_id}/client-person/store', ['\App\Http\Controllers\Panel\LeadController', 'storeClientPerson'])->middleware('auth');
    Route::post('{lead}/tag/update', ['\App\Http\Controllers\Panel\LeadController', 'updateTag'])->middleware('auth');

    Route::get('{lead}/preview/profile', ['\App\Http\Controllers\Panel\LeadController', 'previewProfile'])->middleware('auth');

    Route::get('{value}/{id}/check', ['\App\Http\Controllers\Panel\LeadController', 'checkData'])->middleware('auth');
    
    Route::get('{cellphone}/{rfc}/get/validate', ['\App\Http\Controllers\Panel\LeadController', 'validateCellphoneAndRfc'])->middleware('auth');
    
    Route::get('{agreementId}/getProducts', ['\App\Http\Controllers\Panel\LeadController', 'getProducts'])->middleware('auth');
    
    Route::post('{leadId}/data/export', ['\App\Http\Controllers\Panel\LeadController', 'exportLead'])->middleware('auth');

    //* mover del lugar
    
    Route::get('financial/{lead_id}/show', ['\App\Http\Controllers\Panel\LeadController', 'listFinancial'])->middleware('auth');
    
});


Route::resource('clients', '\App\Http\Controllers\Panel\Client\ClientController')->middleware('auth');
Route::group(['prefix' => 'clients'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Client\ClientController', 'list'])->middleware('auth');
});

Route::get('{id}/{model}/validate/show', ['\App\Http\Controllers\Panel\PanelController', 'showValidate'])->middleware('auth');
Route::post('{model}/note', ['\App\Http\Controllers\Panel\PanelController', 'noteStore'])->middleware('auth');
Route::get('{model}/{id_rel}/notes/list', ['\App\Http\Controllers\Panel\PanelController', 'listNotes'])->middleware('auth');
Route::get('{model}/{id_rel}/advisor/show', ['\App\Http\Controllers\Panel\PanelController', 'showAdvisor'])->middleware('auth');

Route::group(['prefix' => 'archive'], function () {
    Route::get('view/{module}', ['\App\Http\Controllers\Panel\LeadController', 'archiveView'])->middleware('auth');
    Route::get('lead', ['\App\Http\Controllers\Panel\LeadController', 'archive'])->middleware('auth');
    Route::get('lead/list/show', ['\App\Http\Controllers\Panel\LeadController', 'listArchive'])->middleware('auth');
    Route::get('lead/list/{module_id}/show', ['\App\Http\Controllers\Panel\LeadController', 'listModuleArchive'])->middleware('auth');
    Route::get('product', ['\App\Http\Controllers\Panel\LeadController', 'product'])->middleware('auth');
});

Route::get('notification/{model}/show', ['\App\Http\Controllers\Panel\NotificationController', 'show'])->middleware('auth');

//Route::get('notification/{id}/delete', ['\App\Http\Controllers\Panel\NotificationController', 'destroy'])->middleware('auth');

//*action
Route::resource('action', '\App\Http\Controllers\Panel\ActionController')->middleware('auth');
Route::group(['prefix' => 'action'], function () {
    Route::get('financial/product/{financial_id}/{type}/show', ['\App\Http\Controllers\Panel\ActionController', 'listProductFinancial'])->middleware('auth');
    Route::get('list/{id}/{model}/{status}', ['\App\Http\Controllers\Panel\ActionController', 'listAction'])->middleware('auth');
    
    Route::get('{status}/view', ['\App\Http\Controllers\Panel\ActionController', 'viewAction'])->middleware('auth');
    Route::get('{status}/{model}/view', ['\App\Http\Controllers\Panel\ActionController', 'viewActionDt'])->middleware('auth');
    
    Route::get('{status}/{model}/dt/show', ['\App\Http\Controllers\Panel\ActionController', 'list'])->middleware('auth');
    Route::get('module/{name_status}', ['\App\Http\Controllers\Panel\ActionController', 'viewModuleAction'])->middleware('auth');
    Route::get('module/{name_status}/list', ['\App\Http\Controllers\Panel\ActionController', 'listModuleAction'])->middleware('auth');

    Route::post('{id_rel}/{status_id}/{old_status_id}/move', ['\App\Http\Controllers\Panel\ActionController', 'move'])->middleware('auth');
    Route::get('{history}/{status_id}/finish', ['\App\Http\Controllers\Panel\ActionController', 'moveDeliveryFinish'])->middleware('auth');
    //concluir atajo
    Route::get('{history}/complete', ['\App\Http\Controllers\Panel\ActionController', 'complete'])->middleware('auth');
    
    
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

Route::resource('product-complementary', '\App\Http\Controllers\Panel\Financial\ProductComplementaryServiceController')->middleware('auth');
Route::get('product-complementary/{product}/{type}', ['\App\Http\Controllers\Panel\Financial\ProductComplementaryServiceController', 'show'])->middleware('auth');
Route::get('product-complementary/list/{product_id}/refresh', ['\App\Http\Controllers\Panel\Financial\ProductComplementaryServiceController', 'refresh'])->middleware('auth');

Route::resource('product-fee', '\App\Http\Controllers\Panel\ProductFeeController')->middleware('auth');
Route::get('product-fee/{productFee}/showproductFee', ['\App\Http\Controllers\Panel\ProductFeeController', 'showproductFee'])->middleware('auth');

Route::group(['prefix' => 'financial'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Financial\FinancialController', 'list'])->middleware('auth');
    Route::get('product/{financial_id}/list/show', ['\App\Http\Controllers\Panel\Financial\FinancialController', 'listProduct'])->middleware('auth');
});

Route::resource('financial-product', '\App\Http\Controllers\Panel\Financial\FinancialProductController')->middleware('auth');

Route::group(['prefix' => 'financial-product'], function () {
    Route::get('{financial_id}/create', ['\App\Http\Controllers\Panel\Financial\FinancialProductController', 'create'])->middleware('auth');
    Route::get('{product_id}/getPeriodicityAndPaymentMethod', ['\App\Http\Controllers\Panel\Financial\FinancialProductController', 'getPeriodicityAndPaymentMethod'])->middleware('auth');
    Route::get('{product}/getTramite', ['\App\Http\Controllers\Panel\Financial\FinancialProductController', 'getTramite'])->middleware('auth');
    
    Route::get('{periodicityId}/{productId}/terms/get', ['\App\Http\Controllers\Panel\Financial\FinancialProductController', 'getTerms'])->middleware('auth');
});

Route::get('{section}/{id}/move', ['\App\Http\Controllers\Panel\PanelController', 'move'])->middleware('auth');


//*Client
Route::resource('client', '\App\Http\Controllers\Panel\Client\ClientPersonController')->middleware('auth');
Route::get('client/{client}/credit/total',[App\Http\Controllers\Panel\Client\ClientPersonController::class, 'totalCredit'])->middleware('auth');

//*modules
Route::resource('kc-check-up', '\App\Http\Controllers\Panel\Module\KcCheckup\KcCheckupController')->middleware('auth');
Route::group(['prefix' => 'kc-check-up'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\KcCheckupController', 'list'])->middleware('auth');
    Route::get('/report/list/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'list'])->middleware('auth');
    Route::get('/report/answer_module/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'actionReport'])->middleware('auth');
    Route::get('/report/desition/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'desitionReport'])->middleware('auth');
    Route::get('/report/desition/{credit_id}/{financial_id}/{type}/accept', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'desitionAccept']);
    
    Route::get('{credit_id}/{product_id}/report/verify', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'verifyReport'])->middleware('auth');
});

Route::resource('kc-control-desk', '\App\Http\Controllers\Panel\Module\KcControlDesk\KcControlDeskController')->middleware('auth');
Route::group(['prefix' => 'kc-control-desk'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcControlDesk\KcControlDeskController', 'list'])->middleware('auth');
    Route::get('kc/{history_id}/{param}/{param2}/{type}/validate', ['\App\Http\Controllers\Panel\Module\KcControlDesk\KcControlDeskController', 'validateKyc'])->middleware('auth');
});

Route::resource('kc-delivery', '\App\Http\Controllers\Panel\Module\KcDelivery\KcDeliveryController')->middleware('auth');
Route::group(['prefix' => 'kc-delivery'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcDelivery\KcDeliveryController', 'list'])->middleware('auth');
    Route::get('{history_id}/send-email', ['\App\Http\Controllers\Panel\Module\KcDelivery\KcDeliveryController', 'sendEmail'])->middleware('auth');
});

Route::resource('kc-aftermarket', '\App\Http\Controllers\Panel\Module\KcAfterMarketController')->middleware('auth');
Route::group(['prefix' => 'kc-after-market'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcAfterMarketController', 'list'])->middleware('auth');
});

Route::resource('kc-payments', '\App\Http\Controllers\Panel\Module\KcPaymentController')->middleware('auth');
Route::group(['prefix' => 'kc-payments'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcPaymentController', 'list'])->middleware('auth');
});

Route::resource('kc-swap', '\App\Http\Controllers\Panel\Module\KcSwapController')->middleware('auth');
Route::group(['prefix' => 'kc-swap'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcSwapController', 'list'])->middleware('auth');
    Route::get('credit/{credit_id}/cancel', ['\App\Http\Controllers\Panel\Module\KcSwapController', 'cancel'])->middleware('auth');
    Route::get('credit/{history_id}/continue', ['\App\Http\Controllers\Panel\Module\KcSwapController', 'continue'])->middleware('auth');
});

Route::resource('kc-check-up-debt-reduction', '\App\Http\Controllers\Panel\Module\KcCheckup\DebtReductionController')->middleware('auth');
Route::group(['prefix' => 'kc-check-up-debt-reduction'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\DebtReductionController', 'list'])->middleware('auth');
    Route::get('list/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\DebtReductionController', 'listStep'])->middleware('auth');
    
    Route::resource('report', '\App\Http\Controllers\Panel\Module\KcCheckup\ReportController')->middleware('auth');
    Route::get('/report/list/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'list'])->middleware('auth');
    Route::get('/report/answer_module/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'actionReport'])->middleware('auth');
    
    Route::get('/report/desition/{history_id}/show', ['\App\Http\Controllers\Panel\Module\KcCheckup\ReportController', 'desitionReport'])->middleware('auth');
});


Route::resource('kc-check-up-actions', '\App\Http\Controllers\Panel\Module\ActionController')->middleware('auth');

Route::resource('kc-wallet', '\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController')->middleware('auth');

Route::group(['prefix' => 'kc-wallet'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController', 'list'])->middleware('auth');
    Route::get('list/history', ['\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController', 'listHistory'])->middleware('auth');
    Route::get('list/history/show', ['\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController', 'listHistoryShow'])->middleware('auth');

    Route::get('resumen/show', ['\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController', 'resumen'])->middleware('auth');
    
    Route::get('mis-prestamos/show', ['\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController', 'misPrestamos'])->middleware('auth');
    Route::get('{investor}/investor/get', ['\App\Http\Controllers\Panel\Module\KcWallet\KcWalletController', 'getInvestor'])->middleware('auth');
});

Route::resource('inversionista', '\App\Http\Controllers\InvestorController')->middleware('auth');
//Route::get('inversionista/{investor}/storePrestamo', ['\App\Http\Controllers\InvestorController', 'storePrestamo'])->middleware('auth');

Route::resource('kc-down-wallet', '\App\Http\Controllers\Panel\Module\KcWallet\KcDownWalletController')->middleware('auth');

Route::group(['prefix' => 'kc-down-wallet'], function () {
    Route::get('list/show', ['\App\Http\Controllers\Panel\Module\KcWallet\KcDownWalletController', 'list'])->middleware('auth');
    
    
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
    
    Route::get('product/{status}', ['\App\Http\Controllers\Panel\Credit\CreditController', 'product'])->middleware('auth');
    Route::get('product/{status}/list', ['\App\Http\Controllers\Panel\Credit\CreditController', 'productList'])->middleware('auth');
    
    Route::post('{credit_id}/advisor/store', ['\App\Http\Controllers\Panel\Credit\CreditController', 'advisorStore'])->middleware('auth');
    
    //*actualizar banco
    Route::post('storeBank', ['\App\Http\Controllers\Panel\Credit\CreditController', 'storeBank'])->middleware('auth');

    
});

//* actions template
Route::resource('action-form', '\App\Http\Controllers\Panel\Module\FormController')->middleware('auth');
Route::resource('action-document', '\App\Http\Controllers\Panel\Credit\DocumentController')->middleware('auth');

Route::group(['prefix' => 'action-form'], function () {
    Route::get('{model}/{history_id}/form', ['\App\Http\Controllers\Panel\Module\FormController', 'index'])->middleware('auth');
    Route::get('{id}/{type_form}/form/get', ['\App\Http\Controllers\Panel\Module\FormController', 'show'])->middleware('auth');
    
    

});
//*route form add references to credit in control desk step 3_2 
Route::group(['prefix' => 'reference'], function () {
    Route::get('{model}/{history_id}/form', ['\App\Http\Controllers\Panel\Credit\CreditController', 'reference'])->middleware('auth');
    Route::post('{history_id}/storeReference', ['\App\Http\Controllers\Panel\Credit\CreditController', 'storeReference'])->middleware('auth');
    Route::get('{history_id}/list', ['\App\Http\Controllers\Panel\Credit\CreditController', 'listReference'])->middleware('auth');
    Route::get('{history_id}/{reference_id}/edit', ['\App\Http\Controllers\Panel\Credit\CreditController', 'editReference'])->middleware('auth');
    Route::get('{reference_id}/show', ['\App\Http\Controllers\Panel\Credit\CreditController', 'showReference'])->middleware('auth');
    Route::delete('{reference_id}/delete', ['\App\Http\Controllers\Panel\Credit\CreditController', 'deleteReference'])->middleware('auth');
});

Route::group(['prefix' => 'template'], function () {
    Route::get('list/{model}/{history_id}/show', ['\App\Http\Controllers\Panel\Module\TemplateController', 'listStep'])->middleware('auth');
    Route::get('steps/{model}/{history_id}/show', ['\App\Http\Controllers\Panel\Module\TemplateController', 'viewStep'])->middleware('auth');
    
    Route::get('actions/{model}/{history_id}/show', ['\App\Http\Controllers\Panel\Module\TemplateController', 'viewAction'])->middleware('auth');
    
    Route::get('report/{model}/{history_id}/show', ['\App\Http\Controllers\Panel\Module\TemplateController', 'viewReport'])->middleware('auth');
    Route::resource('report', '\App\Http\Controllers\Panel\Module\KcCheckup\ReportController')->middleware('auth');

    
    Route::get('action-document/{model}/{history_id}', ['\App\Http\Controllers\Panel\Credit\DocumentController', 'index'])->middleware('auth');
    Route::get('actions/list/{model}/{history_id}/show', ['\App\Http\Controllers\Panel\Module\ActionController', 'list'])->middleware('auth');
});

Route::get('reason/{type}/list', ['\App\Http\Controllers\HomeController', 'reason'])->middleware('auth');
Route::get('notification/show', ['\App\Http\Controllers\HomeController', 'showNotification'])->middleware('auth');
Route::get('notification/read', ['\App\Http\Controllers\HomeController', 'readNotification'])->middleware('auth');

Route::get('/ayuda', function () {
    return view('panel.ayuda');
})->middleware('auth');
