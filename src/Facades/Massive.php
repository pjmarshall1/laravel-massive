<?php

namespace Pjmarshall1\Massive\Facades;

use Illuminate\Support\Facades\Facade;
use Pjmarshall1\Massive\Resources\Futures;
use Pjmarshall1\Massive\Resources\Options;
use Pjmarshall1\Massive\Resources\Stocks;

/**
 * @method static Stocks stocks()
 * @method static Options options()
 * @method static Futures futures()
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
 * @method static array<string, mixed> sma(string $ticker, array $query = [])
 * @method static array<string, mixed> ema(string $ticker, array $query = [])
 * @method static array<string, mixed> macd(string $ticker, array $query = [])
 * @method static array<string, mixed> rsi(string $ticker, array $query = [])
 * @method static array<string, mixed> exchanges(array $query = [])
 * @method static array<string, mixed> upcomingHolidays(array $query = [])
 * @method static array<string, mixed> marketStatus(array $query = [])
 * @method static array<string, mixed> conditionCodes(array $query = [])
 * @method static array<string, mixed> ipos(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> splits(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> tickerEvents(string $id, array $query = [])
 * @method static array<string, mixed> balanceSheets(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> cashFlowStatements(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> incomeStatements(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> ratios(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> shortInterest(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> shortVolume(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> freeFloat(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> edgarIndex(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> tenKSections(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> eightKText(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> thirteenF(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> riskFactors(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> riskCategories(array $query = [])
 * @method static array<string, mixed> form3(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> form4(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> news(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsContracts(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsContractOverview(string $optionsTicker, array $query = [])
 * @method static array<string, mixed> optionsCustomBars(string $optionsTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsTrades(string $optionsTicker, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsLatestTrade(string $optionsTicker, array $query = [])
 * @method static array<string, mixed> optionsQuotes(string $optionsTicker, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsSma(string $optionsTicker, array $query = [])
 * @method static array<string, mixed> optionsEma(string $optionsTicker, array $query = [])
 * @method static array<string, mixed> optionsMacd(string $optionsTicker, array $query = [])
 * @method static array<string, mixed> optionsRsi(string $optionsTicker, array $query = [])
 * @method static array<string, mixed> optionsExchanges(array $query = [])
 * @method static array<string, mixed> optionsMarketHolidays(array $query = [])
 * @method static array<string, mixed> optionsMarketStatus(array $query = [])
 * @method static array<string, mixed> optionsConditionCodes(array $query = [])
 * @method static array<string, mixed> optionsUnifiedSnapshot(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsChainSnapshot(string $underlyingAsset, array $query = [], bool $allPages = false)
 * @method static array<string, mixed> optionsContractSnapshot(string $underlyingAsset, string $optionContract)
 * @method static array<string, mixed> futuresContracts(array $query = [], bool $allPages = false)
 * @method static array<string, mixed> futuresProducts(array $query = [], bool $allPages = false)
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
