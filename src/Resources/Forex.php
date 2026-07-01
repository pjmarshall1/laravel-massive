<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Forex\Aggregates;
use Pjmarshall1\Massive\Resources\Forex\CurrencyConversion;
use Pjmarshall1\Massive\Resources\Forex\Indicators;
use Pjmarshall1\Massive\Resources\Forex\MarketOperations;
use Pjmarshall1\Massive\Resources\Forex\Quotes;
use Pjmarshall1\Massive\Resources\Forex\Snapshots;
use Pjmarshall1\Massive\Resources\Forex\Stream;
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

    public function aggregates(): Aggregates
    {
        return new Aggregates($this->client);
    }

    public function stream(): Stream
    {
        return new Stream($this->client);
    }

    public function snapshots(): Snapshots
    {
        return new Snapshots($this->client);
    }

    public function quotes(): Quotes
    {
        return new Quotes($this->client);
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
