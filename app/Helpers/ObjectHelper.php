<?php

namespace App\Helpers;

use App\Services\CurrencyLayer;
Use \stdClass;

class ObjectHelper
{
     public static function builderResponse(object $resultApi, $amount): object
    {
        $objCurrencies = new stdClass();
        $objCurrencies->source = $resultApi->source;
        $objCurrencies->success =$resultApi->success;
        $objCurrencies->code =200;
        $objCurrencies->created_at =$resultApi->timestamp;

        foreach ($resultApi->quotes as $key => $row) {

            $objCurrencies->result[] = [
                substr($key, 3) => $row,
                'convert' => CurrencyLayer::convert($row, $amount)
            ];

        }
        return $objCurrencies;
    }

    public static function currenciesParser(array|string $to): string
    {
        $to = explode('-', $to);
        return implode(',', $to);
    }

}