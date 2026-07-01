<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Resources\Stocks\Stream\Business;
use Pjmarshall1\Massive\Resources\Stocks\Stream\Delayed;
use Pjmarshall1\Massive\Resources\Stocks\Stream\RealTime;

class Stream
{
    public function realTime(): RealTime
    {
        return new RealTime;
    }

    public function delayed(): Delayed
    {
        return new Delayed;
    }

    public function business(): Business
    {
        return new Business;
    }
}
