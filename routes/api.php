<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrencyController;

Route::name('api.')->group(function () {
    Route::get('/convertCurrency/{from}/{to}/{amount}', [CurrencyController::class, 'convertCurrency' ]);
    Route::get('/convertCurrency/{from}/{to}/{amount}/{date}', [CurrencyController::class, 'convertCurrencyDate' ]);
    Route::get('/convertCurrencys/', [CurrencyController::class, 'convertCurrencysDate' ]);//Full url
});
