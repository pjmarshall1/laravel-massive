<?php

namespace Pjmarshall1\Massive\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array<string, mixed> aggregates(string $ticker, int $multiplier, string $timespan, string $from, string $to, array $query = [])
 * @method static array<string, mixed> tickerDetails(string $ticker, array $query = [])
 * @method static array<string, mixed> dividends(array $query = [])
 * @method static array<string, mixed> get(string $path, array $query = [])
 *
 * @see \Pjmarshall1\Massive\Massive
 */
class Massive extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'massive';
    }
}
