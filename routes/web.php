<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payments/success/mp', \App\Http\Controllers\MercadoPagoController::class.'@mercadoPagoSuccess')
    ->name('payments.success.mercadopago');
Route::get('/payments/pending/mp', \App\Http\Controllers\MercadoPagoController::class.'@mercadoPagoPending')
    ->name('payments.pending.mercadopago');
Route::get('/payments/error/mp', \App\Http\Controllers\MercadoPagoController::class.'@mercadoPagoError')
    ->name('payments.error.mercadopago');

