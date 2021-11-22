<?php

namespace App\Helpers;

use App\Services\Client;
Use \stdClass;

class ArrayHelper
{
    public static function dataObject(array $currency,$from,$to,$amount): array
    {
        $value = $currency['quotes'][$from.$to];

        return ["source" => $currency["source"],
            $to=>$value,
            'total'=> Client::convert($value,$amount)];
    }

    public static function dataParser(array|string $to): string
    {
        $to = explode('-', $to);
        return implode(',', $to);
    }

    public static function dataObjects(array $currencys, $amount): object
    {
        $objCurrencys = new stdClass();
        $objCurrencys->source = $currencys['source'];

        foreach ($currencys['quotes'] as $key => $row) {
            $objCurrencys->currencies[] = array([
                substr($key, 3) => $row,
                'total' => Client::convert($row, $amount)
            ]);

        }
        return $objCurrencys;
    }
}
