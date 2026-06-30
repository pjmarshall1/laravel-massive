<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Crypto\Tickers;

class Crypto
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function tickers(): Tickers
    {
        return new Tickers($this->client);
    }
}
