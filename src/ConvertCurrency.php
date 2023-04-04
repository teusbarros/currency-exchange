<?php

namespace teusbarros\CurrencyExchange;

class ConvertCurrency
{
    public static function convert($value, $newCurrency): float
    {
        $value = number_format($value * (float) $newCurrency, 2, '.', '');
        return (float) $value;
    }
}
