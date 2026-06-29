<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Stocks\Aggregates;
use Pjmarshall1\Massive\Resources\Stocks\CorporateActions;
use Pjmarshall1\Massive\Resources\Stocks\Filings;
use Pjmarshall1\Massive\Resources\Stocks\Fundamentals;
use Pjmarshall1\Massive\Resources\Stocks\Indicators;
use Pjmarshall1\Massive\Resources\Stocks\MarketOperations;
use Pjmarshall1\Massive\Resources\Stocks\News;
use Pjmarshall1\Massive\Resources\Stocks\Quotes;
use Pjmarshall1\Massive\Resources\Stocks\Snapshots;
use Pjmarshall1\Massive\Resources\Stocks\Tickers;
use Pjmarshall1\Massive\Resources\Stocks\Trades;

class Stocks
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

    public function corporateActions(): CorporateActions
    {
        return new CorporateActions($this->client);
    }

    public function fundamentals(): Fundamentals
    {
        return new Fundamentals($this->client);
    }

    public function filings(): Filings
    {
        return new Filings($this->client);
    }

    public function news(): News
    {
        return new News($this->client);
    }
}
