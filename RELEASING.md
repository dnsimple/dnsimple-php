# Releasing

This document describes the steps to release a new version of DNSimple/PHP.

## Prerequisites

- You have commit access to the repository
- You have push access to the repository
- You have a GPG key configured for signing tags

## Release process

A new release is not necessary for changes to `composer.lock` because [they do not have an effect on projects that depend on `dnsimple-php`](https://getcomposer.org/doc/02-libraries.md#lock-file).

1. **Determine the new version** using [Semantic Versioning](https://semver.org/)

   ```shell
   VERSION=X.Y.Z
   ```

   - **MAJOR** version for incompatible API changes
   - **MINOR** version for backwards-compatible functionality additions
   - **PATCH** version for backwards-compatible bug fixes

2. **Update the version file** with the new version

   Edit `Client.php`:

   ```php
   const VERSION = "$VERSION";
   ```

3. **Run tests** and confirm they pass

   ```shell
   ./vendor/bin/phpunit tests
   ```

4. **Update the changelog** with the new version

   Finalize the `## main` section in `CHANGELOG.md` assigning the version.

5. **Commit the new version**

   ```shell
   git commit -a -m "Release $VERSION"
   ```

6. **Push the changes**

   ```shell
   git push origin main
   ```

7. **Wait for CI to complete**

8. **Create a signed tag**

   ```shell
   git tag -a v$VERSION -s -m "Release $VERSION"
   git push origin --tags
   ```

9. **Wait for Packagist to pull the updates**

   Verify [dnsimple/dnsimple](https://packagist.org/packages/dnsimple/dnsimple) package is updated with the new release.

## Post-release

- Verify the new version appears on [Packagist](https://packagist.org/packages/dnsimple/dnsimple)
- Verify the GitHub release was created
- Announce the release if necessary
