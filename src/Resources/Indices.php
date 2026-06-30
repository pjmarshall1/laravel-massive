<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Indices\Aggregates;
use Pjmarshall1\Massive\Resources\Indices\Tickers;

class Indices
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function tickers(): Tickers
    {
        return new Tickers($this->client);
    }

    public function aggregates(): Aggregates
    {
        return new Aggregates($this->client);
    }
}
