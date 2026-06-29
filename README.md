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

The original flat stock methods remain available as convenience proxies:

```php
$details = Massive::tickerDetails('AAPL');
$dividends = Massive::dividends(['ticker' => 'AAPL']);
$bars = Massive::customBars('AAPL', 1, 'day', '2024-01-01', '2024-01-31');
$grouped = Massive::groupedDaily('2024-01-31');
$openClose = Massive::dailyOpenClose('AAPL', '2024-01-31');
$previousClose = Massive::previousClose('AAPL');
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
