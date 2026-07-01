<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Futures\Stream\Delayed;
use Pjmarshall1\Massive\Resources\Futures\Stream\RealTime;

class Stream
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function realTime(): RealTime
    {
        return new RealTime($this->client->streamUrl('futures'));
    }

    public function delayed(): Delayed
    {
        return new Delayed($this->client->delayedStreamUrl('futures'));
    }
}
