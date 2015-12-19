# Contributing to DNSimple/PHP

## Getting started

### Environment Setup

-   Clone the repository and move into it:

    ```
    $ git clone git@github.com:aetrion/dnsimple-php.git
    $ cd dnsimple-php
    ```

-   [Install composer locally](https://getcomposer.org/doc/00-intro.md#locally).

-   Install the dependencies:

    ```
    $ php composer.phar install
    ```

-   [Run the test suite](#testing) to check everything works as expected.

### Testing

```
$ phpunit
```

## Tests

Submit unit tests for your changes. You can test your changes on your machine by [running the test suite](#testing).

When you submit a PR, tests will also be run on the continuous integration environment [through Travis](https://travis-ci.com/aetrion/dnsimple-php).
