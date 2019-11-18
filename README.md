# Bee Plugin PHP Client

![](https://raw.githubusercontent.com/kirschbaum-development/bee-plugin-php-client/master/banner.png)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/bee-plugin-php-client.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/bee-plugin-php-client)
[![Actions Status](https://github.com/kirschbaum-development/bee-plugin-php-client/workflows/CI/badge.svg)](https://github.com/kirschbaum-development/bee-plugin-php-client/actions)
[![StyleCI](https://github.styleci.io/repos/202812418/shield?branch=master)](https://github.styleci.io/repos/202812418)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/bee-plugin-php-client.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/bee-plugin-php-client)

PHP client to interact with Bee's plugin API. This includes the [Message Services API](https://docs.beefree.io/message-services-api-reference/) and a convenient way to use [authorization](https://docs.beefree.io/authorization-process/).

## Installation

You can install the package via composer:

```bash
composer require kirschbaum-development/bee-plugin-php-client
```

## Usage

First thing you will need is to instantiate the `Bee` base class and setup the API token. You can grab the API token by logging in into the [Developer portal](https://developers.beefree.io) and going to the "details" of your application.

``` php
use KirschbaumDevelopment\Bee\Bee;

$bee = new Bee(new \GuzzleHttp\Client);
$bee->setApiToken('your-api-token-here');
```

### Using Message Services API: HTML

This API allows you to post the JSON content generated on the Bee editor, and it will return the rendered HTML of the JSON. Reference: https://docs.beefree.io/message-services-api-reference/#html

```php
$beeEditorData = []; // this will be the JSON generated using the editor
$html = $bee->html($beeEditorData);
```

### Using Message Services API: PDF

This API allows you to post the HTML content and get an URL with a PDF created from the HTML. Reference: https://docs.beefree.io/message-services-api-reference/#pdf

```php
$pdf = $bee->pdf([
    'html' => $html, // HTML generated using the HTML API (required)
    'page_size' => 'Letter', // (optional)
    'page_orientation' => 'Landscape', // (optional)
]);

// then, you can call these methods:
$pdf->getUrl();
$pdf->getFilename();
$pdf->getPageSize();
$pdf->getPageOrientation();
$pdf->getContentType();
```

### Using Message Services API: Image

This API allows you to post the HTML content and get an URL with a PDF created from the HTML. Reference: https://docs.beefree.io/message-services-api-reference/#image

```php
$image = $bee->image([
    'html' => $html, // HTML generated using the HTML API (required)
    'width' => 500, // (required)
    'height' => 400, // (optional)
    'file_type' => 'jpg',
]);

// then, you can save the image content somewhere, some examples on how you may do this:
file_put_contents('/path/to/storage/image.jpg', $image);

// on Laravel with Storage object:
Storage::put('/path/to/storage/image.jpg', $image);
```

## Generating access token

To initialize Bee Editor you may need an access token. You can use `BeeAuth` to easily generate that. You can grab the Client ID and Secret by logging in into the [Developer portal](https://developers.beefree.io) and going to the "details" of your application.

```php
use KirschbaumDevelopment\Bee\BeeAuth;

$beeAuth = new BeeAuth(new \GuzzleHttp\Client);
$beeAuth->setClientId('your-client-id-here');
$beeAuth->setClientSecret('your-client-secret-here');
$token = $beeAuth->generateToken();

// then you can use the following methods:
$token->getAccessToken();
$token->getRefreshToken();
$token->getExpires();
```

Auth tokens are valid for 5 minutes. If you want to cache your tokens for as long as possible, you will need to pass a [PSR-16](https://www.php-fig.org/psr/psr-16/) compatible cache implementation. Laravel, Symfony and all major frameworks are already compatible with this interface. To enable the cache, you only need to call the `setCache` method passing a `Psr\SimpleCache\CacheInterface` implementation.

```php
$beeAuth->setCache($cacheImplementation);
```

## Usage with Laravel

If you use Laravel, `BeePluginServiceProvider` will be auto-registered if you use Laravel package discovery. Otherwise, you can manually register the following provider:

```php
'providers' => [
    // ...
    KirschbaumDevelopment\Bee\Laravel\BeePluginServiceProvider::class,
],
```

This will make sure that any time you ask Laravel for `KirschbaumDevelopment\Bee\Bee` or `KirschbaumDevelopment\Bee\BeeAuth` using the Laravel container (e.g. `app(Bee::class)`), Guzzle will be automatically injected and also the API token and Client ID/Secret will be injected into the classes.

The config values will be extracted from the following config: `.services.bee`. So, we'll use the following conventions:

API Token: `config('services.bee.api_token')`
Client ID: `config('services.bee.client_id')`
Client Secret: `config('services.bee.client_secret')`

If you don't want to use this config, you can always pass the values manually.

### Caching with Laravel

Laravel service provider will also automatically inject Laravel's cache implementation on `BeeAuth`, so your auth tokens will be cached for as long as possible.

### Testing with Laravel

If you are writing integration tests, but don't want your tests making requests to Bee to get credentials, we have a little helper that can help you. Just run the following code:

```php
use KirschbaumDevelopment\Bee\Laravel\BeeAuthMock;

BeeAuthMock::init();
```

With this, any time you call `BeeAuth::generateToken()` in your code you will receive the same response you would receive, but with some fake tokens and without making any HTTP requests.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email luis@kirschbaumdevelopment.com or nathan@kirschbaumdevelopment.com instead of using the issue tracker.

## Credits

- [Luis Dalmolin](https://github.com/luisdalmolin)

## Sponsorship

Development of this package is sponsored by Kirschbaum Development Group, a developer driven company focused on problem solving, team building, and community. Learn more [about us](https://kirschbaumdevelopment.com) or [join us](https://careers.kirschbaumdevelopment.com)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
