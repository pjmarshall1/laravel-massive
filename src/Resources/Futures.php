<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Futures\Aggregates;
use Pjmarshall1\Massive\Resources\Futures\Contracts;
use Pjmarshall1\Massive\Resources\Futures\Products;
use Pjmarshall1\Massive\Resources\Futures\Schedules;
use Pjmarshall1\Massive\Resources\Futures\Snapshots;

class Futures
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function contracts(): Contracts
    {
        return new Contracts($this->client);
    }

    public function products(): Products
    {
        return new Products($this->client);
    }

    public function schedules(): Schedules
    {
        return new Schedules($this->client);
    }

    public function aggregates(): Aggregates
    {
        return new Aggregates($this->client);
    }

    public function snapshots(): Snapshots
    {
        return new Snapshots($this->client);
    }
}
