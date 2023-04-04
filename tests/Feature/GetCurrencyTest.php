<?php

namespace teusbarros\CurrencyExchange\Tests\Feature;

use teusbarros\CurrencyExchange\ConvertCurrency;
use teusbarros\CurrencyExchange\GetCurrency;
use teusbarros\CurrencyExchange\Tests\TestCase;

class GetCurrencyTest extends TestCase
{
    /** @test  */
    public function test_can_get_currency_and_convert_value()
    {
        $todayCurrency = 1.09;
        $this->mock(GetCurrency::class)
            ->shouldReceive('execute')
            ->with('USD')
            ->andReturn($todayCurrency);

        $this->assertEquals(10.9, ConvertCurrency::convert(10, $todayCurrency));
    }
}