<?php

namespace Pjmarshall1\Massive\Facades;

use Illuminate\Support\Facades\Facade;
use Pjmarshall1\Massive\Resources\Stocks;

/**
 * @method static Stocks stocks()
 * @method static array<string, mixed> tickerDetails(string $ticker, array $query = [])
 * @method static array<string, mixed> dividends(array $query = [])
 * @method static array<string, mixed> get(string $path, array $query = [])
 * @method static array<string, mixed> getAllPages(string $path, array $query = [], string $resultsKey = 'results')
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
