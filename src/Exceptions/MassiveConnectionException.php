<?php

namespace Pjmarshall1\Massive\Exceptions;

use Throwable;

class MassiveConnectionException extends MassiveException
{
    public function __construct(
        protected string $path,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf('Massive request to [%s] failed to connect.', $path), 0, $previous);
    }

    public function path(): string
    {
        return $this->path;
    }
}
