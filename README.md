# DNSimple PHP Client

A PHP client for the [DNSimple API v2](https://developer.dnsimple.com/v2/).

[![Build Status](https://github.com/dnsimple/dnsimple-php/actions/workflows/ci.yml/badge.svg)](https://github.com/dnsimple/dnsimple-php/actions/workflows/ci.yml)

## Requirements

- PHP ^8.3
- An activated DNSimple account

## Installation

Using [Composer](https://getcomposer.org/) is the recommended way to install.
The PHP client is available via [Packagist](https://packagist.org/) under the [`dnsimple/dnsimple`](https://packagist.org/packages/dnsimple/dnsimple) package. If Composer is installed globally on your system, you can run the following in the base directory of your project to add the package as a dependency:

```shell
composer require dnsimple/dnsimple
```

## Usage

This library is a PHP client you can use to interact with the [DNSimple API v2](https://developer.dnsimple.com/v2/). Here are some examples.

```php
use Dnsimple\Client;

$client = new Client("API_TOKEN");

$response = $client->identity->whoami();
$whoami = $response->getData();
$account_id = $whoami->account->id;

$response = $client->domains->listDomains($account_id);
$domains = $response->getData();
```

### Research a domain

> **Note:** This endpoint is part of a Private Beta. During the beta period, changes to the endpoint may occur at any time. If interested in using this endpoint, reach out to [DNSimple support](support@dnsimple.com).

Research a domain name for availability and registration status information:

```php
use Dnsimple\Client;

$client = new Client("API_TOKEN");

$response = $client->domains->domainResearchStatus($account_id, "example.com");
$research = $response->getData();
echo $research->domain;          // "example.com"
echo $research->availability;    // "unavailable"
echo $research->request_id;      // "f453dabc-a27e-4bf1-a93e-f263577ffaae"
print_r($research->errors);      // []
```

## Configuration

### Sandbox Environment

We highly recommend testing against our [sandbox environment](https://developer.dnsimple.com/sandbox/) before using our
production environment. This will allow you to avoid real purchases, live charges on your credit card, and reduce the
chance of your running up against rate limits.

The client supports both the production and sandbox environment. To switch to sandbox pass the sandbox API host using
the `base_uri` option when you construct the client:

```php
use Dnsimple\Client;

$client = new Client("API_TOKEN", ["base_uri" => 'https://api.sandbox.dnsimple.com']);
```

You will need to ensure that you are using an access token created in the sandbox environment.
Production tokens will *not* work in the sandbox environment.

### Setting a custom `User-Agent` header

You can customize the `User-Agent` header for the calls made to the DNSimple API:

```php
use Dnsimple\Client;

$client = new Client("API_TOKEN", ["user_agent" => "my-app/1.0"]);
```

The value you provide will be appended to the default `User-Agent` the client uses. For example, if you use `my-app/1.0`, the final header value will be `dnsimple-php/x.x.x my-app/1.0` (note that it will vary depending on the client version).

## Documentation

- [dnsimple-php Packagist](https://packagist.org/packages/dnsimple/dnsimple)
- [DNSimple API documentation](https://developer.dnsimple.com/)
- [DNSimple API examples repository](https://github.com/dnsimple/dnsimple-api-examples)
- [DNSimple support documentation](https://support.dnsimple.com/)

## Contributing

Contributions are welcome! Please feel free to submit issues and pull requests. See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for details.

## License

Copyright (c) 2015-2026 DNSimple Corporation. This is Free Software distributed under the [MIT License](LICENSE.txt).
