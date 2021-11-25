<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
Use App\Services\Client;
Use Illuminate\Http\JsonResponse;
Use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function convertCurrency(string $from, string $to, string $amount, Client $currencylayer): JsonResponse
    {
        $resultApi = $currencylayer->source($from)
                ->currencies($to)
                ->live();

        $resultApi= $currencylayer->getRequestResponse($resultApi,$amount);

        return response()->json($resultApi);
    }

    public function convertCurrencyDate(string $from,string $to,float $amount,string $date,Client $currencylayer): JsonResponse
    {
        $resultApi = $currencylayer->date($date)
            ->source($from)
            ->currencies($to)
            ->historical();

        $resultApi=  $currencylayer->getRequestResponse($resultApi,$amount);

        return response()->json($resultApi);
    }

    public function convertCurrenciesDate(Request $request,Client $currencylayer): JsonResponse
    {
        $date = $request->query('date');
        $from = $request->query('from');
        $amount = $request->query('amount');

        $to = $currencylayer->getCurrenciesParser($request->query('to'));

        $resultApi = $currencylayer->date($date)
            ->source($from)
            ->currencies($to)
            ->historical();

        $resultApi= $currencylayer->getRequestResponse($resultApi,$amount);

        return response()->json($resultApi);
    }

}
