<?php

namespace Pjmarshall1\Massive;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Pjmarshall1\Massive\Exceptions\MassiveAuthenticationException;
use Pjmarshall1\Massive\Exceptions\MassiveConnectionException;
use Pjmarshall1\Massive\Exceptions\MassiveRateLimitException;
use Pjmarshall1\Massive\Exceptions\MassiveRequestException;
use Pjmarshall1\Massive\Exceptions\UnexpectedMassiveResponseException;
use Pjmarshall1\Massive\Resources\Crypto;
use Pjmarshall1\Massive\Resources\Economy;
use Pjmarshall1\Massive\Resources\Forex;
use Pjmarshall1\Massive\Resources\Futures;
use Pjmarshall1\Massive\Resources\Indices;
use Pjmarshall1\Massive\Resources\Options;
use Pjmarshall1\Massive\Resources\Stocks;

class Massive
{
    /**
     * @param  array<int, int>  $retryDelays
     */
    public function __construct(
        protected ?string $apiKey,
        protected string $baseUrl,
        protected int $timeout,
        protected int $connectTimeout,
        protected array $retryDelays,
    ) {
        //
    }

    public function stocks(): Stocks
    {
        return new Stocks($this);
    }

    public function options(): Options
    {
        return new Options($this);
    }

    public function futures(): Futures
    {
        return new Futures($this);
    }

    public function indices(): Indices
    {
        return new Indices($this);
    }

    public function forex(): Forex
    {
        return new Forex($this);
    }

    public function crypto(): Crypto
    {
        return new Crypto($this);
    }

    public function economy(): Economy
    {
        return new Economy($this);
    }

    /**
     * Retrieve reference ticker details.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tickerDetails(string $ticker, array $query = []): array
    {
        return $this->stocks()->tickers()->overview($ticker, $query);
    }

    /**
     * Retrieve dividend records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dividends(array $query = []): array
    {
        return $this->stocks()->corporateActions()->dividends($query);
    }

    /**
     * Retrieve custom aggregate bars for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $ticker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->aggregates()->customBars($ticker, $multiplier, $timespan, $from, $to, $query, $allPages);
    }

    /**
     * Retrieve grouped daily bars for the entire US stocks market.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function groupedDaily(string $date, array $query = []): array
    {
        return $this->stocks()->aggregates()->groupedDaily($date, $query);
    }

    /**
     * Retrieve daily open and close data for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dailyOpenClose(string $ticker, string $date, array $query = []): array
    {
        return $this->stocks()->aggregates()->dailyOpenClose($ticker, $date, $query);
    }

    /**
     * Retrieve the previous close for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function previousClose(string $ticker, array $query = []): array
    {
        return $this->stocks()->aggregates()->previousClose($ticker, $query);
    }

    /**
     * Retrieve the latest snapshot for a single stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function singleTickerSnapshot(string $ticker, array $query = []): array
    {
        return $this->stocks()->snapshots()->singleTicker($ticker, $query);
    }

    /**
     * Retrieve the full market snapshot for all stock tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function fullMarketSnapshot(array $query = []): array
    {
        return $this->stocks()->snapshots()->fullMarket($query);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function unifiedSnapshot(array $query = []): array
    {
        return $this->stocks()->snapshots()->unified($query);
    }

    /**
     * Retrieve top stock market movers for a direction.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function topMarketMovers(string $direction, array $query = []): array
    {
        return $this->stocks()->snapshots()->topMarketMovers($direction, $query);
    }

    /**
     * Retrieve historical trades for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historicalTrades(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->trades()->historical($ticker, $query, $allPages);
    }

    /**
     * Retrieve the latest trade for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latestTrade(string $ticker, array $query = []): array
    {
        return $this->stocks()->trades()->latest($ticker, $query);
    }

    /**
     * Retrieve historical quotes for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historicalQuotes(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->quotes()->historical($ticker, $query, $allPages);
    }

    /**
     * Retrieve the latest quote for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latestQuote(string $ticker, array $query = []): array
    {
        return $this->stocks()->quotes()->latest($ticker, $query);
    }

    /**
     * Retrieve the simple moving average for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->sma($ticker, $query);
    }

    /**
     * Retrieve the exponential moving average for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->ema($ticker, $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->macd($ticker, $query);
    }

    /**
     * Retrieve the relative strength index for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->rsi($ticker, $query);
    }

    /**
     * Retrieve known exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function exchanges(array $query = []): array
    {
        return $this->stocks()->marketOperations()->exchanges($query);
    }

    /**
     * Retrieve upcoming market holidays.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function upcomingHolidays(array $query = []): array
    {
        return $this->stocks()->marketOperations()->upcomingHolidays($query);
    }

    /**
     * Retrieve the current market status.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function marketStatus(array $query = []): array
    {
        return $this->stocks()->marketOperations()->marketStatus($query);
    }

    /**
     * Retrieve trade and quote condition codes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function conditionCodes(array $query = []): array
    {
        return $this->stocks()->marketOperations()->conditionCodes($query);
    }

    /**
     * Retrieve initial public offerings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ipos(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->corporateActions()->ipos($query, $allPages);
    }

    /**
     * Retrieve stock split events.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function splits(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->corporateActions()->splits($query, $allPages);
    }

    /**
     * Retrieve ticker event history.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tickerEvents(string $id, array $query = []): array
    {
        return $this->stocks()->corporateActions()->tickerEvents($id, $query);
    }

    /**
     * Retrieve balance sheet data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function balanceSheets(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->balanceSheets($query, $allPages);
    }

    /**
     * Retrieve cash flow statement data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cashFlowStatements(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->cashFlowStatements($query, $allPages);
    }

    /**
     * Retrieve income statement data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function incomeStatements(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->incomeStatements($query, $allPages);
    }

    /**
     * Retrieve financial ratios.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ratios(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->ratios($query, $allPages);
    }

    /**
     * Retrieve short interest data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function shortInterest(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->shortInterest($query, $allPages);
    }

    /**
     * Retrieve short volume data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function shortVolume(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->shortVolume($query, $allPages);
    }

    /**
     * Retrieve free float data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function freeFloat(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->fundamentals()->freeFloat($query, $allPages);
    }

    /**
     * Retrieve the SEC EDGAR filings index.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function edgarIndex(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->edgarIndex($query, $allPages);
    }

    /**
     * Retrieve 10-K filing sections.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tenKSections(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->tenKSections($query, $allPages);
    }

    /**
     * Retrieve 8-K filing text.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function eightKText(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->eightKText($query, $allPages);
    }

    /**
     * Retrieve 13-F filings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function thirteenF(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->thirteenF($query, $allPages);
    }

    /**
     * Retrieve standardized risk factor disclosures.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function riskFactors(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->riskFactors($query, $allPages);
    }

    /**
     * Retrieve the risk factor taxonomy.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function riskCategories(array $query = []): array
    {
        return $this->stocks()->filings()->riskCategories($query);
    }

    /**
     * Retrieve Form 3 filings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function form3(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->form3($query, $allPages);
    }

    /**
     * Retrieve Form 4 filings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function form4(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->filings()->form4($query, $allPages);
    }

    /**
     * Retrieve stock news articles.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function news(array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->news()->articles($query, $allPages);
    }

    /**
     * Retrieve options contracts.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsContracts(array $query = [], bool $allPages = false): array
    {
        return $this->options()->contracts()->allContracts($query, $allPages);
    }

    /**
     * Retrieve an options contract overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsContractOverview(string $optionsTicker, array $query = []): array
    {
        return $this->options()->contracts()->overview($optionsTicker, $query);
    }

    /**
     * Retrieve custom aggregate bars for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsCustomBars(string $optionsTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        return $this->options()->aggregates()->customBars($optionsTicker, $multiplier, $timespan, $from, $to, $query, $allPages);
    }

    /**
     * Retrieve historical trades for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsTrades(string $optionsTicker, array $query = [], bool $allPages = false): array
    {
        return $this->options()->trades()->historical($optionsTicker, $query, $allPages);
    }

    /**
     * Retrieve the latest trade for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsLatestTrade(string $optionsTicker, array $query = []): array
    {
        return $this->options()->trades()->latest($optionsTicker, $query);
    }

    /**
     * Retrieve historical quotes for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsQuotes(string $optionsTicker, array $query = [], bool $allPages = false): array
    {
        return $this->options()->quotes()->historical($optionsTicker, $query, $allPages);
    }

    /**
     * Retrieve the simple moving average for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsSma(string $optionsTicker, array $query = []): array
    {
        return $this->options()->indicators()->sma($optionsTicker, $query);
    }

    /**
     * Retrieve the exponential moving average for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsEma(string $optionsTicker, array $query = []): array
    {
        return $this->options()->indicators()->ema($optionsTicker, $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsMacd(string $optionsTicker, array $query = []): array
    {
        return $this->options()->indicators()->macd($optionsTicker, $query);
    }

    /**
     * Retrieve the relative strength index for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsRsi(string $optionsTicker, array $query = []): array
    {
        return $this->options()->indicators()->rsi($optionsTicker, $query);
    }

    /**
     * Retrieve known options exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsExchanges(array $query = []): array
    {
        return $this->options()->marketOperations()->exchanges($query);
    }

    /**
     * Retrieve upcoming options market holidays.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsMarketHolidays(array $query = []): array
    {
        return $this->options()->marketOperations()->marketHolidays($query);
    }

    /**
     * Retrieve the current market status.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsMarketStatus(array $query = []): array
    {
        return $this->options()->marketOperations()->marketStatus($query);
    }

    /**
     * Retrieve options trade and quote condition codes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsConditionCodes(array $query = []): array
    {
        return $this->options()->marketOperations()->conditionCodes($query);
    }

    /**
     * Retrieve unified options snapshots.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsUnifiedSnapshot(array $query = [], bool $allPages = false): array
    {
        return $this->options()->snapshots()->unified($query, $allPages);
    }

    /**
     * Retrieve an option chain snapshot for an underlying asset.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function optionsChainSnapshot(string $underlyingAsset, array $query = [], bool $allPages = false): array
    {
        return $this->options()->snapshots()->chain($underlyingAsset, $query, $allPages);
    }

    /**
     * Retrieve a snapshot for a single options contract.
     *
     * @return array<string, mixed>
     */
    public function optionsContractSnapshot(string $underlyingAsset, string $optionContract): array
    {
        return $this->options()->snapshots()->contract($underlyingAsset, $optionContract);
    }

    /**
     * Retrieve futures contracts.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresContracts(array $query = [], bool $allPages = false): array
    {
        return $this->futures()->contracts()->allContracts($query, $allPages);
    }

    /**
     * Retrieve futures products.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresProducts(array $query = [], bool $allPages = false): array
    {
        return $this->futures()->products()->allProducts($query, $allPages);
    }

    /**
     * Retrieve futures schedules.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresSchedules(array $query = [], bool $allPages = false): array
    {
        return $this->futures()->schedules()->allSchedules($query, $allPages);
    }

    /**
     * Retrieve aggregate bars for a futures contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresAggregateBars(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->futures()->aggregates()->aggregateBars($ticker, $query, $allPages);
    }

    /**
     * Retrieve futures contract snapshots.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresContractSnapshots(array $query = [], bool $allPages = false): array
    {
        return $this->futures()->snapshots()->contractSnapshots($query, $allPages);
    }

    /**
     * Retrieve historical trades for a futures contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresTrades(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->futures()->trades()->historical($ticker, $query, $allPages);
    }

    /**
     * Retrieve historical quotes for a futures contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresQuotes(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->futures()->quotes()->historical($ticker, $query, $allPages);
    }

    /**
     * Retrieve current futures market status records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresMarketStatus(array $query = [], bool $allPages = false): array
    {
        return $this->futures()->marketOperations()->marketStatus($query, $allPages);
    }

    /**
     * Retrieve supported futures exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function futuresExchanges(array $query = [], bool $allPages = false): array
    {
        return $this->futures()->marketOperations()->exchanges($query, $allPages);
    }

    /**
     * Retrieve index tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesTickers(array $query = [], bool $allPages = false): array
    {
        return $this->indices()->tickers()->allTickers($query, $allPages);
    }

    /**
     * Retrieve an index ticker overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesTickerOverview(string $ticker, array $query = []): array
    {
        return $this->indices()->tickers()->overview($ticker, $query);
    }

    /**
     * Retrieve custom aggregate bars for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesCustomBars(string $indicesTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        return $this->indices()->aggregates()->customBars($indicesTicker, $multiplier, $timespan, $from, $to, $query, $allPages);
    }

    /**
     * Retrieve the previous close for an index ticker.
     *
     * @return array<string, mixed>
     */
    public function indicesPreviousClose(string $indicesTicker): array
    {
        return $this->indices()->aggregates()->previousClose($indicesTicker);
    }

    /**
     * Retrieve daily open and close data for an index ticker.
     *
     * @return array<string, mixed>
     */
    public function indicesDailyOpenClose(string $indicesTicker, string $date): array
    {
        return $this->indices()->aggregates()->dailyOpenClose($indicesTicker, $date);
    }

    /**
     * Retrieve snapshots for one or more indices.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesSnapshots(array $query = [], bool $allPages = false): array
    {
        return $this->indices()->snapshots()->indices($query, $allPages);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesUnifiedSnapshot(array $query = [], bool $allPages = false): array
    {
        return $this->indices()->snapshots()->unified($query, $allPages);
    }

    /**
     * Retrieve the simple moving average for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesSma(string $indicesTicker, array $query = []): array
    {
        return $this->indices()->indicators()->sma($indicesTicker, $query);
    }

    /**
     * Retrieve the exponential moving average for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesEma(string $indicesTicker, array $query = []): array
    {
        return $this->indices()->indicators()->ema($indicesTicker, $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesMacd(string $indicesTicker, array $query = []): array
    {
        return $this->indices()->indicators()->macd($indicesTicker, $query);
    }

    /**
     * Retrieve the relative strength index for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesRsi(string $indicesTicker, array $query = []): array
    {
        return $this->indices()->indicators()->rsi($indicesTicker, $query);
    }

    /**
     * Retrieve upcoming index market holidays.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesMarketHolidays(array $query = []): array
    {
        return $this->indices()->marketOperations()->marketHolidays($query);
    }

    /**
     * Retrieve the current index market status.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indicesMarketStatus(array $query = []): array
    {
        return $this->indices()->marketOperations()->marketStatus($query);
    }

    /**
     * Retrieve forex tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexTickers(array $query = [], bool $allPages = false): array
    {
        return $this->forex()->tickers()->allTickers($query, $allPages);
    }

    /**
     * Retrieve a forex ticker overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexTickerOverview(string $ticker, array $query = []): array
    {
        return $this->forex()->tickers()->overview($ticker, $query);
    }

    /**
     * Retrieve crypto tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoTickers(array $query = [], bool $allPages = false): array
    {
        return $this->crypto()->tickers()->allTickers($query, $allPages);
    }

    /**
     * Retrieve a crypto ticker overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoTickerOverview(string $ticker, array $query = []): array
    {
        return $this->crypto()->tickers()->overview($ticker, $query);
    }

    /**
     * Retrieve custom aggregate bars for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoCustomBars(string $cryptoTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        return $this->crypto()->aggregates()->customBars($cryptoTicker, $multiplier, $timespan, $from, $to, $query, $allPages);
    }

    /**
     * Retrieve daily market summary bars for all crypto tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoDailyMarketSummary(string $date, array $query = []): array
    {
        return $this->crypto()->aggregates()->dailyMarketSummary($date, $query);
    }

    /**
     * Retrieve the daily open and close summary for a crypto pair.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoDailyTickerSummary(string $from, string $to, string $date, array $query = []): array
    {
        return $this->crypto()->aggregates()->dailyTickerSummary($from, $to, $date, $query);
    }

    /**
     * Retrieve the previous close for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoPreviousClose(string $cryptoTicker, array $query = []): array
    {
        return $this->crypto()->aggregates()->previousClose($cryptoTicker, $query);
    }

    /**
     * Retrieve the latest snapshot for a single crypto ticker.
     *
     * @return array<string, mixed>
     */
    public function cryptoSingleTickerSnapshot(string $ticker): array
    {
        return $this->crypto()->snapshots()->singleTicker($ticker);
    }

    /**
     * Retrieve the full market snapshot for crypto tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoFullMarketSnapshot(array $query = []): array
    {
        return $this->crypto()->snapshots()->fullMarket($query);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoUnifiedSnapshot(array $query = [], bool $allPages = false): array
    {
        return $this->crypto()->snapshots()->unified($query, $allPages);
    }

    /**
     * Retrieve top crypto market movers for a direction.
     *
     * @return array<string, mixed>
     */
    public function cryptoTopMarketMovers(string $direction): array
    {
        return $this->crypto()->snapshots()->topMarketMovers($direction);
    }

    /**
     * Retrieve historical trades for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoTrades(string $cryptoTicker, array $query = [], bool $allPages = false): array
    {
        return $this->crypto()->trades()->historical($cryptoTicker, $query, $allPages);
    }

    /**
     * Retrieve the latest trade for a crypto pair.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoLatestTrade(string $from, string $to, array $query = []): array
    {
        return $this->crypto()->trades()->latest($from, $to, $query);
    }

    /**
     * Retrieve the simple moving average for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoSma(string $cryptoTicker, array $query = []): array
    {
        return $this->crypto()->indicators()->sma($cryptoTicker, $query);
    }

    /**
     * Retrieve the exponential moving average for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoEma(string $cryptoTicker, array $query = []): array
    {
        return $this->crypto()->indicators()->ema($cryptoTicker, $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoMacd(string $cryptoTicker, array $query = []): array
    {
        return $this->crypto()->indicators()->macd($cryptoTicker, $query);
    }

    /**
     * Retrieve the relative strength index for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoRsi(string $cryptoTicker, array $query = []): array
    {
        return $this->crypto()->indicators()->rsi($cryptoTicker, $query);
    }

    /**
     * Retrieve known crypto exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoExchanges(array $query = []): array
    {
        return $this->crypto()->marketOperations()->exchanges($query);
    }

    /**
     * Retrieve upcoming crypto market holidays.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoMarketHolidays(array $query = []): array
    {
        return $this->crypto()->marketOperations()->marketHolidays($query);
    }

    /**
     * Retrieve the current crypto market status.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoMarketStatus(array $query = []): array
    {
        return $this->crypto()->marketOperations()->marketStatus($query);
    }

    /**
     * Retrieve crypto trade condition codes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cryptoConditionCodes(array $query = []): array
    {
        return $this->crypto()->marketOperations()->conditionCodes($query);
    }

    /**
     * Retrieve real-time currency conversion rates.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexCurrencyConversion(string $from, string $to, array $query = []): array
    {
        return $this->forex()->currencyConversion()->convert($from, $to, $query);
    }

    /**
     * Retrieve custom aggregate bars for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexCustomBars(string $forexTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        return $this->forex()->aggregates()->customBars($forexTicker, $multiplier, $timespan, $from, $to, $query, $allPages);
    }

    /**
     * Retrieve daily market summary bars for all forex tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexDailyMarketSummary(string $date, array $query = []): array
    {
        return $this->forex()->aggregates()->dailyMarketSummary($date, $query);
    }

    /**
     * Retrieve the previous close for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexPreviousClose(string $forexTicker, array $query = []): array
    {
        return $this->forex()->aggregates()->previousClose($forexTicker, $query);
    }

    /**
     * Retrieve the latest snapshot for a single forex ticker.
     *
     * @return array<string, mixed>
     */
    public function forexSingleTickerSnapshot(string $ticker): array
    {
        return $this->forex()->snapshots()->singleTicker($ticker);
    }

    /**
     * Retrieve the full market snapshot for forex tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexFullMarketSnapshot(array $query = []): array
    {
        return $this->forex()->snapshots()->fullMarket($query);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexUnifiedSnapshot(array $query = [], bool $allPages = false): array
    {
        return $this->forex()->snapshots()->unified($query, $allPages);
    }

    /**
     * Retrieve top forex market movers for a direction.
     *
     * @return array<string, mixed>
     */
    public function forexTopMarketMovers(string $direction): array
    {
        return $this->forex()->snapshots()->topMarketMovers($direction);
    }

    /**
     * Retrieve historical quotes for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexQuotes(string $fxTicker, array $query = [], bool $allPages = false): array
    {
        return $this->forex()->quotes()->historical($fxTicker, $query, $allPages);
    }

    /**
     * Retrieve the latest quote for a forex currency pair.
     *
     * @return array<string, mixed>
     */
    public function forexLastQuote(string $from, string $to): array
    {
        return $this->forex()->quotes()->latest($from, $to);
    }

    /**
     * Retrieve the simple moving average for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexSma(string $fxTicker, array $query = []): array
    {
        return $this->forex()->indicators()->sma($fxTicker, $query);
    }

    /**
     * Retrieve the exponential moving average for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexEma(string $fxTicker, array $query = []): array
    {
        return $this->forex()->indicators()->ema($fxTicker, $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexMacd(string $fxTicker, array $query = []): array
    {
        return $this->forex()->indicators()->macd($fxTicker, $query);
    }

    /**
     * Retrieve the relative strength index for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexRsi(string $fxTicker, array $query = []): array
    {
        return $this->forex()->indicators()->rsi($fxTicker, $query);
    }

    /**
     * Retrieve known forex exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexExchanges(array $query = []): array
    {
        return $this->forex()->marketOperations()->exchanges($query);
    }

    /**
     * Retrieve upcoming forex market holidays.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexMarketHolidays(array $query = []): array
    {
        return $this->forex()->marketOperations()->marketHolidays($query);
    }

    /**
     * Retrieve the current forex market status.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function forexMarketStatus(array $query = []): array
    {
        return $this->forex()->marketOperations()->marketStatus($query);
    }

    /**
     * Retrieve treasury yield data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function economyTreasuryYields(array $query = [], bool $allPages = false): array
    {
        return $this->economy()->treasuryYields($query, $allPages);
    }

    /**
     * Retrieve inflation data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function economyInflation(array $query = [], bool $allPages = false): array
    {
        return $this->economy()->inflation($query, $allPages);
    }

    /**
     * Retrieve inflation expectation data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function economyInflationExpectations(array $query = [], bool $allPages = false): array
    {
        return $this->economy()->inflationExpectations($query, $allPages);
    }

    /**
     * Retrieve labor market data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function economyLaborMarket(array $query = [], bool $allPages = false): array
    {
        return $this->economy()->laborMarket($query, $allPages);
    }

    /**
     * Send a GET request to a Massive REST endpoint.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array
    {
        $path = $this->normalizePath($path);

        try {
            $response = $query === []
                ? $this->requestFor($path)->get($path)
                : $this->requestFor($path)->get($path, $query);

            $response->throw();
        } catch (ConnectionException $exception) {
            throw new MassiveConnectionException($path, $exception);
        } catch (RequestException $exception) {
            throw $this->requestExceptionFor($path, $exception);
        }

        $json = $response->json();

        if (! is_array($json)) {
            throw new UnexpectedMassiveResponseException($path);
        }

        return $json;
    }

    /**
     * Send GET requests until a paginated Massive endpoint has no next page.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function getAllPages(string $path, array $query = [], string $resultsKey = 'results'): array
    {
        $response = $this->get($path, $query);
        $results = $response[$resultsKey] ?? [];
        $nextUrl = $response['next_url'] ?? null;

        while (is_string($nextUrl) && $nextUrl !== '') {
            $nextResponse = $this->get($nextUrl);

            $results = [
                ...$results,
                ...($nextResponse[$resultsKey] ?? []),
            ];

            $nextUrl = $nextResponse['next_url'] ?? null;
        }

        $response[$resultsKey] = $results;
        unset($response['next_url']);

        return $response;
    }

    public function request(): PendingRequest
    {
        return $this->baseRequest()->baseUrl($this->baseUrl);
    }

    protected function requestFor(string $path): PendingRequest
    {
        $request = $this->baseRequest();

        if (! $this->isAbsoluteUrl($path)) {
            $request = $request->baseUrl($this->baseUrl);
        }

        return $request;
    }

    protected function requestExceptionFor(string $path, RequestException $exception): MassiveRequestException
    {
        return match ($exception->response->status()) {
            401, 403 => MassiveAuthenticationException::fromRequestException($path, $exception),
            429 => MassiveRateLimitException::fromRequestException($path, $exception),
            default => MassiveRequestException::fromRequestException($path, $exception),
        };
    }

    protected function baseRequest(): PendingRequest
    {
        $request = Http::acceptJson()
            ->timeout($this->timeout)
            ->connectTimeout($this->connectTimeout);

        if (is_string($this->apiKey) && $this->apiKey !== '') {
            $request = $request->withToken($this->apiKey);
        }

        if ($this->retryDelays !== []) {
            $request = $request->retry($this->retryDelays);
        }

        return $request;
    }

    protected function normalizePath(string $path): string
    {
        if ($this->isAbsoluteUrl($path)) {
            return $path;
        }

        return '/'.ltrim($path, '/');
    }

    protected function isAbsoluteUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }
}
