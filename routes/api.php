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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'surveysparrow'], function () {
    Route::resource('survey', '\App\Http\Controllers\Api\SurveySparrow\SurveyController');
});

Route::resource('rrss', '\App\Http\Controllers\Api\RssController');


Route::group(['prefix' => 'appkax'], function () {
    Route::get('{history}/{model}/steps', ['\App\Http\Controllers\Api\AppKaxController', 'steps']);
});

Route::post('lead', ['\App\Http\Controllers\Api\Campaign\LeadController', 'store']);
Route::post('action/manychat/{section}', ['\App\Http\Controllers\Api\ActionManychatController', 'store']);
Route::post('action/manychat/lead/store', ['\App\Http\Controllers\Api\ActionManychatController', 'storeLead']);

Route::post('action/manychat/wa-complete/lead/store', ['\App\Http\Controllers\Api\ActionManychatController', 'storeLeadWaComplete']);

Route::get('credit/{credit}/{s2_credit_id}/{tipo}/set', ['\App\Http\Controllers\Api\CreditController', 'activar']);


Route::get('investor/{financial_product_id}/setTotalCapital', ['\App\Http\Controllers\Api\CreditController', 'apiSetTotalCapital']);
