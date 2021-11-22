<?php

namespace App\Contracts;

interface ConvertCurrency
{
    /**
     * @param float $rate
     * @param float $amount
     * @return float
     */
    public static function convert(float $rate, float $amount): float;
}
