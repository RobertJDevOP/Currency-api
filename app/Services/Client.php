<?php

namespace App\Services;

Use App\Contracts\ConvertCurrency;
Use App\Helpers\ArrayHelper;
use App\Exceptions\CustomException;

class Client extends ArrayHelper implements ConvertCurrency
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
    public function __construct(string $access_key = '5055a16e38adba2a3fbfd77331ed6e94')
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
     */
    public function live(): array
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
     */
    public function historical(): array
    {
        return $this->request('/historical', [
            'date'       => $this->date,
            'currencies' => $this->currencies,
            'source'     => $this->source,
        ]);
    }

    /**
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return array
     *@throws CustomException
     *
     */
    protected function request(string $endpoint, array $params): array
    {
        $params['access_key'] = $this->access_key;
        $url = self::ENDPOINT.$endpoint.'?'.http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $rsp = json_decode($json, true);

        if (array_key_exists('error', $rsp)) {
            $error = $rsp['error'];

            throw new CustomException($error['info'],$error['code']);
        }

        return $rsp;
    }


    public static function convert(float $rate, float $amount): float
    {
        return floatval($amount * $rate);
    }
}
