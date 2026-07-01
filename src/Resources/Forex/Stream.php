<?php

namespace Pjmarshall1\Massive\Resources\Forex;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Forex\Stream\Business;
use Pjmarshall1\Massive\Resources\Forex\Stream\RealTime;

class Stream
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function realTime(): RealTime
    {
        return new RealTime($this->client->streamUrl('forex'));
    }

    public function business(): Business
    {
        return new Business($this->client->businessStreamUrl('forex'));
    }
}
