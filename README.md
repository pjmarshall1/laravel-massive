# Laravel Massive

A Laravel-native client for the [Massive](https://massive.com) REST API.

This package intentionally uses Laravel's built-in HTTP client instead of Massive's PHP SDK.

## Installation

Require the package with Composer:

```bash
composer require pjmarshall1/laravel-massive
```

Laravel will auto-discover the package service provider and facade.

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=massive-config
```

Add your Massive API key to `.env`:

```dotenv
MASSIVE_API_KEY=your-api-key
```

Optional environment variables:

```dotenv
MASSIVE_BASE_URL=https://api.massive.com
MASSIVE_TIMEOUT=10
MASSIVE_CONNECT_TIMEOUT=3
```

## Usage

Resolve the client from Laravel's container:

```php
use Pjmarshall1\Massive\Massive;

$massive = app(Massive::class);

$overview = $massive->stocks()->tickers()->overview('AAPL');
```

Or use the facade:

```php
use Pjmarshall1\Massive\Facades\Massive;

$details = Massive::tickerDetails('AAPL');
```

## Available Methods

### Generic GET Requests

Use `get` for any REST endpoint that is not wrapped yet:

```php
$response = Massive::get('/v3/reference/tickers', [
    'ticker' => 'AAPL',
]);
```

### Stock Tickers

```php
$tickers = Massive::stocks()->tickers()->allTickers([
    'market' => 'stocks',
    'active' => 'true',
]);

$allTickers = Massive::stocks()->tickers()->allTickers([
    'market' => 'stocks',
    'active' => 'true',
], allPages: true);

$overview = Massive::stocks()->tickers()->overview('AAPL');
$types = Massive::stocks()->tickers()->types();
$related = Massive::stocks()->tickers()->related('AAPL');
```

### Stock Aggregates

```php
$bars = Massive::stocks()->aggregates()->customBars(
    ticker: 'AAPL',
    multiplier: 1,
    timespan: 'day',
    from: '2024-01-01',
    to: '2024-01-31',
    query: ['adjusted' => true],
);

$allBars = Massive::stocks()->aggregates()->customBars(
    ticker: 'AAPL',
    multiplier: 1,
    timespan: 'day',
    from: '2024-01-01',
    to: '2024-01-31',
    query: ['limit' => 5000],
    allPages: true,
);

$grouped = Massive::stocks()->aggregates()->groupedDaily('2024-01-31', [
    'adjusted' => true,
]);

$openClose = Massive::stocks()->aggregates()->dailyOpenClose('AAPL', '2024-01-31', [
    'adjusted' => true,
]);

$previousClose = Massive::stocks()->aggregates()->previousClose('AAPL', [
    'adjusted' => true,
]);
```

### Stock Snapshots

```php
$singleTicker = Massive::stocks()->snapshots()->singleTicker('AAPL');

$fullMarket = Massive::stocks()->snapshots()->fullMarket();

$unified = Massive::stocks()->snapshots()->unified([
    'ticker.any_of' => 'AAPL,MSFT',
]);

$gainers = Massive::stocks()->snapshots()->topMarketMovers('gainers');
$losers = Massive::stocks()->snapshots()->topMarketMovers('losers');
```

### Trades

```php
$trades = Massive::stocks()->trades()->historical('AAPL', [
    'timestamp.gte' => '2024-01-31',
]);

$allTrades = Massive::stocks()->trades()->historical('AAPL', [
    'limit' => 5000,
], allPages: true);

$latestTrade = Massive::stocks()->trades()->latest('AAPL');
```

### Quotes

```php
$quotes = Massive::stocks()->quotes()->historical('AAPL', [
    'timestamp.gte' => '2024-01-31',
]);

$allQuotes = Massive::stocks()->quotes()->historical('AAPL', [
    'limit' => 5000,
], allPages: true);

$latestQuote = Massive::stocks()->quotes()->latest('AAPL');
```

### Indicators

```php
$sma = Massive::stocks()->indicators()->sma('AAPL', [
    'timespan' => 'day',
]);

$ema = Massive::stocks()->indicators()->ema('AAPL', [
    'timespan' => 'day',
]);

$macd = Massive::stocks()->indicators()->macd('AAPL', [
    'timespan' => 'day',
]);

$rsi = Massive::stocks()->indicators()->rsi('AAPL', [
    'timespan' => 'day',
]);
```

### Market Operations

```php
$exchanges = Massive::stocks()->marketOperations()->exchanges([
    'asset_class' => 'stocks',
]);

$upcomingHolidays = Massive::stocks()->marketOperations()->upcomingHolidays();

$marketStatus = Massive::stocks()->marketOperations()->marketStatus();

$conditionCodes = Massive::stocks()->marketOperations()->conditionCodes([
    'asset_class' => 'stocks',
]);
```

### Corporate Actions

```php
$ipos = Massive::stocks()->corporateActions()->ipos([
    'ipo_status' => 'new',
]);

$splits = Massive::stocks()->corporateActions()->splits([
    'ticker' => 'AAPL',
]);

$dividends = Massive::stocks()->corporateActions()->dividends([
    'ticker' => 'AAPL',
]);

$tickerEvents = Massive::stocks()->corporateActions()->tickerEvents('AAPL', [
    'types' => 'ticker_change',
]);
```

### Fundamentals

```php
$balanceSheets = Massive::stocks()->fundamentals()->balanceSheets([
    'ticker' => 'AAPL',
]);

$cashFlowStatements = Massive::stocks()->fundamentals()->cashFlowStatements([
    'ticker' => 'AAPL',
]);

$incomeStatements = Massive::stocks()->fundamentals()->incomeStatements([
    'ticker' => 'AAPL',
]);

$ratios = Massive::stocks()->fundamentals()->ratios([
    'ticker' => 'AAPL',
]);

$shortInterest = Massive::stocks()->fundamentals()->shortInterest([
    'ticker' => 'AAPL',
]);

$shortVolume = Massive::stocks()->fundamentals()->shortVolume([
    'ticker' => 'AAPL',
]);

$freeFloat = Massive::stocks()->fundamentals()->freeFloat([
    'ticker' => 'AAPL',
]);
```

The original flat stock methods remain available as convenience proxies:

```php
$details = Massive::tickerDetails('AAPL');
$dividends = Massive::dividends(['ticker' => 'AAPL']);
$bars = Massive::customBars('AAPL', 1, 'day', '2024-01-01', '2024-01-31');
$grouped = Massive::groupedDaily('2024-01-31');
$openClose = Massive::dailyOpenClose('AAPL', '2024-01-31');
$previousClose = Massive::previousClose('AAPL');
$singleTicker = Massive::singleTickerSnapshot('AAPL');
$fullMarket = Massive::fullMarketSnapshot();
$unified = Massive::unifiedSnapshot(['ticker.any_of' => 'AAPL,MSFT']);
$gainers = Massive::topMarketMovers('gainers');
$trades = Massive::historicalTrades('AAPL');
$latestTrade = Massive::latestTrade('AAPL');
$quotes = Massive::historicalQuotes('AAPL');
$latestQuote = Massive::latestQuote('AAPL');
$sma = Massive::sma('AAPL');
$ema = Massive::ema('AAPL');
$macd = Massive::macd('AAPL');
$rsi = Massive::rsi('AAPL');
$exchanges = Massive::exchanges(['asset_class' => 'stocks']);
$upcomingHolidays = Massive::upcomingHolidays();
$marketStatus = Massive::marketStatus();
$conditionCodes = Massive::conditionCodes(['asset_class' => 'stocks']);
$ipos = Massive::ipos(['ipo_status' => 'new']);
$splits = Massive::splits(['ticker' => 'AAPL']);
$tickerEvents = Massive::tickerEvents('AAPL');
$balanceSheets = Massive::balanceSheets(['ticker' => 'AAPL']);
$cashFlowStatements = Massive::cashFlowStatements(['ticker' => 'AAPL']);
$incomeStatements = Massive::incomeStatements(['ticker' => 'AAPL']);
$ratios = Massive::ratios(['ticker' => 'AAPL']);
$shortInterest = Massive::shortInterest(['ticker' => 'AAPL']);
$shortVolume = Massive::shortVolume(['ticker' => 'AAPL']);
$freeFloat = Massive::freeFloat(['ticker' => 'AAPL']);
```

## Error Handling

Failed HTTP responses throw Laravel's `Illuminate\Http\Client\RequestException` via `throw()`.

```php
use Illuminate\Http\Client\RequestException;
use Pjmarshall1\Massive\Facades\Massive;

try {
    $details = Massive::tickerDetails('AAPL');
} catch (RequestException $exception) {
    report($exception);
}
```

## Testing

Use Laravel HTTP fakes in your application tests:

```php
use Illuminate\Support\Facades\Http;
use Pjmarshall1\Massive\Facades\Massive;

Http::preventStrayRequests();

Http::fake([
    'api.massive.com/v3/reference/tickers/AAPL*' => Http::response([
        'status' => 'OK',
        'results' => [
            'ticker' => 'AAPL',
        ],
    ]),
]);

$details = Massive::tickerDetails('AAPL');
```
