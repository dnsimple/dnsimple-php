# Contributing to DNSimple/PHP

## Getting started

### 1. Clone the repository

Clone the repository and move into it:

```shell
git clone git@github.com:dnsimple/dnsimple-php.git
cd dnsimple-php
```

### 2. Install dependencies

[Install composer locally](https://getcomposer.org/doc/00-intro.md#locally).

Install the dependencies using composer:

```shell
composer install
```

### 3. Testing

[Run the test suite](#testing) to check everything works as expected.

To run the test suite:

```shell
./vendor/bin/phpunit tests
```

## Changelog

We follow the [Common Changelog](https://common-changelog.org/) format for changelog entries.

## Testing

Submit unit tests for your changes. You can test your changes on your machine by [running the test suite](#testing).

When you submit a PR, tests will also be run on the [continuous integration environment via GitHub Actions](https://github.com/dnsimple/dnsimple-php/actions).
