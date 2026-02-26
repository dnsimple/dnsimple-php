# Changelog

This project uses [Semantic Versioning 2.0.0](http://semver.org/), the format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## 6.1.0 - 2026-02-26

### Added

- Added `getDomainResearchStatus` to research a domain for availability and registration status. (#149)

## 6.0.0 - 2026-01-22

### Removed

- Removed deprecated `getDomainPremiumPrice`. Use `getDomainPrices` instead. (dnsimple/dnsimple-developer#916)
- Removed deprecated `getWhoisPrivacy` (dnsimple/dnsimple-developer#919)
- Removed deprecated `renewWhoisPrivacy` (dnsimple/dnsimple-developer#919)

## 5.0.0 - 2026-01-12

### Removed

- **BREAKING**: Removed `from` and `to` fields in `EmailForward`. Please use `aliasEmail` and `destinationEmail` instead.

### Added

- Added `active` to `EmailForward`

## 4.0.0 - 2025-08-20

### Removed

- **BREAKING**: `DomainCollaborators` have been removed. Please use our Domain Access Control feature.

### Changed

- Drop support for PHP < 8.3

## 3.0.0 - 2025-05-09

### Added

- Added `aliasEmail` and `destinationEmail` to `EmailForward`

### Deprecated

- Deprecated `from` and `to` fields in `EmailForward`
- `DomainCollaborators` have been deprecated and will be removed in the next major version. Please use our Domain Access Control feature.

### Changed

- Add support for PHP 8.4

## 2.0.0 - 2024-12-12

### Changed

- Drop support for PHP < 8.2
- Add support for PHP 8.3

## 1.4.0 - 2024-01-16

### Added

- Added `secondary`, `lastTransferredAt`, `active` to `Zone` (dnsimple/dnsimple-php#93)

## 1.3.0 - 2023-12-12

### Added

- Added Billing service listCharges endpoint (dnsimple/dnsimple-php#89)

## 1.2.0 - 2023-12-06

### Added

- Added listRegistrantChanges, createRegistrantChange, getRegistrantChange, deleteRegistrantChange and checkRegistrantChange endpoints (dnsimple/dnsimple-php#83)
- Added getDomainTransferLock, enableDomainTransferLock and deleteDomainTransferLock endpoints (dnsimple/dnsimple-php#85)
- Added activateZoneService and deactivateZoneService endpoints (dnsimple/dnsimple-php#87)

## 1.1.0 - 2023-03-03

### Added

- Added getDomainRenewal and getDomainRegistration endpoints (dnsimple/dnsimple-php#72)

## 1.0.0 - 2022-09-20

### Changed

- **BREAKING**: Wrap `GuzzleHttp\Exception\ClientException` (dnsimple/dnsimple-php#63)
  - **400** http exceptions are wrapped in `BadRequestException`
  - **404** http exceptions are wrapped in `NotFoundException`
  - All other **4xx** exceptions are wrapped in `HttpException` which the other classes inherit
  - The new exception classes come with [improved interface](src/Dnsimple/Exceptions/HttpException.php) e.g. `->getAttributeErrors()` to get validation errors.
- Add support for PHP ^8.0 (dnsimple-php#64)
- Add documentation to CONTRIBUTING.md

### Deprecated

- Deprecate Certificate's `contact_id` (dnsimple/dnsimple-php#46)

### Fixed

- Version number of the client

## 0.4.0 - 2021-10-25

### Changed

- Add support for DNSSEC key-data interface (dnsimple/dnsimple-php#29).

## 0.3.1 - 2021-06-07

### Deprecated

- Deprecates `service.getDomainPremiumPrice`

## 0.3.0 - 2021-04-21

### Added

- Added `service.getDomainPrices` to retrieve whether a domain is premium, and the prices to register, transfer, and renew. (dnsimple/dnsimple-php#18)

## 0.1.0 - 2020-09-14

Initial public release.
