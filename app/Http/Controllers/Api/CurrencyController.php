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
        // refactor save data currencys on object cache.......

            $result = $currencylayer->source($from)
                ->currencies($to)
                ->live();

            $result= $currencylayer::RequestResponse($result,$from,$to,$amount);

        return response()->json($result);
    }

    public function convertCurrencyDate(string $from,string $to,float $amount,string $date,Client $currencylayer) : JsonResponse
    {
        $result = $currencylayer->date($date)
            ->source($from)
            ->currencies($to)
            ->historical();

        $result= $currencylayer::RequestResponse($result,$from,$to,$amount);

        return response()->json($result);
    }

    public function convertCurrencysDate(Request $request,Client $currencylayer)//: JsonResponse
    {
        $date = $request->query('date');
        $from = $request->query('from');
        $amount = $request->query('amount');
        $to = Client::currencysParser($request->query('to'));

        $result = $currencylayer->date($date)
            ->source($from)
            ->currencies($to)
            ->historical();

        $result= $currencylayer::multipleRequestResponse($result,$amount);

        return response()->json([
            "source" => $result
        ]);
    }

}
