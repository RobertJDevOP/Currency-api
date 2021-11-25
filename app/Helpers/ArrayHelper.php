<?php

namespace App\Helpers;

use App\Services\Client;
Use \stdClass;

class ArrayHelper
{
    public static function RequestResponse(array $currency,$from,$to,$amount): array
    {
        $value = $currency['quotes'][$from.$to];

        return ["source" => $currency["source"],
              'success' => true,
              'code' => 200,
              'created_at' => now(),
              $to=>$value,
              'total'=> Client::convert($value,$amount)];
    }

    public static function currencysParser(array|string $to): string
    {
        $to = explode('-', $to);
        return implode(',', $to);
    }

    public static function multipleRequestResponse(array $currencys, $amount): object
    {
        $objCurrencies = new stdClass();
        $objCurrencies->source = $currencys['source'];
        $objCurrencies->success =true;
        $objCurrencies->code =200;
        $objCurrencies->created_at =now();

        foreach ($currencys['quotes'] as $key => $row) {
            $objCurrencies->currencies[] = [
                 substr($key, 3) => $row,
                'total' => Client::convert($row, $amount)
            ];

        }
        return $objCurrencies;
    }
}
