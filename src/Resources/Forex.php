<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Forex\CurrencyConversion;
use Pjmarshall1\Massive\Resources\Forex\Tickers;

class Forex
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function tickers(): Tickers
    {
        return new Tickers($this->client);
    }

    public function currencyConversion(): CurrencyConversion
    {
        return new CurrencyConversion($this->client);
    }
}
