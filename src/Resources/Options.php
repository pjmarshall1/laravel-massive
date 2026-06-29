<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Options\Contracts;

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
}
