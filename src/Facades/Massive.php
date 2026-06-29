<?php

namespace Pjmarshall1\Massive\Facades;

use Illuminate\Support\Facades\Facade;
use Pjmarshall1\Massive\Resources\Stocks;

/**
 * @method static Stocks stocks()
 * @method static array<string, mixed> tickerDetails(string $ticker, array $query = [])
 * @method static array<string, mixed> dividends(array $query = [])
 * @method static array<string, mixed> customBars(string $ticker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> groupedDaily(string $date, array $query = [])
 * @method static array<string, mixed> dailyOpenClose(string $ticker, string $date, array $query = [])
 * @method static array<string, mixed> previousClose(string $ticker, array $query = [])
 * @method static array<string, mixed> singleTickerSnapshot(string $ticker, array $query = [])
 * @method static array<string, mixed> fullMarketSnapshot(array $query = [])
 * @method static array<string, mixed> unifiedSnapshot(array $query = [])
 * @method static array<string, mixed> topMarketMovers(string $direction, array $query = [])
 * @method static array<string, mixed> historicalTrades(string $ticker, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> latestTrade(string $ticker, array $query = [])
 * @method static array<string, mixed> historicalQuotes(string $ticker, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> latestQuote(string $ticker, array $query = [])
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
