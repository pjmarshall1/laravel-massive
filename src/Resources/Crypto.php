<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Crypto\Aggregates;
use Pjmarshall1\Massive\Resources\Crypto\Indicators;
use Pjmarshall1\Massive\Resources\Crypto\MarketOperations;
use Pjmarshall1\Massive\Resources\Crypto\Snapshots;
use Pjmarshall1\Massive\Resources\Crypto\Tickers;
use Pjmarshall1\Massive\Resources\Crypto\Trades;

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

    public function aggregates(): Aggregates
    {
        return new Aggregates($this->client);
    }

    public function snapshots(): Snapshots
    {
        return new Snapshots($this->client);
    }

    public function trades(): Trades
    {
        return new Trades($this->client);
    }

    public function indicators(): Indicators
    {
        return new Indicators($this->client);
    }

    public function marketOperations(): MarketOperations
    {
        return new MarketOperations($this->client);
    }
}
