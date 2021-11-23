<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrencyController;

Route::name('api.')->group(function () {
    Route::get('v1/convertCurrency/{from}/{to}/{amount}', [CurrencyController::class, 'convertCurrency' ]);
    Route::get('v1/convertCurrency/{from}/{to}/{amount}/{date}', [CurrencyController::class, 'convertCurrencyDate' ]);
    Route::get('v1/convertCurrencys/', [CurrencyController::class, 'convertCurrencysDate' ]);//Full url
});
