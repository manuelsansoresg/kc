<?php

use App\Http\Controllers\DeployController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
    return view('default.index');
});



Auth::routes();


Route::get('/politicas', function () {
    return view('politicas');
});

Route::get('/unsubscribe', function () {
    return view('index');
});
Route::get('/condiciones', function () {
    return view('index');
});

Route::get('hola', ['\App\Http\Controllers\HomeController', 'surveyHola']);



Route::get('reporte/{history_id}', ['\App\Http\Controllers\HomeController', 'report']);
Route::get('app/reporte/{history_id}/{credit_id}', ['\App\Http\Controllers\HomeController', 'report']);
Route::get('reporte/{history_id}/metodologia', ['\App\Http\Controllers\HomeController', 'method']);

Route::get('reporte/{credit}/status/finish', ['\App\Http\Controllers\HomeController', 'exitReport']);

Route::get('credit-resume/{credit}', ['\App\Http\Controllers\HomeController', 'resumeCredit']);

Route::resource('survey', '\App\Http\Controllers\Panel\Module\SurveyController');
Route::get('user/tyc/validate', ['\App\Http\Controllers\HomeController', 'validateAccess']);

Route::post('lead/store', ['\App\Http\Controllers\HomeController', 'leadStore']);
Route::post('lead/form/store', ['\App\Http\Controllers\HomeController', 'leadFormStore']);

Route::get('quiz/form', ['\App\Http\Controllers\HomeController', 'surveyForm']);


Route::get('/nosotros', function () {
    return view('about');
});
Route::get('/contacto', function () {
    return view('contact');
});

Route::get('/ayuda', function () {
    return view('help');
});

Route::get('/aviso-de-privacidad', function () {
    return view('privacidad');
});
