<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Stocks\Stream\Business;
use Pjmarshall1\Massive\Resources\Stocks\Stream\Delayed;
use Pjmarshall1\Massive\Resources\Stocks\Stream\RealTime;

class Stream
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function realTime(): RealTime
    {
        return new RealTime($this->client->streamUrl('stocks'));
    }

    public function delayed(): Delayed
    {
        return new Delayed($this->client->delayedStreamUrl('stocks'));
    }

    public function business(): Business
    {
        return new Business($this->client->businessStreamUrl('stocks'));
    }
}
