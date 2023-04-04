<?php

namespace teusbarros\CurrencyExchange\Tests\Feature;

use teusbarros\CurrencyExchange\ConvertCurrency;
use teusbarros\CurrencyExchange\Tests\TestCase;

class ConvertCurrencyTest extends TestCase
{
    /** @test  */
    public function test_currency_is_converted_correctly()
    {
        $this->assertEquals(10.00, ConvertCurrency::convert(20, 0.5));
    }
}