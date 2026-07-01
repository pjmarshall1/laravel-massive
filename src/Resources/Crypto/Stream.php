<?php

namespace Pjmarshall1\Massive\Resources\Crypto;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Crypto\Stream\Business;
use Pjmarshall1\Massive\Resources\Crypto\Stream\RealTime;

class Stream
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function realTime(): RealTime
    {
        return new RealTime($this->client->streamUrl('crypto'));
    }

    public function business(): Business
    {
        return new Business($this->client->businessStreamUrl('crypto'));
    }
}
