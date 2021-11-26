<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
Use App\Services\Client;
Use Illuminate\Http\JsonResponse;
Use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function convert(string $from, string $to, string $amount,$date = null, Client $currencylayer): JsonResponse
    {
        (!empty($date))
            ?
        $resultApi = $currencylayer->date($date)
            ->source($from)
            ->currencies($to)
            ->historical()
            :
        $resultApi = $currencylayer->source($from)
            ->currencies($to)
            ->live();

        $resultApi= $currencylayer->getResponse($resultApi,$amount);

        return response()->json($resultApi);
    }

    /**
     * @throws CustomException
     */
    public function multipleConvert(Request $request, Client $currencylayer): JsonResponse
    {
        $date = $request->query('date');
        $from = $request->query('from');
        $amount = $request->query('amount');
        $to = $currencylayer->getCurrenciesParser($request->query('to'));

        (!empty($date))
            ?
            $resultApi = $currencylayer->date($date)
                ->source($from)
                ->currencies($to)
                ->historical()
                :
            $resultApi = $currencylayer->source($from)
                ->currencies($to)
                ->live();

        $resultApi= $currencylayer->getResponse($resultApi,$amount);

        return response()->json($resultApi);
    }

}
