<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Options\Stream\Business;
use Pjmarshall1\Massive\Resources\Options\Stream\Delayed;
use Pjmarshall1\Massive\Resources\Options\Stream\RealTime;

class Stream
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function realTime(): RealTime
    {
        return new RealTime($this->client->streamUrl('options'));
    }

    public function delayed(): Delayed
    {
        return new Delayed($this->client->delayedStreamUrl('options'));
    }

    public function business(): Business
    {
        return new Business($this->client->businessStreamUrl('options'));
    }
}
