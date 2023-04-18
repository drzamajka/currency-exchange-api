<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyExchangeController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Endpoint do autoryzacji
Route::post('login', [AuthController::class, 'login']);

// Chronione Endpointy
Route::group(['middleware' => ['auth:sanctum', 'role:api']], function () {

// Endpoint do dodawania kursu waluty
Route::post('currency', [CurrencyExchangeController::class, 'add']);

// Endpoint do pobierania listy kursów walut z danego dnia
Route::get('currencies/{date}', [CurrencyExchangeController::class, 'list']);

// Endpoint do pobierania kursu dla wybranej waluty z danego dnia
Route::get('currency/{currency}/{date}', [CurrencyExchangeController::class, 'get']);

});

