# Contributing to DNSimple/PHP

## Getting started

Clone the repository and move into it:

```shell
git clone git@github.com:dnsimple/dnsimple-php.git
cd dnsimple-php
```

Install the dependencies using [composer](https://getcomposer.org/doc/00-intro.md#locally):

```shell
composer install
```

Run the test suite to check everything works as expected.

## Testing

To run the test suite:

```shell
composer test
```

Or directly with PHPUnit:

```shell
./vendor/bin/phpunit
```

Submit unit tests for your changes. You can test your changes on your machine by running the test suite.

When you submit a PR, tests will also be run on the [continuous integration environment via GitHub Actions](https://github.com/dnsimple/dnsimple-php/actions).

## Changelog

We follow the [Common Changelog](https://common-changelog.org/) format for changelog entries.
