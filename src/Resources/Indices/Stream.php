<?php

namespace Pjmarshall1\Massive\Resources\Indices;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Indices\Stream\Business;
use Pjmarshall1\Massive\Resources\Indices\Stream\Delayed;
use Pjmarshall1\Massive\Resources\Indices\Stream\RealTime;

class Stream
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function realTime(): RealTime
    {
        return new RealTime($this->client->streamUrl('indices'));
    }

    public function delayed(): Delayed
    {
        return new Delayed($this->client->delayedStreamUrl('indices'));
    }

    public function business(): Business
    {
        return new Business($this->client->businessStreamUrl('indices'));
    }
}
