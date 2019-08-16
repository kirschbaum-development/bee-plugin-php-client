# Bee Plugin PHP Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/bee-plugin-php-client.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/bee-plugin-php-client)
[![Build Status](https://img.shields.io/travis/kirschbaum-development/bee-plugin-php-client/master.svg?style=flat-square)](https://travis-ci.org/kirschbaum-development/bee-plugin-php-client)
[![Quality Score](https://img.shields.io/scrutinizer/g/kirschbaum-development/bee-plugin-php-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/kirschbaum-development/bee-plugin-php-client)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/bee-plugin-php-client.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/bee-plugin-php-client)

PHP client to interact with Bee's plugin API. This includes the [Message Services API](https://docs.beefree.io/message-services-api-reference/) and a convinient way to use [authorization](https://docs.beefree.io/authorization-process/).

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

### Testing

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
