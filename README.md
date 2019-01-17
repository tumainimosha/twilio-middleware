# Twilio Auth Middleware

A Laravel Middleware for Twilio API signature validation

## Installation

Install via composer

```bash
composer require tumainimosha/twilio-middleware
```

## Configuration

Paste the following in `config/services.php`. In your `.env` file set your `TWILIO_TOKEN` respectively.

```php
'twilio' => [
    'token' => env('TWILIO_TOKEN'),
],
```

## Usage

Add the package middleware as a middleware to Twilio API routes you wish to secure.


Add Middleware Alias to `app\Http\Kernel.php`


```php
protected $routeMiddleware = [
    ...
    'twilio' => \TwilioMiddleware\TwilioAuthMiddleware::class,
];
```

Once alias added, you can use the middleware as below.

```php
Route::middleware('twilio')
    ->prefix('twilio')
    ->group(function () {
        
        // Place your secure routes here
        
    });
```

## Security

If you discover any security related issues, please email [Me](mailto:princeton.mosha@gmail.com?subject=TwilioMiddleware+Package+Security+Issue)
instead of using the issue tracker.

## Credits

- [Tumaini Mosha](https://github.com/tumainimosha/)
- [All contributors](https://github.com/tumainimosha/twilio-middleware/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
