<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Options\Aggregates;
use Pjmarshall1\Massive\Resources\Options\Contracts;
use Pjmarshall1\Massive\Resources\Options\Indicators;
use Pjmarshall1\Massive\Resources\Options\MarketOperations;
use Pjmarshall1\Massive\Resources\Options\Quotes;
use Pjmarshall1\Massive\Resources\Options\Snapshots;
use Pjmarshall1\Massive\Resources\Options\Stream;
use Pjmarshall1\Massive\Resources\Options\Trades;

class Options
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function contracts(): Contracts
    {
        return new Contracts($this->client);
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
}
