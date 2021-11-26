<?php

namespace App\Services;

Use App\Contracts\ConvertCurrency;
Use App\Helpers\ObjectHelper;
use App\Exceptions\CustomException;
use App\Helpers\ResponseHelper;

class CurrencyLayer  implements ConvertCurrency
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
     * @param string $access_key
     */
    public function __construct(string $access_key = 'a3ff3f4a3b0c5dd2deffdc3eaa07325c')
    {
        $this->access_key = $access_key;
    }

    /**
     * @param $source
     * @return $this
     */
    public function source($source): CurrencyLayer
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @param $currencies
     * @return $this
     */
    public function currencies($currencies): CurrencyLayer
    {
        $this->currencies = $currencies;
        return $this;
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from): CurrencyLayer
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param $to
     * @return $this
     */
    public function to($to): CurrencyLayer
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function amount($amount): CurrencyLayer
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param $date
     * @return $this
     */
    public function date($date): CurrencyLayer
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
     * @return object
     *@throws CustomException
     */
    protected function request(string $endpoint, array $params): object
    {
        return ResponseHelper::builderResponse( $endpoint,$params,$this->access_key);
    }

    public  function  getResponse(object $Currencies,$amount): object
    {
        return ObjectHelper::builderObject($Currencies,$amount);
    }

    static  function getCurrenciesParser(array|string $to): string
    {
        return ObjectHelper::parserCurrencies($to);
    }

    public static function convert(float $rate, float $amount): float
    {
        return floatval($amount * $rate);
    }
}
