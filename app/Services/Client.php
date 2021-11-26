<?php

namespace App\Services;

Use App\Contracts\ConvertCurrency;
Use App\Helpers\ArrayHelper;
use App\Exceptions\CustomException;
use App\Helpers\CacheHelper;

class Client  implements ConvertCurrency
{
    const ENDPOINT = 'http://apilayer.net/api';

    /**
     * API endpoint parameters.
     */
    private $source = null;
    private $currencies = null;
    private $from = null;
    private $to = null;
    private $amount = null;
    private $date = null;
    private $access_key;

    /**
     * Constructor.
     *
     * @param string $access_key
     */
    public function __construct(string $access_key = 'a3ff3f4a3b0c5dd2deffdc3eaa07325c')
    {
        $this->access_key = $access_key;
    }

    /**
     * @param $source
     *
     * @return $this
     */
    public function source($source): Client
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param $currencies
     *
     * @return $this
     */
    public function currencies($currencies): Client
    {
        $this->currencies = $currencies;

        return $this;
    }

    /**
     * @param $from
     *
     * @return $this
     */
    public function from($from): Client
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param $to
     *
     * @return $this
     */
    public function to($to): Client
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function amount($amount): Client
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param $date
     *
     * @return $this
     */
    public function date($date): Client
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Request the API's "live" endpoint.
     *
     * @return array
     * @throws CustomException
     */
    public function live(): object
    {
        return $this->request('/live', [
            'currencies' => $this->currencies,
            'source'     => $this->source,
        ]);
    }

    /**
     * Request the API's "historical" endpoint.
     *
     * @return array
     * @throws CustomException
     */
    public function historical(): object
    {
        return $this->request('/historical', [
            'date'       => $this->date,
            'currencies' => $this->currencies,
            'source'     => $this->source,
        ]);
    }

    /**
     * @param string $endpoint
     * @param array $params
     *
     * @return array
     *@throws CustomException
     *
     */
    protected function request(string $endpoint, array $params): object
    {
         $from=$params['source'];
         $to=$this->getCurrenciesParser($params['currencies']);
         $to = preg_replace('/[\,\+]/', '', $to);

        ('/live'===$endpoint)
            ? $typeRequest='live'
            : $typeRequest='historical';

        $obj = new CacheHelper();
        $rsp = $obj->getCache($from.$to,$typeRequest);

          if($rsp  !== false) {
              $objectResponse=$rsp;
          }else {
              $params['access_key'] = $this->access_key;
              $url = self::ENDPOINT.$endpoint.'?'.http_build_query($params);
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $json = curl_exec($ch);
              curl_close($ch);
              $objectResponse = json_decode($json);
              $objectResponse->cacheTime = time();

              if (property_exists( $objectResponse,'error')) {
                  $error = $objectResponse['error'];

                  throw new CustomException($error['info'],$error['code']);
              }

              $obj->newCache($from.$to, $objectResponse,$typeRequest);
          }

          return $objectResponse;
    }

    public  function  getResponse(object $Currencies,$amount): object
    {
        return ArrayHelper::builderResponse($Currencies,$amount);
    }

    public  function getCurrenciesParser(array|string $to): string
    {
        return ArrayHelper::currenciesParser($to);
    }

    public static function convert(float $rate, float $amount): float
    {
        return floatval($amount * $rate);
    }
}
