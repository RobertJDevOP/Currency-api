<?php

namespace App\Helpers;

use App\Exceptions\CustomException;
use App\Services\CurrencyLayer;
use App\Cache\CacheFile;

class ResponseHelper extends CurrencyLayer
{
    /**
     * @param string $endpoint
     * @param array $params
     * @param string $acceskey
     * @return object
     * @throws CustomException
     */
    public static function builderResponse(string $endpoint, array $params,string $acceskey): object
    {
        $from = $params['source'];
        $to = self::getCurrenciesParser($params['currencies']);
        $to = preg_replace('/[\,\+]/', '', $to);

        ('/live' === $endpoint)
            ? $typeRequest = 'live'
            : $typeRequest = 'historical';

        $obj = new CacheFile();
        $rsp = $obj->getCache($from . $to, $typeRequest);

        if ($rsp !== false) {
            $objectResponse = $rsp;
        } else {
            $params['access_key'] = $acceskey;
            $url = self::ENDPOINT . $endpoint . '?' . http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
            curl_close($ch);
            $objectResponse = json_decode($json);
            $objectResponse->cacheTime = time();

            if (property_exists($objectResponse, 'error')) {
                $error = $objectResponse['error'];

                throw new CustomException($error['info'], $error['code']);
            }

            $obj->newCache($from . $to, $objectResponse, $typeRequest);
        }
        return  $objectResponse;
    }

}
