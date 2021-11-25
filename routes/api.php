<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrencyController;

Route::name('api.')->group(function () {
   Route::get('v1/convert/{from}/{to}/{amount}', [CurrencyController::class, 'convertCurrency' ])
      ->whereNumber('amount')->whereAlpha('from')->whereAlpha('to');

    Route::get('v1/convert/{from}/{to}/{amount}/{date}', [CurrencyController::class, 'convertCurrencyDate' ])
        ->whereNumber('amount')->whereAlpha('from')->whereAlpha('to');

    Route::get('v1/multipleConvert/', [CurrencyController::class, 'convertCurrenciesDate' ]);
});
