# Contributing to DNSimple/PHP

## Getting started

#### 1. Clone the repository

Clone the repository and move into it:

```shell
git clone git@github.com:dnsimple/dnsimple-php.git
cd dnsimple-php
```

#### 2. Install dependencies

[Install composer locally](https://getcomposer.org/doc/00-intro.md#locally).

Install the dependencies:

```shell
$ php composer.phar install
```

#### 3. Testing
[Run the test suite](#testing) to check everything works as expected.

To run the test suite:

```shell
./vendor/bin/phpunit tests
```

## Releasing

The following instructions uses `$VERSION` as a placeholder, where `$VERSION` is a `MAJOR.MINOR.BUGFIX` release such as `1.2.0`.

1. Run the test suite and ensure all the tests pass.
2. Run the test suite and ensure all tests pass: `./vendor/bin/phpunit`
3. Finalize the `## master` section in `CHANGELOG.md` assigning the version.
4. Commit and push the changes

    ```shell
    git commit -a -m "Release $VERSION"
    git push origin master
    ```

5. Wait for the CI to complete.
6. Create a signed tag.

    ```shell
    git tag -a v$VERSION -s -m "Release $VERSION"
    git push origin --tags
    ```

7. Wait for Packagist to pull the updates. Verify [dnsimple/dnsimple](https://packagist.org/packages/dnsimple/dnsimple) package is updated with the new release.

## Testing

Submit unit tests for your changes. You can test your changes on your machine by [running the test suite](#testing).

When you submit a PR, tests will also be run on the [continuous integration environment via Travis](https://travis-ci.com/dnsimple/dnsimple-php).
