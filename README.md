# DNSimple PHP Client

A PHP client for the [DNSimple API v2](https://developer.dnsimple.com/v2/).

[![Build Status](https://github.com/dnsimple/dnsimple-php/actions/workflows/ci.yml/badge.svg)](https://github.com/dnsimple/dnsimple-php/actions/workflows/ci.yml)

## Documentation

- [dnsimple-php Packagist](https://packagist.org/packages/dnsimple/dnsimple)
- [DNSimple API documentation](https://developer.dnsimple.com/)
- [DNSimple API examples repository](https://github.com/dnsimple/dnsimple-api-examples)
- [DNSimple support documentation](https://support.dnsimple.com/)

## Requirements

- PHP ^8.2

## Getting Started

1. **Sign up for DNSimple** – Before you begin, you need to
   sign up for a [DNSimple](https://dnsimple.com) account and retrieve your [DNSimple API token](https://developer.dnsimple.com/v2/#authentication).
2. **Install** – Using [Composer] is the recommended way to install.
   The PHP client is available via [Packagist] under the [`dnsimple/dnsimple`] package. If Composer is installed globally on your system, you can run the following in the base directory of your project to add the package as a dependency:

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

## Contributing

Contibutions are welcomed. Please open an issue to discuss the changes before opening a PR. For more details on how to do development please refer to [CONTRIBUTING.md](CONTRIBUTING.md)

## License

Copyright (c) 2015-2022 DNSimple Corporation. This is Free Software distributed under the MIT license.
