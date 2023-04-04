<?php

namespace teusbarros\CurrencyExchange;

use Illuminate\Support\Facades\Http;

class GetCurrency
{
    public function execute($currency): float|null
    {
        $response = Http::get("https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");

        $currencies = $this->getCurrencies($response->body());

        return $currencies[$currency] ?? null;
    }

    public function getCurrencies($data): array
    {
        $result = [];

        $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        foreach ($array['Cube']['Cube']['Cube'] as $currency) {
            // set the currency abbreviation as the array key i.e: $result['USD'] = 1.08
            $result[$currency['@attributes']['currency']] = $currency['@attributes']['rate'];
        }

        return $result;
    }
}
