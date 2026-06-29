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

$dividends = $massive->dividends([
    'ticker' => 'AAPL',
]);
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

### Aggregate Bars

```php
$bars = Massive::aggregates(
    ticker: 'AAPL',
    multiplier: 1,
    timespan: 'day',
    from: '2026-01-01',
    to: '2026-01-31',
    query: [
        'adjusted' => 'true',
    ],
);
```

### Ticker Details

```php
$details = Massive::tickerDetails('AAPL');
```

### Dividends

```php
$dividends = Massive::dividends([
    'ticker' => 'AAPL',
]);
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
