<?php

namespace App\Contracts;

interface ConvertCurrency
{
    public static function convert(float $rate, float $amount): float;

}
